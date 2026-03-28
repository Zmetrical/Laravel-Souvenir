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

  // Next logical status + button label
  $nextStatus = match($order->status) {
    'pending'     => ['status' => 'confirmed',   'label' => 'Confirm Order',  'color' => '#1D4ED8', 'icon' => 'check'],
    'confirmed'   => ['status' => 'in_progress', 'label' => 'Start Working',  'color' => '#7C3AED', 'icon' => 'wrench'],
    'in_progress' => ['status' => 'ready',       'label' => 'Mark as Ready',  'color' => '#059669', 'icon' => 'package-check'],
    'ready'       => ['status' => 'completed',   'label' => 'Complete Order', 'color' => '#065F46', 'icon' => 'circle-check'],
    default       => null,
  };

  $canCancel = ! in_array($order->status, ['completed', 'cancelled']);
  $sc = $tabColors[$order->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151'];
@endphp

{{-- ── Breadcrumb + header ──────────────────────────────────────────────── --}}
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
       LEFT COLUMN — Design + Order Items
  ══════════════════════════════════════════════════════════════════════════ --}}
  <div class="col-lg-7">

    {{-- Design Preview ──────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header">
        <i data-lucide="palette"></i> Design Preview
      </div>
      <div class="p-4">

        @if($order->design)
          @php $d = $order->design; @endphp

          {{-- Snapshot image --}}
          @if($d->snapshot_path)
            <div class="text-center mb-3">
              <img src="{{ asset('storage/' . $d->snapshot_path) }}"
                   style="max-width:280px;width:100%;border-radius:12px;
                          border:1px solid var(--grey-200);background:var(--grey-50);
                          padding:8px;"
                   alt="Design snapshot"/>
            </div>
          @else
            <div style="text-align:center;padding:24px;background:var(--grey-50);
                        border-radius:10px;border:1px dashed var(--grey-200);margin-bottom:16px;">
              <i data-lucide="image-off" style="width:28px;height:28px;color:var(--grey-400);"></i>
              <p class="mb-0 mt-2" style="font-size:.78rem;color:var(--grey-400);">No snapshot available</p>
            </div>
          @endif

          {{-- Design specs grid --}}
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px 16px;font-size:.8rem;">

            @if($d->str_type)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">String Type</div>
                <div class="fw-semibold" style="color:var(--ink);">{{ $d->str_type }}</div>
              </div>
            @endif

            @if($d->str_color)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">String Color</div>
                <div class="d-flex align-items-center gap-2">
                  <span style="width:16px;height:16px;border-radius:50%;display:inline-block;
                               background:{{ $d->str_color }};border:1px solid rgba(0,0,0,.1);flex-shrink:0;"></span>
                  <code style="font-size:.75rem;">{{ $d->str_color }}</code>
                </div>
              </div>
            @endif

            @if($d->clasp)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Clasp</div>
                <div class="fw-semibold" style="color:var(--ink);">{{ $d->clasp }}</div>
              </div>
            @endif

            @if($d->view)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">View</div>
                <div class="fw-semibold" style="color:var(--ink);">{{ $d->view }}</div>
              </div>
            @endif

            @if($d->ring_type)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Ring Type</div>
                <div class="fw-semibold" style="color:var(--ink);">{{ $d->ring_type }}</div>
              </div>
            @endif

            @if($d->ring_color)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Ring Color</div>
                <div class="d-flex align-items-center gap-2">
                  <span style="width:16px;height:16px;border-radius:50%;display:inline-block;
                               background:{{ $d->ring_color }};border:1px solid rgba(0,0,0,.1);flex-shrink:0;"></span>
                  <code style="font-size:.75rem;">{{ $d->ring_color }}</code>
                </div>
              </div>
            @endif

            @if($d->keychain_strands > 1)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Strands</div>
                <div class="fw-semibold" style="color:var(--ink);">{{ $d->keychain_strands }}</div>
              </div>
            @endif

            @if($d->letter_shape)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Letter Shape</div>
                <div class="fw-semibold" style="color:var(--ink);">{{ $d->letter_shape }}</div>
              </div>
            @endif

            @if($d->letter_bg_color)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Letter BG</div>
                <div class="d-flex align-items-center gap-2">
                  <span style="width:16px;height:16px;border-radius:50%;display:inline-block;
                               background:{{ $d->letter_bg_color }};border:1px solid rgba(0,0,0,.1);flex-shrink:0;"></span>
                  <code style="font-size:.75rem;">{{ $d->letter_bg_color }}</code>
                </div>
              </div>
            @endif

            @if($d->letter_text_color)
              <div>
                <div style="color:var(--grey-400);font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;">Letter Text</div>
                <div class="d-flex align-items-center gap-2">
                  <span style="width:16px;height:16px;border-radius:50%;display:inline-block;
                               background:{{ $d->letter_text_color }};border:1px solid rgba(0,0,0,.1);flex-shrink:0;"></span>
                  <code style="font-size:.75rem;">{{ $d->letter_text_color }}</code>
                </div>
              </div>
            @endif

          </div>

        @else
          <div style="text-align:center;padding:24px;color:var(--grey-400);">
            <i data-lucide="box" style="width:28px;height:28px;"></i>
            <p class="mb-0 mt-2" style="font-size:.78rem;">No design attached to this order.</p>
          </div>
        @endif

      </div>
    </div>

    {{-- Order Items ─────────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header">
        <i data-lucide="list-ordered"></i>
        Elements on Design
        <span class="ms-auto badge" style="background:var(--grey-100);color:var(--grey-600);font-size:.7rem;">
          {{ $order->items->count() }} items
        </span>
      </div>

      @if($order->items->isEmpty())
        <div class="p-4 text-center" style="color:var(--grey-400);font-size:.82rem;">
          No items recorded for this order.
        </div>
      @else
        {{-- Group items by strand --}}
        @php
          $byStrand = $order->items->groupBy('strand');
          $multiStrand = $byStrand->keys()->count() > 1;
        @endphp

        @foreach($byStrand as $strand => $items)
          @if($multiStrand)
            <div style="padding:8px 16px 2px;font-size:.65rem;font-weight:700;
                        text-transform:uppercase;letter-spacing:.08em;
                        color:var(--grey-400);border-top:1px solid var(--grey-100);">
              Strand {{ $strand + 1 }}
            </div>
          @endif

          <div style="padding:6px 12px;">
            @foreach($items as $item)
              <div style="display:flex;align-items:center;gap:10px;
                          padding:6px 8px;border-radius:8px;
                          transition:background .1s;"
                   onmouseenter="this.style.background='var(--grey-50)'"
                   onmouseleave="this.style.background='transparent'">

                {{-- Position number --}}
                <span style="width:22px;height:22px;border-radius:50%;
                             background:var(--grey-100);color:var(--grey-600);
                             font-size:.65rem;font-weight:700;flex-shrink:0;
                             display:flex;align-items:center;justify-content:center;">
                  {{ $item->sort_order + 1 }}
                </span>

                {{-- Element or letter --}}
                @if($item->isLetter())
                  {{-- Letter bead --}}
                  <div style="width:32px;height:32px;border-radius:6px;flex-shrink:0;
                              background:{{ $item->letter_bg ?? '#F9B8CF' }};
                              color:{{ $item->letter_text_color ?? '#C0136A' }};
                              display:flex;align-items:center;justify-content:center;
                              font-weight:900;font-size:.85rem;
                              border:1px solid rgba(0,0,0,.08);">
                    {{ strtoupper($item->letter) }}
                  </div>
                  <div style="flex:1;">
                    <div style="font-size:.8rem;font-weight:600;color:var(--ink);">
                      Letter "{{ strtoupper($item->letter) }}"
                    </div>
                    <div style="font-size:.7rem;color:var(--grey-400);">
                      {{ $item->letter_shape ?? 'Standard' }} shape
                    </div>
                  </div>
                @else
                  {{-- Regular element --}}
                  @php $el = $item->element; @endphp
                  @if($el && $el->img_path)
                    <img src="{{ asset('img/builder/' . $el->img_path) }}"
                         style="width:32px;height:32px;object-fit:contain;border-radius:6px;
                                background:var(--grey-100);border:1px solid var(--grey-200);
                                flex-shrink:0;"/>
                  @elseif($el)
                    <div style="width:32px;height:32px;border-radius:50%;flex-shrink:0;
                                background:{{ $el->color ?? '#F9B8CF' }};
                                border:1.5px solid rgba(0,0,0,.08);"></div>
                  @else
                    <div style="width:32px;height:32px;border-radius:50%;flex-shrink:0;
                                background:var(--grey-200);"></div>
                  @endif
                  <div style="flex:1;">
                    <div style="font-size:.8rem;font-weight:600;color:var(--ink);">
                      {{ $el->name ?? '(deleted element)' }}
                    </div>
                    @if($el)
                    <div style="font-size:.7rem;color:var(--grey-400);">
                      {{ ucfirst($el->category) }}{{ $el->shape ? ' · ' . $el->shape : '' }}
                    </div>
                    @endif
                  </div>
                @endif

                {{-- Price --}}
                <span style="font-size:.77rem;font-weight:700;color:var(--pink);flex-shrink:0;">
                  ₱{{ $item->price_at_order }}
                </span>

              </div>
            @endforeach
          </div>
        @endforeach
      @endif

    </div>

  </div>{{-- /col-lg-7 --}}

  {{-- ═══════════════════════════════════════════════════════════════════════
       RIGHT COLUMN — Customer + Pricing + Status Actions
  ══════════════════════════════════════════════════════════════════════════ --}}
  <div class="col-lg-5">

    {{-- Customer Info ───────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header">
        <i data-lucide="user"></i> Customer
      </div>
      <div class="p-4">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div style="width:42px;height:42px;border-radius:50%;
                      background:var(--pink-lt,#FFD6E8);
                      color:var(--pink);font-weight:800;font-size:1rem;
                      display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            {{ strtoupper(substr($order->first_name, 0, 1)) }}
          </div>
          <div>
            <div class="fw-bold" style="color:var(--ink);">
              {{ $order->first_name }} {{ $order->last_name }}
            </div>
            <div style="font-size:.8rem;color:var(--grey-400);">
              {{ $order->contact_number }}
            </div>
          </div>
        </div>

        @if($order->notes)
          <div style="background:var(--grey-50);border:1px solid var(--grey-200);
                      border-radius:8px;padding:10px 12px;">
            <div style="font-size:.67rem;font-weight:700;text-transform:uppercase;
                        letter-spacing:.08em;color:var(--grey-400);margin-bottom:4px;">
              Notes
            </div>
            <p class="mb-0" style="font-size:.82rem;color:var(--ink-2);line-height:1.5;">
              {{ $order->notes }}
            </p>
          </div>
        @endif
      </div>
    </div>

    {{-- Order Summary ───────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header">
        <i data-lucide="receipt"></i> Order Summary
      </div>
      <div class="p-4">

        <div style="font-size:.82rem;">
          <div class="d-flex justify-content-between mb-2">
            <span style="color:var(--grey-400);">Product</span>
            <span class="fw-semibold">{{ $order->product->label ?? '—' }}</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span style="color:var(--grey-400);">Length</span>
            <span class="fw-semibold">{{ $order->length }}</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span style="color:var(--grey-400);">Base Price</span>
            <span>₱{{ number_format($order->base_price) }}</span>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span style="color:var(--grey-400);">Elements Cost</span>
            <span>₱{{ number_format($order->elements_cost) }}</span>
          </div>
          <div style="height:1px;background:var(--grey-200);margin:10px 0;"></div>
          <div class="d-flex justify-content-between">
            <span class="fw-bold">Total</span>
            <span class="fw-bold" style="font-size:1.05rem;color:var(--pink);">
              ₱{{ number_format($order->total_price) }}
            </span>
          </div>
        </div>

      </div>
    </div>

    {{-- Status Timeline ─────────────────────────────────────────────────── --}}
    <div class="ac-card mb-3">
      <div class="ac-card-header">
        <i data-lucide="clock"></i> Timeline
      </div>
      <div class="p-4">
        @php
          $timeline = [
            ['label' => 'Order Placed',  'at' => $order->created_at,   'icon' => 'shopping-bag'],
            ['label' => 'Confirmed',     'at' => $order->confirmed_at, 'icon' => 'check-circle'],
            ['label' => 'Completed',     'at' => $order->completed_at, 'icon' => 'package-check'],
            ['label' => 'Cancelled',     'at' => $order->cancelled_at, 'icon' => 'x-circle'],
          ];
        @endphp
        @foreach($timeline as $t)
          @if($t['at'])
          <div class="d-flex gap-3 mb-3 align-items-start">
            <div style="width:28px;height:28px;border-radius:50%;flex-shrink:0;
                        background:{{ $t['label'] === 'Cancelled' ? '#FEE2E2' : '#D1FAE5' }};
                        color:{{ $t['label'] === 'Cancelled' ? '#991B1B' : '#065F46' }};
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

    {{-- ── Status Action Buttons ────────────────────────────────────────── --}}
    @if($nextStatus || $canCancel)
    <div class="ac-card">
      <div class="ac-card-header">
        <i data-lucide="zap"></i> Update Status
      </div>
      <div class="p-4 d-flex flex-column gap-2">

        {{-- Primary next-step button --}}
        @if($nextStatus)
          <form action="{{ route('admin.orders.status', $order) }}" method="POST">
            @csrf
            <input type="hidden" name="status" value="{{ $nextStatus['status'] }}"/>
            <button type="submit" class="btn w-100 fw-bold"
                    style="background:{{ $nextStatus['color'] }};color:#fff;
                           border-radius:10px;padding:10px 16px;font-size:.88rem;
                           display:flex;align-items:center;justify-content:center;gap:7px;
                           border:none;cursor:pointer;">
              <i data-lucide="{{ $nextStatus['icon'] }}" style="width:15px;height:15px;"></i>
              {{ $nextStatus['label'] }}
            </button>
          </form>
        @else
          <div style="text-align:center;padding:8px;font-size:.82rem;color:var(--grey-400);">
            @if($order->status === 'completed')
              ✅ Order is fully completed.
            @elseif($order->status === 'cancelled')
              ❌ Order has been cancelled.
            @endif
          </div>
        @endif

        {{-- Cancel button (secondary / danger) --}}
        @if($canCancel)
          <form action="{{ route('admin.orders.status', $order) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to cancel order {{ $order->order_code }}?')">
            @csrf
            <input type="hidden" name="status" value="cancelled"/>
            <button type="submit" class="btn btn-sm w-100"
                    style="background:#FEE2E2;color:#991B1B;
                           border:none;border-radius:8px;
                           padding:7px 16px;font-size:.8rem;font-weight:600;
                           display:flex;align-items:center;justify-content:center;gap:6px;
                           cursor:pointer;">
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

@endsection