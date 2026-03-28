<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Sign In — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --pink:      #FF5FA0;
      --pink-dk:   #E8407E;
      --pink-lt:   #FFE4F0;
      --teal:      #1AC8C4;
      --teal-dk:   #0FA8A4;
      --teal-bg:   #E8FAF9;
      --ink:       #1E1E2E;
      --ink-md:    #6B6B85;
      --ink-lt:    #E2E2EE;
      --offwhite:  #F7F7FC;
      --white:     #FFFFFF;
      --fb:        'Nunito', sans-serif;
      --fh:        'Syne', sans-serif;
    }

    body {
      font-family: var(--fb);
      background: var(--offwhite);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── Layout ── */
    .auth-wrap {
      flex: 1;
      display: grid;
      grid-template-columns: 1fr 1fr;
      min-height: 100vh;
    }

    /* ── Left panel — decorative ── */
    .auth-aside {
      background: var(--ink);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 48px 52px;
      position: relative;
      overflow: hidden;
    }
    .auth-aside::before {
      content: '';
      position: absolute;
      inset: 0;
      background:
        radial-gradient(ellipse 60% 50% at 20% 30%, rgba(255,95,160,.22) 0%, transparent 70%),
        radial-gradient(ellipse 50% 60% at 80% 70%, rgba(26,200,196,.18) 0%, transparent 70%);
      pointer-events: none;
    }

    .aside-logo {
      font-family: var(--fh);
      font-size: 1.5rem;
      color: var(--white);
      text-decoration: none;
      position: relative;
      z-index: 1;
    }
    .aside-logo b { color: var(--pink); }

    .aside-body {
      position: relative;
      z-index: 1;
    }
    .aside-tag {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: rgba(255,95,160,.15);
      border: 1px solid rgba(255,95,160,.3);
      border-radius: 999px;
      padding: 5px 14px;
      font-size: .7rem;
      font-weight: 800;
      color: var(--pink);
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: 20px;
    }
    .aside-tag::before {
      content: '';
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--pink);
    }
    .aside-title {
      font-family: var(--fh);
      font-size: clamp(2rem, 3.5vw, 2.8rem);
      color: var(--white);
      line-height: 1.1;
      margin-bottom: 18px;
    }
    .aside-title span { color: var(--pink); }
    .aside-sub {
      font-size: .88rem;
      font-weight: 600;
      color: rgba(255,255,255,.55);
      line-height: 1.75;
      max-width: 340px;
    }

    /* floating bead decorations */
    .aside-beads {
      display: flex;
      gap: 10px;
      margin-top: 36px;
      flex-wrap: wrap;
    }
    .aside-bead {
      width: 38px; height: 38px;
      border-radius: 50%;
      border: 2px solid rgba(255,255,255,.12);
      opacity: .7;
    }

    .aside-foot {
      position: relative;
      z-index: 1;
      font-size: .72rem;
      font-weight: 700;
      color: rgba(255,255,255,.3);
    }

    /* ── Right panel — form ── */
    .auth-main {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 32px;
      background: var(--white);
    }
    .auth-card {
      width: 100%;
      max-width: 420px;
    }

    .auth-card-title {
      font-family: var(--fh);
      font-size: 1.75rem;
      color: var(--ink);
      margin-bottom: 6px;
    }
    .auth-card-sub {
      font-size: .85rem;
      font-weight: 700;
      color: var(--ink-md);
      margin-bottom: 32px;
    }
    .auth-card-sub a {
      color: var(--pink);
      text-decoration: none;
      font-weight: 800;
    }
    .auth-card-sub a:hover { text-decoration: underline; }

    /* Status / error banner */
    .auth-banner {
      border-radius: 12px;
      padding: 12px 16px;
      font-size: .82rem;
      font-weight: 700;
      margin-bottom: 20px;
      display: flex;
      align-items: flex-start;
      gap: 10px;
    }
    .auth-banner.error {
      background: #FFF1F5;
      border: 1.5px solid rgba(255,95,160,.25);
      color: var(--pink-dk);
    }
    .auth-banner.info {
      background: var(--teal-bg);
      border: 1.5px solid rgba(26,200,196,.25);
      color: var(--teal-dk);
    }

    /* Fields */
    .frow {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 18px;
    }
    .flbl {
      font-size: .75rem;
      font-weight: 800;
      color: var(--ink);
      letter-spacing: .03em;
    }
    .finput {
      border: 1.5px solid var(--ink-lt);
      border-radius: 12px;
      padding: 12px 14px;
      font-family: var(--fb);
      font-weight: 600;
      font-size: .9rem;
      background: var(--offwhite);
      color: var(--ink);
      width: 100%;
      transition: border-color .13s, background .13s, box-shadow .13s;
    }
    .finput:focus {
      outline: none;
      border-color: var(--teal);
      background: var(--white);
      box-shadow: 0 0 0 3px rgba(26,200,196,.12);
    }
    .finput.is-error {
      border-color: var(--pink);
      background: #FFF8FA;
    }
    .finput.is-error:focus {
      box-shadow: 0 0 0 3px rgba(255,95,160,.12);
    }
    .ferr {
      font-size: .72rem;
      font-weight: 800;
      color: var(--pink-dk);
    }

    /* Remember + forgot row */
    .frow-inline {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }
    .fcheck {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      font-size: .8rem;
      font-weight: 700;
      color: var(--ink-md);
    }
    .fcheck input[type="checkbox"] {
      width: 16px; height: 16px;
      accent-color: var(--teal);
      cursor: pointer;
    }
    .fforgot {
      font-size: .8rem;
      font-weight: 800;
      color: var(--pink);
      text-decoration: none;
    }
    .fforgot:hover { text-decoration: underline; }

    /* Submit button */
    .fbtn {
      width: 100%;
      padding: 14px;
      background: var(--pink);
      color: var(--white);
      font-family: var(--fb);
      font-weight: 900;
      font-size: .95rem;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 6px 22px rgba(255,95,160,.32);
      transition: background .14s, transform .12s, box-shadow .14s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 9px;
    }
    .fbtn:hover {
      background: var(--pink-dk);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(255,95,160,.4);
    }
    .fbtn:active { transform: scale(.98); }

    /* Divider */
    .auth-divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 24px 0;
      color: var(--ink-lt);
      font-size: .75rem;
      font-weight: 700;
    }
    .auth-divider::before,
    .auth-divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--ink-lt);
    }

    /* Register link row */
    .auth-register {
      text-align: center;
      font-size: .82rem;
      font-weight: 700;
      color: var(--ink-md);
    }
    .auth-register a {
      color: var(--teal-dk);
      font-weight: 900;
      text-decoration: none;
    }
    .auth-register a:hover { text-decoration: underline; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
      .auth-wrap { grid-template-columns: 1fr; }
      .auth-aside { display: none; }
      .auth-main { padding: 40px 20px; }
    }
  </style>
