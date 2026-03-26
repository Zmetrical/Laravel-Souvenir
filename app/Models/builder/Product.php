<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
 
class Product extends Model
{
    protected $fillable = ['slug', 'label', 'base_price', 'max_beads', 'is_active'];
 
    protected $casts = [
        'is_active' => 'boolean',
    ];
 
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
 