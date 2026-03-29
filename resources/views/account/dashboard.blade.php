<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>My Account — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    body { overflow: auto !important; height: auto !important; background: var(--grey-50); display: block !important; }

    .acc-wrap { max-width: 1080px; margin: 0 auto; padding: 36px 20px 72px; }

    /* ── Page header ── */
    .acc-header { margin-bottom: 28px; }
    .acc-hello {
      font-family: var(--fh); font-size: 1.65rem; font-weight: 800;
      color: var(--ink); margin-bottom: 4px; letter-spacing: -.025em;
    }
    .acc-hello span { color: var(--pink); }
    .acc-sub { font-size: .82rem; font-weight: 600; color: var(--ink2); }

    /* ── Welcome banner ── */
    .welcome-banner {
      background: var(--teal-lt); border: 1.5px solid var(--teal-bd);
      border-radius: var(--r-md); padding: 14px 18px;
      margin-bottom: 24px; display: flex; align-items: center; gap: 12px;
      font-size: .84rem; font-weight: 700; color: var(--teal-dk);
    }
    .welcome-banner a {
      margin-left: auto; background: var(--teal); color: var(--white);
      font-weight: 800; border-radius: var(--r-sm); padding: 7px 15px;
      text-decoration: none; font-size: .76rem; white-space: nowrap;
      flex-shrink: 0; transition: background .13s;
    }
    .welcome-banner a:hover { background: var(--teal-dk); color: var(--white); }

    /* ── Stat cards ── */
    .stat-card {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-md); padding: 18px 20px;
      display: flex; flex-direction: column; gap: 4px;
      transition: border-color .15s, box-shadow .15s;
    }
    .stat-card:hover { border-color: var(--grey-300); box-shadow: var(--sh-sm); }
    .stat-label {
      font-size: .58rem; font-weight: 800; letter-spacing: .10em;
      text-transform: uppercase; color: var(--ink3);
    }
    .stat-val {
      font-family: var(--fh); font-size: 2rem; font-weight: 800;
      color: var(--ink); line-height: 1;
    }
    .stat-hint { font-size: .7rem; font-weight: 600; color: var(--ink3); }

    /* ── Section headers ── */
    .sec-head {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 14px;
    }
    .sec-title { font-family: var(--fh); font-size: 1rem; font-weight: 800; color: var(--ink); }
    .sec-link {
      font-size: .74rem; font-weight: 800; color: var(--teal-dk);
      text-decoration: none; display: flex; align-items: center; gap: 4px;
    }
    .sec-link:hover { text-decoration: underline; }
    .sec-link i[data-lucide] { width: 12px; height: 12px; }

    /* ── Order rows ── */
    .order-list { display: flex; flex-direction: column; gap: 8px; }
    .order-row {
      display: grid; grid-template-columns: 44px 1fr auto auto;
      gap: 13px; align-items: center;
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-md); padding: 13px 16px;
      text-decoration: none; color: inherit;
      transition: border-color .13s, box-shadow .13s;
    }
    .order-row:hover { border-color: var(--teal-bd); box-shadow: var(--sh-xs); }
    .order-snap {
      width: 44px; height: 32px; border-radius: var(--r-xs);
      background: var(--grey-50); border: 1px solid var(--grey-200);
      object-fit: cover; display: flex; align-items: center; justify-content: center;
      font-size: .85rem; flex-shrink: 0; overflow: hidden;
    }
    .order-snap img { width: 100%; height: 100%; object-fit: cover; }
    .order-code { font-size: .8rem; font-weight: 800; color: var(--ink); }
    .order-prod { font-size: .7rem; font-weight: 600; color: var(--ink2); }
    .order-price { font-family: var(--fh); font-size: .92rem; font-weight: 800; color: var(--ink); white-space: nowrap; }

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

    /* ── Design cards ── */
    .design-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .design-card {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-md); overflow: hidden;
      text-decoration: none; color: inherit;
      transition: border-color .13s, box-shadow .13s, transform .12s;
      display: block;
    }
    .design-card:hover { border-color: var(--pink-bd); box-shadow: var(--sh-sm); transform: translateY(-1px); }
    .design-thumb {
      width: 100%; aspect-ratio: 16/9;
      background: var(--grey-50); object-fit: cover; display: block;
    }
    .design-thumb-ph {
      width: 100%; aspect-ratio: 16/9;
      background: var(--grey-50); display: flex; align-items: center;
      justify-content: center; font-size: 1.6rem;
    }
    .design-foot { padding: 10px 12px; }
    .design-name { font-size: .78rem; font-weight: 800; color: var(--ink); margin-bottom: 2px; }
    .design-meta { font-size: .66rem; font-weight: 600; color: var(--ink3); }

    /* ── Empty states ── */
    .acc-empty {
      background: var(--white); border: 1.5px dashed var(--grey-200);
      border-radius: var(--r-md); padding: 32px 20px; text-align: center;
    }
    .acc-empty-icon { font-size: 1.8rem; margin-bottom: 9px; }
    .acc-empty-msg { font-size: .82rem; font-weight: 700; color: var(--ink2); margin-bottom: 14px; }
    .acc-empty-btn {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--pink); color: var(--white);
      font-weight: 800; font-size: .8rem;
      border: none; border-radius: var(--r-sm); padding: 9px 18px;
      text-decoration: none; cursor: pointer;
      transition: background .13s;
    }
    .acc-empty-btn:hover { background: var(--pink-dk); color: var(--white); }

    /* ── Quick links sidebar ── */
    .quick-links { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
    .qlink {
      display: flex; align-items: center; gap: 10px;
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-md); padding: 11px 14px;
      text-decoration: none; color: var(--ink2);
      font-size: .78rem; font-weight: 700;
      transition: border-color .13s, background .13s, color .13s;
    }
    .qlink:hover { border-color: var(--pink-bd); background: var(--pink-lt); color: var(--pink-dk); }
    .qlink i[data-lucide] { width: 15px; height: 15px; flex-shrink: 0; }
    .qlink-arrow { margin-left: auto; opacity: .4; }
    .qlink-arrow i[data-lucide] { width: 13px; height: 13px; }

    @media (max-width: 900px) {
      .design-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
      .design-grid { grid-template-columns: 1fr; }
      .order-row { grid-template-columns: 36px 1fr auto; }
      .order-row > .sbd { display: none; }
    }
  </style>