</head>
<body>

<div class="auth-wrap">

  <!-- ── Left: decorative aside ── -->
  <div class="auth-aside">
    <a href="{{ route('home') }}" class="aside-logo">Artsy<b>Crate</b></a>

    <div class="aside-body">
      <div class="aside-tag">Custom Design Studio</div>
      <h2 class="aside-title">
        Design it.<br>
        <span>Make it yours.</span>
      </h2>
      <p class="aside-sub">
        Build custom keychains, bracelets, and necklaces bead by bead.
        Track your order from design approval to your door.
      </p>
      <div class="aside-beads">
        <div class="aside-bead" style="background:#FF5FA0;"></div>
        <div class="aside-bead" style="background:#1AC8C4;"></div>
        <div class="aside-bead" style="background:#A855F7;"></div>
        <div class="aside-bead" style="background:#FFD700;"></div>
        <div class="aside-bead" style="background:#3B82F6;"></div>
        <div class="aside-bead" style="background:#EF4444;"></div>
        <div class="aside-bead" style="background:#fff;"></div>
        <div class="aside-bead" style="background:#F9B8CF;"></div>
      </div>
    </div>

    <div class="aside-foot">© {{ date('Y') }} ArtsyCrate. All rights reserved.</div>
  </div>

  <!-- ── Right: login form ── -->
  <div class="auth-main">
    <div class="auth-card">

      <h1 class="auth-card-title">Welcome back 👋</h1>
      <p class="auth-card-sub">
        Don't have an account?
        <a href="{{ route('register') }}">Sign up free</a>
      </p>

      {{-- Session error (e.g. redirected from middleware) --}}
      @if (session('error'))
        <div class="auth-banner error">
          ⚠ {{ session('error') }}
        </div>
      @endif

      {{-- Session info (e.g. password reset success) --}}
      @if (session('status'))
        <div class="auth-banner info">
          ✓ {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        {{-- Email ──────────────────────────────────────── --}}
        <div class="frow">
          <label class="flbl" for="email">Email Address</label>
          <input
            class="finput {{ $errors->has('email') ? 'is-error' : '' }}"
            id="email" name="email" type="email"
            value="{{ old('email') }}"
            placeholder="maria@example.com"
            autocomplete="email" autofocus required/>
          @error('email')
            <span class="ferr">{{ $message }}</span>
          @enderror
        </div>

        {{-- Password ────────────────────────────────────── --}}
        <div class="frow">
          <label class="flbl" for="password">Password</label>
          <input
            class="finput {{ $errors->has('password') ? 'is-error' : '' }}"
            id="password" name="password" type="password"
            placeholder="••••••••"
            autocomplete="current-password" required/>
          @error('password')
            <span class="ferr">{{ $message }}</span>
          @enderror
        </div>

        {{-- Remember + Forgot ───────────────────────────── --}}
        <div class="frow-inline">
          <label class="fcheck">
            <input type="checkbox" name="remember" id="remember"
                   {{ old('remember') ? 'checked' : '' }}/>
            Keep me signed in
          </label>
          <a class="fforgot" href="{{ route('password.request') }}">
            Forgot password?
          </a>
        </div>

        {{-- Submit ─────────────────────────────────────── --}}
        <button type="submit" class="fbtn">
          Sign In →
        </button>

      </form>

      <div class="auth-divider">or</div>

      <div class="auth-register">
        New to ArtsyCrate?
        <a href="{{ route('register') }}">Create a free account</a>
      </div>

    </div>
  </div>

</div>

</body>
</html>