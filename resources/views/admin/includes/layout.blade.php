<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ArtsyCrate Admin — @yield('title', 'Dashboard')</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    
    :root {
      --pink:      #FF5FA0; --pink-dk:   #E04080; --pink-bg:   #FFF0F6; --pink-bd: #FFD0E8;
      --teal:      #1AC8C4; --teal-dk:   #0FA8A4; --teal-bg:   #E8FAFA;
      --purple:    #A855F7; --purple-bg: #F3E8FF; --purple-dk: #6D28D9;
      --lime:      #84CC16; --lime-bg:   #F7FEE7; --lime-dk:   #4D7C0F;
      --ink:       #1E1E2E; --ink-md:    #6c757d; --ink-lt:    #e9ecef;
      --white:     #FFFFFF; --offwhite:  #FAFBFC;
      --grey-50:   #F4F5F8; --grey-100:  #F0F0F4; --grey-200:  #E5E7EB; --grey-400: #9ca3af;
      --fh: 'Lilita One', cursive; --fb: 'Nunito', sans-serif;
      --sidebar-w: 250px;
    }

    body { background: var(--offwhite); font-family: var(--fb); color: var(--ink); overflow-x: hidden; }

    /* ── Light Sidebar ── */
    .ac-sidebar {
      width: var(--sidebar-w); min-height: 100vh; background: var(--white);
      border-right: 1.5px solid var(--grey-200); position: fixed; top: 0; left: 0; 
      display: flex; flex-direction: column; z-index: 100;
    }
    .ac-sidebar .brand {
      padding: 20px 24px; font-family: var(--fh); font-size: 1.6rem; color: var(--ink);
      border-bottom: 1.5px solid var(--grey-200); display: flex; align-items: center; gap: 8px; letter-spacing: 1px; text-decoration: none;
    }
    .ac-sidebar .brand-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--pink); }
    .ac-sidebar .brand small { font-family: var(--fb); font-size: 0.7rem; font-weight: 800; color: var(--grey-400); text-transform: uppercase; letter-spacing: 0.1em; }

    .nav-section { padding: 24px 24px 8px; font-size: 0.7rem; font-weight: 900; color: var(--grey-400); text-transform: uppercase; letter-spacing: 0.1em; }
    .nav-link {
      display: flex; align-items: center; gap: 10px; padding: 10px 16px; margin: 2px 12px; border-radius: 10px;
      color: var(--ink-md); font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
    }
    .nav-link:hover  { background: var(--grey-50); color: var(--ink); }
    .nav-link.active { background: var(--pink-bg); color: var(--pink-dk); border: 1.5px solid var(--pink-bd); font-weight: 800; box-shadow: 0 4px 12px rgba(255,95,160,0.05); }

    .ac-subnav { margin: 4px 12px 4px 34px; border-left: 1.5px solid var(--grey-200); padding-left: 8px; }
    .sub-link { display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 8px; color: var(--ink-md); font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: all 0.2s; }
    .sub-link:hover  { background: var(--grey-50); color: var(--ink); }
    .sub-link.active { color: var(--ink); font-weight: 800; background: var(--grey-100); }
    .sub-link .dot { width: 6px; height: 6px; border-radius: 50%; }

    /* ── Main Area & Topbar ── */
    .ac-main { margin-left: var(--sidebar-w); min-height: 100vh; display: flex; flex-direction: column; }
    .ac-topbar {
      background: var(--white); border-bottom: 1.5px solid var(--grey-200); padding: 0 28px; height: 64px;
      display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50;
    }
    .ac-topbar .page-title { font-family: var(--fh); font-size: 1.3rem; color: var(--ink); letter-spacing: 0.5px; }
    .ac-content { padding: 32px 28px; flex: 1; }

    /* ── Global App Cards & Inputs ── */
    .ac-card { background: var(--white); border-radius: 16px; border: 1.5px solid var(--grey-200); box-shadow: 0 4px 12px rgba(0,0,0,.02); overflow: hidden; }
    .ac-card-header { padding: 16px 24px; border-bottom: 1.5px solid var(--grey-200); font-family: var(--fh); font-size: 1.1rem; color: var(--ink); background: var(--offwhite); display: flex; align-items: center; gap: 8px; }
    
    .form-control, .form-select { padding: 10px 14px; border: 1.5px solid var(--grey-200); border-radius: 10px; font-weight: 700; font-size: 0.9rem; background: var(--offwhite); color: var(--ink); transition: all 0.2s; }
    .form-control:focus, .form-select:focus { outline: none; border-color: var(--pink); background: var(--white); box-shadow: 0 0 0 4px var(--pink-bg); }
    .form-label { font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }

    /* ── Buttons ── */
    .btn-pink { background: var(--pink); color: #fff; border: none; border-radius: 10px; font-weight: 800; font-size: 0.9rem; padding: 10px 20px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(255,95,160,0.2); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-pink:hover { background: var(--pink-dk); color: #fff; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(255,95,160,0.3); }
    .btn-ghost { background: var(--white); color: var(--ink-md); border: 1.5px solid var(--grey-200); border-radius: 10px; font-weight: 800; font-size: 0.85rem; padding: 8px 16px; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; }
    .btn-ghost:hover { background: var(--grey-50); color: var(--ink); border-color: var(--grey-300); }

    .flash-success { background: var(--lime-bg); border: 1.5px solid var(--lime); color: var(--lime-dk); border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 800; display: flex; align-items: center; gap: 10px; }
  
  /* ── Updated Filter Bar (Single Line) ── */
.filter-bar {
  display: flex;
  flex-flow: row nowrap; /* Force one line */
  align-items: center;
  gap: 10px;
  padding: 16px 20px;
  background: var(--offwhite);
  border-bottom: 1.5px solid var(--grey-200);
}

.filter-bar input, 
.filter-bar select {
  height: 40px; /* Uniform height */
  flex: 0 1 auto;
  min-width: 150px;
}

.filter-bar .btn-filter,
.filter-bar .btn-reset {
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 20px;
  white-space: nowrap;
  font-weight: 800;
  border-radius: 10px;
}

.filter-bar .btn-filter {
  background: var(--ink);
  color: #fff;
  border: none;
}

.filter-bar .btn-reset {
  background: #fff;
  color: var(--ink-md);
  border: 1.5px solid var(--grey-200);
  text-decoration: none;
}
  </style>

  @stack('styles')
</head>
<body>

<aside class="ac-sidebar">
  <a href="{{ route('home') }}" class="brand">
    <div class="brand-dot"></div> ArtsyCrate <small>Admin</small>
  </a>

  <div class="nav-section">Builder Settings</div>
  <a href="{{ route('admin.elements.index') }}" class="nav-link {{ request()->routeIs('admin.elements.index') ? 'active' : '' }}">
    <i data-lucide="layers"></i> Elements Overview
  </a>
  <div class="ac-subnav">
    <a href="{{ route('admin.elements.beads') }}" class="sub-link {{ request()->routeIs('admin.elements.beads') ? 'active' : '' }}">
      <span class="dot" style="background:var(--pink);"></span> Beads
    </a>
    <a href="{{ route('admin.elements.figures') }}" class="sub-link {{ request()->routeIs('admin.elements.figures') ? 'active' : '' }}">
      <span class="dot" style="background:var(--teal);"></span> Figures
    </a>
    <a href="{{ route('admin.elements.charms') }}" class="sub-link {{ request()->routeIs('admin.elements.charms') ? 'active' : '' }}">
      <span class="dot" style="background:var(--purple);"></span> Charms
    </a>
  </div>

  <div class="nav-section">Store Management</div>
  <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
    <i data-lucide="package"></i> Orders Tracker
  </a>
</aside>

<div class="ac-main">
  <div class="ac-topbar">
    <div class="page-title">@yield('title', 'Dashboard')</div>
    <div style="font-size: 0.85rem; font-weight: 800; color: var(--ink-md); display: flex; align-items: center; gap: 8px;">
      <i data-lucide="user"></i> Admin Mode
    </div>
  </div>

  <div class="ac-content">
    @if(session('success'))
      <div class="flash-success"><i data-lucide="check-circle"></i> {{ session('success') }}</div>
    @endif
    @yield('content')
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
@stack('scripts')
</body>
</html>