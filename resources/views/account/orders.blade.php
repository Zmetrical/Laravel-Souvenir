<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>My Orders — ArtsyCrate</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { overflow-y: auto !important; height: auto !important; background: var(--offwhite); display: block !important; }

    .acc-wrap { max-width: 900px; margin: 0 auto; padding: 36px 20px 72px; }

    /* ── Page head ── */
    .pg-back {
      display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 800; color: var(--ink-md);
      text-decoration: none; margin-bottom: 16px; transition: color 0.2s;
    }
    .pg-back:hover { color: var(--pink); }
    .pg-title { font-family: var(--fh); font-size: 2.2rem; color: var(--ink); margin-bottom: 4px; letter-spacing: 1px; }
    .pg-sub { font-size: 0.95rem; font-weight: 700; color: var(--ink-md); margin-bottom: 24px; }

    /* ── Filter pills ── */
    .filter-bar { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 24px; }
    .filter-pill {
      display: inline-flex; align-items: center; gap: 8px; border: 1.5px solid var(--grey-200); border-radius: 12px;
      padding: 8px 16px; font-size: 0.8rem; font-weight: 800; color: var(--ink-md); text-decoration: none; background: #fff;
      transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .filter-pill:hover { border-color: var(--teal); background: var(--teal-bg); color: var(--teal-dk); }
    .filter-pill.active { border-color: var(--pink); color: var(--pink-dk); background: var(--pink-bg); }
    .filter-pill .count { background: var(--offwhite); border-radius: 8px; padding: 2px 8px; font-size: 0.7rem; font-weight: 900; color: var(--ink-md); }
    .filter-pill.active .count { background: var(--white); color: var(--pink-dk); }

    /* ── Order cards ── */
    .order-list { display: flex; flex-direction: column; gap: 16px; }
    .order-card {
      background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 16px; overflow: hidden;
      text-decoration: none; color: inherit; transition: all 0.2s; display: block; box-shadow: 0 4px 16px rgba(0,0,0,0.02);
    }
    .order-card:hover { border-color: var(--teal); box-shadow: 0 8px 24px rgba(26,200,196,0.1); transform: translateY(-2px); color: inherit; }

    .oc-head {
      display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; background: var(--offwhite);
      border-bottom: 1.5px solid var(--grey-200);
    }
    .oc-code { font-family: var(--fh); font-size: 1.1rem; color: var(--ink); }
    .oc-date { font-size: 0.8rem; font-weight: 700; color: var(--ink-md); }

    .oc-body { display: grid; grid-template-columns: 80px 1fr auto; gap: 16px; align-items: center; padding: 20px; }
    .oc-snap {
      width: 80px; height: 60px; border-radius: 10px; background: var(--offwhite); border: 1.5px solid var(--grey-200);
      object-fit: cover; overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--grey-300);
    }
    .oc-snap img { width: 100%; height: 100%; object-fit: cover; }
    .oc-prod { font-size: 1rem; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
    .oc-meta { font-size: 0.8rem; font-weight: 700; color: var(--ink-md); }
    .oc-right { text-align: right; flex-shrink: 0; }
    .oc-price { font-family: var(--fh); font-size: 1.4rem; color: var(--pink); margin-bottom: 8px; }

    /* ── Status badges ── */
    .sbd {
      display: inline-flex; align-items: center; gap: 6px; border-radius: 8px; padding: 6px 12px;
      font-size: 0.7rem; font-weight: 900; letter-spacing: 0.05em; text-transform: uppercase; white-space: nowrap;
    }
    .s-pending     { background: var(--lime-bg); color: var(--lime-dk); border: 1.5px solid var(--lime); }
    .s-confirmed   { background: var(--teal-bg); color: var(--teal-dk); border: 1.5px solid var(--teal); }
    .s-in_progress { background: var(--purple-bg); color: var(--purple-dk); border: 1.5px solid var(--purple); }
    .s-ready       { background: var(--teal-bg); color: var(--teal-dk); border: 1.5px solid var(--teal); }
    .s-completed   { background: var(--grey-200); color: var(--ink-md); border: 1.5px solid var(--grey-300); }
    .s-cancelled   { background: var(--pink-bg); color: var(--pink-dk); border: 1.5px solid var(--pink); }

    /* ── Empty ── */
    .acc-empty { background: var(--white); border: 2px dashed var(--grey-200); border-radius: 16px; padding: 60px 20px; text-align: center; }
    .acc-empty-icon { font-size: 2.5rem; margin-bottom: 12px; }
    .acc-empty-msg { font-size: 0.95rem; font-weight: 700; color: var(--ink-md); margin-bottom: 20px; }
    .acc-empty-btn {
      display: inline-flex; align-items: center; gap: 8px; background: var(--pink); color: var(--white); font-weight: 800;
      font-size: 0.9rem; border: none; border-radius: 10px; padding: 12px 24px; text-decoration: none; transition: all 0.2s;
    }
    .acc-empty-btn:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,95,160,0.2); color: var(--white); }

    @media (max-width: 600px) {
      .oc-body { grid-template-columns: 60px 1fr; }
      .oc-right { display: none; }
    }
  </style>
