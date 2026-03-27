<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\builder\Element;
use App\Models\builder\ElementSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ElementController extends Controller
{
    // ── GET /admin/elements ────────────────────────────────────────────────
    // Overview dashboard — shows counts + quick stats per category
    public function overview()
    {
        $stats = [
            'beads' => [
                'total'    => Element::where('category', 'beads')->count(),
                'active'   => Element::where('category', 'beads')->where('is_active', true)->count(),
                'low'      => Element::where('category', 'beads')->where('stock', 'low')->count(),
                'out'      => Element::where('category', 'beads')->where('stock', 'out')->count(),
            ],
            'figures' => [
                'total'    => Element::where('category', 'figures')->count(),
                'active'   => Element::where('category', 'figures')->where('is_active', true)->count(),
                'low'      => Element::where('category', 'figures')->where('stock', 'low')->count(),
                'out'      => Element::where('category', 'figures')->where('stock', 'out')->count(),
            ],
            'charms' => [
                'total'    => Element::where('category', 'charms')->count(),
                'active'   => Element::where('category', 'charms')->where('is_active', true)->count(),
                'low'      => Element::where('category', 'charms')->where('stock', 'low')->count(),
                'out'      => Element::where('category', 'charms')->where('stock', 'out')->count(),
            ],
        ];

        return view('admin.elements.overview', compact('stats'));
    }

    // ── GET /admin/elements/beads ──────────────────────────────────────────
    public function beads(Request $request)
    {
        $query = Element::where('category', 'beads')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('stock')) {
            $query->where('stock', $request->stock);
        }
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        $elements = $query->paginate(40)->withQueryString();
        $groups   = Element::where('category', 'beads')->whereNotNull('group')->distinct()->pluck('group');

        return view('admin.elements.beads', compact('elements', 'groups'));
    }

    // ── GET /admin/elements/figures ────────────────────────────────────────
    public function figures(Request $request)
    {
        $query = Element::where('category', 'figures')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('stock')) {
            $query->where('stock', $request->stock);
        }
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }

        $elements = $query->paginate(40)->withQueryString();
        $groups   = Element::where('category', 'figures')->whereNotNull('group')->distinct()->pluck('group');

        return view('admin.elements.figures', compact('elements', 'groups'));
    }

    // ── GET /admin/elements/charms ─────────────────────────────────────────
    public function charms(Request $request)
    {
        $query = Element::with('series')->where('category', 'charms')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('stock')) {
            $query->where('stock', $request->stock);
        }
        if ($request->filled('series')) {
            $query->where('series_id', $request->series);
        }

        $elements   = $query->paginate(24)->withQueryString();
        $seriesList = ElementSeries::where('is_active', true)->orderBy('name')->get();

        return view('admin.elements.charms', compact('elements', 'seriesList'));
    }

    // ── GET /admin/elements/create ─────────────────────────────────────────
    // Accepts ?cat=beads|figures|charms to pre-select + lock category
    public function create(Request $request)
    {
        $seriesList  = ElementSeries::where('is_active', true)->orderBy('name')->get();
        $preCategory = $request->query('cat', 'beads');

        return view('admin.elements.create', compact('seriesList', 'preCategory'));
    }

    // ── POST /admin/elements ───────────────────────────────────────────────
public function store(Request $request)
{
    // ── Bulk mode ────────────────────────────────────────────────────────
    if ($request->input('_mode') === 'bulk') {

        $request->validate([
            'category'       => 'required|in:beads,figures,charms',
            'shape'          => 'required|string',
            'name'           => 'required|string|max:120',
            'slug'           => 'required|string|max:120',
            'group'          => 'nullable|string|max:80',
            'price'          => 'required|numeric|min:1',
            'stock'          => 'required|in:in,low,out',
            'variations'     => 'required|array|min:1',
            'variations.*.color'  => 'required|string|max:20',
            'variations.*.detail' => 'required|string|max:20',
        ]);

        $created = 0;
        foreach ($request->variations as $v) {
            $suffix = trim($v['suffix'] ?? '');
            $name   = $suffix ? $request->name . ' ' . $suffix : $request->name;
            $slug   = $suffix
                ? $request->slug . '-' . Str::slug($suffix)
                : $request->slug;

            // Ensure slug is unique
            $slug = $this->uniqueSlug($slug);

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

    // ── Single mode (existing logic below) ───────────────────────────────
    // ... your current store code ...
}

// Helper — appends -2, -3 etc. if slug already exists
private function uniqueSlug(string $base): string
{
    $slug = $base;
    $i    = 2;
    while (Element::where('slug', $slug)->exists()) {
        $slug = $base . '-' . $i++;
    }
    return $slug;
}

    // ── GET /admin/elements/{element}/edit ─────────────────────────────────
    public function edit(Element $element)
    {
        $seriesList  = ElementSeries::where('is_active', true)->orderBy('name')->get();
        $preCategory = $element->category;

        return view('admin.elements.edit', compact('element', 'seriesList', 'preCategory'));
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
            $validated['img_path'] = $this->handleImageUpload($request, $validated['series_slug'] ?? 'charms');
        }
        unset($validated['series_slug'], $validated['img_file']);

        $element->update($validated);

        $category = $element->category;
        return redirect()->route('admin.elements.' . $category)
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

        return redirect()->route('admin.elements.' . $category)
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
            'series_id'    => 'nullable|exists:element_series,id',
            'series_slug'  => 'nullable|string',
            'is_small'     => 'boolean',
            'is_large'     => 'boolean',
            'price'        => 'required|integer|min:1|max:9999',
            'stock'        => 'required|in:in,low,out',
            'is_active'    => 'boolean',
        ]);
    }

    private function handleImageUpload(Request $request, string $seriesSlug): string
    {
        $file   = $request->file('img_file');
        $folder = public_path('img/builder/' . $seriesSlug);

        if (!is_dir($folder)) mkdir($folder, 0755, true);

        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                  . '.' . $file->getClientOriginalExtension();

        $file->move($folder, $filename);

        return $seriesSlug . '/' . $filename;
    }

    private function generateSlug(string $name): string
    {
        $base = Str::slug($name, '-');
        $slug = $base;
        $i    = 1;

        while (Element::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}