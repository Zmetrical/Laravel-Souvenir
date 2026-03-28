<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>My Account — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>
  <style>
    .acc-wrap   { max-width: 1080px; margin: 0 auto; padding: 36px 20px 72px; }
    .acc-header { margin-bottom: 32px; }
    .acc-hello  { font-family: var(--fh); font-size: 1.8rem; color: var(--ink); margin-bottom: 4px; }
    .acc-hello span { color: var(--pink); }
    .acc-sub    { font-size: .88rem; font-weight: 700; color: var(--ink-md); }

    /* stat cards */
    .acc-stats  { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 36px; }
    .stat-card  {
      background: var(--white);
      border: 1.5px solid var(--ink-lt);
      border-radius: 16px;
      padding: 18px 20px;
    }
    .stat-lbl   { font-size: .68rem; font-weight: 900; letter-spacing: .1em; text-transform: uppercase; color: var(--ink-md); margin-bottom: 8px; }
    .stat-val   { font-family: var(--fh); font-size: 1.9rem; color: var(--ink); line-height: 1; margin-bottom: 4px; }
    .stat-hint  { font-size: .72rem; font-weight: 700; color: var(--ink-md); }

    /* sections */
    .acc-grid   { display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start; }
    .acc-section-head {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 14px;
    }
    .acc-section-title {
      font-family: var(--fh); font-size: 1.05rem; color: var(--ink);
    }
    .acc-link   { font-size: .78rem; font-weight: 800; color: var(--teal-dk); text-decoration: none; }
    .acc-link:hover { text-decoration: underline; }

    /* order rows */
    .order-list { display: flex; flex-direction: column; gap: 10px; }
    .order-row  {
      display: grid;
      grid-template-columns: auto 1fr auto auto;
      gap: 14px;
      align-items: center;
      background: var(--white);
      border: 1.5px solid var(--ink-lt);
      border-radius: 14px;
      padding: 14px 18px;
      text-decoration: none;
      transition: border-color .13s, box-shadow .13s;
    }
    .order-row:hover { border-color: var(--teal); box-shadow: 0 4px 16px rgba(26,200,196,.1); }
    .order-snap {
      width: 52px; height: 36px;
      border-radius: 8px;
      background: var(--offwhite);
      border: 1px solid var(--ink-lt);
      object-fit: cover;
      flex-shrink: 0;
    }
    .order-snap-ph {
      width: 52px; height: 36px;
      border-radius: 8px;
      background: var(--offwhite);
      border: 1px solid var(--ink-lt);
      display: flex; align-items: center; justify-content: center;
      font-size: .9rem;
    }
    .order-code  { font-size: .8rem; font-weight: 900; color: var(--ink); }
    .order-prod  { font-size: .73rem; font-weight: 700; color: var(--ink-md); }
    .order-price { font-family: var(--fh); font-size: .95rem; color: var(--ink); white-space: nowrap; }

    /* status badges */
    .sbd {
      display: inline-flex; align-items: center;
      border-radius: 999px; padding: 3px 10px;
      font-size: .65rem; font-weight: 900; letter-spacing: .05em;
      text-transform: uppercase; white-space: nowrap;
    }
    .s-pending     { background: #FFF7E0; color: #B47D00; border: 1px solid #F0D080; }
    .s-confirmed   { background: var(--teal-bg); color: var(--teal-dk); border: 1px solid rgba(26,200,196,.3); }
    .s-in_progress { background: #EEF4FF; color: #3B5BDB; border: 1px solid #BBCFFF; }
    .s-ready       { background: #F0FFF4; color: #1A7F4A; border: 1px solid #9BE0BB; }
    .s-completed   { background: #F4F4F4; color: #555; border: 1px solid #DDD; }
    .s-cancelled   { background: var(--pink-lt); color: var(--pink-dk); border: 1px solid rgba(255,95,160,.3); }

    /* saved design cards */
    .design-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .design-card {
      background: var(--white);
      border: 1.5px solid var(--ink-lt);
      border-radius: 14px;
      overflow: hidden;
      text-decoration: none;
      transition: border-color .13s, box-shadow .13s;
      display: block;
    }
    .design-card:hover { border-color: var(--pink); box-shadow: 0 4px 16px rgba(255,95,160,.1); }
    .design-thumb {
      width: 100%; aspect-ratio: 16/9;
      background: var(--offwhite);
      object-fit: cover;
      display: block;
    }
    .design-thumb-ph {
      width: 100%; aspect-ratio: 16/9;
      background: var(--offwhite);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.5rem;
    }
    .design-foot { padding: 10px 12px; }
    .design-name { font-size: .8rem; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
    .design-meta { font-size: .68rem; font-weight: 700; color: var(--ink-md); }

    /* empty states */
    .acc-empty {
      background: var(--white);
      border: 1.5px dashed var(--ink-lt);
      border-radius: 14px;
      padding: 32px 20px;
      text-align: center;
    }
    .acc-empty-icon { font-size: 1.8rem; margin-bottom: 8px; }
    .acc-empty-msg  { font-size: .85rem; font-weight: 700; color: var(--ink-md); margin-bottom: 14px; }
    .acc-empty-btn  {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--pink); color: var(--white);
      font-family: var(--fb); font-weight: 900; font-size: .82rem;
      border: none; border-radius: 10px; padding: 9px 18px;
      text-decoration: none; cursor: pointer;
    }

    @media (max-width: 900px) {
      .acc-stats { grid-template-columns: repeat(2,1fr); }
      .acc-grid  { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
      .acc-stats { grid-template-columns: 1fr 1fr; }
      .design-grid { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body style="background:var(--offwhite,#F7F7FC);">

{{-- Topbar reuse --}}
@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  {{-- Welcome banner (first login after register) --}}
  @if (session('welcome'))
    <div style="background:var(--teal-bg);border:1.5px solid rgba(26,200,196,.25);
                border-radius:14px;padding:14px 18px;margin-bottom:24px;
                display:flex;align-items:center;gap:12px;
                font-size:.85rem;font-weight:700;color:var(--teal-dk);">
      🎉 Welcome to ArtsyCrate, {{ auth()->user()->name }}! Start designing your first piece.
      <a href="{{ route('builder.keychain') }}" style="margin-left:auto;background:var(--teal);
         color:#fff;font-weight:900;border-radius:8px;padding:6px 14px;
         text-decoration:none;font-size:.78rem;white-space:nowrap;">
        Open Builder →
      </a>
    </div>
  @endif

  <div class="acc-header">
    <h1 class="acc-hello">Hey, <span>{{ $user->name }}</span> 👋</h1>
    <p class="acc-sub">Here's everything going on with your orders and designs.</p>
  </div>

  {{-- Stats row --}}
  <div class="acc-stats">
    <div class="stat-card">
      <div class="stat-lbl">Total Orders</div>
      <div class="stat-val">{{ $orderCounts['total'] }}</div>
      <div class="stat-hint">All time</div>
    </div>
    <div class="stat-card">
      <div class="stat-lbl">Pending</div>
      <div class="stat-val" style="color:var(--pink);">{{ $orderCounts['pending'] }}</div>
      <div class="stat-hint">Awaiting approval</div>
    </div>
    <div class="stat-card">
      <div class="stat-lbl">In Progress</div>
      <div class="stat-val" style="color:#3B5BDB;">{{ $orderCounts['in_progress'] }}</div>
      <div class="stat-hint">Being crafted</div>
    </div>
    <div class="stat-card">
      <div class="stat-lbl">Completed</div>
      <div class="stat-val" style="color:var(--teal-dk);">{{ $orderCounts['completed'] }}</div>
      <div class="stat-hint">Delivered</div>
    </div>
  </div>

  {{-- Main grid --}}
  <div class="acc-grid">

    {{-- Recent orders --}}
    <div>
      <div class="acc-section-head">
        <div class="acc-section-title">Recent Orders</div>
        <a class="acc-link" href="{{ route('account.orders') }}">View all →</a>
      </div>

      @if ($recentOrders->isEmpty())
        <div class="acc-empty">
          <div class="acc-empty-icon">🛍️</div>
          <div class="acc-empty-msg">No orders yet. Design something!</div>
          <a class="acc-empty-btn" href="{{ route('builder.keychain') }}">
            Start Designing →
          </a>
        </div>
      @else
        <div class="order-list">
          @foreach ($recentOrders as $order)
            <a class="order-row" href="{{ route('account.orders') }}">
              {{-- Snapshot thumbnail --}}
              @if ($order->design?->snapshot_path)
                <img class="order-snap"
                     src="{{ asset('storage/' . $order->design->snapshot_path) }}"
                     alt="Design snapshot"/>
              @else
                <div class="order-snap-ph">✽</div>
              @endif

              <div>
                <div class="order-code">{{ $order->order_code }}</div>
                <div class="order-prod">{{ $order->product->label }}</div>
              </div>

              <div class="order-price">₱{{ number_format($order->total_price) }}</div>

              <span class="sbd s-{{ $order->status }}">
                {{ str_replace('_', ' ', $order->status) }}
              </span>
            </a>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Saved designs sidebar --}}
    <div>
      <div class="acc-section-head">
        <div class="acc-section-title">Saved Designs</div>
        <a class="acc-link" href="{{ route('account.designs') }}">View all →</a>
      </div>

      @if ($savedDesigns->isEmpty())
        <div class="acc-empty">
          <div class="acc-empty-icon">🎨</div>
          <div class="acc-empty-msg">No saved designs yet.</div>
          <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}">
            Open Builder →
          </a>
        </div>
      @else
        <div class="design-grid">
          @foreach ($savedDesigns as $design)
            <a class="design-card" href="{{ $design->builderUrl() }}">
              @if ($design->snapshotUrl())
                <img class="design-thumb" src="{{ $design->snapshotUrl() }}" alt="{{ $design->name }}"/>
              @else
                <div class="design-thumb-ph">✽</div>
              @endif
              <div class="design-foot">
                <div class="design-name">{{ $design->name }}</div>
                <div class="design-meta">{{ ucfirst($design->product_slug) }}</div>
              </div>
            </a>
          @endforeach
        </div>
      @endif
    </div>

  </div>
</div>

</body>
</html>