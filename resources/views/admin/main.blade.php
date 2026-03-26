<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ArtsyCrate Admin — @yield('title', 'Dashboard')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- Lucide Icons -->
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

  <style>
    :root {
      --pink:    #FF5FA0;
      --pink-lt: #FFD6E8;
      --teal:    #1AC8C4;
      --purple:  #A855F7;
      --ink:     #2D2D3A;
      --sidebar-w: 240px;
    }

    body { background: #F8F7FA; font-family: 'Segoe UI', sans-serif; }

    /* ── Sidebar ── */
    .ac-sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background: var(--ink);
      position: fixed; top: 0; left: 0;
      display: flex; flex-direction: column;
      z-index: 100;
    }
    .ac-sidebar .brand {
      padding: 20px 22px 16px;
      font-size: 1.15rem; font-weight: 800;
      color: #fff; letter-spacing: -.3px;
      border-bottom: 1px solid rgba(255,255,255,.08);
    }
    .ac-sidebar .brand span { color: var(--pink); }

    .ac-sidebar .nav-section {
      padding: 12px 14px 4px;
      font-size: .65rem; font-weight: 700;
      color: rgba(255,255,255,.35); letter-spacing: .08em; text-transform: uppercase;
    }
    .ac-sidebar .nav-link {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 16px; margin: 1px 8px;
      border-radius: 8px;
      color: rgba(255,255,255,.65); font-size: .85rem; font-weight: 500;
      text-decoration: none; transition: all .15s;
    }
    .ac-sidebar .nav-link:hover  { background: rgba(255,255,255,.08); color: #fff; }
    .ac-sidebar .nav-link.active { background: var(--pink); color: #fff; }
    .ac-sidebar .nav-link i      { width: 16px; height: 16px; }

    /* ── Main area ── */
    .ac-main {
      margin-left: var(--sidebar-w);
      min-height: 100vh;
      display: flex; flex-direction: column;
    }

    /* ── Topbar ── */
    .ac-topbar {
      background: #fff;
      border-bottom: 1px solid #EEEDF3;
      padding: 12px 28px;
      display: flex; align-items: center; justify-content: space-between;
      position: sticky; top: 0; z-index: 50;
    }
    .ac-topbar .page-title { font-weight: 700; font-size: 1rem; color: var(--ink); }

    /* ── Content ── */
    .ac-content { padding: 28px; flex: 1; }

    /* ── Cards ── */
    .ac-card {
      background: #fff; border-radius: 14px;
      border: 1px solid #EEEDF3;
      box-shadow: 0 1px 4px rgba(0,0,0,.04);
    }
    .ac-card-header {
      padding: 16px 20px;
      border-bottom: 1px solid #EEEDF3;
      font-weight: 700; font-size: .9rem; color: var(--ink);
      display: flex; align-items: center; gap: 8px;
    }

    /* ── Badges ── */
    .stock-in  { background: #D1FAE5; color: #065F46; }
    .stock-low { background: #FEF3C7; color: #92400E; }
    .stock-out { background: #FEE2E2; color: #991B1B; }

    /* ── Flash alerts ── */
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
  </style>

  @stack('styles')
</head>
<body>

<!-- ══ SIDEBAR ══════════════════════════════════════════════════════════════ -->
<aside class="ac-sidebar">
  <div class="brand">Artsy<span>Crate</span> <small style="font-size:.6rem;opacity:.5;font-weight:400;">Admin</small></div>

  <div class="nav-section">Builder</div>
  <a href="{{ route('admin.elements.index') }}"
     class="nav-link {{ request()->routeIs('admin.elements.*') ? 'active' : '' }}">
    <i data-lucide="gem"></i> Elements
  </a>

  <div class="nav-section" style="margin-top:8px;">Store</div>
  <a href="#" class="nav-link"><i data-lucide="package"></i> Orders</a>
  <a href="#" class="nav-link"><i data-lucide="box"></i> Products</a>

  <div style="margin-top:auto; padding:16px;">
    <a href="/" class="nav-link" style="background:rgba(255,255,255,.06);">
      <i data-lucide="arrow-left"></i> Back to Site
    </a>
  </div>
</aside>

<!-- ══ MAIN ═════════════════════════════════════════════════════════════════ -->
<div class="ac-main">

  <!-- Topbar -->
  <div class="ac-topbar">
    <div class="page-title">@yield('title', 'Dashboard')</div>
    <div style="font-size:.8rem; color:#888;">
      @auth {{ auth()->user()->name }} @endauth
    </div>
  </div>

  <!-- Content -->
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