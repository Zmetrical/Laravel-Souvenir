<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
 
class Element extends Model
{
    protected $fillable = [
        'slug', 'name', 'category', 'group', 'shape',
        'color', 'detail_color', 'use_img', 'img_path',
        'series_id', 'price', 'stock',
        'is_small', 'is_large', 'is_active',
    ];
 
    protected $casts = [
        'use_img'   => 'boolean',
        'is_small'  => 'boolean',
        'is_large'  => 'boolean',
        'is_active' => 'boolean',
    ];
 
    public function series()
    {
        return $this->belongsTo(ElementSeries::class, 'series_id');
    }
 
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
    // Matches the structure your JS data.js files expect
public function toCanvasArray(): array
{
    return [
        // ── Identity ─────────────────────────────────────────────────
        'id'       => $this->slug,          // JS uses slug as id
        'name'     => $this->name,
        'category' => $this->category,      // 'beads' | 'figures' | 'charms'
        'group'    => $this->group,         // ← was group_label (wrong)

        // ── Shape / Color (canvas drawing) ───────────────────────────
        'shape'    => $this->shape,
        'color'    => $this->color,
        'detail'   => $this->detail_color,  // ← DB: detail_color → JS: detail

        // ── Image-based charms ───────────────────────────────────────
        'useImg'   => (bool) $this->use_img,              // ← DB: use_img → JS: useImg
        'imgSrc' => $this->img_path
            ? asset('img/builder/' . $this->img_path)
            : null,

        // ── Size flags ───────────────────────────────────────────────
        'small'    => (bool) $this->is_small,  // ← DB: is_small → JS: small
        'large'    => (bool) $this->is_large,  // ← DB: is_large → JS: large

        // ── Pricing / Stock ──────────────────────────────────────────
        'price'    => $this->price,
        'stock'    => $this->stock,             // 'in' | 'low' | 'out'

        // ── Charms series name ───────────────────────────────────────
        'series'   => $this->series?->name,     // used by buildCharmsGrid
    ];
}
}