<?php
// $activePage must be set by the parent page before including this file
// Accepted values: 'bracelet' | 'necklace' | 'keychain' | '' (index)
$activePage = $activePage ?? 'bracelet';

// Upgraded to use Lucide icon names instead of basic text symbols!
$navLinks = [
  'bracelet' => ['href' => route('builder.bracelet'), 'icon' => 'circle', 'label' => 'Bracelet'],
  'necklace' => ['href' => route('builder.necklace'), 'icon' => 'gem', 'label' => 'Necklace'],
  'keychain' => ['href' => route('builder.keychain'), 'icon' => 'key', 'label' => 'Keychain'],
];
?>
<style>
  /* ── 1. Topbar Layout (Matches Workspace Columns exactly!) ──────────── */
  .topbar {
    background: #ffffff;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1.5px solid var(--grey-200);
    box-shadow: 0 2px 12px rgba(0,0,0,0.02);
    z-index: 100;
  }
  
  /* Left zone matches the 240px Setup Panel */
  .topbar-l { 
    width: 240px; 
    min-width: 240px; 
    padding-left: 18px; /* Aligns logo with panel headers */
    display: flex; 
    justify-content: flex-start; 
    align-items: center; 
  }
  
  /* Center zone takes remaining space, aligning perfectly with Canvas */
  .topbar-c { 
    flex: 1; 
    display: flex; 
    justify-content: center; 
    align-items: center; 
  }
  
  /* Right zone matches the 540px combined Design + Library panels */
  .topbar-r { 
    width: 540px; 
    min-width: 540px; 
    padding-right: 18px; 
    display: flex; 
    justify-content: flex-end; 
    align-items: center; 
    gap: 12px; 
  }

  /* ── 2. Logo ───────────────────────────────────────────────────────── */
  .logo {
    font-family: var(--fh);
    font-size: 1.4rem;
    color: var(--ink);
    text-decoration: none;
    letter-spacing: -0.02em;
  }
  .logo b { color: var(--pink); }

  /* ── 3. Centered Navigation Pills ──────────────────────────────────── */
  .builder-nav {
    display: flex;
    background: var(--offwhite);
    border: 1.5px solid var(--grey-200);
    border-radius: 999px;
    padding: 4px;
    gap: 4px;
  }
  .bnav-link {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 18px;
    border-radius: 999px;
    font-family: var(--fb);
    font-size: 0.8rem;
    font-weight: 800;
    color: var(--ink-md);
    text-decoration: none;
    transition: all 0.2s cubic-bezier(0.22, 1, 0.36, 1);
  }
  .bnav-link:hover { 
    color: var(--ink); 
  }
  .bnav-link.active {
    background: #ffffff;
    color: var(--pink-dk);
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border: 1px solid var(--pink-bg); /* Soft pink accent ring */
  }

  /* ── 4. Order Button ───────────────────────────────────────────────── */
  .btn-order {
    background: var(--pink);
    color: #fff;
    border: none;
    border-radius: 999px;
    padding: 8px 20px;
    font-family: var(--fb);
    font-weight: 900;
    font-size: 0.8rem;
    cursor: pointer;
    transition: transform 0.15s, box-shadow 0.15s;
    box-shadow: 0 4px 12px rgba(255,95,160,0.25);
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .btn-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(255,95,160,0.35);
  }

  /* ── 5. Auth pill ──────────────────────────────────────────────────── */
  .auth-pill {
    display: inline-flex; align-items: center; gap: 7px;
    border-radius: 999px; padding: 6px 14px 6px 8px;
    font-family: var(--fb); font-size: .75rem; font-weight: 800;
    text-decoration: none; transition: all 0.15s; cursor: pointer;
  }
  .auth-pill.is-auth { background: var(--white); border: 1.5px solid var(--grey-200); color: var(--ink); position: relative; }
  .auth-pill.is-auth:hover { border-color: var(--pink-bd); background: var(--pink-bg); color: var(--pink-dk); }
  .auth-pill.is-guest { background: transparent; border: 1.5px solid var(--grey-300); color: var(--ink-md); }
  .auth-pill.is-guest:hover { border-color: var(--pink); color: var(--pink-dk); background: var(--pink-bg); }

  .auth-avatar {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 900; flex-shrink: 0;
  }
  .auth-avatar.av-user { background: var(--pink); color: var(--white); }
  .auth-avatar.av-guest { background: var(--grey-200); color: #9ca3af; }

  .auth-dot {
    width: 8px; height: 8px; border-radius: 50%; background: var(--lime-dk);
    border: 1.5px solid var(--white); position: absolute; bottom: 4px; left: 26px;
  }

  /* Dropdown */
  .auth-wrap { position: relative; }
  .auth-dropdown {
    display: none; position: absolute; top: calc(100% + 12px); right: 0;
    min-width: 200px; background: var(--white); border: 1.5px solid var(--grey-200);
    border-radius: 14px; box-shadow: 0 10px 30px rgba(30,30,42,.08); overflow: hidden; z-index: 200;
  }
  .auth-wrap:hover .auth-dropdown, .auth-wrap.open .auth-dropdown { display: block; animation: popIn 0.2s cubic-bezier(0.22, 1, 0.36, 1); }
  @keyframes popIn { from { opacity: 0; transform: translateY(10px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }

  .auth-dropdown-head { padding: 14px 16px 10px; border-bottom: 1px solid var(--grey-100); background: var(--offwhite); }
  .auth-dropdown-name { font-size: .85rem; font-weight: 900; color: var(--ink); margin-bottom: 2px; }
  .auth-dropdown-role { font-size: .65rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: .06em; }
  .auth-dropdown-item {
    display: flex; align-items: center; gap: 10px; padding: 10px 16px;
    font-size: .8rem; font-weight: 800; color: var(--ink-md); text-decoration: none; transition: all .11s;
  }
  .auth-dropdown-item:hover { background: var(--pink-bg); color: var(--pink-dk); }
  .auth-dropdown-item.danger { color: #DC2626; }
  .auth-dropdown-item.danger:hover { background: #FEF2F2; color: #991B1B; }
  .auth-dropdown-divider { height: 1px; background: var(--grey-200); margin: 4px 0; }
</style>

<div class="topbar">
  
  <div class="topbar-l">
    <a href="<?= route('builder.index') ?>" class="logo">Artsy<b>Crate</b></a>
  </div>

  <div class="topbar-c">
    <nav class="builder-nav">
      <?php foreach ($navLinks as $key => $link): ?>
      <a class="bnav-link {{ $activePage === $key ? 'active' : '' }}" href="{{ $link['href'] }}">
        <i data-lucide="{{ $link['icon'] }}" style="width: 14px; height: 14px;"></i>
        {{ $link['label'] }}
      </a>
      <?php endforeach; ?>
    </nav>
  </div>

  <div class="topbar-r">

    {{-- ── Order button — only on builder pages ── --}}
    @if($activePage)
      <button class="btn-order" onclick="app.ui.openOrder()">
        Order This <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
      </button>
    @endif

    {{-- ── Auth state pill ── --}}
    @auth
      {{-- Logged in: show name + dropdown --}}
      <div class="auth-wrap" id="auth-wrap">
        <div class="auth-pill is-auth" onclick="document.getElementById('auth-wrap').classList.toggle('open')">
          <div class="auth-avatar av-user">
{{ strtoupper(substr(auth()->user()->first_name, 0, 1)) }}
          </div>
          <span>{{ explode(' ', auth()->user()->first_name)[0] }}</span>
          <i data-lucide="chevron-down" style="width: 12px; height: 12px; color: var(--ink-md);"></i>
          <span class="auth-dot"></span>
        </div>

        <div class="auth-dropdown">
          <div class="auth-dropdown-head">
            <div class="auth-dropdown-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="auth-dropdown-role">
              {{ auth()->user()->role === 'admin' ? 'Admin' : 'Customer' }}
            </div>
          </div>

          @if(auth()->user()->role === 'admin')
            <a class="auth-dropdown-item" href="{{ route('admin.orders.index') }}">
              <i data-lucide="layout-dashboard" style="width: 16px;"></i> Admin Dashboard
            </a>
            <div class="auth-dropdown-divider"></div>
          @endif

          <a class="auth-dropdown-item" href="{{ route('account.dashboard') }}">
            <i data-lucide="user" style="width: 16px;"></i> My Account
          </a>
          <a class="auth-dropdown-item" href="{{ route('account.orders') }}">
            <i data-lucide="package" style="width: 16px;"></i> My Orders
          </a>
          <a class="auth-dropdown-item" href="{{ route('account.designs') }}">
            <i data-lucide="palette" style="width: 16px;"></i> Saved Designs
          </a>

          <div class="auth-dropdown-divider"></div>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="auth-dropdown-item danger" style="width:100%;background:none;border:none;text-align:left;cursor:pointer;font-family:var(--fb);">
              <i data-lucide="log-out" style="width: 16px;"></i> Log Out
            </button>
          </form>
        </div>
      </div>

    @else
      {{-- Guest: pill that links to login --}}
      <a class="auth-pill is-guest" href="{{ route('login') }}">
        <div class="auth-avatar av-guest">
          <i data-lucide="user" style="width: 14px; height: 14px;"></i>
        </div>
        <span>Guest</span>
        <i data-lucide="log-in" style="width: 14px; height: 14px; margin-left: 4px;"></i>
      </a>
    @endguest

  </div>
</div>

<script>
  // Ensure lucide icons render
  if (typeof lucide !== 'undefined') {
    lucide.createIcons();
  }
  
  // Close auth dropdown when clicking outside
  document.addEventListener('click', function(e) {
    const wrap = document.getElementById('auth-wrap');
    if (wrap && !wrap.contains(e.target)) {
      wrap.classList.remove('open');
    }
  });
</script>