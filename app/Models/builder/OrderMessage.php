<?php

namespace App\Models\builder;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderMessage extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'type',
        'body',
        'image_path',
        'design_json',
        'snapshot_path',
    ];

    protected $casts = [
        'design_json' => 'array',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ── Who sent this? ────────────────────────────────────────────────────────
    // Since there's no sender_type column, we infer from message type:
    //   Admin sends:    mockup, note
    //   Customer sends: approval, revision

    public function isFromAdmin(): bool
    {
        return in_array($this->type, ['mockup', 'note']);
    }

    public function isFromCustomer(): bool
    {
        return in_array($this->type, ['approval', 'revision']);
    }

    // ── Content helpers ───────────────────────────────────────────────────────

    public function hasImage(): bool
    {
        return !empty($this->image_path);
    }

    public function hasSnapshot(): bool
    {
        return !empty($this->snapshot_path);
    }

    public function hasDesign(): bool
    {
        return !empty($this->design_json);
    }

    // ── Display helpers ───────────────────────────────────────────────────────

    public function typeLabel(): string
    {
        return match($this->type) {
            'mockup'   => 'Mockup Photo',
            'approval' => 'Design Approved ✅',
            'revision' => 'Revised Design',
            'note'     => 'Note',
            default    => ucfirst($this->type),
        };
    }

    public function typeBadgeStyle(): string
    {
        return match($this->type) {
            'mockup'   => 'background:#DBEAFE;color:#1E40AF;',
            'approval' => 'background:#D1FAE5;color:#065F46;',
            'revision' => 'background:#F3E8FF;color:#6D28D9;',
            'note'     => 'background:#F3F4F6;color:#374151;',
            default    => 'background:#F3F4F6;color:#374151;',
        };
    }
}