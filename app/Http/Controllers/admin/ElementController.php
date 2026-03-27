<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\builder\Element;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ElementController extends Controller
{
    // ── GET /admin/elements ────────────────────────────────────────────────
    public function overview()
    {
        $stats = [
            'beads' => [
                'total'  => Element::where('category', 'beads')->count(),
                'active' => Element::where('category', 'beads')->where('is_active', true)->count(),
                'low'    => Element::where('category', 'beads')->where('stock', 'low')->count(),
                'out'    => Element::where('category', 'beads')->where('stock', 'out')->count(),
            ],
            'figures' => [
                'total'  => Element::where('category', 'figures')->count(),
                'active' => Element::where('category', 'figures')->where('is_active', true)->count(),
                'low'    => Element::where('category', 'figures')->where('stock', 'low')->count(),
                'out'    => Element::where('category', 'figures')->where('stock', 'out')->count(),
            ],
            'charms' => [
                'total'  => Element::where('category', 'charms')->count(),
                'active' => Element::where('category', 'charms')->where('is_active', true)->count(),
                'low'    => Element::where('category', 'charms')->where('stock', 'low')->count(),
                'out'    => Element::where('category', 'charms')->where('stock', 'out')->count(),
            ],
        ];

        return view('admin.elements.overview', compact('stats'));
    }

    // ── GET /admin/elements/beads ──────────────────────────────────────────
    public function beads(Request $request)
    {
        $query = Element::where('category', 'beads')->latest();

        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->filled('stock'))  $query->where('stock', $request->stock);
        if ($request->filled('group'))  $query->where('group', $request->group);

        $elements = $query->paginate(40)->withQueryString();
        $groups   = Element::where('category', 'beads')->whereNotNull('group')->distinct()->pluck('group');

        return view('admin.elements.beads', compact('elements', 'groups'));
    }

    // ── GET /admin/elements/figures ────────────────────────────────────────
    public function figures(Request $request)
    {
        $query = Element::where('category', 'figures')->latest();

        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->filled('stock'))  $query->where('stock', $request->stock);
        if ($request->filled('group'))  $query->where('group', $request->group);

        $elements = $query->paginate(40)->withQueryString();
        $groups   = Element::where('category', 'figures')->whereNotNull('group')->distinct()->pluck('group');

        return view('admin.elements.figures', compact('elements', 'groups'));
    }

    // ── GET /admin/elements/charms ─────────────────────────────────────────
    public function charms(Request $request)
    {
        $query = Element::where('category', 'charms')->latest();

        if ($request->filled('search')) $query->where('name', 'like', '%' . $request->search . '%');
        if ($request->filled('stock'))  $query->where('stock', $request->stock);
        if ($request->filled('group'))  $query->where('group', $request->group);

        $elements = $query->paginate(24)->withQueryString();
        $groups   = Element::where('category', 'charms')->whereNotNull('group')->distinct()->pluck('group');

        return view('admin.elements.charms', compact('elements', 'groups'));
    }

    // ── GET /admin/elements/create ─────────────────────────────────────────
    public function create(Request $request)
    {
        $preCategory = $request->query('cat', 'beads');
        return view('admin.elements.create', compact('preCategory'));
    }

    // ── POST /admin/elements ───────────────────────────────────────────────
    public function store(Request $request)
    {
        // ── Bulk mode ─────────────────────────────────────────────────────
        if ($request->input('_mode') === 'bulk') {

            // ── Charm bulk (each variation has its own image) ──────────────
            if ($request->input('category') === 'charms') {
                $request->validate([
                    'category'  => 'required|in:beads,figures,charms',
                    'name'      => 'required|string|max:120',
                    'slug'      => 'required|string|max:120',
                    'group'     => 'nullable|string|max:80',
                    'price'     => 'required|numeric|min:1',
                    'stock'     => 'required|in:in,low,out',
                    'variations' => 'required|array|min:1',
                    'variations.*.suffix' => 'nullable|string|max:80',
                ]);

                $folder   = Str::slug($request->group ?? 'charms');
                $varFiles = $request->file('variations') ?? [];
                $created  = 0;

                // Create the primary charm (top-level img_file)
                $primarySlug    = $this->uniqueSlug($request->slug);
                $primaryImgPath = null;
                if ($request->hasFile('img_file')) {
                    $primaryImgPath = $this->handleImageUpload($request, $folder);
                }
                Element::create([
                    'category'  => 'charms',
                    'name'      => $request->name,
                    'slug'      => $primarySlug,
                    'group'     => $request->group,
                    'price'     => $request->price,
                    'stock'     => $request->stock,
                    'is_active' => $request->boolean('is_active'),
                    'is_large'  => $request->boolean('is_large'),
                    'img_path'  => $primaryImgPath,
                    'use_img'   => !empty($primaryImgPath),
                ]);
                $created++;

                // Create each additional variation
                foreach ($request->variations as $idx => $v) {
                    $suffix = trim($v['suffix'] ?? '');
                    $name   = $suffix ? $request->name . ' ' . $suffix : $request->name;
                    $base   = $suffix
                        ? $request->slug . '-' . Str::slug($suffix)
                        : $request->slug;
                    $slug   = $this->uniqueSlug($base);

                    $imgPath = null;
                    if (isset($varFiles[$idx]['img_file'])) {
                        $imgPath = $this->handleImageFile($varFiles[$idx]['img_file'], $folder);
                    }

                    Element::create([
                        'category'  => 'charms',
                        'name'      => $name,
                        'slug'      => $slug,
                        'group'     => $request->group,
                        'price'     => $request->price,
                        'stock'     => $request->stock,
                        'is_active' => $request->boolean('is_active'),
                        'is_large'  => $request->boolean('is_large'),
                        'img_path'  => $imgPath,
                        'use_img'   => !empty($imgPath),
                    ]);
                    $created++;
                }

                return redirect()
                    ->route('admin.elements.charms')
                    ->with('success', "{$created} charm(s) created successfully!");
            }

            // ── Bead / Figure bulk (color variations) ─────────────────────
            $request->validate([
                'category'           => 'required|in:beads,figures,charms',
                'shape'              => 'required|string',
                'name'               => 'required|string|max:120',
                'slug'               => 'required|string|max:120',
                'group'              => 'nullable|string|max:80',
                'price'              => 'required|numeric|min:1',
                'stock'              => 'required|in:in,low,out',
                'variations'         => 'required|array|min:1',
                'variations.*.color'  => 'required|string|max:20',
                'variations.*.detail' => 'required|string|max:20',
            ]);

            $created = 0;
            foreach ($request->variations as $v) {
                $suffix = trim($v['suffix'] ?? '');
                $name   = $suffix ? $request->name . ' ' . $suffix : $request->name;
                $base   = $suffix
                    ? $request->slug . '-' . Str::slug($suffix)
                    : $request->slug;
                $slug   = $this->uniqueSlug($base);

                Element::create([
                    'category'     => $request->category,
                    'shape'        => $request->shape,
                    'name'         => $name,
                    'slug'         => $slug,
                    'group'        => $request->group,
                    'price'        => $request->price,
                    'stock'        => $request->stock,
                    'is_active'    => $request->boolean('is_active'),
                    'color'        => $v['color'],
                    'detail_color' => $v['detail'],
                ]);
                $created++;
            }

            return redirect()
                ->route('admin.elements.' . $request->category)
                ->with('success', "{$created} variation(s) created successfully!");
        }

        // ── Single mode ────────────────────────────────────────────────────
        $validated = $this->validateElement($request);

        if ($request->hasFile('img_file')) {
            $folder = Str::slug($validated['group'] ?? 'charms');
            $validated['img_path'] = $this->handleImageUpload($request, $folder);
        }
        unset($validated['img_file']);

        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateSlug($validated['name']);
        }

        Element::create($validated);

        return redirect()
            ->route('admin.elements.' . $validated['category'])
            ->with('success', 'Element "' . $validated['name'] . '" added successfully.');
    }

    // ── GET /admin/elements/{element}/edit ─────────────────────────────────
    public function edit(Element $element)
    {
        $preCategory = $element->category;
        return view('admin.elements.edit', compact('element', 'preCategory'));
    }

    // ── PUT /admin/elements/{element} ──────────────────────────────────────
    public function update(Request $request, Element $element)
    {
        $validated = $this->validateElement($request, $element->id);

        if ($request->hasFile('img_file')) {
            if ($element->img_path) {
                $oldPath = public_path('img/builder/' . $element->img_path);
                if (file_exists($oldPath)) unlink($oldPath);
            }
            $folder = Str::slug($validated['group'] ?? 'charms');
            $validated['img_path'] = $this->handleImageUpload($request, $folder);
        }
        unset($validated['img_file']);

        $element->update($validated);

        return redirect()
            ->route('admin.elements.' . $element->category)
            ->with('success', 'Element "' . $element->name . '" updated successfully.');
    }

    // ── DELETE /admin/elements/{element} ───────────────────────────────────
    public function destroy(Element $element)
    {
        $category = $element->category;

        if ($element->img_path) {
            $path = public_path('img/builder/' . $element->img_path);
            if (file_exists($path)) unlink($path);
        }

        $name = $element->name;
        $element->delete();

        return redirect()
            ->route('admin.elements.' . $category)
            ->with('success', 'Element "' . $name . '" deleted.');
    }

    // ── PRIVATE HELPERS ────────────────────────────────────────────────────

    private function validateElement(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = $ignoreId
            ? "required|string|max:30|unique:elements,slug,{$ignoreId}"
            : 'required|string|max:30|unique:elements,slug';

        return $request->validate([
            'slug'         => $slugRule,
            'name'         => 'required|string|max:255',
            'category'     => 'required|in:beads,figures,charms',
            'group'        => 'nullable|string|max:100',
            'shape'        => 'nullable|string|max:50',
            'color'        => 'nullable|string|max:10',
            'detail_color' => 'nullable|string|max:10',
            'use_img'      => 'boolean',
            'img_path'     => 'nullable|string|max:255',
            'img_file'     => 'nullable|image|mimes:png,jpg,webp|max:2048',
            'is_small'     => 'boolean',
            'is_large'     => 'boolean',
            'price'        => 'required|integer|min:1|max:9999',
            'stock'        => 'required|in:in,low,out',
            'is_active'    => 'boolean',
        ]);
    }

    /** Handle a file from $request->file('img_file') */
    private function handleImageUpload(Request $request, string $folderName): string
    {
        return $this->handleImageFile($request->file('img_file'), $folderName);
    }

    /** Handle an already-resolved UploadedFile instance */
    private function handleImageFile(\Illuminate\Http\UploadedFile $file, string $folderName): string
    {
        $dir = public_path('img/builder/' . $folderName);

        if (!is_dir($dir)) mkdir($dir, 0755, true);

        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                  . '.' . $file->getClientOriginalExtension();

        $file->move($dir, $filename);

        return $folderName . '/' . $filename;
    }

    /** Return a slug that does not yet exist in the elements table */
    private function uniqueSlug(string $base): string
    {
        $slug = $base;
        $i    = 2;
        while (Element::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    private function generateSlug(string $name): string
    {
        return $this->uniqueSlug(Str::slug($name, '-'));
    }
}