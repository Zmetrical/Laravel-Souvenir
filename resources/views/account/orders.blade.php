<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>My Orders — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    body { overflow: auto !important; height: auto !important; background: var(--grey-50); display: block !important; }

    .acc-wrap { max-width: 900px; margin: 0 auto; padding: 36px 20px 72px; }

    /* ── Page head ── */
    .pg-back {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: .76rem; font-weight: 800; color: var(--ink2);
      text-decoration: none; margin-bottom: 14px;
      transition: color .13s;
    }
    .pg-back:hover { color: var(--pink); }
    .pg-back i[data-lucide] { width: 12px; height: 12px; }
    .pg-title { font-family: var(--fh); font-size: 1.55rem; font-weight: 800; color: var(--ink); margin-bottom: 4px; letter-spacing: -.025em; }
    .pg-sub { font-size: .82rem; font-weight: 600; color: var(--ink2); margin-bottom: 22px; }

    /* ── Filter pills ── */
    .filter-bar { display: flex; gap: 7px; flex-wrap: wrap; margin-bottom: 22px; }
    .filter-pill {
      display: inline-flex; align-items: center; gap: 5px;
      border: 1.5px solid var(--grey-200); border-radius: var(--r-pill);
      padding: 5px 14px; font-size: .72rem; font-weight: 800;
      color: var(--ink2); text-decoration: none; background: var(--white);
      transition: border-color .12s, color .12s, background .12s;
    }
    .filter-pill:hover { border-color: var(--grey-300); background: var(--grey-50); }
    .filter-pill.active { border-color: var(--teal); color: var(--teal-dk); background: var(--teal-lt); }
    .filter-pill .count {
      background: var(--grey-100); border-radius: var(--r-pill);
      padding: 0 6px; font-size: .6rem; font-weight: 900; color: var(--ink3);
    }
    .filter-pill.active .count { background: rgba(13,188,180,.15); color: var(--teal-dk); }

    /* ── Order cards ── */
    .order-list { display: flex; flex-direction: column; gap: 10px; }
    .order-card {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-md); overflow: hidden;
      text-decoration: none; color: inherit;
      transition: border-color .13s, box-shadow .13s;
      display: block;
    }
    .order-card:hover { border-color: var(--teal-bd); box-shadow: var(--sh-sm); }

    .oc-head {
      display: flex; align-items: center; justify-content: space-between;
      padding: 11px 18px; background: var(--grey-50);
      border-bottom: 1px solid var(--grey-200);
    }
    .oc-code { font-family: var(--fh); font-size: .9rem; font-weight: 800; color: var(--ink); }
    .oc-date { font-size: .7rem; font-weight: 700; color: var(--ink3); }

    .oc-body {
      display: grid; grid-template-columns: 64px 1fr auto;
      gap: 14px; align-items: center; padding: 14px 18px;
    }
    .oc-snap {
      width: 64px; height: 44px; border-radius: var(--r-sm);
      background: var(--grey-50); border: 1px solid var(--grey-200);
      object-fit: cover; overflow: hidden;
      display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
    }
    .oc-snap img { width: 100%; height: 100%; object-fit: cover; }
    .oc-prod { font-size: .84rem; font-weight: 800; color: var(--ink); margin-bottom: 3px; }
    .oc-meta { font-size: .7rem; font-weight: 600; color: var(--ink2); }
    .oc-right { text-align: right; flex-shrink: 0; }
    .oc-price { font-family: var(--fh); font-size: 1.05rem; font-weight: 800; color: var(--ink); margin-bottom: 5px; }

    /* ── Status badges ── */
    .sbd {
      display: inline-flex; align-items: center; gap: 4px;
      border-radius: var(--r-pill); padding: 3px 10px;
      font-size: .6rem; font-weight: 800; letter-spacing: .04em;
      text-transform: uppercase; white-space: nowrap;
    }
    .sbd::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; flex-shrink: 0; }
    .s-pending     { background: #FFF7E0; color: #B47D00; border: 1px solid #F0D080; }
    .s-confirmed   { background: var(--teal-lt); color: var(--teal-dk); border: 1px solid var(--teal-bd); }
    .s-in_progress { background: var(--purple-lt); color: var(--purple-dk); border: 1px solid var(--purple-bd); }
    .s-ready       { background: #F0FFF4; color: #1A7F4A; border: 1px solid #9BE0BB; }
    .s-completed   { background: var(--grey-100); color: var(--ink2); border: 1px solid var(--grey-200); }
    .s-cancelled   { background: var(--pink-lt); color: var(--pink-dk); border: 1px solid var(--pink-bd); }

    /* ── Empty ── */
    .acc-empty {
      background: var(--white); border: 1.5px dashed var(--grey-200);
      border-radius: var(--r-md); padding: 48px 20px; text-align: center;
    }
    .acc-empty-icon { font-size: 2rem; margin-bottom: 10px; }
    .acc-empty-msg { font-size: .86rem; font-weight: 700; color: var(--ink2); margin-bottom: 16px; }
    .acc-empty-btn {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--pink); color: var(--white);
      font-weight: 800; font-size: .82rem;
      border: none; border-radius: var(--r-sm); padding: 10px 20px; text-decoration: none;
      transition: background .13s;
    }
    .acc-empty-btn:hover { background: var(--pink-dk); color: var(--white); }

    /* ── Pagination ── */
    .pg-links { display: flex; justify-content: center; gap: 6px; margin-top: 24px; }
    .pg-links a, .pg-links span {
      display: inline-flex; align-items: center; justify-content: center;
      min-width: 36px; height: 36px; border-radius: var(--r-sm);
      font-size: .76rem; font-weight: 800; text-decoration: none;
      border: 1.5px solid var(--grey-200); color: var(--ink2); padding: 0 10px;
    }
    .pg-links a:hover { border-color: var(--teal); color: var(--teal-dk); background: var(--teal-lt); }
    .pg-links span[aria-current] { background: var(--teal); border-color: var(--teal); color: var(--white); }

    @media (max-width: 600px) {
      .oc-body { grid-template-columns: 48px 1fr; }
      .oc-right { display: none; }
    }
  </style>
</head>
<body>

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  <a href="{{ route('account.dashboard') }}" class="pg-back">
    <i data-lucide="arrow-left"></i> Back to Dashboard
  </a>
  <h1 class="pg-title">My Orders</h1>
  <p class="pg-sub">Track the status of all your custom orders.</p>

  {{-- Filter pills --}}
  <div class="filter-bar">
    <a class="filter-pill {{ ! request('status') ? 'active' : '' }}"
       href="{{ route('account.orders') }}">
      All
      <span class="count">{{ $orderCounts['total'] ?? '' }}</span>
    </a>
    @foreach ([
      'pending'     => 'Pending',
      'confirmed'   => 'Confirmed',
      'in_progress' => 'In Progress',
      'ready'       => 'Ready',
      'completed'   => 'Completed',
      'cancelled'   => 'Cancelled',
    ] as $s => $label)
      <a class="filter-pill {{ request('status') === $s ? 'active' : '' }}"
         href="{{ route('account.orders', ['status' => $s]) }}">
        {{ $label }}
      </a>
    @endforeach
  </div>

  @if ($orders->isEmpty())
    <div class="acc-empty">
      <div class="acc-empty-icon">📦</div>
      <div class="acc-empty-msg">No orders found.</div>
      <a class="acc-empty-btn" href="{{ route('builder.keychain') }}">
        <i data-lucide="wand-2" style="width:14px;height:14px;"></i>
        Start Designing
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
              <div class="oc-prod">{{ $order->product->label }}</div>
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
      <div class="pg-links">
        {{ $orders->onEachSide(1)->links('pagination::simple-tailwind') }}
      </div>
    @endif
  @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>