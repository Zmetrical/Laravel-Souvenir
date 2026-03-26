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
      --teal:      #1AC8C4;
      --purple:    #A855F7;
      --lime:      #84CC16;
      --ink:       #2D2D3A;
      --sidebar-w: 240px;
    }

    * { box-sizing: border-box; }

    body {
      background: #F8F7FA;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
    }

    /* ── Lucide fix ────────────────────────────────────────────────────── */
    [data-lucide] {
      width: 15px; height: 15px;
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
      padding: 20px 22px 16px;
      font-size: 1.15rem; font-weight: 800;
      color: #fff; letter-spacing: -.3px;
      border-bottom: 1px solid rgba(255,255,255,.08);
      flex-shrink: 0;
    }
    .ac-sidebar .brand span { color: var(--pink); }

    .ac-sidebar .nav-section {
      padding: 14px 16px 4px;
      font-size: .62rem; font-weight: 700;
      color: rgba(255,255,255,.3);
      letter-spacing: .1em; text-transform: uppercase;
    }

    .ac-sidebar .nav-link {
      display: flex; align-items: center; gap: 10px;
      padding: 8px 14px; margin: 1px 8px;
      border-radius: 8px;
      color: rgba(255,255,255,.6); font-size: .84rem; font-weight: 500;
      text-decoration: none; transition: all .15s;
    }
    .ac-sidebar .nav-link:hover  { background: rgba(255,255,255,.08); color: #fff; }
    .ac-sidebar .nav-link.active { background: var(--pink); color: #fff; }

    /* ── Sub-nav (category links) ──────────────────────────────────────── */
    .ac-subnav {
      margin: 2px 8px 4px 36px;
      border-left: 2px solid rgba(255,255,255,.1);
      padding-left: 4px;
    }
    .ac-subnav .sub-link {
      display: flex; align-items: center; gap: 8px;
      padding: 6px 10px;
      border-radius: 6px;
      color: rgba(255,255,255,.45); font-size: .8rem;
      text-decoration: none; transition: all .15s;
    }
    .ac-subnav .sub-link:hover  { background: rgba(255,255,255,.07); color: #fff; }
    .ac-subnav .sub-link.active { color: var(--pink-lt); font-weight: 600; }
    .ac-subnav .sub-link .dot {
      width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    }

    /* ── Main area ─────────────────────────────────────────────────────── */
    .ac-main {
      margin-left: var(--sidebar-w);
      min-height: 100vh;
      display: flex; flex-direction: column;
    }

    /* ── Topbar ────────────────────────────────────────────────────────── */
    .ac-topbar {
      background: #fff;
      border-bottom: 1px solid #EEEDF3;
      padding: 13px 28px;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
    }
    .ac-topbar .page-title { font-weight: 700; font-size: 1rem; color: var(--ink); }

    /* ── Content ───────────────────────────────────────────────────────── */
    .ac-content { padding: 28px; flex: 1; }

    /* ── Cards ─────────────────────────────────────────────────────────── */
    .ac-card {
      background: #fff; border-radius: 14px;
      border: 1px solid #EEEDF3;
      box-shadow: 0 1px 4px rgba(0,0,0,.04);
    }
    .ac-card-header {
      padding: 14px 20px;
      border-bottom: 1px solid #EEEDF3;
      font-weight: 700; font-size: .88rem; color: var(--ink);
      display: flex; align-items: center; gap: 8px;
    }

    /* ── Stock badges ──────────────────────────────────────────────────── */
    .stock-in  { background: #D1FAE5; color: #065F46; }
    .stock-low { background: #FEF3C7; color: #92400E; }
    .stock-out { background: #FEE2E2; color: #991B1B; }

    /* ── Flash alerts ──────────────────────────────────────────────────── */
    .flash-success {
      background: #D1FAE5; border: 1px solid #6EE7B7;
      color: #065F46; border-radius: 10px; padding: 12px 18px;
      margin-bottom: 18px; font-size: .88rem; font-weight: 500;
    }
    .flash-error {
      background: #FEE2E2; border: 1px solid #FCA5A5;
      color: #991B1B; border-radius: 10px; padding: 12px 18px;
      margin-bottom: 18px; font-size: .88rem; font-weight: 500;
    }

    /* ── Compact element grid cards ────────────────────────────────────── */
    .el-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
      gap: 12px;
      padding: 16px;
    }
    .el-card {
      background: #FAFAFA; border: 1px solid #EEEDF3;
      border-radius: 10px; padding: 12px 10px;
      text-align: center; position: relative;
      transition: box-shadow .15s, border-color .15s;
    }
    .el-card:hover { box-shadow: 0 3px 12px rgba(0,0,0,.08); border-color: #DDD; }

    .el-card .swatch {
      width: 44px; height: 44px; border-radius: 50%;
      margin: 0 auto 8px;
      border: 2px solid rgba(0,0,0,.07);
      display: flex; align-items: center; justify-content: center;
      font-size: .7rem; font-weight: 700; color: rgba(0,0,0,.3);
    }
    .el-card .el-name {
      font-size: .76rem; font-weight: 600; color: var(--ink);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .el-card .el-price {
      font-size: .72rem; color: var(--pink); font-weight: 700; margin-top: 2px;
    }
    .el-card .el-actions {
      display: none;
      position: absolute; top: 6px; right: 6px;
      gap: 3px;
    }
    .el-card:hover .el-actions { display: flex; }
    .el-card .el-actions a,
    .el-card .el-actions button {
      width: 24px; height: 24px; border-radius: 5px; border: none;
      display: flex; align-items: center; justify-content: center;
      font-size: .65rem; cursor: pointer; text-decoration: none;
      transition: background .1s;
    }
    .el-card .el-actions .btn-edit   { background: #EEE; color: #444; }
    .el-card .el-actions .btn-delete { background: #FEE2E2; color: #991B1B; }
    .el-card .el-actions .btn-edit:hover   { background: #DDD; }
    .el-card .el-actions .btn-delete:hover { background: #FCA5A5; }

    /* inactive overlay */
    .el-card.inactive { opacity: .45; }
    .el-card .inactive-badge {
      position: absolute; top: 5px; left: 5px;
      font-size: .6rem; background: #374151; color: #fff;
      border-radius: 4px; padding: 1px 5px;
    }

    /* ── Charm image grid ──────────────────────────────────────────────── */
    .charm-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
      gap: 12px;
      padding: 16px;
    }
    .charm-card {
      background: #FAFAFA; border: 1px solid #EEEDF3;
      border-radius: 10px; overflow: hidden; position: relative;
      transition: box-shadow .15s, border-color .15s;
    }
    .charm-card:hover { box-shadow: 0 3px 12px rgba(0,0,0,.08); border-color: #DDD; }
    .charm-card .thumb {
      width: 100%; aspect-ratio: 1;
      display: flex; align-items: center; justify-content: center;
      background: linear-gradient(135deg, #FFF0F6, #F0F8FF);
    }
    .charm-card .thumb img {
      width: 80%; height: 80%; object-fit: contain;
    }
    .charm-card .thumb-placeholder {
      font-size: 1.8rem;
    }
    .charm-card .charm-info {
      padding: 8px 10px 10px;
    }
    .charm-card .charm-name {
      font-size: .78rem; font-weight: 600; color: var(--ink);
      white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .charm-card .charm-series {
      font-size: .68rem; color: #999; margin-top: 1px;
    }
    .charm-card .charm-price {
      font-size: .72rem; color: var(--pink); font-weight: 700; margin-top: 4px;
    }
    .charm-card .el-actions {
      display: none;
      position: absolute; top: 6px; right: 6px;
      gap: 3px;
    }
    .charm-card:hover .el-actions { display: flex; }
    .charm-card .el-actions a,
    .charm-card .el-actions button {
      width: 26px; height: 26px; border-radius: 5px; border: none;
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; text-decoration: none; transition: background .1s;
    }
    .charm-card .el-actions .btn-edit   { background: rgba(255,255,255,.9); color: #444; }
    .charm-card .el-actions .btn-delete { background: #FEE2E2; color: #991B1B; }

    /* ── Filter bar ────────────────────────────────────────────────────── */
    .filter-bar {
      padding: 12px 16px;
      border-bottom: 1px solid #EEEDF3;
      display: flex; flex-wrap: wrap; gap: 8px; align-items: center;
    }
    .filter-bar input, .filter-bar select {
      font-size: .8rem; padding: 5px 10px; border-radius: 7px;
      border: 1px solid #DDDCEF; background: #FAFAFA;
      height: 32px;
    }
    .filter-bar input:focus, .filter-bar select:focus {
      outline: none; border-color: var(--pink);
    }
    .filter-bar .btn-filter {
      background: var(--ink); color: #fff; border: none;
      font-size: .78rem; padding: 5px 14px; border-radius: 7px; height: 32px;
      cursor: pointer;
    }
    .filter-bar .btn-reset {
      background: transparent; color: #888; border: 1px solid #DDD;
      font-size: .78rem; padding: 5px 12px; border-radius: 7px; height: 32px;
      cursor: pointer; text-decoration: none; display: inline-flex; align-items: center;
    }

    /* ── Group divider inside grid ─────────────────────────────────────── */
    .group-label {
      grid-column: 1 / -1;
      font-size: .7rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: .08em; color: #AAA;
      padding: 4px 2px 0;
      border-top: 1px solid #EEEDF3; margin-top: 4px;
    }
    .group-label:first-child { border-top: none; margin-top: 0; }
  </style>

  @stack('styles')
</head>
<body>

{{-- ══ SIDEBAR ══════════════════════════════════════════════════════════════ --}}
<aside class="ac-sidebar">

  <div class="brand">Artsy<span>Crate</span><small style="font-size:.58rem;opacity:.4;font-weight:400;margin-left:5px;">Admin</small></div>

  {{-- ── Builder section ──────────────────────────────────────────────── --}}
  <div class="nav-section">Builder</div>

  {{-- Elements parent link (overview) --}}
  <a href="{{ route('admin.elements.index') }}"
     class="nav-link {{ request()->routeIs('admin.elements.index') ? 'active' : '' }}">
    <i data-lucide="gem"></i> Elements
  </a>

  {{-- Sub-nav — always visible ──────────────────────────────────────────── --}}
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

  {{-- ── Store section ────────────────────────────────────────────────── --}}
  <div class="nav-section" style="margin-top:8px;">Store</div>
  <a href="#" class="nav-link"><i data-lucide="package"></i> Orders</a>
  <a href="#" class="nav-link"><i data-lucide="box"></i> Products</a>

  {{-- ── Bottom ────────────────────────────────────────────────────────── --}}
  <div style="margin-top:auto; padding:14px 8px;">
    <a href="/" class="nav-link" style="background:rgba(255,255,255,.05);">
      <i data-lucide="arrow-left"></i> Back to Site
    </a>
  </div>

</aside>

{{-- ══ MAIN ═════════════════════════════════════════════════════════════════ --}}
<div class="ac-main">

  {{-- Topbar --}}
  <div class="ac-topbar">
    <div class="page-title">@yield('title', 'Dashboard')</div>
    <div style="font-size:.8rem; color:#999;">
      @auth {{ auth()->user()->name }} @endauth
    </div>
  </div>

  {{-- Content --}}
  <div class="ac-content">

    @if(session('success'))
      <div class="flash-success">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="flash-error">✕ {{ session('error') }}</div>
    @endif

    @yield('content')

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>lucide.createIcons();</script>
@stack('scripts')
</body>
</html>