@extends('admin.includes.layout')
@section('title', 'Order ' . $order->order_code)

@section('content')

@php
  $tabColors = [
    'pending'     => ['bg' => '#FEF3C7', 'text' => '#92400E'],
    'confirmed'   => ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
    'in_progress' => ['bg' => '#F3E8FF', 'text' => '#6D28D9'],
    'ready'       => ['bg' => '#D1FAE5', 'text' => '#065F46'],
    'completed'   => ['bg' => '#F0FDF4', 'text' => '#14532D'],
    'cancelled'   => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
  ];

  /* 👇 UPDATED TO USE YOUR THEME VARIABLES 👇 */
  $nextStatus = match($order->status) {
    'pending'     => ['status' => 'confirmed',   'label' => 'Confirm Order',  'color' => 'var(--teal)',   'icon' => 'check'],
    'confirmed'   => ['status' => 'in_progress', 'label' => 'Start Working',  'color' => 'var(--purple)', 'icon' => 'wrench'],
    'in_progress' => ['status' => 'ready',       'label' => 'Mark as Ready',  'color' => 'var(--teal)',   'icon' => 'package-check'],
    'ready'       => ['status' => 'completed',   'label' => 'Complete Order', 'color' => 'var(--ink)',    'icon' => 'circle-check'],
    default       => null,
  };

  $canCancel = ! in_array($order->status, ['completed', 'cancelled']);
  $sc  = $tabColors[$order->status] ?? ['bg' => 'var(--grey-100)', 'text' => 'var(--ink-md)'];
  
  $tsc = ['bg' => 'var(--grey-100)', 'text' => 'var(--ink-md)', 'border' => 'var(--grey-200)'];
  if (isset($thread)) {
      $tsc = $thread->statusColor();
  }
@endphp

<style>
  /* ── Thread ── */
  .thread-wrap { display: flex; flex-direction: column; }
  .msg-row { display: flex; gap: 12px; padding: 16px 24px; }
  .msg-row.msg-admin    { justify-content: flex-end; }
  .msg-row.msg-customer { justify-content: flex-start; }

  .msg-avatar { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.9rem; flex-shrink: 0; align-self: flex-end; }
  .msg-avatar.admin-av    { background: var(--pink-lt); color: var(--pink-dk); }
  .msg-avatar.customer-av { background: var(--teal-bg); color: var(--teal-dk); border: 1.5px solid var(--teal); }

  .msg-bubble-wrap { max-width: 75%; display: flex; flex-direction: column; }
  .msg-row.msg-admin    .msg-bubble-wrap { align-items: flex-end; }
  .msg-row.msg-customer .msg-bubble-wrap { align-items: flex-start; }

  .msg-sender-name { font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; margin-bottom: 6px; padding: 0 4px; }
  .msg-bubble { border-radius: 16px; padding: 14px 18px; font-size: 0.9rem; font-weight: 700; line-height: 1.5; }
  
  /* Bubbles */
  .admin-bub    { background: var(--pink-bg); border: 1.5px solid var(--pink-bd); color: var(--pink-dk); border-bottom-right-radius: 4px; }
  .customer-bub { background: var(--offwhite); border: 1.5px solid var(--grey-200); color: var(--ink); border-bottom-left-radius: 4px; }
  .approval-bub { background: var(--lime-bg); border: 1.5px solid var(--lime); color: var(--lime-dk); border-bottom-left-radius: 4px; }
  .revision-bub { background: var(--purple-bg); border: 1.5px solid var(--purple); color: var(--purple-dk); border-bottom-left-radius: 4px; }

  .msg-time { font-size: 0.7rem; color: var(--ink-md); font-weight: 700; margin-top: 6px; padding: 0 4px; }
  .msg-type-badge { display: inline-block; font-size: 0.7rem; font-weight: 900; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 6px; padding: 4px 10px; margin-bottom: 8px; }

  /* Images */
  .msg-mockup-img { margin-top: 12px; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--pink-bd); max-width: 320px; }
  .msg-mockup-img img { width: 100%; display: block; cursor: pointer; }
  .msg-snapshot { margin-top: 12px; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--purple); max-width: 260px; }
  .msg-snapshot img { width: 100%; display: block; }
  .snap-label { text-align: center; padding: 8px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--purple-dk); background: var(--purple-bg); }

  .thread-date-divider { display: flex; align-items: center; gap: 12px; padding: 12px 24px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink-md); }
  .thread-date-divider::before, .thread-date-divider::after { content: ''; flex: 1; height: 1.5px; background: var(--grey-200); }

  /* ── Upload form ── */
  .upload-zone { position: relative; width: 100%; padding: 32px 16px; text-align: center; border: 2px dashed var(--grey-300); border-radius: 12px; background: var(--offwhite); cursor: pointer; transition: all 0.2s; }
  .upload-zone:hover { border-color: var(--pink); background: var(--pink-bg); }
  .upload-zone input[type=file] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
  #upload-preview { width: 100%; border-radius: 8px; display: none; margin-top: 16px; border: 1.5px solid var(--grey-200); }
