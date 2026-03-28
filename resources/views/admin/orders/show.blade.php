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

  $nextStatus = match($order->status) {
    'pending'     => ['status' => 'confirmed',   'label' => 'Confirm Order',  'color' => '#1D4ED8', 'icon' => 'check'],
    'confirmed'   => ['status' => 'in_progress', 'label' => 'Start Working',  'color' => '#7C3AED', 'icon' => 'wrench'],
    'in_progress' => ['status' => 'ready',       'label' => 'Mark as Ready',  'color' => '#059669', 'icon' => 'package-check'],
    'ready'       => ['status' => 'completed',   'label' => 'Complete Order', 'color' => '#065F46', 'icon' => 'circle-check'],
    default       => null,
  };

  $canCancel = ! in_array($order->status, ['completed', 'cancelled']);
  $sc  = $tabColors[$order->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151'];
  $tsc = $thread?->statusColor() ?? ['bg' => '#F3F4F6', 'text' => '#374151', 'border' => '#E5E7EB'];
@endphp

<style>
  /* ── Thread ─────────────────────────────────────────────────────────────── */
  .thread-msg { display:flex; gap:9px; padding:10px 0; }
  .thread-msg.from-admin    { justify-content:flex-start; }
  .thread-msg.from-customer { justify-content:flex-end; }

  .thread-av {
    width:30px;height:30px;border-radius:50%;flex-shrink:0;align-self:flex-end;
    display:flex;align-items:center;justify-content:center;font-size:.68rem;font-weight:900;
  }
  .av-admin    { background:var(--pink-lt,#FFD6E8);color:var(--pink-dk,#C0136A); }
  .av-customer { background:#D1FAE5;color:#065F46; }

  .thread-bw { max-width:72%;display:flex;flex-direction:column; }
  .from-admin    .thread-bw { align-items:flex-start; }
  .from-customer .thread-bw { align-items:flex-end; }

  .thread-sender { font-size:.62rem;font-weight:700;color:var(--grey-400);margin-bottom:3px;padding:0 3px; }

  .thread-bubble { padding:10px 13px;border-radius:12px;font-size:.8rem;font-weight:600;line-height:1.5; }
  .bub-admin    { background:var(--grey-50);border:1.5px solid var(--grey-200);color:var(--ink);border-bottom-left-radius:3px; }
  .bub-customer { background:#F0FDF4;border:1.5px solid #A7F3D0;color:#065F46;border-bottom-right-radius:3px; }
  .bub-approval { background:#D1FAE5;border-color:#6EE7B7; }
  .bub-revision { background:#F3E8FF;border-color:#DDD6FE;color:#6D28D9;border-bottom-right-radius:3px; }
  .bub-note-customer { background:#FEF3C7;border-color:#FDE68A;color:#92400E;border-bottom-right-radius:3px; }

  .thread-type-badge {
    display:inline-block;font-size:.58rem;font-weight:800;
    text-transform:uppercase;letter-spacing:.05em;
    border-radius:4px;padding:2px 6px;margin-bottom:5px;
  }

  .thread-time { font-size:.6rem;color:var(--grey-400);font-weight:600;margin-top:4px;padding:0 3px; }

  /* Mockup image uses image_path */
  .mockup-img-wrap {
    margin-top:9px;border-radius:9px;overflow:hidden;
    border:1.5px solid var(--grey-200);max-width:260px;cursor:pointer;
  }
  .mockup-img-wrap img { width:100%;display:block;transition:opacity .13s; }
  .mockup-img-wrap img:hover { opacity:.88; }
  .mockup-img-footer {
    text-align:center;padding:5px;font-size:.65rem;font-weight:700;
    color:var(--grey-400);background:var(--grey-50);border-top:1px solid var(--grey-200);
  }

  /* Revised design snapshot */
  .snap-wrap { margin-top:9px;border-radius:9px;overflow:hidden;border:1.5px solid #DDD6FE;max-width:200px; }
  .snap-wrap img { width:100%;display:block; }
  .snap-foot { text-align:center;padding:5px;font-size:.65rem;font-weight:700;color:#6D28D9;background:#F3E8FF; }

  .thread-date-sep {
    display:flex;align-items:center;gap:10px;margin:6px 0;
    font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--grey-300);
  }
  .thread-date-sep::before,.thread-date-sep::after { content:'';flex:1;height:1px;background:var(--grey-200); }

  /* ── Upload form ─────────────────────────────────────────────────────────── */
  .ac-form-label { display:block;font-size:.72rem;font-weight:700;color:var(--grey-400);text-transform:uppercase;letter-spacing:.05em;margin-bottom:5px; }
  .ac-form-input { width:100%;padding:8px 11px;border:1.5px solid var(--grey-200);border-radius:8px;font-family:'Segoe UI',system-ui,sans-serif;font-size:.8rem;color:var(--ink);background:var(--white);outline:none;transition:border-color .13s; }
  .ac-form-input:focus { border-color:var(--pink); }

  .upload-zone {
    position:relative;width:100%;padding:28px 16px;text-align:center;
    border:2px dashed var(--grey-200);border-radius:10px;
    background:var(--grey-50);cursor:pointer;transition:border-color .13s,background .13s;
  }
  .upload-zone:hover { border-color:var(--pink);background:#FFF8FB; }
  .upload-zone input[type=file] { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
  #upload-preview { width:100%;border-radius:8px;display:none;margin-top:10px;border:1px solid var(--grey-200); }

  .btn-send-mockup {
    width:100%;padding:10px;border:none;border-radius:8px;cursor:pointer;
    font-family:'Segoe UI',system-ui,sans-serif;font-weight:800;font-size:.84rem;
    background:var(--pink);color:#fff;transition:background .13s;
  }
  .btn-send-mockup:hover { background:var(--pink-dk); }
  .btn-send-mockup:disabled { background:var(--grey-300);cursor:not-allowed; }

  .btn-send-note {
    width:100%;padding:9px;border:none;border-radius:8px;cursor:pointer;
    font-family:'Segoe UI',system-ui,sans-serif;font-weight:700;font-size:.8rem;
    background:var(--ink);color:#fff;transition:background .13s;
  }
  .btn-send-note:hover { background:var(--ink-2); }

  /* Lightbox */
  .lb-overlay { display:none;position:fixed;inset:0;background:rgba(0,0,0,.72);z-index:9999;align-items:center;justify-content:center; }
  .lb-overlay.open { display:flex; }
  .lb-overlay img { max-width:90vw;max-height:88vh;border-radius:12px; }
  .lb-close { position:fixed;top:16px;right:20px;background:#fff;border:none;border-radius:50%;width:36px;height:36px;cursor:pointer;font-size:1.1rem;font-weight:900;display:flex;align-items:center;justify-content:center; }
</style>

{{-- ── Page header ──────────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
  <div class="d-flex align-items-center gap-3">
    <a href="{{ route('admin.orders.index') }}"
       style="color:var(--grey-400);text-decoration:none;font-size:.85rem;">← Orders</a>
    <span style="color:var(--grey-200);">/</span>
    <div>
      <h5 class="mb-0 fw-bold font-monospace" style="color:var(--ink);font-size:1rem;">
        {{ $order->order_code }}
      </h5>
      <small style="color:var(--grey-400);">
        Placed {{ $order->created_at->format('F d, Y \a\t h:i A') }}
      </small>
    </div>
  </div>
  <div class="d-flex align-items-center gap-2">
    <span style="padding:4px 14px;border-radius:20px;font-size:.77rem;font-weight:700;
                 background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
      {{ $order->statusLabel() }}
    </span>
    @if($thread)
      <span style="padding:4px 12px;border-radius:20px;font-size:.72rem;font-weight:700;
                   background:{{ $tsc['bg'] }};color:{{ $tsc['text'] }};
                   border:1px solid {{ $tsc['border'] }};">
        {{ $thread->statusIcon() }} {{ $thread->statusLabel() }}
      </span>
    @endif
    <a href="{{ route('admin.orders.print', $order) }}" target="_blank"
       class="btn btn-sm"
       style="background:var(--grey-100);color:var(--ink-2);border:1px solid var(--grey-200);
              border-radius:7px;font-size:.78rem;padding:5px 12px;
              display:inline-flex;align-items:center;gap:5px;">
      <i data-lucide="printer" style="width:13px;height:13px;"></i> Print
    </a>
  </div>
</div>

<div class="row g-3">

  {{-- ═══════════════════════════════════════════════════════════════════════
       LEFT COLUMN
  ══════════════════════════════════════════════════════════════════════════ --}}
  <div class="col-lg-7">

    {{-- Design Preview ──────────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header"><i data-lucide="palette"></i> Design Preview</div>
      <div class="p-4">
        @if($order->design)
          @php $d = $order->design; @endphp
          @if($d->snapshot_path)
            <div class="text-center mb-3">
              <img src="{{ asset('storage/' . $d->snapshot_path) }}"
                   style="max-width:280px;width:100%;border-radius:12px;
                          border:1px solid var(--grey-200);background:var(--grey-50);padding:8px;"
                   alt="Design snapshot"/>
            </div>
          @else
            <div style="text-align:center;padding:24px;background:var(--grey-50);
                        border-radius:10px;border:1px dashed var(--grey-200);margin-bottom:16px;">
              <i data-lucide="image-off" style="width:28px;height:28px;color:var(--grey-400);"></i>
              <p class="mb-0 mt-2" style="font-size:.78rem;color:var(--grey-400);">No snapshot</p>
            </div>
          @endif
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px 16px;font-size:.8rem;">
            @if($d->str_type)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">String</div>
                <div class="fw-semibold">{{ $d->str_type }}</div>
              </div>
            @endif
            @if($d->str_color)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Color</div>
                <div class="d-flex align-items-center gap-2">
                  <span style="width:14px;height:14px;border-radius:50%;display:inline-block;
                               background:{{ $d->str_color }};border:1px solid rgba(0,0,0,.1);flex-shrink:0;"></span>
                  <code style="font-size:.73rem;">{{ $d->str_color }}</code>
                </div>
              </div>
            @endif
            @if($d->clasp) <div><div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Clasp</div><div class="fw-semibold">{{ $d->clasp }}</div></div> @endif
            @if($d->ring_type) <div><div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Ring</div><div class="fw-semibold">{{ $d->ring_type }}</div></div> @endif
            @if($d->letter_shape) <div><div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Letter Shape</div><div class="fw-semibold">{{ $d->letter_shape }}</div></div> @endif
            @if($d->keychain_strands > 1) <div><div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Strands</div><div class="fw-semibold">{{ $d->keychain_strands }}</div></div> @endif
          </div>
        @else
          <div style="text-align:center;padding:24px;color:var(--grey-400);">
            <i data-lucide="box" style="width:28px;height:28px;"></i>
            <p class="mb-0 mt-2" style="font-size:.78rem;">No design attached.</p>
          </div>
        @endif
      </div>
    </div>

    {{-- Order Items ─────────────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header">
        <i data-lucide="list-ordered"></i> Elements on Design
        <span class="ms-auto badge" style="background:var(--grey-100);color:var(--grey-600);font-size:.7rem;">
          {{ $order->items->count() }} items
        </span>
      </div>
      @if($order->items->isEmpty())
        <div class="p-4 text-center" style="color:var(--grey-400);font-size:.82rem;">No items recorded.</div>
      @else
        @php $byStrand = $order->items->groupBy('strand'); $multi = $byStrand->keys()->count() > 1; @endphp
        @foreach($byStrand as $strand => $items)
          @if($multi)
            <div style="padding:8px 16px 2px;font-size:.65rem;font-weight:700;text-transform:uppercase;
                        letter-spacing:.08em;color:var(--grey-400);border-top:1px solid var(--grey-100);">
              Strand {{ $strand + 1 }}
            </div>
          @endif
          <div style="padding:6px 12px;">
            @foreach($items as $item)
              <div style="display:flex;align-items:center;gap:10px;padding:6px 8px;border-radius:8px;transition:background .1s;"
                   onmouseenter="this.style.background='var(--grey-50)'"
                   onmouseleave="this.style.background='transparent'">
                <span style="width:22px;height:22px;border-radius:50%;background:var(--grey-100);
                             color:var(--grey-600);font-size:.65rem;font-weight:700;flex-shrink:0;
                             display:flex;align-items:center;justify-content:center;">
                  {{ $item->sort_order + 1 }}
                </span>
                @if($item->isLetter())
                  <div style="width:30px;height:30px;border-radius:6px;flex-shrink:0;
                              background:{{ $item->letter_bg ?? '#F9B8CF' }};
                              color:{{ $item->letter_text_color ?? '#C0136A' }};
                              display:flex;align-items:center;justify-content:center;
                              font-weight:900;font-size:.85rem;border:1px solid rgba(0,0,0,.08);">
                    {{ strtoupper($item->letter) }}
                  </div>
                  <div style="flex:1;font-size:.8rem;font-weight:600;color:var(--ink);">Letter "{{ strtoupper($item->letter) }}"</div>
                @else
                  @php $el = $item->element; @endphp
                  @if($el?->img_path)
                    <img src="{{ asset('img/builder/' . $el->img_path) }}"
                         style="width:30px;height:30px;object-fit:contain;border-radius:6px;
                                background:var(--grey-100);border:1px solid var(--grey-200);flex-shrink:0;"/>
                  @else
                    <div style="width:30px;height:30px;border-radius:50%;flex-shrink:0;
                                background:{{ $el->color ?? '#F9B8CF' }};border:1.5px solid rgba(0,0,0,.08);"></div>
                  @endif
                  <div style="flex:1;font-size:.8rem;font-weight:600;color:var(--ink);">{{ $el->name ?? '(deleted)' }}</div>
                @endif
                <span style="font-size:.77rem;font-weight:700;color:var(--pink);flex-shrink:0;">₱{{ $item->price_at_order }}</span>
              </div>
            @endforeach
          </div>
        @endforeach
      @endif
    </div>

    {{-- ══════════════════════════════════════════════════════════════════════
         COMMUNICATION THREAD
    ══════════════════════════════════════════════════════════════════════ --}}
    <div class="ac-card mb-3" id="thread-card">
      <div class="ac-card-header">
        <i data-lucide="message-circle"></i>
        Communication Thread
        @if($thread)
          <span style="margin-left:6px;padding:2px 9px;border-radius:12px;font-size:.68rem;font-weight:700;
                       background:{{ $tsc['bg'] }};color:{{ $tsc['text'] }};">
            {{ $thread->statusIcon() }} {{ $thread->statusLabel() }}
          </span>
          @if($thread->revision_count > 0)
            <span style="font-size:.65rem;color:var(--grey-400);font-weight:600;margin-left:4px;">
              · {{ $thread->revision_count }} revision{{ $thread->revision_count > 1 ? 's' : '' }}
            </span>
          @endif
        @endif
        <a href="{{ route('account.orders.show', $order->order_code) }}" target="_blank"
           class="ms-auto" style="font-size:.7rem;color:var(--grey-400);text-decoration:none;
                                  display:flex;align-items:center;gap:4px;">
          <i data-lucide="external-link" style="width:11px;height:11px;"></i>
          Customer view
        </a>
      </div>

      {{-- Messages ─────────────────────────────────────────────────────────── --}}
      <div id="thread-scroll"
           style="padding:8px 20px;min-height:80px;max-height:500px;overflow-y:auto;">

        @forelse($messages as $i => $msg)

          @php
            $showDate = $i === 0 ||
              $msg->created_at->toDateString() !== $messages[$i-1]->created_at->toDateString();
          @endphp

          @if($showDate)
            <div class="thread-date-sep">
              {{ $msg->created_at->isToday() ? 'Today' : $msg->created_at->format('M d, Y') }}
            </div>
          @endif

          {{-- Admin messages: mockup, note ────────────────────────────────── --}}
          @if($msg->isFromAdmin())
            <div class="thread-msg from-admin">
              <div class="thread-av av-admin">🌸</div>
              <div class="thread-bw">
                <div class="thread-sender">
                  {{ $msg->user?->name ?? 'Admin' }}
                </div>
                <div class="thread-bubble bub-admin">
                  <span class="thread-type-badge" style="{{ $msg->typeBadgeStyle() }}">
                    {{ $msg->typeLabel() }}
                  </span>
                  @if($msg->body)
                    <div>{{ $msg->body }}</div>
                  @endif

                  {{-- Mockup photo — uses image_path ───────────────────────── --}}
                  @if($msg->hasImage())
                    <div class="mockup-img-wrap"
                         onclick="openLb('{{ asset('storage/' . $msg->image_path) }}')">
                      <img src="{{ asset('storage/' . $msg->image_path) }}" alt="Mockup"/>
                      <div class="mockup-img-footer">
                        <i data-lucide="zoom-in" style="width:10px;height:10px;"></i>
                        Click to enlarge
                      </div>
                    </div>
                  @endif
                </div>
                <div class="thread-time">{{ $msg->created_at->format('h:i A') }}</div>
              </div>
            </div>

          {{-- Customer messages: approval, revision, note ───────────────────── --}}
          @else
            @php
              $extraClass = match($msg->type) {
                'approval' => 'bub-approval',
                'revision' => 'bub-revision',
                'note'     => 'bub-note-customer',
                default    => '',
              };
            @endphp
            <div class="thread-msg from-customer">
              <div class="thread-bw">
                <div class="thread-sender">
                  {{ $order->first_name }} {{ $order->last_name }}
                </div>
                <div class="thread-bubble bub-customer {{ $extraClass }}">
                  <span class="thread-type-badge" style="{{ $msg->typeBadgeStyle() }}">
                    {{ $msg->typeLabel() }}
                  </span>
                  @if($msg->body)
                    <div>{{ $msg->body }}</div>
                  @endif

                  {{-- Revised design snapshot ────────────────────────────── --}}
                  @if($msg->hasSnapshot())
                    <div class="snap-wrap">
                      <img src="{{ asset('storage/' . $msg->snapshot_path) }}" alt="Revised"/>
                      <div class="snap-foot">Revised Design</div>
                    </div>
                  @endif
                </div>
                <div class="thread-time">{{ $msg->created_at->format('h:i A') }}</div>
              </div>
              <div class="thread-av av-customer">
                {{ strtoupper(substr($order->first_name, 0, 1)) }}
              </div>
            </div>
          @endif

        @empty
          <div style="text-align:center;padding:28px;color:var(--grey-400);">
            <i data-lucide="message-circle" style="width:24px;height:24px;display:block;margin:0 auto 8px;"></i>
            <div style="font-size:.78rem;font-weight:700;">No messages yet</div>
            <div style="font-size:.7rem;margin-top:3px;">Upload a mockup below to start.</div>
          </div>
        @endforelse

      </div>{{-- /#thread-scroll --}}

    </div>

  </div>{{-- /col-lg-7 --}}

  {{-- ═══════════════════════════════════════════════════════════════════════
       RIGHT COLUMN
  ══════════════════════════════════════════════════════════════════════════ --}}
  <div class="col-lg-5">

    {{-- Customer Info --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header"><i data-lucide="user"></i> Customer</div>
      <div class="p-4">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div style="width:42px;height:42px;border-radius:50%;background:var(--pink-lt,#FFD6E8);
                      color:var(--pink);font-weight:800;font-size:1rem;
                      display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            {{ strtoupper(substr($order->first_name, 0, 1)) }}
          </div>
          <div>
            <div class="fw-bold" style="color:var(--ink);">{{ $order->first_name }} {{ $order->last_name }}</div>
            <div style="font-size:.8rem;color:var(--grey-400);">{{ $order->contact_number }}</div>
          </div>
        </div>
        @if($order->notes)
          <div style="background:var(--grey-50);border:1px solid var(--grey-200);border-radius:8px;padding:10px 12px;">
            <div style="font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:var(--grey-400);margin-bottom:4px;">Notes</div>
            <p class="mb-0" style="font-size:.82rem;color:var(--ink-2);line-height:1.5;">{{ $order->notes }}</p>
          </div>
        @endif
      </div>
    </div>

    {{-- Order Summary --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header"><i data-lucide="receipt"></i> Order Summary</div>
      <div class="p-4" style="font-size:.82rem;">
        <div class="d-flex justify-content-between mb-2"><span style="color:var(--grey-400);">Product</span><span class="fw-semibold">{{ $order->product->label ?? '—' }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span style="color:var(--grey-400);">Length</span><span class="fw-semibold">{{ $order->length }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span style="color:var(--grey-400);">Base Price</span><span>₱{{ number_format($order->base_price) }}</span></div>
        <div class="d-flex justify-content-between mb-2"><span style="color:var(--grey-400);">Elements</span><span>₱{{ number_format($order->elements_cost) }}</span></div>
        <div style="height:1px;background:var(--grey-200);margin:10px 0;"></div>
        <div class="d-flex justify-content-between">
          <span class="fw-bold">Total</span>
          <span class="fw-bold" style="font-size:1.05rem;color:var(--pink);">₱{{ number_format($order->total_price) }}</span>
        </div>
      </div>
    </div>

    {{-- ── Upload Mockup ─────────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3" style="border-color:#E8D5F7;">
      <div class="ac-card-header" style="background:linear-gradient(135deg,#F3E8FF,#EDE9FE);">
        <i data-lucide="upload-cloud"></i>
        Upload Mockup Photo
      </div>
      <div class="p-4">
        <form action="{{ route('admin.orders.mockup', $order) }}"
              method="POST" enctype="multipart/form-data">
          @csrf

          <div class="upload-zone mb-3">
            <input type="file" name="mockup_photo"
                   accept="image/png,image/jpeg,image/webp"
                   onchange="previewPhoto(this)" required/>
            <div style="font-size:1.4rem;margin-bottom:6px;" id="upload-icon">📷</div>
            <div style="font-size:.75rem;font-weight:700;color:var(--grey-400);" id="upload-text">
              Click or drop a photo here
            </div>
            <div style="font-size:.67rem;color:var(--grey-300);margin-top:2px;">
              PNG, JPG, WEBP — max 8 MB
            </div>
          </div>

          <img id="upload-preview" src="" alt="Preview"/>

          <div class="mb-3">
            <label class="ac-form-label">Message to Customer (optional)</label>
            <textarea name="note" class="ac-form-input" rows="2"
                      placeholder="e.g. Here's your mockup! Let us know if you'd like any changes."></textarea>
          </div>

          <button type="submit" class="btn-send-mockup" id="upload-btn" disabled>
            <i data-lucide="send" style="width:14px;height:14px;display:inline;vertical-align:middle;"></i>
            Send Mockup to Customer
          </button>

        </form>
      </div>
    </div>

    {{-- ── Send Note ─────────────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header"><i data-lucide="message-square"></i> Send a Note</div>
      <div class="p-4">
        <form action="{{ route('admin.orders.note', $order) }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="ac-form-label">Message</label>
            <textarea name="body" class="ac-form-input" rows="3" required
                      placeholder="e.g. We'll start on this tomorrow! Thanks for your patience."></textarea>
          </div>
          <button type="submit" class="btn-send-note">
            <i data-lucide="send" style="width:13px;height:13px;display:inline;vertical-align:middle;"></i>
            Send Note
          </button>
        </form>
      </div>
    </div>

    {{-- Timeline --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header"><i data-lucide="clock"></i> Timeline</div>
      <div class="p-4">
        @php
          $timeline = [
            ['label' => 'Order Placed', 'at' => $order->created_at,   'icon' => 'shopping-bag'],
            ['label' => 'Confirmed',    'at' => $order->confirmed_at, 'icon' => 'check-circle'],
            ['label' => 'Completed',    'at' => $order->completed_at, 'icon' => 'package-check'],
            ['label' => 'Cancelled',    'at' => $order->cancelled_at, 'icon' => 'x-circle'],
          ];
          if($thread?->approved_at)
            $timeline[] = ['label' => 'Design Approved', 'at' => $thread->approved_at, 'icon' => 'check-square'];
        @endphp
        @foreach($timeline as $t)
          @if($t['at'])
            <div class="d-flex gap-3 mb-3 align-items-start">
              <div style="width:28px;height:28px;border-radius:50%;flex-shrink:0;
                          background:{{ $t['label']==='Cancelled' ? '#FEE2E2' : '#D1FAE5' }};
                          color:{{ $t['label']==='Cancelled' ? '#991B1B' : '#065F46' }};
                          display:flex;align-items:center;justify-content:center;">
                <i data-lucide="{{ $t['icon'] }}" style="width:13px;height:13px;"></i>
              </div>
              <div>
                <div style="font-size:.8rem;font-weight:600;color:var(--ink);">{{ $t['label'] }}</div>
                <div style="font-size:.72rem;color:var(--grey-400);">
                  {{ $t['at']->format('M d, Y · h:i A') }}
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>

    {{-- Order Status Actions --}}
    @if($nextStatus || $canCancel)
      <div class="ac-card">
        <div class="ac-card-header"><i data-lucide="zap"></i> Update Order Status</div>
        <div class="p-4 d-flex flex-column gap-2">
          @if($nextStatus)
            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
              @csrf
              <input type="hidden" name="status" value="{{ $nextStatus['status'] }}"/>
              <button type="submit" class="btn w-100 fw-bold"
                      style="background:{{ $nextStatus['color'] }};color:#fff;border-radius:10px;
                             padding:10px 16px;font-size:.88rem;border:none;cursor:pointer;
                             display:flex;align-items:center;justify-content:center;gap:7px;">
                <i data-lucide="{{ $nextStatus['icon'] }}" style="width:15px;height:15px;"></i>
                {{ $nextStatus['label'] }}
              </button>
            </form>
          @else
            <div style="text-align:center;padding:8px;font-size:.82rem;color:var(--grey-400);">
              @if($order->status === 'completed') ✅ Order fully completed.
              @elseif($order->status === 'cancelled') ❌ Order cancelled.
              @endif
            </div>
          @endif
          @if($canCancel)
            <form action="{{ route('admin.orders.status', $order) }}" method="POST"
                  onsubmit="return confirm('Cancel order {{ $order->order_code }}?')">
              @csrf
              <input type="hidden" name="status" value="cancelled"/>
              <button type="submit" class="btn btn-sm w-100"
                      style="background:#FEE2E2;color:#991B1B;border:none;border-radius:8px;
                             padding:7px 16px;font-size:.8rem;font-weight:600;cursor:pointer;
                             display:flex;align-items:center;justify-content:center;gap:6px;">
                <i data-lucide="x" style="width:12px;height:12px;"></i>
                Cancel Order
              </button>
            </form>
          @endif
        </div>
      </div>
    @endif

  </div>{{-- /col-lg-5 --}}

</div>{{-- /row --}}

{{-- Lightbox --}}
<div class="lb-overlay" id="lightbox" onclick="closeLb()">
  <button class="lb-close" onclick="closeLb()">×</button>
  <img id="lb-img" src="" alt="" onclick="event.stopPropagation()"/>
</div>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    // Scroll thread to bottom
    const s = document.getElementById('thread-scroll');
    if (s) s.scrollTop = s.scrollHeight;
  });

  function previewPhoto(input) {
    if (!input.files?.[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      const img = document.getElementById('upload-preview');
      img.src = e.target.result;
      img.style.display = 'block';
      document.getElementById('upload-icon').textContent = '✅';
      document.getElementById('upload-text').textContent = input.files[0].name;
      document.getElementById('upload-btn').disabled = false;
    };
    reader.readAsDataURL(input.files[0]);
  }

  function openLb(src) {
    document.getElementById('lb-img').src = src;
    document.getElementById('lightbox').classList.add('open');
  }
  function closeLb() {
    document.getElementById('lightbox').classList.remove('open');
  }
</script>
@endpush