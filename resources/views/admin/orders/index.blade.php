@extends('admin.includes.layout')
@section('title', 'Orders')

@section('content')

{{-- ── Page header ──────────────────────────────────────────────────────── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0 fw-bold" style="color:var(--ink);">Orders</h5>
    <small style="color:var(--grey-400);">All custom keychain &amp; bag charm orders</small>
  </div>
</div>

{{-- ── Status tabs ──────────────────────────────────────────────────────── --}}
@php
  $allStatuses = [
    ''            => 'All',
    'pending'     => 'Pending',
    'confirmed'   => 'Confirmed',
    'in_progress' => 'In Progress',
    'ready'       => 'Ready',
    'completed'   => 'Completed',
    'cancelled'   => 'Cancelled',
  ];

  $tabColors = [
    'pending'     => ['bg' => '#FEF3C7', 'text' => '#92400E'],
    'confirmed'   => ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
    'in_progress' => ['bg' => '#F3E8FF', 'text' => '#6D28D9'],
    'ready'       => ['bg' => '#D1FAE5', 'text' => '#065F46'],
    'completed'   => ['bg' => '#F0FDF4', 'text' => '#14532D'],
    'cancelled'   => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
  ];

  $currentStatus = request('status', '');
  $totalAll = $counts->sum();
@endphp

<div class="ac-card mb-3">
  <div style="padding: 8px 14px; display:flex; gap:6px; flex-wrap:wrap; border-bottom: 1px solid var(--grey-200);">
    @foreach($allStatuses as $val => $label)
      @php
        $count  = $val === '' ? $totalAll : ($counts[$val] ?? 0);
        $isActive = $currentStatus === $val;
      @endphp
      <a href="{{ route('admin.orders.index', array_merge(request()->except('status','page'), $val ? ['status' => $val] : [])) }}"
         style="display:inline-flex; align-items:center; gap:5px;
                padding: 4px 12px; border-radius: 20px; font-size:.77rem; font-weight:600;
                text-decoration:none; transition: all .12s;
                {{ $isActive
                    ? ($val && isset($tabColors[$val])
                        ? 'background:' . $tabColors[$val]['bg'] . ';color:' . $tabColors[$val]['text'] . ';'
                        : 'background:var(--ink);color:#fff;')
                    : 'background:var(--grey-100);color:var(--grey-600);' }}">
        {{ $label }}
        <span style="font-size:.7rem; font-weight:700;
                     background: rgba(0,0,0,.1); border-radius:10px;
                     padding: 1px 7px; line-height:1.6;">
          {{ $count }}
        </span>
      </a>
    @endforeach
  </div>

  {{-- ── Search bar ──────────────────────────────────────────────────────── --}}
  <form method="GET" action="{{ route('admin.orders.index') }}">
    @if(request('status'))
      <input type="hidden" name="status" value="{{ request('status') }}"/>
    @endif
    <div class="filter-bar">
      <i data-lucide="search" style="width:14px;height:14px;color:var(--grey-400);"></i>
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Order code, name, or phone…" style="width:230px;"/>
      <button type="submit" class="btn-filter">Search</button>
      <a href="{{ route('admin.orders.index', request('status') ? ['status' => request('status')] : []) }}"
         class="btn-reset">Reset</a>
      <span class="ms-auto" style="font-size:.75rem;color:var(--grey-400);">
        {{ $orders->total() }} order{{ $orders->total() !== 1 ? 's' : '' }}
      </span>
    </div>
  </form>

  {{-- ── Orders table ─────────────────────────────────────────────────────── --}}
  @if($orders->isEmpty())
    <div class="text-center py-5" style="color:var(--grey-400);">
      <i data-lucide="inbox" style="width:32px;height:32px;margin-bottom:8px;display:block;margin-inline:auto;"></i>
      No orders found.
    </div>
  @else
    <div class="table-responsive">
      <table class="table table-hover mb-0" style="font-size:.84rem;">
        <thead style="background:var(--grey-50); font-size:.73rem; text-transform:uppercase; letter-spacing:.05em;">
          <tr>
            <th class="ps-4 py-3">Order</th>
            <th class="py-3">Customer</th>
            <th class="py-3">Product</th>
            <th class="py-3">Length</th>
            <th class="py-3 text-end">Total</th>
            <th class="py-3">Status</th>
            <th class="py-3">Date</th>
            <th class="py-3 pe-4 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          @php
            $sc  = $tabColors[$order->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151'];
          @endphp
          <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.orders.show', $order) }}'">

            {{-- Order code ──────────────────────────────────────────────── --}}
            <td class="ps-4 py-3 align-middle">
              <div class="fw-bold font-monospace" style="color:var(--ink);font-size:.8rem;">
                {{ $order->order_code }}
              </div>
              @if($order->design && $order->design->snapshot_path)
                <div style="margin-top:4px;">
                  <img src="{{ asset('storage/' . $order->design->snapshot_path) }}"
                       style="width:32px;height:32px;object-fit:contain;border-radius:5px;
                              background:var(--grey-100);border:1px solid var(--grey-200);"
                       alt="Design"/>
                </div>
              @endif
            </td>

            {{-- Customer ────────────────────────────────────────────────── --}}
            <td class="py-3 align-middle">
              <div class="fw-semibold" style="color:var(--ink);">
                {{ $order->first_name }} {{ $order->last_name }}
              </div>
              <small style="color:var(--grey-400);">{{ $order->contact_number }}</small>
            </td>

            {{-- Product ─────────────────────────────────────────────────── --}}
            <td class="py-3 align-middle">
              <span style="font-size:.78rem;color:var(--ink-2);">
                {{ $order->product->label ?? '—' }}
              </span>
            </td>

            {{-- Length ──────────────────────────────────────────────────── --}}
            <td class="py-3 align-middle">
              <span style="font-size:.78rem;color:var(--grey-600);">{{ $order->length }}</span>
            </td>

            {{-- Total ───────────────────────────────────────────────────── --}}
            <td class="py-3 align-middle text-end">
              <span class="fw-bold" style="color:var(--pink);">₱{{ number_format($order->total_price) }}</span>
            </td>

            {{-- Status ──────────────────────────────────────────────────── --}}
            <td class="py-3 align-middle">
              <span style="display:inline-block;padding:3px 10px;border-radius:20px;
                           font-size:.71rem;font-weight:700;
                           background:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                {{ $order->statusLabel() }}
              </span>
            </td>

            {{-- Date ────────────────────────────────────────────────────── --}}
            <td class="py-3 align-middle">
              <div style="font-size:.78rem;color:var(--ink-2);">
                {{ $order->created_at->format('M d, Y') }}
              </div>
              <small style="color:var(--grey-400);">
                {{ $order->created_at->format('h:i A') }}
              </small>
            </td>

            {{-- Actions ─────────────────────────────────────────────────── --}}
            <td class="py-3 pe-4 align-middle text-end" onclick="event.stopPropagation()">
              <a href="{{ route('admin.orders.show', $order) }}"
                 class="btn btn-sm btn-outline-secondary me-1"
                 style="padding:3px 10px;font-size:.73rem;border-radius:6px;">
                View
              </a>
              <a href="{{ route('admin.orders.print', $order) }}" target="_blank"
                 class="btn btn-sm"
                 style="padding:3px 10px;font-size:.73rem;border-radius:6px;
                        background:var(--grey-100);color:var(--ink-2);border:1px solid var(--grey-200);">
                <i data-lucide="printer" style="width:11px;height:11px;"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
    <div class="p-3 border-top">{{ $orders->links() }}</div>
    @endif
  @endif

</div>

@endsection