</head>
<body>

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  <a href="{{ route('account.dashboard') }}" class="pg-back"><i data-lucide="arrow-left" style="width:16px;"></i> Back to Dashboard</a>
  <h1 class="pg-title">My Orders</h1>
  <p class="pg-sub">Track the status of all your custom orders.</p>

  {{-- Filter pills --}}
  <div class="filter-bar">
    <a class="filter-pill {{ ! request('status') ? 'active' : '' }}" href="{{ route('account.orders') }}">
      All <span class="count">{{ $orderCounts['total'] ?? 0 }}</span>
    </a>
    @foreach ([
      'pending'     => 'Pending',
      'confirmed'   => 'Confirmed',
      'in_progress' => 'In Progress',
      'ready'       => 'Ready',
      'completed'   => 'Completed',
      'cancelled'   => 'Cancelled',
    ] as $s => $label)
      <a class="filter-pill {{ request('status') === $s ? 'active' : '' }}" href="{{ route('account.orders', ['status' => $s]) }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  @if ($orders->isEmpty())
    <div class="acc-empty">
      <div class="acc-empty-icon">📦</div>
      <div class="acc-empty-msg">No orders found.</div>
      <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}">
        <i data-lucide="wand-2" style="width:16px;"></i> Start Designing
      </a>
    </div>
  @else
    <div class="order-list">
      @foreach ($orders as $order)
        <a class="order-card" href="{{ route('account.orders.show', $order->order_code) }}">
          <div class="oc-head">
            <span class="oc-code">{{ $order->order_code }}</span>
            <span class="oc-date">{{ $order->created_at->format('M d, Y') }}</span>
          </div>
          <div class="oc-body">
            <div class="oc-snap">
              @if ($order->design?->snapshot_path)
                <img src="{{ asset('storage/' . $order->design->snapshot_path) }}" alt="Design"/>
              @else
                ✽
              @endif
            </div>
            <div>
              <div class="oc-prod">{{ $order->product->label ?? 'Custom' }}</div>
              <div class="oc-meta">
                {{ ucfirst($order->length) }} length
                @if($order->items->count()) · {{ $order->items->count() }} elements @endif
              </div>
            </div>
            <div class="oc-right">
              <div class="oc-price">₱{{ number_format($order->total_price) }}</div>
              <span class="sbd s-{{ $order->status }}">{{ str_replace('_', ' ', $order->status) }}</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    @if ($orders->hasPages())
      <div style="margin-top: 24px;">
        {{ $orders->onEachSide(1)->links('pagination::simple-tailwind') }}
      </div>
    @endif
  @endif

</div>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>