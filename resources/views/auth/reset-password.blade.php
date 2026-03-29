<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Reset Password — ArtsyCrate</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: var(--offwhite); overflow-y: auto !important; height: auto !important; display: block !important; }
    
    .auth-page { min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px; }
    
    .logo-container { margin-bottom: 32px; text-align: center; }
    .logo { font-family: var(--fh); font-size: 2.2rem; color: var(--ink); text-decoration: none; }
    .logo b { color: var(--pink); }

    .auth-card {
      background: #fff; border: 1.5px solid var(--grey-200);
      border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);
      width: 100%; max-width: 420px; padding: 32px;
    }

    .auth-title { font-family: var(--fh); font-size: 1.8rem; color: var(--ink); margin-bottom: 8px; text-align: center; }
    .auth-subtitle { font-size: 0.95rem; font-weight: 700; color: var(--ink-md); text-align: center; margin-bottom: 24px; }
    
    .form-group { margin-bottom: 16px; width: 100%; }
    .form-label { display: block; font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .form-control {
      width: 100%; padding: 12px 16px; border: 1.5px solid var(--grey-200);
      border-radius: 10px; font-family: var(--fb); font-size: 0.9rem; font-weight: 700;
      color: var(--ink); background: var(--offwhite); transition: all 0.2s;
    }
    .form-control:focus { outline: none; border-color: var(--pink); background: #fff; box-shadow: 0 0 0 4px var(--pink-bg); }
    .form-control.is-error { border-color: var(--pink); background: var(--pink-bg); }
    .error-msg { font-size: 0.75rem; font-weight: 800; color: var(--pink-dk); margin-top: 4px; display: block; }
    
    .btn-submit {
      width: 100%; padding: 16px; background: var(--pink); color: #fff;
      border: none; border-radius: 12px; font-family: var(--fh); font-size: 1.1rem;
      cursor: pointer; box-shadow: 0 8px 24px rgba(255,95,160,0.25);
      transition: all 0.2s; margin-top: 8px;
    }
    .btn-submit:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(255,95,160,0.35); }
  </style>
</head>
<body>

<div class="auth-page">
  <div class="logo-container">
    <a href="{{ route('home') }}" class="logo">Artsy<b>Crate</b></a>
  </div>

  <div class="auth-card">
    <h1 class="auth-title">Set New Password</h1>
    <p class="auth-subtitle">Pick something secure (min 8 characters).</p>

    <form method="POST" action="{{ route('password.update') }}" novalidate>
      @csrf
      <input type="hidden" name="token" value="{{ $token }}"/>

      <div class="form-group">
        <label class="form-label" for="email">Email Address</label>
        <input class="form-control {{ $errors->has('email') ? 'is-error' : '' }}" type="email" id="email" name="email" value="{{ old('email', $email) }}" required/>
        @error('email')<span class="error-msg">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password">New Password</label>
        <input class="form-control {{ $errors->has('password') ? 'is-error' : '' }}" type="password" id="password" name="password" required autofocus/>
        @error('password')<span class="error-msg">{{ $message }}</span>@enderror
      </div>

      <div class="form-group">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required/>
      </div>

      <button type="submit" class="btn-submit">Reset Password</button>
    </form>
  </div>
</div>

</body>
</html>