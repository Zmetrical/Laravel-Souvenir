<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
 
class OrderDesign extends Model
{
    protected $fillable = [
        'order_id', 'design_json', 'snapshot_path',
        'str_color', 'str_type', 'clasp', 'view', 'length',
        'keychain_strands', 'ring_type', 'ring_color',
        'letter_bg_color', 'letter_text_color', 'letter_shape',
    ];
 
    protected $casts = [
        'design_json' => 'array',   // auto encode/decode JSON
    ];
 
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
 
    // Full public URL to the snapshot PNG
    public function snapshotUrl(): ?string
    {
        return $this->snapshot_path
            ? asset('storage/' . $this->snapshot_path)
            : null;
    }
}