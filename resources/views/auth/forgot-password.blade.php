<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Forgot Password — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --pink:     #FF5FA0; --pink-dk: #E8407E; --pink-lt: #FFE4F0;
      --teal:     #1AC8C4; --teal-dk: #0FA8A4; --teal-bg: #E8FAF9;
      --ink:      #1E1E2E; --ink-md:  #6B6B85; --ink-lt:  #E2E2EE;
      --offwhite: #F7F7FC; --white:   #FFFFFF;
      --fb: 'Nunito', sans-serif; --fh: 'Syne', sans-serif;
    }
    body { font-family: var(--fb); background: var(--offwhite); min-height: 100vh; display: flex; flex-direction: column; }

    .auth-wrap { flex: 1; display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }

    /* ── Left aside ── */
    .auth-aside {
      background: var(--ink); display: flex; flex-direction: column;
      justify-content: space-between; padding: 48px 52px;
      position: relative; overflow: hidden;
    }
    .auth-aside::before {
      content: ''; position: absolute; inset: 0;
      background:
        radial-gradient(ellipse 60% 50% at 25% 35%, rgba(255,95,160,.2) 0%, transparent 70%),
        radial-gradient(ellipse 50% 60% at 75% 75%, rgba(26,200,196,.15) 0%, transparent 70%);
      pointer-events: none;
    }
    .aside-logo { font-family: var(--fh); font-size: 1.5rem; color: var(--white); text-decoration: none; position: relative; z-index: 1; }
    .aside-logo b { color: var(--pink); }
    .aside-body { position: relative; z-index: 1; }
    .aside-title { font-family: var(--fh); font-size: clamp(2rem, 3.5vw, 2.6rem); color: var(--white); line-height: 1.1; margin-bottom: 18px; }
    .aside-title span { color: var(--pink); }
    .aside-sub { font-size: .88rem; font-weight: 600; color: rgba(255,255,255,.5); line-height: 1.75; max-width: 340px; }
    .aside-foot { position: relative; z-index: 1; font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.3); }

    /* ── Right form ── */
    .auth-main { display: flex; align-items: center; justify-content: center; padding: 48px 32px; background: var(--white); }
    .auth-card { width: 100%; max-width: 420px; }

    .back-link {
      display: inline-flex; align-items: center; gap: 6px;
      font-size: .78rem; font-weight: 800; color: var(--ink-md);
      text-decoration: none; margin-bottom: 28px;
    }
    .back-link:hover { color: var(--ink); }

    .auth-card-title { font-family: var(--fh); font-size: 1.75rem; color: var(--ink); margin-bottom: 6px; }
    .auth-card-sub { font-size: .85rem; font-weight: 700; color: var(--ink-md); margin-bottom: 28px; line-height: 1.65; }

    .auth-banner { border-radius: 12px; padding: 12px 16px; font-size: .82rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
    .auth-banner.success { background: var(--teal-bg); border: 1.5px solid rgba(26,200,196,.25); color: var(--teal-dk); }
    .auth-banner.error   { background: #FFF1F5; border: 1.5px solid rgba(255,95,160,.25); color: var(--pink-dk); }

    .frow { display: flex; flex-direction: column; gap: 6px; margin-bottom: 20px; }
    .flbl { font-size: .75rem; font-weight: 800; color: var(--ink); letter-spacing: .03em; }
    .finput {
      border: 1.5px solid var(--ink-lt); border-radius: 12px; padding: 12px 14px;
      font-family: var(--fb); font-weight: 600; font-size: .9rem;
      background: var(--offwhite); color: var(--ink); width: 100%;
      transition: border-color .13s, background .13s, box-shadow .13s;
    }
    .finput:focus { outline: none; border-color: var(--teal); background: var(--white); box-shadow: 0 0 0 3px rgba(26,200,196,.12); }
    .finput.is-error { border-color: var(--pink); background: #FFF8FA; }
    .ferr { font-size: .72rem; font-weight: 800; color: var(--pink-dk); }

    .fbtn {
      width: 100%; padding: 14px; background: var(--pink); color: var(--white);
      font-family: var(--fb); font-weight: 900; font-size: .95rem;
      border: none; border-radius: 12px; cursor: pointer;
      box-shadow: 0 6px 22px rgba(255,95,160,.32);
      transition: background .14s, transform .12s, box-shadow .14s;
    }
    .fbtn:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(255,95,160,.4); }
    .fbtn:active { transform: scale(.98); }

    @media (max-width: 768px) {
      .auth-wrap { grid-template-columns: 1fr; }
      .auth-aside { display: none; }
      .auth-main { padding: 40px 20px; }
    }
  </style>
</head>
<body>
<div class="auth-wrap">

  <div class="auth-aside">
    <a href="{{ route('home') }}" class="aside-logo">Artsy<b>Crate</b></a>
    <div class="aside-body">
      <h2 class="aside-title">No worries.<br><span>We've got you.</span></h2>
      <p class="aside-sub">
        Enter the email linked to your account and we'll send you a secure link
        to reset your password. It expires in 60 minutes.
      </p>
    </div>
    <div class="aside-foot">© {{ date('Y') }} ArtsyCrate. All rights reserved.</div>
  </div>

  <div class="auth-main">
    <div class="auth-card">

      <a class="back-link" href="{{ route('login') }}">← Back to Sign In</a>

      <h1 class="auth-card-title">Forgot password? 🔑</h1>
      <p class="auth-card-sub">
        Type in your email address below and we'll send you a reset link right away.
      </p>

      {{-- Success status --}}
      @if (session('status'))
        <div class="auth-banner success">
          ✓ {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}" novalidate>
        @csrf

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

        <button type="submit" class="fbtn">Send Reset Link →</button>
      </form>

    </div>
  </div>

</div>
</body>
</html>