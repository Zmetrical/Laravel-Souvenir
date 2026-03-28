<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Create Account — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --pink:     #FF5FA0;
      --pink-dk:  #E8407E;
      --pink-lt:  #FFE4F0;
      --teal:     #1AC8C4;
      --teal-dk:  #0FA8A4;
      --teal-bg:  #E8FAF9;
      --ink:      #1E1E2E;
      --ink-md:   #6B6B85;
      --ink-lt:   #E2E2EE;
      --offwhite: #F7F7FC;
      --white:    #FFFFFF;
      --fb:       'Nunito', sans-serif;
      --fh:       'Syne', sans-serif;
    }

    body {
      font-family: var(--fb);
      background: var(--offwhite);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .auth-wrap {
      flex: 1;
      display: grid;
      grid-template-columns: 1fr 1fr;
      min-height: 100vh;
    }

    /* ── Left aside ── */
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
        radial-gradient(ellipse 60% 50% at 30% 40%, rgba(26,200,196,.2) 0%, transparent 70%),
        radial-gradient(ellipse 50% 60% at 70% 80%, rgba(255,95,160,.15) 0%, transparent 70%);
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
    .aside-logo b { color: var(--teal); }

    .aside-body { position: relative; z-index: 1; }
    .aside-tag {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: rgba(26,200,196,.15);
      border: 1px solid rgba(26,200,196,.3);
      border-radius: 999px;
      padding: 5px 14px;
      font-size: .7rem;
      font-weight: 800;
      color: var(--teal);
      letter-spacing: .08em;
      text-transform: uppercase;
      margin-bottom: 20px;
    }
    .aside-tag::before {
      content: '';
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--teal);
    }
    .aside-title {
      font-family: var(--fh);
      font-size: clamp(2rem, 3.5vw, 2.8rem);
      color: var(--white);
      line-height: 1.1;
      margin-bottom: 18px;
    }
    .aside-title span { color: var(--teal); }
    .aside-sub {
      font-size: .88rem;
      font-weight: 600;
      color: rgba(255,255,255,.55);
      line-height: 1.75;
      max-width: 340px;
      margin-bottom: 28px;
    }

    /* perks list */
    .aside-perks { display: flex; flex-direction: column; gap: 12px; }
    .aside-perk {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      font-size: .82rem;
      font-weight: 700;
      color: rgba(255,255,255,.7);
    }
    .perk-dot {
      width: 22px; height: 22px;
      border-radius: 50%;
      background: rgba(26,200,196,.2);
      border: 1.5px solid rgba(26,200,196,.4);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .65rem;
      color: var(--teal);
      font-weight: 900;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .aside-foot {
      position: relative;
      z-index: 1;
      font-size: .72rem;
      font-weight: 700;
      color: rgba(255,255,255,.3);
    }

    /* ── Right form ── */
    .auth-main {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 48px 32px;
      background: var(--white);
      overflow-y: auto;
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

    /* Fields */
    .frow {
      display: flex;
      flex-direction: column;
      gap: 6px;
      margin-bottom: 16px;
    }
    .frow-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
      margin-bottom: 16px;
    }
    .flbl {
      font-size: .75rem;
      font-weight: 800;
      color: var(--ink);
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
    .finput.is-error { border-color: var(--pink); background: #FFF8FA; }
    .ferr {
      font-size: .72rem;
      font-weight: 800;
      color: var(--pink-dk);
    }
    .fhint {
      font-size: .7rem;
      font-weight: 700;
      color: var(--ink-md);
    }

    /* Submit */
    .fbtn {
      width: 100%;
      padding: 14px;
      background: var(--teal);
      color: var(--white);
      font-family: var(--fb);
      font-weight: 900;
      font-size: .95rem;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      box-shadow: 0 6px 22px rgba(26,200,196,.3);
      transition: background .14s, transform .12s, box-shadow .14s;
      margin-top: 8px;
    }
    .fbtn:hover {
      background: var(--teal-dk);
      transform: translateY(-2px);
      box-shadow: 0 10px 28px rgba(26,200,196,.38);
    }
    .fbtn:active { transform: scale(.98); }

    .auth-terms {
      font-size: .7rem;
      font-weight: 700;
      color: var(--ink-md);
      text-align: center;
      margin-top: 14px;
      line-height: 1.65;
    }

    /* Sign in link */
    .auth-divider {
      display: flex;
      align-items: center;
      gap: 12px;
      margin: 22px 0;
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
    .auth-signin {
      text-align: center;
      font-size: .82rem;
      font-weight: 700;
      color: var(--ink-md);
    }
    .auth-signin a {
      color: var(--pink);
      font-weight: 900;
      text-decoration: none;
    }
    .auth-signin a:hover { text-decoration: underline; }

    @media (max-width: 768px) {
      .auth-wrap { grid-template-columns: 1fr; }
      .auth-aside { display: none; }
      .auth-main { padding: 40px 20px; }
      .frow-2 { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

<div class="auth-wrap">

  <!-- ── Left aside ── -->
  <div class="auth-aside">
    <a href="{{ route('home') }}" class="aside-logo">Artsy<b>Crate</b></a>

    <div class="aside-body">
      <div class="aside-tag">Join ArtsyCrate</div>
      <h2 class="aside-title">
        Start designing<br>
        <span>something special.</span>
      </h2>
      <p class="aside-sub">
        Create an account to save your designs, track your orders,
        and bring your custom creations to life.
      </p>
      <div class="aside-perks">
        <div class="aside-perk">
          <div class="perk-dot">✓</div>
          Save designs and come back to them anytime
        </div>
        <div class="aside-perk">
          <div class="perk-dot">✓</div>
          Track your order from approval to delivery
        </div>
        <div class="aside-perk">
          <div class="perk-dot">✓</div>
          Revise your design with the admin in real time
        </div>
        <div class="aside-perk">
          <div class="perk-dot">✓</div>
          Reorder a past design with one click
        </div>
      </div>
    </div>

    <div class="aside-foot">© {{ date('Y') }} ArtsyCrate. All rights reserved.</div>
  </div>

  <!-- ── Right form ── -->
  <div class="auth-main">
    <div class="auth-card">

      <h1 class="auth-card-title">Create your account ✨</h1>
      <p class="auth-card-sub">
        Already have one?
        <a href="{{ route('login') }}">Sign in instead</a>
      </p>

      <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        {{-- Name ──────────────────────────────────────────── --}}
        <div class="frow">
          <label class="flbl" for="name">Full Name</label>
          <input
            class="finput {{ $errors->has('name') ? 'is-error' : '' }}"
            id="name" name="name" type="text"
            value="{{ old('name') }}"
            placeholder="Maria Santos"
            autocomplete="name" autofocus required/>
          @error('name')
            <span class="ferr">{{ $message }}</span>
          @enderror
        </div>

        {{-- Email ─────────────────────────────────────────── --}}
        <div class="frow">
          <label class="flbl" for="email">Email Address</label>
          <input
            class="finput {{ $errors->has('email') ? 'is-error' : '' }}"
            id="email" name="email" type="email"
            value="{{ old('email') }}"
            placeholder="maria@example.com"
            autocomplete="email" required/>
          @error('email')
            <span class="ferr">{{ $message }}</span>
          @enderror
        </div>

        {{-- Password ───────────────────────────────────────── --}}
        <div class="frow">
          <label class="flbl" for="password">Password</label>
          <input
            class="finput {{ $errors->has('password') ? 'is-error' : '' }}"
            id="password" name="password" type="password"
            placeholder="••••••••"
            autocomplete="new-password" required/>
          <span class="fhint">At least 8 characters</span>
          @error('password')
            <span class="ferr">{{ $message }}</span>
          @enderror
        </div>

        {{-- Confirm password ───────────────────────────────── --}}
        <div class="frow">
          <label class="flbl" for="password_confirmation">Confirm Password</label>
          <input
            class="finput {{ $errors->has('password_confirmation') ? 'is-error' : '' }}"
            id="password_confirmation" name="password_confirmation" type="password"
            placeholder="••••••••"
            autocomplete="new-password" required/>
          @error('password_confirmation')
            <span class="ferr">{{ $message }}</span>
          @enderror
        </div>

        {{-- Submit ─────────────────────────────────────────── --}}
        <button type="submit" class="fbtn">
          Create Account →
        </button>

        <p class="auth-terms">
          By creating an account you agree to be contacted via the details
          provided for order updates. No spam — ever.
        </p>

      </form>

      <div class="auth-divider">or</div>

      <div class="auth-signin">
        Already have an account?
        <a href="{{ route('login') }}">Sign in</a>
      </div>

    </div>
  </div>

</div>

</body>
</html>