<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\builder\Element;
use App\Models\builder\ElementSeries;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ElementController extends Controller
{
    // ── GET /admin/elements ───────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Element::with('series')->latest();
 
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
 
        $elements = $query->paginate(30)->withQueryString();
 
        return view('admin.elements.index', compact('elements'));
    }
 
    // ── GET /admin/elements/create ────────────────────────────────────────────
    public function create()
    {
        $seriesList = ElementSeries::where('is_active', true)->orderBy('name')->get();
        return view('admin.elements.create', compact('seriesList'));
    }
 
    // ── POST /admin/elements ──────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $this->validateElement($request);
 
        // ── Handle image upload ───────────────────────────────────────────────
        if ($request->hasFile('img_file')) {
            $validated['img_path'] = $this->handleImageUpload($request, $validated['series_slug'] ?? 'charms');
        }
        unset($validated['series_slug'], $validated['img_file']);
 
        // ── Auto-generate slug if not provided ────────────────────────────────
        if (empty($validated['slug'])) {
            $validated['slug'] = $this->generateSlug($validated['name']);
        }
 
        Element::create($validated);
 
        return redirect()->route('admin.elements.index')
        ->with('success', "Element "{$validated['name']}" added successfully.");
    }
 
    // ── GET /admin/elements/{element}/edit ────────────────────────────────────
    public function edit(Element $element)
    {
        $seriesList = ElementSeries::where('is_active', true)->orderBy('name')->get();
        return view('admin.elements.edit', compact('element', 'seriesList'));
    }
 
    // ── PUT /admin/elements/{element} ─────────────────────────────────────────
    public function update(Request $request, Element $element)
    {
        $validated = $this->validateElement($request, $element->id);
 
        if ($request->hasFile('img_file')) {
            // Delete old image if it exists
            if ($element->img_path) {
                $oldPath = public_path('img/builder/' . $element->img_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $validated['img_path'] = $this->handleImageUpload($request, $validated['series_slug'] ?? 'charms');
        }
        unset($validated['series_slug'], $validated['img_file']);
 
        $element->update($validated);
 
        return redirect()->route('admin.elements.index')
            ->with('success', "Element "{$element->name}" updated successfully.");
    }
 
    // ── DELETE /admin/elements/{element} ──────────────────────────────────────
    public function destroy(Element $element)
    {
        // Delete image file if charm
        if ($element->img_path) {
            $path = public_path('img/builder/' . $element->img_path);
            if (file_exists($path)) {
                unlink($path);
            }
        }
 
        $name = $element->name;
        $element->delete();
 
        return redirect()->route('admin.elements.index')
            ->with('success', "Element "{$name}" deleted.");
    }
 
    // ── PRIVATE HELPERS ───────────────────────────────────────────────────────
 
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
            'series_slug'  => 'nullable|string',   // used for folder naming only
            'is_small'     => 'boolean',
            'is_large'     => 'boolean',
            'price'        => 'required|integer|min:1|max:9999',
            'stock'        => 'required|in:in,low,out',
            'is_active'    => 'boolean',
        ]);
    }
 
    private function handleImageUpload(Request $request, string $seriesSlug): string
    {
        $file      = $request->file('img_file');
        $folder    = public_path('img/builder/' . $seriesSlug);
 
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
 
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
