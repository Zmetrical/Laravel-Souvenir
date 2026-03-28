<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>My Orders — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>
  <style>
    .acc-wrap  { max-width: 860px; margin: 0 auto; padding: 36px 20px 72px; }
    .pg-head   { margin-bottom: 28px; }
    .pg-title  { font-family: var(--fh); font-size: 1.7rem; color: var(--ink); margin-bottom: 4px; }
    .pg-sub    { font-size: .85rem; font-weight: 700; color: var(--ink-md); }

    /* filter bar */
    .filter-bar {
      display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap;
    }
    .filter-pill {
      display: inline-flex; align-items: center;
      border: 1.5px solid var(--ink-lt);
      border-radius: 999px; padding: 5px 14px;
      font-size: .75rem; font-weight: 800; color: var(--ink-md);
      text-decoration: none; background: var(--white);
      transition: border-color .12s, color .12s, background .12s;
    }
    .filter-pill:hover,
    .filter-pill.active {
      border-color: var(--teal); color: var(--teal-dk); background: var(--teal-bg);
    }

    /* order cards */
    .order-list { display: flex; flex-direction: column; gap: 12px; }
    .order-card {
      background: var(--white);
      border: 1.5px solid var(--ink-lt);
      border-radius: 16px;
      overflow: hidden;
      text-decoration: none;
      display: block;
      transition: border-color .13s, box-shadow .13s;
    }
    .order-card:hover { border-color: var(--teal); box-shadow: 0 4px 18px rgba(26,200,196,.1); }

    .order-card-head {
      display: flex; align-items: center; justify-content: space-between;
      padding: 14px 18px;
      border-bottom: 1px solid var(--ink-lt);
      background: var(--offwhite);
    }
    .order-card-code { font-family: var(--fh); font-size: .95rem; color: var(--ink); }
    .order-card-date { font-size: .72rem; font-weight: 700; color: var(--ink-md); }

    .order-card-body {
      display: grid;
      grid-template-columns: auto 1fr auto;
      gap: 16px; align-items: center;
      padding: 14px 18px;
    }
    .order-snap {
      width: 72px; height: 48px; border-radius: 10px;
      background: var(--offwhite); border: 1px solid var(--ink-lt);
      object-fit: cover;
    }
    .order-snap-ph {
      width: 72px; height: 48px; border-radius: 10px;
      background: var(--offwhite); border: 1px solid var(--ink-lt);
      display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
    }
    .order-prod  { font-size: .85rem; font-weight: 800; color: var(--ink); margin-bottom: 3px; }
    .order-meta  { font-size: .73rem; font-weight: 700; color: var(--ink-md); }
    .order-right { text-align: right; }
    .order-price { font-family: var(--fh); font-size: 1.1rem; color: var(--ink); margin-bottom: 5px; }

    /* status badges */
    .sbd {
      display: inline-flex; border-radius: 999px; padding: 3px 10px;
      font-size: .65rem; font-weight: 900; letter-spacing: .05em; text-transform: uppercase;
    }
    .s-pending     { background:#FFF7E0;color:#B47D00;border:1px solid #F0D080; }
    .s-confirmed   { background:var(--teal-bg);color:var(--teal-dk);border:1px solid rgba(26,200,196,.3); }
    .s-in_progress { background:#EEF4FF;color:#3B5BDB;border:1px solid #BBCFFF; }
    .s-ready       { background:#F0FFF4;color:#1A7F4A;border:1px solid #9BE0BB; }
    .s-completed   { background:#F4F4F4;color:#555;border:1px solid #DDD; }
    .s-cancelled   { background:var(--pink-lt);color:var(--pink-dk);border:1px solid rgba(255,95,160,.3); }

    .acc-empty {
      background:var(--white);border:1.5px dashed var(--ink-lt);
      border-radius:14px;padding:48px 20px;text-align:center;
    }
    .acc-empty-icon { font-size:2rem;margin-bottom:10px; }
    .acc-empty-msg  { font-size:.88rem;font-weight:700;color:var(--ink-md);margin-bottom:16px; }
    .acc-empty-btn  {
      display:inline-flex;align-items:center;gap:7px;
      background:var(--pink);color:var(--white);
      font-family:var(--fb);font-weight:900;font-size:.85rem;
      border:none;border-radius:10px;padding:10px 20px;text-decoration:none;
    }

    /* pagination */
    .pg-links { display:flex;justify-content:center;gap:6px;margin-top:24px; }
    .pg-links a, .pg-links span {
      display:inline-flex;align-items:center;justify-content:center;
      min-width:36px;height:36px;border-radius:8px;
      font-size:.78rem;font-weight:800;text-decoration:none;
      border:1.5px solid var(--ink-lt);color:var(--ink-md);
      padding:0 10px;
    }
    .pg-links a:hover { border-color:var(--teal);color:var(--teal-dk);background:var(--teal-bg); }
    .pg-links span[aria-current] { background:var(--teal);border-color:var(--teal);color:#fff; }
  </style>
</head>
<body style="background:var(--offwhite,#F7F7FC);">

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  <div class="pg-head">
    <a href="{{ route('account.dashboard') }}"
       style="font-size:.78rem;font-weight:800;color:var(--ink-md);
              text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-bottom:12px;">
      ← Back to Dashboard
    </a>
    <h1 class="pg-title">My Orders</h1>
    <p class="pg-sub">Track the status of all your custom orders.</p>
  </div>

  {{-- Filter pills --}}
  <div class="filter-bar">
    <a class="filter-pill {{ ! request('status') ? 'active' : '' }}"
       href="{{ route('account.orders') }}">All</a>
    @foreach (['pending','confirmed','in_progress','ready','completed','cancelled'] as $s)
      <a class="filter-pill {{ request('status') === $s ? 'active' : '' }}"
         href="{{ route('account.orders', ['status' => $s]) }}">
        {{ ucfirst(str_replace('_', ' ', $s)) }}
      </a>
    @endforeach
  </div>

  @if ($orders->isEmpty())
    <div class="acc-empty">
      <div class="acc-empty-icon">📦</div>
      <div class="acc-empty-msg">No orders found.</div>
      <a class="acc-empty-btn" href="{{ route('builder.keychain') }}">
        Start Designing →
      </a>
    </div>
  @else
    <div class="order-list">
      @foreach ($orders as $order)
        <div class="order-card">
          <div class="order-card-head">
            <span class="order-card-code">{{ $order->order_code }}</span>
            <span class="order-card-date">
              {{ $order->created_at->format('M d, Y') }}
            </span>
          </div>
          <div class="order-card-body">
            @if ($order->design?->snapshot_path)
              <img class="order-snap"
                   src="{{ asset('storage/' . $order->design->snapshot_path) }}"
                   alt="Design"/>
            @else
              <div class="order-snap-ph">✽</div>
            @endif

            <div>
              <div class="order-prod">{{ $order->product->label }}</div>
              <div class="order-meta">
                {{ ucfirst($order->length) }} length
                · {{ $order->first_name }} {{ $order->last_name }}
              </div>
            </div>

            <div class="order-right">
              <div class="order-price">₱{{ number_format($order->total_price) }}</div>
              <span class="sbd s-{{ $order->status }}">
                {{ str_replace('_', ' ', $order->status) }}
              </span>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- Pagination --}}
    @if ($orders->hasPages())
      <div class="pg-links">
        {{ $orders->onEachSide(1)->links('pagination::simple-tailwind') }}
      </div>
    @endif
  @endif

</div>

</body>
</html>