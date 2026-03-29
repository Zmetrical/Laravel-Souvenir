<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>My Account — ArtsyCrate</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { overflow-y: auto !important; height: auto !important; background: var(--offwhite); display: block !important; }

    .acc-wrap { max-width: 1080px; margin: 0 auto; padding: 36px 20px 72px; }

    /* ── Page header ── */
    .acc-header { margin-bottom: 28px; }
    .acc-hello { font-family: var(--fh); font-size: 2.2rem; color: var(--ink); margin-bottom: 4px; letter-spacing: 1px; }
    .acc-hello span { color: var(--pink); }
    .acc-sub { font-size: 0.95rem; font-weight: 700; color: var(--ink-md); }

    /* ── Welcome banner ── */
    .welcome-banner {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: 16px; padding: 16px 20px; margin-bottom: 24px;
      display: flex; align-items: center; gap: 12px; font-size: 0.9rem; font-weight: 800; color: var(--ink);
      box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .welcome-banner a {
      margin-left: auto; background: var(--pink); color: var(--white); font-weight: 800; border-radius: 10px;
      padding: 10px 20px; text-decoration: none; font-size: 0.85rem; white-space: nowrap; flex-shrink: 0; transition: all 0.2s;
      box-shadow: 0 4px 12px rgba(255,95,160,0.2);
    }
    .welcome-banner a:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(255,95,160,0.3); color: var(--white); }

    /* ── Stat cards ── */
    .stat-card {
      background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 16px; padding: 20px;
      display: flex; flex-direction: column; gap: 4px; transition: all 0.2s; box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }
    .stat-card:hover { border-color: var(--grey-300); box-shadow: 0 6px 24px rgba(0,0,0,0.05); transform: translateY(-2px); }
    .stat-label { font-size: 0.7rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-md); }
    .stat-val { font-family: var(--fh); font-size: 2.4rem; color: var(--ink); line-height: 1; margin: 4px 0; }
    .stat-hint { font-size: 0.75rem; font-weight: 700; color: var(--ink-md); }

    /* ── Section headers ── */
    .sec-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .sec-title { font-family: var(--fh); font-size: 1.4rem; color: var(--ink); }
    .sec-link { font-size: 0.85rem; font-weight: 800; color: var(--ink-md); text-decoration: none; display: flex; align-items: center; gap: 4px; transition: color 0.2s; }
    .sec-link:hover { color: var(--pink); }

    /* ── Order rows ── */
    .order-list { display: flex; flex-direction: column; gap: 10px; }
    .order-row {
      display: grid; grid-template-columns: 50px 1fr auto auto; gap: 16px; align-items: center;
      background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 16px; padding: 16px 20px;
      text-decoration: none; color: inherit; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .order-row:hover { border-color: var(--pink-bd); box-shadow: 0 4px 16px rgba(255,95,160,0.08); transform: translateY(-1px); color: inherit; }
    .order-snap {
      width: 50px; height: 50px; border-radius: 10px; background: var(--offwhite); border: 1.5px solid var(--grey-200);
      object-fit: cover; display: flex; align-items: center; justify-content: center; font-size: 1rem; overflow: hidden;
    }
    .order-snap img { width: 100%; height: 100%; object-fit: cover; }
    .order-code { font-size: 0.95rem; font-weight: 800; color: var(--ink); }
    .order-prod { font-size: 0.75rem; font-weight: 700; color: var(--ink-md); text-transform: uppercase; }
    .order-price { font-family: var(--fh); font-size: 1.1rem; color: var(--ink); white-space: nowrap; margin-right: 12px; }

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

    /* ── Design cards ── */
    .design-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .design-card {
      background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 16px; overflow: hidden;
      text-decoration: none; color: inherit; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .design-card:hover { border-color: var(--pink-bd); box-shadow: 0 8px 24px rgba(255,95,160,0.1); transform: translateY(-2px); color: inherit; }
    .design-thumb { width: 100%; aspect-ratio: 16/9; background: var(--offwhite); object-fit: cover; display: block; border-bottom: 1.5px solid var(--grey-200); }
    .design-thumb-ph { width: 100%; aspect-ratio: 16/9; background: var(--offwhite); border-bottom: 1.5px solid var(--grey-200); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--grey-300); }
    .design-foot { padding: 14px 16px; }
    .design-name { font-size: 0.9rem; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
    .design-meta { font-size: 0.75rem; font-weight: 700; color: var(--ink-md); text-transform: uppercase; }

    /* ── Empty states ── */
    .acc-empty { background: var(--white); border: 2px dashed var(--grey-200); border-radius: 16px; padding: 40px 20px; text-align: center; }
    .acc-empty-icon { font-size: 2.5rem; margin-bottom: 12px; }
    .acc-empty-msg { font-size: 0.9rem; font-weight: 700; color: var(--ink-md); margin-bottom: 20px; }
    .acc-empty-btn {
      display: inline-flex; align-items: center; gap: 8px; background: var(--pink); color: var(--white);
      font-weight: 800; font-size: 0.9rem; border: none; border-radius: 10px; padding: 12px 24px; text-decoration: none; transition: all 0.2s;
    }
    .acc-empty-btn:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,95,160,0.2); color: var(--white); }

    /* ── Quick links sidebar ── */
    .quick-links { display: flex; flex-direction: column; gap: 10px; margin-bottom: 32px; }
    .qlink {
      display: flex; align-items: center; gap: 12px; background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: 12px; padding: 14px 18px; text-decoration: none; color: var(--ink); font-size: 0.85rem; font-weight: 800; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .qlink:hover { border-color: var(--grey-300); background: var(--offwhite); transform: translateY(-1px); }
    .qlink i[data-lucide] { width: 18px; height: 18px; flex-shrink: 0; color: var(--ink-md); }
    .qlink-arrow { margin-left: auto; opacity: 0.5; color: var(--ink-md); }

    @media (max-width: 900px) { .design-grid { grid-template-columns: 1fr 1fr; } }
    @media (max-width: 600px) {
      .design-grid { grid-template-columns: 1fr; }
      .order-row { grid-template-columns: 44px 1fr auto; }
      .order-row > .sbd { display: none; }
    }
  </style>
</head>
<body>

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  @if (session('welcome'))
    <div class="welcome-banner">
      <i data-lucide="party-popper" style="width:20px; height:20px; flex-shrink:0; color: var(--pink);"></i>
      Welcome to ArtsyCrate, {{ auth()->user()->first_name }}! Start designing your first piece.
      <a href="{{ route('builder.bracelet') }}">Open Builder →</a>
    </div>
  @endif

  <div class="acc-header">
    <h1 class="acc-hello">Hey, <span>{{ auth()->user()->first_name }}</span></h1>
    <p class="acc-sub">Here's everything going on with your orders and designs.</p>
  </div>

  {{-- Stat cards --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">Total Orders</div>
        <div class="stat-val">{{ $orderCounts['total'] ?? 0 }}</div>
        <div class="stat-hint">All time</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">Pending</div>
        <div class="stat-val">{{ $orderCounts['pending'] ?? 0 }}</div>
        <div class="stat-hint">Awaiting approval</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">In Progress</div>
        <div class="stat-val">{{ $orderCounts['in_progress'] ?? 0 }}</div>
        <div class="stat-hint">Being crafted</div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-label">Completed</div>
        <div class="stat-val">{{ $orderCounts['completed'] ?? 0 }}</div>
        <div class="stat-hint">Delivered</div>
      </div>
    </div>
  </div>

  <div class="row g-4 align-items-start">

    {{-- Recent orders --}}
    <div class="col-lg-7">
      <div class="sec-head">
        <div class="sec-title">Recent Orders</div>
        <a class="sec-link" href="{{ route('account.orders') }}">View all <i data-lucide="arrow-right" style="width:16px;"></i></a>
      </div>

      @if ($recentOrders->isEmpty())
        <div class="acc-empty">
          <div class="acc-empty-icon">🛍️</div>
          <div class="acc-empty-msg">No orders yet — design something!</div>
          <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}">
            <i data-lucide="wand-2" style="width:16px;"></i> Start Designing
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
                <div class="order-prod">{{ $order->product->label ?? 'Custom' }}</div>
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
      </div>

      {{-- Saved designs --}}
      <div class="sec-head">
        <div class="sec-title">Saved Designs</div>
        <a class="sec-link" href="{{ route('account.designs') }}">View all <i data-lucide="arrow-right" style="width:16px;"></i></a>
      </div>

      @if ($savedDesigns->isEmpty())
        <div class="acc-empty">
          <div class="acc-empty-icon">🎨</div>
          <div class="acc-empty-msg">No saved designs yet.</div>
          <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}">
            <i data-lucide="palette" style="width:16px;"></i> Open Builder
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

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>