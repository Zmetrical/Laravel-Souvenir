<?php
// $activePage must be set by the parent page before including this file
// Accepted values: 'bracelet' | 'necklace' | 'keychain' | '' (index)
$activePage = $activePage ?? 'bracelet';

$navLinks = [
  'bracelet' => ['href' => route('builder.bracelet'), 'icon' => '◯', 'label' => 'Bracelet'],
  'necklace' => ['href' => route('builder.necklace'), 'icon' => '⌒', 'label' => 'Necklace'],
  'keychain' => ['href' => route('builder.keychain'), 'icon' => '⊟', 'label' => 'Keychain'],
];
?>
<style>
  /* ── Auth pill ──────────────────────────────────────────────────────── */
  .auth-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    border-radius: 999px;
    padding: 6px 14px 6px 8px;
    font-family: var(--fb);
    font-size: .75rem;
    font-weight: 800;
    text-decoration: none;
    transition: background .13s, border-color .13s;
    white-space: nowrap;
    cursor: pointer;
  }

  /* Logged-in state: subtle filled pill with avatar */
  .auth-pill.is-auth {
    background: var(--white);
    border: 1.5px solid var(--grey-200);
    color: var(--ink);
    position: relative;
  }
  .auth-pill.is-auth:hover {
    border-color: var(--pink-bd);
    background: var(--pink-lt);
    color: var(--pink-dk);
  }

  /* Guest state: outlined ghost pill */
  .auth-pill.is-guest {
    background: transparent;
    border: 1.5px solid var(--grey-300);
    color: var(--ink2);
  }
  .auth-pill.is-guest:hover {
    border-color: var(--pink);
    color: var(--pink-dk);
    background: var(--pink-lt);
  }

  /* Avatar circle */
  .auth-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .68rem;
    font-weight: 900;
    flex-shrink: 0;
    line-height: 1;
  }
  .auth-avatar.av-user {
    background: var(--pink);
    color: var(--white);
  }
  .auth-avatar.av-guest {
    background: var(--grey-200);
    color: var(--grey-400);
  }

  /* Online dot */
  .auth-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22C55E;
    border: 1.5px solid var(--white);
    position: absolute;
    bottom: 4px;
    left: 25px;
  }

  /* Dropdown */
  .auth-wrap {
    position: relative;
  }
  .auth-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    min-width: 180px;
    background: var(--white);
    border: 1.5px solid var(--grey-200);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(30,30,42,.10);
    overflow: hidden;
    z-index: 200;
  }
  .auth-wrap:hover .auth-dropdown,
  .auth-wrap.open .auth-dropdown {
    display: block;
  }
  .auth-dropdown-head {
    padding: 11px 14px 8px;
    border-bottom: 1px solid var(--grey-100);
  }
  .auth-dropdown-name {
    font-size: .8rem;
    font-weight: 800;
    color: var(--ink);
    margin-bottom: 1px;
  }
  .auth-dropdown-role {
    font-size: .65rem;
    font-weight: 700;
    color: var(--grey-400);
    text-transform: uppercase;
    letter-spacing: .06em;
  }
  .auth-dropdown-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 14px;
    font-size: .78rem;
    font-weight: 700;
    color: var(--ink2);
    text-decoration: none;
    transition: background .11s, color .11s;
  }
  .auth-dropdown-item:hover {
    background: var(--grey-50);
    color: var(--ink);
  }
  .auth-dropdown-item.danger {
    color: #DC2626;
  }
  .auth-dropdown-item.danger:hover {
    background: #FEF2F2;
    color: #991B1B;
  }
  .auth-dropdown-divider {
    height: 1px;
    background: var(--grey-100);
    margin: 2px 0;
  }
  .auth-dropdown-icon {
    font-size: .85rem;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
  }

  /* Keep topbar-r tidy */
  .topbar-r {
    display: flex;
    align-items: center;
    gap: 10px;
  }
</style>

<div class="topbar">
  <div class="topbar-l">
    <a href="<?= route('builder.index') ?>" class="logo">Artsy<b>Crate</b></a>
    <nav class="builder-nav">
      <?php foreach ($navLinks as $key => $link): ?>
      <a class="bnav-link {{ $activePage === $key ? 'active' : '' }}"
        href="{{ $link['href'] }}">
        <span class="bnav-icon">{!! $link['icon'] !!}</span>
        {{ $link['label'] }}
      </a>
      <?php endforeach; ?>
    </nav>
  </div>

  <div class="topbar-r">

    {{-- ── Order button — only on builder pages ── --}}
    @if($activePage)
      <button class="btn-order" onclick="app.ui.openOrder()">Order This →</button>
    @endif

    {{-- ── Auth state pill ── --}}
    @auth
      {{-- Logged in: show name + dropdown --}}
      <div class="auth-wrap" id="auth-wrap">
        <div class="auth-pill is-auth" onclick="document.getElementById('auth-wrap').classList.toggle('open')">
          <div class="auth-avatar av-user">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
          <span>{{ explode(' ', auth()->user()->name)[0] }}</span>
          <svg viewBox="0 0 12 12" style="width:10px;height:10px;flex-shrink:0;opacity:.5;">
            <polyline points="2,4 6,8 10,4" fill="none" stroke="currentColor" stroke-width="1.5"/>
          </svg>
          <span class="auth-dot"></span>
        </div>

        <div class="auth-dropdown">
          <div class="auth-dropdown-head">
            <div class="auth-dropdown-name">{{ auth()->user()->name }}</div>
            <div class="auth-dropdown-role">
              {{ auth()->user()->role === 'admin' ? '⭐ Admin' : '🛍️ Customer' }}
            </div>
          </div>

          @if(auth()->user()->role === 'admin')
            <a class="auth-dropdown-item" href="{{ route('admin.orders.index') }}">
              <span class="auth-dropdown-icon">📋</span> Admin Dashboard
            </a>
            <div class="auth-dropdown-divider"></div>
          @endif

          <a class="auth-dropdown-item" href="{{ route('account.dashboard') }}">
            <span class="auth-dropdown-icon">👤</span> My Account
          </a>
          <a class="auth-dropdown-item" href="{{ route('account.orders') }}">
            <span class="auth-dropdown-icon">📦</span> My Orders
          </a>
          <a class="auth-dropdown-item" href="{{ route('account.designs') }}">
            <span class="auth-dropdown-icon">🎨</span> Saved Designs
          </a>

          <div class="auth-dropdown-divider"></div>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="auth-dropdown-item danger"
                    style="width:100%;background:none;border:none;text-align:left;cursor:pointer;
                           font-family:var(--fb);">
              <span class="auth-dropdown-icon">🚪</span> Log Out
            </button>
          </form>
        </div>
      </div>

    @else
      {{-- Guest: pill that links to login --}}
      <a class="auth-pill is-guest" href="{{ route('login') }}">
        <div class="auth-avatar av-guest">?</div>
        <span>Guest</span>
        <svg viewBox="0 0 12 12" style="width:9px;height:9px;flex-shrink:0;opacity:.45;">
          <polyline points="5,2 10,6 5,10" fill="none" stroke="currentColor" stroke-width="1.5"/>
          <line x1="2" y1="6" x2="10" y2="6" stroke="currentColor" stroke-width="1.5"/>
        </svg>
      </a>
    @endguest

  </div>
</div>

<script>
  // Close auth dropdown when clicking outside
  document.addEventListener('click', function(e) {
    const wrap = document.getElementById('auth-wrap');
    if (wrap && !wrap.contains(e.target)) {
      wrap.classList.remove('open');
    }
  });
</script>