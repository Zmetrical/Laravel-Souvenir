<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ArtsyCrate Admin — @yield('title', 'Dashboard')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

  <style>
    :root {
      --pink:      #FF5FA0;
      --pink-lt:   #FFD6E8;
      --pink-dk:   #C0136A;
      --teal:      #1AC8C4;
      --teal-lt:   #D0F5F4;
      --purple:    #A855F7;
      --purple-lt: #EDE9FE;
      --lime:      #84CC16;
      --lime-lt:   #ECFCCB;
      --ink:       #1E1E2A;
      --ink-2:     #3A3A4A;
      --sidebar-w: 232px;
      --white:     #FFFFFF;
      --grey-50:   #F8F8FB;
      --grey-100:  #F0EFF7;
      --grey-200:  #E2E0EF;
      --grey-400:  #9896A8;
      --grey-600:  #5E5C6E;
    }

    * { box-sizing: border-box; }

    body {
      background: var(--grey-50);
      font-family: 'Segoe UI', system-ui, sans-serif;
      margin: 0;
      color: var(--ink);
    }

    /* ── Lucide fix ────────────────────────────────────────────────────── */
    [data-lucide] {
      width: 14px; height: 14px;
      display: inline-block;
      vertical-align: middle;
      flex-shrink: 0;
    }

    /* ── Sidebar ───────────────────────────────────────────────────────── */
    .ac-sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background: var(--ink);
      position: fixed; top: 0; left: 0;
      display: flex; flex-direction: column;
      z-index: 100;
      overflow-y: auto;
    }

    .ac-sidebar .brand {
      padding: 18px 20px 16px;
      font-size: 1rem; font-weight: 800;
      color: #fff; letter-spacing: -.2px;
      border-bottom: 1px solid rgba(255,255,255,.07);
      flex-shrink: 0;
      display: flex; align-items: center; gap: 8px;
    }
    .ac-sidebar .brand-dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--pink); flex-shrink: 0;
    }
    .ac-sidebar .brand small {
      font-size: .58rem; opacity: .35; font-weight: 400; margin-left: 2px;
    }

    .ac-sidebar .nav-section {
      padding: 16px 18px 4px;
      font-size: .6rem; font-weight: 700;
      color: rgba(255,255,255,.25);
      letter-spacing: .12em; text-transform: uppercase;
    }

    .ac-sidebar .nav-link {
      display: flex; align-items: center; gap: 9px;
      padding: 7px 12px; margin: 1px 8px;
      border-radius: 7px;
      color: rgba(255,255,255,.5); font-size: .82rem; font-weight: 500;
      text-decoration: none; transition: all .12s;
    }
    .ac-sidebar .nav-link:hover  { background: rgba(255,255,255,.07); color: rgba(255,255,255,.85); }
    .ac-sidebar .nav-link.active { background: var(--pink); color: #fff; }

    /* Sub-nav */
    .ac-subnav {
      margin: 1px 8px 4px 34px;
      border-left: 1px solid rgba(255,255,255,.08);
      padding-left: 6px;
    }
    .ac-subnav .sub-link {
      display: flex; align-items: center; gap: 8px;
      padding: 5px 10px;
      border-radius: 6px;
      color: rgba(255,255,255,.38); font-size: .78rem;
      text-decoration: none; transition: all .12s;
    }
    .ac-subnav .sub-link:hover  { background: rgba(255,255,255,.06); color: rgba(255,255,255,.7); }
    .ac-subnav .sub-link.active { color: var(--pink-lt); font-weight: 600; }
    .ac-subnav .sub-link .dot {
      width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
    }

    /* ── Main area ─────────────────────────────────────────────────────── */
    .ac-main {
      margin-left: var(--sidebar-w);
      min-height: 100vh;
      display: flex; flex-direction: column;
    }

    /* ── Topbar ────────────────────────────────────────────────────────── */
    .ac-topbar {
      background: var(--white);
      border-bottom: 1px solid var(--grey-200);
      padding: 12px 28px;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
    }
    .ac-topbar .page-title {
      font-weight: 700; font-size: .95rem; color: var(--ink);
    }
    .ac-topbar .topbar-right {
      display: flex; align-items: center; gap: 12px;
      font-size: .78rem; color: var(--grey-400);
    }

    /* ── Content ───────────────────────────────────────────────────────── */
    .ac-content { padding: 26px 28px; flex: 1; }

    /* ── Cards ─────────────────────────────────────────────────────────── */
    .ac-card {
      background: var(--white); border-radius: 12px;
      border: 1px solid var(--grey-200);
      box-shadow: 0 1px 3px rgba(0,0,0,.04);
    }
    .ac-card-header {
      padding: 12px 18px;
      border-bottom: 1px solid var(--grey-200);
      font-weight: 700; font-size: .82rem; color: var(--ink-2);
      display: flex; align-items: center; gap: 8px;
    }

    /* ── Stock badges ──────────────────────────────────────────────────── */
    .stock-in  { background: #D1FAE5; color: #065F46; }
    .stock-low { background: #FEF3C7; color: #92400E; }
    .stock-out { background: #FEE2E2; color: #991B1B; }

    /* ── Flash alerts ──────────────────────────────────────────────────── */
    .flash-success {
      background: #F0FDF4; border: 1px solid #86EFAC;
      color: #166534; border-radius: 8px; padding: 10px 16px;
      margin-bottom: 16px; font-size: .85rem; font-weight: 500;
      display: flex; align-items: center; gap: 8px;
    }
    .flash-error {
      background: #FFF1F2; border: 1px solid #FDA4AF;
      color: #9F1239; border-radius: 8px; padding: 10px 16px;
      margin-bottom: 16px; font-size: .85rem; font-weight: 500;
      display: flex; align-items: center; gap: 8px;
    }

    /* ── Element grid cards ─────────────────────────────────────────────── */
    .el-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      gap: 10px;
      padding: 16px;
    }
    .el-card {
      background: var(--grey-50); border: 1px solid var(--grey-200);
      border-radius: 9px; padding: 11px 9px;
      text-align: center; position: relative;
      transition: box-shadow .12s, border-color .12s;
    }
    .el-card:hover {
      box-shadow: 0 2px 10px rgba(0,0,0,.07);
      border-color: var(--grey-400);
    }
    .el-card .el-name {
      font-size: .72rem; font-weight: 600; color: var(--ink);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .el-card .el-price {
      font-size: .68rem; color: var(--pink); font-weight: 700; margin-top: 2px;
    }
    .el-card .el-actions {
      display: none;
      position: absolute; top: 5px; right: 5px;
      gap: 3px;
    }
    .el-card:hover .el-actions { display: flex; }
    .el-card .el-actions a,
    .el-card .el-actions button {
      width: 22px; height: 22px; border-radius: 4px; border: none;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; text-decoration: none;
      transition: background .1s;
    }
    .el-card .el-actions .btn-edit   { background: var(--grey-200); color: var(--ink-2); }
    .el-card .el-actions .btn-delete { background: #FEE2E2; color: #991B1B; }
    .el-card .el-actions .btn-edit:hover   { background: var(--grey-400); color: #fff; }
    .el-card .el-actions .btn-delete:hover { background: #FCA5A5; }

    .el-card.inactive { opacity: .42; }
    .el-card .inactive-badge {
      position: absolute; top: 4px; left: 4px;
      font-size: .58rem; background: var(--ink-2); color: #fff;
      border-radius: 3px; padding: 1px 5px; letter-spacing: .03em;
    }

    /* ── Charm grid ─────────────────────────────────────────────────────── */
    .charm-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
      gap: 10px;
      padding: 16px;
    }
    .charm-card {
      background: var(--grey-50); border: 1px solid var(--grey-200);
      border-radius: 9px; overflow: hidden; position: relative;
      transition: box-shadow .12s, border-color .12s;
    }
    .charm-card:hover {
      box-shadow: 0 2px 10px rgba(0,0,0,.07);
      border-color: var(--grey-400);
    }
    .charm-card .thumb {
      width: 100%; aspect-ratio: 1;
      display: flex; align-items: center; justify-content: center;
      background: var(--grey-100);
      border-bottom: 1px solid var(--grey-200);
    }
    .charm-card .thumb img { width: 72%; height: 72%; object-fit: contain; }
    .charm-card .thumb-placeholder { font-size: 1.4rem; opacity: .3; }
    .charm-card .charm-info { padding: 8px 10px 10px; }
    .charm-card .charm-name {
      font-size: .74rem; font-weight: 600; color: var(--ink);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .charm-card .charm-series { font-size: .65rem; color: var(--grey-400); margin-top: 1px; }
    .charm-card .charm-price { font-size: .68rem; color: var(--pink); font-weight: 700; margin-top: 4px; }
    .charm-card .el-actions {
      display: none;
      position: absolute; top: 5px; right: 5px; gap: 3px;
    }
    .charm-card:hover .el-actions { display: flex; }
    .charm-card .el-actions a,
    .charm-card .el-actions button {
      width: 24px; height: 24px; border-radius: 4px; border: none;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; text-decoration: none; transition: background .1s;
    }
    .charm-card .el-actions .btn-edit   { background: rgba(255,255,255,.92); color: var(--ink-2); }
    .charm-card .el-actions .btn-delete { background: #FEE2E2; color: #991B1B; }

    /* ── Filter bar ─────────────────────────────────────────────────────── */
    .filter-bar {
      padding: 10px 14px;
      border-bottom: 1px solid var(--grey-200);
      display: flex; flex-wrap: wrap; gap: 7px; align-items: center;
    }
    .filter-bar input, .filter-bar select {
      font-size: .78rem; padding: 4px 9px; border-radius: 6px;
      border: 1px solid var(--grey-200); background: var(--white);
      height: 30px; color: var(--ink);
    }
    .filter-bar input:focus, .filter-bar select:focus {
      outline: none; border-color: var(--pink);
    }
    .filter-bar .btn-filter {
      background: var(--ink); color: #fff; border: none;
      font-size: .75rem; padding: 4px 13px; border-radius: 6px; height: 30px;
      cursor: pointer; font-weight: 600;
    }
    .filter-bar .btn-filter:hover { background: var(--ink-2); }
    .filter-bar .btn-reset {
      background: transparent; color: var(--grey-400);
      border: 1px solid var(--grey-200);
      font-size: .75rem; padding: 4px 11px; border-radius: 6px; height: 30px;
      cursor: pointer; text-decoration: none; display: inline-flex; align-items: center;
    }

    /* ── Group divider inside grid ─────────────────────────────────────── */
    .group-label {
      grid-column: 1 / -1;
      font-size: .65rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: .09em; color: var(--grey-400);
      padding: 4px 2px 0;
      border-top: 1px solid var(--grey-200); margin-top: 4px;
    }
    .group-label:first-child { border-top: none; margin-top: 0; }

    /* ── Series header ─────────────────────────────────────────────────── */
    .series-label {
      padding: 12px 16px 4px;
      font-size: .65rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: .09em; color: var(--grey-400);
      border-top: 1px solid var(--grey-200);
    }
    .series-label:first-of-type { border-top: none; }
  </style>

  @stack('styles')
</head>
<body>

{{-- SIDEBAR ──────────────────────────────────────────────────────────────── --}}
<aside class="ac-sidebar">

  <div class="brand">
    <div class="brand-dot"></div>
    ArtsyCrate
    <small>Admin</small>
  </div>

  <div class="nav-section">Builder</div>

  <a href="{{ route('admin.elements.index') }}"
     class="nav-link {{ request()->routeIs('admin.elements.index') ? 'active' : '' }}">
    <i data-lucide="gem"></i> Elements
  </a>

  <div class="ac-subnav">
    <a href="{{ route('admin.elements.beads') }}"
       class="sub-link {{ request()->routeIs('admin.elements.beads') ? 'active' : '' }}">
      <span class="dot" style="background:#F9B8CF;"></span> Beads
    </a>
    <a href="{{ route('admin.elements.figures') }}"
       class="sub-link {{ request()->routeIs('admin.elements.figures') ? 'active' : '' }}">
      <span class="dot" style="background:#93C5FD;"></span> Figures
    </a>
    <a href="{{ route('admin.elements.charms') }}"
       class="sub-link {{ request()->routeIs('admin.elements.charms') ? 'active' : '' }}">
      <span class="dot" style="background:#C4B5FD;"></span> Charms
    </a>
  </div>

  <div class="nav-section" style="margin-top:8px;">Store</div>
  <a href="{{ route('admin.orders.index') }}" class="nav-link"><i data-lucide="package"></i> Orders</a>
  {{-- <a href="{{ route('admin.products.index') }}" class="nav-link"><i data-lucide="box"></i> Products</a> --}}

  <div style="margin-top:auto; padding:12px 8px;">

  </div>

</aside>

{{-- MAIN ─────────────────────────────────────────────────────────────────── --}}
<div class="ac-main">

  <div class="ac-topbar">
    <div class="page-title">@yield('title', 'Dashboard')</div>
    <div class="topbar-right">
      @auth
        <i data-lucide="user" style="width:13px;height:13px;"></i>
        {{ auth()->user()->name }}
      @endauth
    </div>
  </div>

  <div class="ac-content">

    @if(session('success'))
      <div class="flash-success">
        <i data-lucide="check-circle" style="width:15px;height:15px;"></i>
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="flash-error">
        <i data-lucide="x-circle" style="width:15px;height:15px;"></i>
        {{ session('error') }}
      </div>
    @endif

    @yield('content')

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
@stack('scripts')
</body>
</html>