</head>
<body>

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  @if (session('welcome'))
    <div class="welcome-banner">
      <i data-lucide="party-popper" style="width:18px;height:18px;flex-shrink:0;"></i>
      Welcome to ArtsyCrate, {{ auth()->user()->name }}! Start designing your first piece.
      <a href="{{ route('builder.keychain') }}">Open Builder →</a>
    </div>
  @endif

  <div class="acc-header">
    <h1 class="acc-hello">Hey, <span>{{ $user->name }}</span> 👋</h1>
    <p class="acc-sub">Here's everything going on with your orders and designs.</p>
  </div>

  {{-- Stat cards --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">Total Orders</div>
        <div class="stat-val">{{ $orderCounts['total'] }}</div>
        <div class="stat-hint">All time</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-val" style="color:var(--pink);">{{ $orderCounts['pending'] }}</div>
        <div class="stat-hint">Awaiting approval</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">In Progress</div>
        <div class="stat-val" style="color:var(--purple);">{{ $orderCounts['in_progress'] }}</div>
        <div class="stat-hint">Being crafted</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">Completed</div>
        <div class="stat-val" style="color:var(--teal-dk);">{{ $orderCounts['completed'] }}</div>
        <div class="stat-hint">Delivered</div>
      </div>
    </div>
  </div>

  <div class="row g-4 align-items-start">

    {{-- Recent orders --}}
    <div class="col-lg-7">
      <div class="sec-head">
        <div class="sec-title">Recent Orders</div>
        <a class="sec-link" href="{{ route('account.orders') }}">
          View all <i data-lucide="arrow-right"></i>
        </a>
      </div>

      @if ($recentOrders->isEmpty())
        <div class="acc-empty">
          <div class="acc-empty-icon">🛍️</div>
          <div class="acc-empty-msg">No orders yet — design something!</div>
          <a class="acc-empty-btn" href="{{ route('builder.keychain') }}">
            <i data-lucide="wand-2" style="width:14px;height:14px;"></i>
            Start Designing
          </a>
        </div>
      @else
        <div class="order-list">
          @foreach ($recentOrders as $order)
            <a class="order-row" href="{{ route('account.orders.show', $order->order_code) }}">
              <div class="order-snap">
                @if ($order->design?->snapshot_path)
                  <img src="{{ asset('storage/' . $order->design->snapshot_path) }}" alt="Design"/>
                @else
                  ✽
                @endif
              </div>
              <div>
                <div class="order-code">{{ $order->order_code }}</div>
                <div class="order-prod">{{ $order->product->label }}</div>
              </div>
              <div class="order-price">₱{{ number_format($order->total_price) }}</div>
              <span class="sbd s-{{ $order->status }}">{{ str_replace('_', ' ', $order->status) }}</span>
            </a>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Right sidebar --}}
    <div class="col-lg-5">

      {{-- Quick links --}}
      <div class="sec-title mb-3">Quick Links</div>
      <div class="quick-links mb-4">
        <a class="qlink" href="{{ route('builder.bracelet') }}">
          <i data-lucide="wand-2"></i> Open Bracelet Builder
          <span class="qlink-arrow"><i data-lucide="arrow-right"></i></span>
        </a>
        <a class="qlink" href="{{ route('builder.keychain') }}">
          <i data-lucide="key"></i> Open Keychain Builder
          <span class="qlink-arrow"><i data-lucide="arrow-right"></i></span>
        </a>
        <a class="qlink" href="{{ route('account.designs') }}">
          <i data-lucide="bookmark"></i> My Saved Designs
          <span class="qlink-arrow"><i data-lucide="arrow-right"></i></span>
        </a>
        <a class="qlink" href="{{ route('account.orders') }}">
          <i data-lucide="package"></i> All Orders
          <span class="qlink-arrow"><i data-lucide="arrow-right"></i></span>
        </a>
      </div>

      {{-- Saved designs --}}
      <div class="sec-head">
        <div class="sec-title">Saved Designs</div>
        <a class="sec-link" href="{{ route('account.designs') }}">
          View all <i data-lucide="arrow-right"></i>
        </a>
      </div>

      @if ($savedDesigns->isEmpty())
        <div class="acc-empty">
          <div class="acc-empty-icon">🎨</div>
          <div class="acc-empty-msg">No saved designs yet.</div>
          <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}" style="background:var(--teal);">
            <i data-lucide="palette" style="width:14px;height:14px;"></i>
            Open Builder
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>