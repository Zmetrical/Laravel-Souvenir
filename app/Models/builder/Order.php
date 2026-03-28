<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
 
class Order extends Model
{
    protected $fillable = [
        'order_code', 'first_name', 'last_name', 'contact_number',
        'notes', 'product_id', 'length',
        'base_price', 'elements_cost', 'total_price',
        'status', 'confirmed_at', 'completed_at', 'cancelled_at', 'user_id',
    ];
 
    protected $casts = [
        'confirmed_at'  => 'datetime',
        'completed_at'  => 'datetime',
        'cancelled_at'  => 'datetime',
    ];
 
    // ── Relationships ──────────────────────────────────────────────────────────
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
 
    public function design()
    {
        return $this->hasOne(OrderDesign::class);
    }
 
    public function items()
    {
        return $this->hasMany(OrderItem::class)->orderBy('sort_order');
    }
 
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class)->withDefault();
    }
 
    // ── Order code generator ──────────────────────────────────────────────────
    public static function generateCode(): string
    {
        $date     = now()->format('Ymd');
        $lastCode = static::where('order_code', 'like', "AC-{$date}-%")
                          ->orderByDesc('id')
                          ->value('order_code');
 
        $seq = $lastCode
            ? (int) substr($lastCode, -4) + 1
            : 1;
 
        return sprintf('AC-%s-%04d', $date, $seq);
    }
 
    // ── Status helpers ────────────────────────────────────────────────────────
    public static array $statuses = [
        'pending'     => 'Pending',
        'confirmed'   => 'Confirmed',
        'in_progress' => 'In Progress',
        'ready'       => 'Ready',
        'completed'   => 'Completed',
        'cancelled'   => 'Cancelled',
    ];
 
    public function statusLabel(): string
    {
        return static::$statuses[$this->status] ?? ucfirst($this->status);
    }

    
}