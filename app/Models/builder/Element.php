<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
 
class Element extends Model
{
    protected $fillable = [
        'slug', 'name', 'category', 'group', 'shape',
        'color', 'detail_color', 'use_img', 'img_path',
        'is_small', 'is_large',                          // ← removed series_id
        'price', 'stock', 'is_active',
    ];
 
    protected $casts = [
        'use_img'   => 'boolean',
        'is_small'  => 'boolean',
        'is_large'  => 'boolean',
        'is_active' => 'boolean',
    ];
 
    // ── series() relationship REMOVED ────────────────────────────────────────

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
 
    // ── Scopes ────────────────────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('stock', '!=', 'out');
    }
 
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
 
    // ── Canvas-ready JSON shape ───────────────────────────────────────────────
public function toCanvasArray(): array
{
    return [
        // ── Identity ─────────────────────────────────────────────────
        'id'       => $this->slug,      // JS uses this
        'slug'     => $this->slug,      // Blade uses this
        'name'     => $this->name,
        'category' => $this->category,
        'group'    => $this->group,

        // ── Shape / Color ────────────────────────────────────────────
        'shape'    => $this->shape,
        'color'    => $this->color,
        'detail'   => $this->detail_color,  // JS key
        'detail_color' => $this->detail_color,  // Blade key (if needed)

        // ── Image-based charms ───────────────────────────────────────
        'useImg'   => (bool) $this->use_img,    // JS key
        'use_img'  => (bool) $this->use_img,    // Blade key
        'imgSrc'   => $this->img_path
            ? asset('img/builder/' . $this->img_path)
            : null,                             // JS key (full URL)
        'img_path' => $this->img_path,          // Blade key (raw path)

        // ── Size flags ───────────────────────────────────────────────
        'small'    => (bool) $this->is_small,   // JS key
        'is_small' => (bool) $this->is_small,   // Blade key
        'large'    => (bool) $this->is_large,   // JS key
        'is_large' => (bool) $this->is_large,   // Blade key

        // ── Pricing / Stock ──────────────────────────────────────────
        'price'    => $this->price,
        'stock'    => $this->stock,
    ];
}
}