</style>

{{-- ── Page header ── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.orders.index') }}" class="btn-ghost"><i data-lucide="arrow-left" style="width: 14px;"></i> Orders</a>
    <div>
      <h5 class="mb-0" style="font-family: var(--fh); font-size: 1.8rem; color: var(--ink);">{{ $order->order_code }}</h5>
      <small style="font-size: 0.85rem; font-weight: 700; color: var(--ink-md);">Placed {{ $order->created_at->format('F d, Y \a\t h:i A') }}</small>
    </div>
  </div>
  <div class="d-flex align-items-center gap-2">
    <span style="padding: 6px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}; border: 1.5px solid {{ $sc['text'] }};">
      {{ $order->statusLabel() ?? ucfirst($order->status) }}
    </span>
    <a href="{{ route('admin.orders.print', $order) }}" target="_blank" class="btn-ghost">
      <i data-lucide="printer" style="width: 14px;"></i> Print
    </a>
  </div>
</div>

<div class="row g-4">

  {{-- ══ LEFT COLUMN ══ --}}
  <div class="col-lg-7">

    {{-- Design Preview --}}
    <div class="ac-card mb-4">
      <div class="ac-card-header"><i data-lucide="palette"></i> Design Snapshot</div>
      <div class="p-4">
        @if($order->design && $order->design->snapshot_path)
          <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $order->design->snapshot_path) }}" style="max-width: 320px; width: 100%; border-radius: 12px; border: 1.5px solid var(--grey-200); background: var(--offwhite); padding: 8px;" alt="Design snapshot"/>
          </div>
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; font-size: 0.9rem;">
            @if($order->design->str_type) <div><div class="form-label">String</div><div class="fw-bold">{{ $order->design->str_type }}</div></div> @endif
            @if($order->design->str_color) <div><div class="form-label">Color</div><div class="d-flex align-items-center gap-2"><span style="width:16px;height:16px;border-radius:50%;background:{{ $order->design->str_color }};border:1.5px solid rgba(0,0,0,.1);"></span> <code style="font-size:0.8rem; font-weight: 800; color: var(--ink-md);">{{ $order->design->str_color }}</code></div></div> @endif
            @if($order->design->clasp) <div><div class="form-label">Clasp</div><div class="fw-bold">{{ $order->design->clasp }}</div></div> @endif
            @if($order->design->ring_type) <div><div class="form-label">Ring</div><div class="fw-bold">{{ $order->design->ring_type }}</div></div> @endif
          </div>
        @else
          <div class="text-center py-4" style="color: var(--ink-md);">
            <i data-lucide="image-off" style="width: 32px; height: 32px; margin-bottom: 8px;"></i>
            <div class="fw-bold">No snapshot attached</div>
          </div>
        @endif
      </div>
    </div>

    {{-- Thread --}}
    <div class="ac-card mb-4">
      <div class="ac-card-header">
        <i data-lucide="message-circle"></i> Communication Thread
        @if(isset($thread))
          <span style="margin-left: auto; padding: 4px 10px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; background:{{ $tsc['bg'] }}; color:{{ $tsc['text'] }}; border: 1.5px solid {{ $tsc['border'] }};">
            {{ $thread->statusLabel() }}
          </span>
        @endif
      </div>

      <div id="thread-scroll" style="min-height: 200px; max-height: 600px; overflow-y: auto;">
        @forelse($messages ?? [] as $i => $msg)
          @php $showDate = $i === 0 || $msg->created_at->toDateString() !== ($messages[$i-1]->created_at->toDateString() ?? ''); @endphp

          @if($showDate)
            <div class="thread-date-divider">{{ $msg->created_at->isToday() ? 'Today' : $msg->created_at->format('M d, Y') }}</div>
          @endif

          @if($msg->isFromAdmin())
            <div class="msg-row msg-admin">
              <div class="msg-bubble-wrap">
                <div class="msg-sender-name">You (Admin)</div>
                <div class="msg-bubble admin-bub">
                  <span class="msg-type-badge" style="{{ $msg->typeBadgeStyle() }}">{{ $msg->typeLabel() }}</span>
                  @if($msg->body) <div>{{ $msg->body }}</div> @endif
                  @if($msg->hasImage())
                    <div class="msg-mockup-img">
                      <img src="{{ asset('storage/' . $msg->image_path) }}" alt="Mockup Photo" onclick="openLb('{{ asset('storage/' . $msg->image_path) }}')"/>
                    </div>
                  @endif
                </div>
                <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
              </div>
              <div class="msg-avatar admin-av"><i data-lucide="sparkles" style="width: 20px;"></i></div>
            </div>
          @else
            @php $bubbleClass = match($msg->type) { 'approval' => 'approval-bub', 'revision' => 'revision-bub', default => 'customer-bub' }; @endphp
            <div class="msg-row msg-customer">
              <div class="msg-avatar customer-av">{{ strtoupper(substr($order->first_name, 0, 1)) }}</div>
              <div class="msg-bubble-wrap">
                <div class="msg-sender-name">{{ $order->first_name }}</div>
                <div class="msg-bubble {{ $bubbleClass }}">
                  <span class="msg-type-badge" style="{{ $msg->typeBadgeStyle() }}">{{ $msg->typeLabel() }}</span>
                  @if($msg->body) <div>{{ $msg->body }}</div> @endif
                  @if($msg->hasSnapshot())
                    <div class="msg-snapshot">
                      <img src="{{ asset('storage/' . $msg->snapshot_path) }}" alt="Revised"/>
                      <div class="snap-label">Revised Design</div>
                    </div>
                  @endif
                </div>
                <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
              </div>
            </div>
          @endif

        @empty
          <div class="text-center py-5" style="color: var(--ink-md);">
            <i data-lucide="message-circle" style="width: 32px; height: 32px; margin-bottom: 8px;"></i>
            <div class="fw-bold">No messages yet</div>
            <div style="font-size: 0.85rem;">Upload a mockup below to start the conversation.</div>
          </div>
        @endforelse
      </div>
    </div>

  </div>

  {{-- ══ RIGHT COLUMN ══ --}}
  <div class="col-lg-5">

    {{-- Send Mockup --}}
    <div class="ac-card mb-4">
      <div class="ac-card-header"><i data-lucide="upload-cloud"></i> Send Mockup to Customer</div>
      <div class="p-4">
        <form action="{{ route('admin.orders.mockup', $order) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="upload-zone mb-3">
            <input type="file" name="mockup_photo" accept="image/png,image/jpeg,image/webp" onchange="previewPhoto(this)" required/>
            <i data-lucide="camera" id="upload-icon" style="width: 36px; height: 36px; color: var(--pink); margin-bottom: 12px;"></i>
            <div class="fw-bold mb-1" id="upload-text" style="color: var(--ink);">Click or drop photo here</div>
            <div style="font-size: 0.75rem; color: var(--ink-md);">PNG, JPG, WEBP</div>
          </div>
          <img id="upload-preview" src="" alt="Preview"/>

          <div class="mt-3 mb-3">
            <label class="form-label">Message (optional)</label>
            <textarea name="note" class="form-control" rows="2" placeholder="e.g. Here's your mockup! Let us know if you'd like any changes."></textarea>
          </div>

          {{-- 👇 UPDATED TO PINK BUTTON 👇 --}}
          <button type="submit" class="btn-pink w-100 justify-content-center" id="upload-btn" disabled style="padding: 14px; font-size: 1rem;">
            <i data-lucide="send" style="width: 18px;"></i> Send Mockup
          </button>
        </form>
      </div>
    </div>

    {{-- Send Note --}}
    <div class="ac-card mb-4">
      <div class="ac-card-header"><i data-lucide="message-square"></i> Send Note</div>
      <div class="p-4">
        <form action="{{ route('admin.orders.note', $order) }}" method="POST">
          @csrf
          <div class="mb-3">
            <textarea name="body" class="form-control" rows="3" required placeholder="Type a message..."></textarea>
          </div>
          {{-- 👇 UPDATED TO GHOST BUTTON 👇 --}}
          <button type="submit" class="btn-ghost w-100 justify-content-center" style="padding: 14px; font-size: 1rem;">
            <i data-lucide="message-square" style="width: 18px;"></i> Send Note
          </button>
        </form>
      </div>
    </div>

    {{-- Customer Details --}}
    <div class="ac-card mb-4">
      <div class="ac-card-header"><i data-lucide="user"></i> Customer Info</div>
      <div class="p-4" style="font-size: 0.9rem;">
        <div class="d-flex justify-content-between mb-2"><span class="form-label mb-0">Name</span><span class="fw-bold">{{ $order->first_name }} {{ $order->last_name }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span class="form-label mb-0">Contact</span><span class="fw-bold">{{ $order->contact_number }}</span></div>
        @if($order->notes)
          <div class="mt-3 p-3 bg-light rounded border">
            <div class="form-label">Special Notes</div>
            <div style="font-weight: 700; color: var(--ink);">{{ $order->notes }}</div>
          </div>
        @endif
      </div>
    </div>

    {{-- Order Status Actions --}}
    @if($nextStatus || $canCancel)
      <div class="ac-card mb-4">
        <div class="ac-card-header"><i data-lucide="zap"></i> Update Order Status</div>
        <div class="p-4 d-flex flex-column gap-2">
          @if($nextStatus)
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
              @csrf
              <input type="hidden" name="status" value="{{ $nextStatus['status'] }}"/>
              {{-- 👇 UPDATED THEME-COLORED BUTTON 👇 --}}
              <button type="submit" class="btn w-100 fw-bold justify-content-center d-flex align-items-center gap-2" style="background:{{ $nextStatus['color'] }}; color:#fff; border-radius:10px; padding:14px; font-size:1rem; border:none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                <i data-lucide="{{ $nextStatus['icon'] }}" style="width: 18px;"></i> {{ $nextStatus['label'] }}
              </button>
            </form>
          @endif
          @if($canCancel)
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" onsubmit="return confirm('Cancel order {{ $order->order_code }}?')">
              @csrf
              <input type="hidden" name="status" value="cancelled"/>
              {{-- 👇 FIXED CANCEL BUTTON PADDING/STYLE 👇 --}}
              <button type="submit" class="btn-danger-ghost w-100 mt-2 justify-content-center d-flex align-items-center gap-2" style="padding: 14px; font-size: 1rem; border-radius: 10px; background: #fff; color: #DC2626; border: 1.5px solid #FECACA; font-weight: 800;">
                <i data-lucide="x-circle" style="width: 18px;"></i> Cancel Order
              </button>
            </form>
          @endif
        </div>
      </div>
    @endif

  </div>
</div>

{{-- Lightbox --}}
<div class="overlay" id="lightbox" onclick="closeLb()" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center;">
  <button onclick="closeLb()" style="position: absolute; top: 20px; right: 20px; background: #fff; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 1.5rem; font-weight: bold; cursor: pointer;">×</button>
  <img id="lb-img" src="" style="max-width: 90vw; max-height: 90vh; border-radius: 12px;"/>
</div>

<script>
  function previewPhoto(input) {
    if (!input.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      const img = document.getElementById('upload-preview');
      img.src = e.target.result;
      img.style.display = 'block';
      document.getElementById('upload-icon').outerHTML = '<div style="font-size:2rem; margin-bottom:12px;">✅</div>';
      document.getElementById('upload-text').textContent = input.files[0].name;
      document.getElementById('upload-btn').disabled = false;
    };
    reader.readAsDataURL(input.files[0]);
  }

  function openLb(src) {
    document.getElementById('lb-img').src = src;
    document.getElementById('lightbox').style.display = 'flex';
  }
  function closeLb() {
    document.getElementById('lightbox').style.display = 'none';
  }

  document.addEventListener('DOMContentLoaded', () => {
    const s = document.getElementById('thread-scroll');
    if (s) s.scrollTop = s.scrollHeight;
  });
</script>

@endsection