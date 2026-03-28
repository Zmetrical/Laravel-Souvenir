<?php

namespace App\Models\builder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderThread extends Model
{
    protected $fillable = [
        'order_id',
        'approval_status',
        'revision_count',
        'approved_at',
    ];

    protected $casts = [
        'approved_at'    => 'datetime',
        'revision_count' => 'integer',
    ];

    // ── Status metadata ───────────────────────────────────────────────────────

    public static array $statuses = [
        'awaiting_mockup'    => 'Awaiting Mockup',
        'mockup_sent'        => 'Mockup Ready for Review',
        'revision_requested' => 'Revision Requested',
        'revised'            => 'Revised Design Submitted',
        'approved'           => 'Design Approved',
        'cancelled'          => 'Cancelled',
    ];

    public static array $statusColors = [
        'awaiting_mockup'    => ['bg' => '#FEF3C7', 'text' => '#92400E', 'border' => '#FDE68A'],
        'mockup_sent'        => ['bg' => '#DBEAFE', 'text' => '#1E40AF', 'border' => '#BFDBFE'],
        'revision_requested' => ['bg' => '#FEE2E2', 'text' => '#991B1B', 'border' => '#FECACA'],
        'revised'            => ['bg' => '#F3E8FF', 'text' => '#6D28D9', 'border' => '#DDD6FE'],
        'approved'           => ['bg' => '#D1FAE5', 'text' => '#065F46', 'border' => '#A7F3D0'],
        'cancelled'          => ['bg' => '#F3F4F6', 'text' => '#6B7280', 'border' => '#E5E7EB'],
    ];

    public static array $statusDescriptions = [
        'awaiting_mockup'    => 'We\'re working on your mockup. We\'ll notify you once it\'s ready!',
        'mockup_sent'        => 'Your mockup is ready! Please review it and let us know what you think.',
        'revision_requested' => 'Got your revision request! We\'ll update the design and send a new mockup soon.',
        'revised'            => 'Your revised design is in — we\'re reviewing it now.',
        'approved'           => 'Your design is approved and your order is confirmed. We\'ll start crafting it! 🌸',
        'cancelled'          => 'This order has been cancelled.',
    ];

    public static array $statusIcons = [
        'awaiting_mockup'    => '⏳',
        'mockup_sent'        => '📷',
        'revision_requested' => '✏️',
        'revised'            => '🔄',
        'approved'           => '✅',
        'cancelled'          => '❌',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(OrderMessage::class, 'order_id', 'order_id')
                    ->oldest();
    }

    // ── Status helpers ────────────────────────────────────────────────────────

    public function statusLabel(): string
    {
        return self::$statuses[$this->approval_status]
            ?? ucwords(str_replace('_', ' ', $this->approval_status));
    }

    public function statusColor(): array
    {
        return self::$statusColors[$this->approval_status]
            ?? ['bg' => '#F3F4F6', 'text' => '#374151', 'border' => '#E5E7EB'];
    }

    public function statusDescription(): string
    {
        return self::$statusDescriptions[$this->approval_status] ?? '';
    }

    public function statusIcon(): string
    {
        return self::$statusIcons[$this->approval_status] ?? '●';
    }

    // ── Permission checks ─────────────────────────────────────────────────────

    public function isApproved(): bool
    {
        return $this->approval_status === 'approved';
    }

    public function isCancelled(): bool
    {
        return $this->approval_status === 'cancelled';
    }

    /** Customer can approve OR request revision */
    public function canCustomerAct(): bool
    {
        return $this->approval_status === 'mockup_sent';
    }

    /** Customer can open builder and submit a revised design */
    public function canCustomerRevise(): bool
    {
        return in_array($this->approval_status, ['mockup_sent', 'revision_requested']);
    }

    /** Admin can upload a new mockup */
    public function adminCanUploadMockup(): bool
    {
        return in_array($this->approval_status, [
            'awaiting_mockup',
            'revised',
            'revision_requested',
        ]);
    }
}