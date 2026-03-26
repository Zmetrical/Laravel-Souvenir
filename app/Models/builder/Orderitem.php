<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
 
class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'element_id',
        'letter', 'letter_bg', 'letter_text_color', 'letter_shape',
        'strand', 'sort_order', 'price_at_order',
    ];
 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    public function element()
    {
        return $this->belongsTo(Element::class)->withDefault();
    }
 
    public function isLetter(): bool
    {
        return $this->element_id === null && $this->letter !== null;
    }
}