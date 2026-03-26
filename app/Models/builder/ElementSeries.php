<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
 
class ElementSeries extends Model
{
    protected $fillable = ['name', 'slug', 'is_active'];
 
    protected $casts = [
        'is_active' => 'boolean',
    ];
 
    public function elements()
    {
        return $this->hasMany(Element::class, 'series_id');
    }
}
 
