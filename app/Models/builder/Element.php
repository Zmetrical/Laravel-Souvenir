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
        return array_filter([
            'id'           => $this->slug,
            'name'         => $this->name,
            'category'     => $this->category,
            'group'        => $this->group,
            'shape'        => $this->shape,
            'color'        => $this->color,
            'detail'       => $this->detail_color,
            'useImg'       => $this->use_img ?: null,
            'imgSrc'       => $this->use_img
                                ? asset('storage/' . $this->img_path)
                                : null,
            'series'       => $this->series?->name,
            'price'        => $this->price,
            'stock'        => $this->stock,
            'small'        => $this->is_small ?: null,
            'large'        => $this->is_large ?: null,
        ], fn($v) => $v !== null);
    }
}