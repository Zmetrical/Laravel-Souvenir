@extends('admin.includes.layout')
@section('title', 'Orders')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h5 class="mb-0" style="font-family: var(--fh); font-size: 2rem; color: var(--ink); letter-spacing: 1px;">All Orders</h5>
    <small style="font-size: 0.95rem; font-weight: 700; color: var(--ink-md);">Track and update custom keychain & bag charm orders.</small>
  </div>
</div>

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

<div class="ac-card mb-4">
  <div style="padding: 12px 16px; display:flex; gap:8px; flex-wrap:wrap; border-bottom: 1.5px solid var(--grey-200); background: var(--offwhite);">
    @foreach($allStatuses as $val => $label)
      @php
        $count  = $val === '' ? $totalAll : ($counts[$val] ?? 0);
        $isActive = $currentStatus === $val;
      @endphp
      <a href="{{ route('admin.orders.index', array_merge(request()->except('status','page'), $val ? ['status' => $val] : [])) }}"
         style="display:inline-flex; align-items:center; gap:6px;
                padding: 6px 14px; border-radius: 10px; font-size:0.85rem; font-weight:800;
                text-decoration:none; transition: all .15s; border: 1.5px solid transparent;
                {{ $isActive
                    ? ($val && isset($tabColors[$val])
                        ? 'background:' . $tabColors[$val]['bg'] . ';color:' . $tabColors[$val]['text'] . '; border-color: ' . $tabColors[$val]['text'] . ';'
                        : 'background:var(--pink-bg);color:var(--pink-dk); border-color: var(--pink-bd);')
                    : 'background:var(--white);color:var(--ink-md); border-color: var(--grey-200);' }}">
        {{ $label }}
        <span style="font-size:0.75rem; font-weight:900; background: rgba(0,0,0,.08); border-radius:6px; padding: 2px 8px;">
          {{ $count }}
        </span>
      </a>
    @endforeach
  </div>

  <div class="p-3">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 align-items-end">
      @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"/> @endif
      <div class="col-md-5">
        <label class="form-label">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Order code, name, or phone…"/>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn-ghost" style="background: var(--ink); color: #fff; border-color: var(--ink); width: 100%; justify-content: center;">Search</button>
      </div>
      <div class="col-md-2">
        <a href="{{ route('admin.orders.index', request('status') ? ['status' => request('status')] : []) }}" class="btn-ghost w-100 justify-content-center">Reset</a>
      </div>
    </form>
  </div>
</div>

<div class="ac-card">
  @if($orders->isEmpty())
    <div class="text-center py-5" style="color:var(--ink-md);">
      <i data-lucide="package" style="width:36px;height:36px;margin-bottom:12px;opacity: 0.5;"></i>
      <h6 class="fw-bold">No orders found.</h6>
    </div>
  @else
    <div class="table-responsive">
      <table class="table table-borderless align-middle mb-0" style="font-size: 0.9rem; font-weight: 700;">
        <thead style="background: var(--offwhite); border-bottom: 1.5px solid var(--grey-200); font-size: 0.75rem; text-transform: uppercase; color: var(--ink-md);">
          <tr>
            <th class="ps-4 py-3">Order</th>
            <th class="py-3">Customer</th>
            <th class="py-3">Product</th>
            <th class="py-3">Status</th>
            <th class="py-3 text-end">Total</th>
            <th class="py-3 pe-4 text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          @php $sc = $tabColors[$order->status] ?? ['bg' => '#F3F4F6', 'text' => '#374151']; @endphp
          <tr style="border-bottom: 1px solid var(--grey-100); cursor: pointer;" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
            
            <td class="ps-4 py-3 align-middle">
              <div style="font-family: var(--fh); font-size: 1.1rem; color: var(--ink); letter-spacing: 0.5px;">{{ $order->order_code }}</div>
              <div style="font-size: 0.75rem; color: var(--ink-md); font-weight: 700;">{{ $order->created_at->format('M d, Y') }}</div>
            </td>

            <td class="py-3 align-middle">
              <div style="color: var(--ink); font-weight: 800;">{{ $order->first_name }} {{ $order->last_name }}</div>
            </td>

            <td class="py-3 align-middle" style="color: var(--ink-md);">
              {{ $order->product->label ?? '—' }} ({{ $order->length }})
            </td>

            <td class="py-3 align-middle">
              <span style="display:inline-block; padding:4px 12px; border-radius:6px; font-size:0.75rem; font-weight:800; text-transform: uppercase; background:{{ $sc['bg'] }}; color:{{ $sc['text'] }}; border: 1.5px solid {{ $sc['text'] }};">
                {{ $order->statusLabel() ?? ucfirst($order->status) }}
              </span>
            </td>

            <td class="py-3 align-middle text-end" style="color: var(--pink); font-weight: 800;">
              ₱{{ number_format($order->total_price) }}
            </td>

            <td class="py-3 pe-4 align-middle text-end" onclick="event.stopPropagation()">
              <a href="{{ route('admin.orders.show', $order) }}" class="btn-ghost" style="padding: 6px 12px; font-size: 0.8rem;">View</a>
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