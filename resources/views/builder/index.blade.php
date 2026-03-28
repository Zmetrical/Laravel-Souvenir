{{--
  ArtsyCrate — Builder Index
  resources/views/builder/index.blade.php
--}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Design Studio</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    /* ── Reset body (builder CSS locks overflow) ── */
    body {
      overflow: auto !important;
      height: auto !important;
      background: var(--white);
      display: block !important;
    }

    .idx-page { min-height: 100vh; display: flex; flex-direction: column; }
    .idx-main { flex: 1; }

    /* ══════════════════════════════
       HERO
    ══════════════════════════════ */
    .idx-hero {
      background: var(--white);
      border-bottom: 1px solid var(--grey-200);
      padding: 56px 0 52px;
      position: relative;
      overflow: hidden;
    }

    /* Subtle dot grid */
    .idx-hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(var(--grey-300) 1px, transparent 1px);
      background-size: 20px 20px;
      opacity: .28;
      pointer-events: none;
    }
    .idx-hero > .container { position: relative; z-index: 1; }

    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: var(--pink-lt);
      border: 1.5px solid var(--pink-bd);
      border-radius: var(--r-pill);
      padding: 4px 13px;
      font-family: var(--fb);
      font-size: .65rem;
      font-weight: 800;
      color: var(--pink-dk);
      letter-spacing: .07em;
      text-transform: uppercase;
      margin-bottom: 18px;
    }

    .hero-title {
      font-family: var(--fh);
      font-size: clamp(2rem, 4.5vw, 3.2rem);
      font-weight: 800;
      line-height: 1.1;
      letter-spacing: -.03em;
      color: var(--ink);
      margin-bottom: 16px;
    }
    .hero-title em {
      font-style: normal;
      color: var(--pink);
    }

    .hero-sub {
      font-family: var(--fb);
      font-size: .9rem;
      font-weight: 600;
      color: var(--ink2);
      line-height: 1.7;
      max-width: 420px;
      margin-bottom: 28px;
    }

    .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-start {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: var(--pink);
      color: var(--white) !important;
      text-decoration: none;
      border: none;
      border-radius: var(--r-pill);
      padding: 11px 24px;
      font-family: var(--fb);
      font-weight: 800;
      font-size: .84rem;
      transition: background .14s, transform .12s;
    }
    .btn-start:hover { background: var(--pink-dk); transform: translateY(-1px); }
    .btn-start i[data-lucide] { width: 15px; height: 15px; }

    .btn-outline {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: var(--white);
      color: var(--ink2) !important;
      text-decoration: none;
      border: 1.5px solid var(--grey-200);
      border-radius: var(--r-pill);
      padding: 10px 20px;
      font-family: var(--fb);
      font-weight: 700;
      font-size: .82rem;
      transition: border-color .13s, background .13s;
    }
    .btn-outline:hover { background: var(--grey-50); border-color: var(--grey-300); }
    .btn-outline i[data-lucide] { width: 14px; height: 14px; }

    /* ══════════════════════════════
       PRODUCTS SECTION
    ══════════════════════════════ */
    .products-section {
      padding: 56px 0 64px;
      background: var(--grey-50);
      border-bottom: 1px solid var(--grey-200);
    }

    .section-label {
      font-family: var(--fb);
      font-size: .62rem;
      font-weight: 800;
      letter-spacing: .12em;
      text-transform: uppercase;
      color: var(--ink3);
      margin-bottom: 5px;
    }
    .section-title {
      font-family: var(--fh);
      font-size: 1.55rem;
      font-weight: 800;
      color: var(--ink);
      letter-spacing: -.025em;
      margin-bottom: 32px;
    }

    /* Product card */
    .pcard {
      background: var(--white);
      border: 1.5px solid var(--grey-200);
      border-radius: var(--r-lg);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      text-decoration: none;
      color: inherit;
      height: 100%;
      transition: border-color .18s, box-shadow .18s, transform .18s;
    }
    .pcard:hover {
      border-color: var(--pink-bd);
      box-shadow: 0 8px 28px rgba(232,37,122,.08);
      transform: translateY(-3px);
      text-decoration: none;
      color: inherit;
    }

    .pcard-strip { height: 5px; flex-shrink: 0; }
    .strip-pink   { background: var(--pink); }
    .strip-purple { background: var(--purple); }
    .strip-teal   { background: var(--teal); }

    .pcard-top {
      padding: 22px 22px 14px;
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 10px;
    }

    .pcard-icon {
      width: 50px;
      height: 50px;
      border-radius: var(--r-md);
      border: 1.5px solid var(--grey-200);
      background: var(--white);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }
    .pcard-icon i[data-lucide] { width: 24px; height: 24px; }

    .pcard-body {
      padding: 0 22px 22px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .pcard-type {
      font-size: .58rem;
      font-weight: 800;
      letter-spacing: .10em;
      text-transform: uppercase;
      margin-bottom: 4px;
    }

    .pcard-name {
      font-family: var(--fh);
      font-size: 1.18rem;
      font-weight: 800;
      color: var(--ink);
      letter-spacing: -.02em;
      margin-bottom: 8px;
    }

    .pcard-desc {
      font-size: .78rem;
      font-weight: 600;
      color: var(--ink2);
      line-height: 1.65;
      margin-bottom: 16px;
      flex: 1;
    }

    .pcard-foot {
      padding-top: 16px;
      border-top: 1px solid var(--grey-100);
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .pcard-price-lbl { font-size: .62rem; font-weight: 700; color: var(--ink3); margin-bottom: 1px; }
    .pcard-price-val { font-family: var(--fh); font-size: 1.05rem; font-weight: 800; }

    .pcard-btn {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      border-radius: var(--r-pill);
      padding: 8px 16px;
      font-family: var(--fb);
      font-weight: 800;
      font-size: .74rem;
      color: var(--white);
      border: none;
      transition: opacity .13s, transform .12s;
      text-decoration: none;
    }
    .pcard-btn:hover { opacity: .88; transform: translateY(-1px); color: var(--white); }
    .pcard-btn i[data-lucide] { width: 12px; height: 12px; }
    .btn-pink   { background: var(--pink); }
    .btn-purple { background: var(--purple); }
    .btn-teal   { background: var(--teal-dk); }

    /* ══════════════════════════════
       HOW IT WORKS
    ══════════════════════════════ */
    .how-section {
      padding: 52px 0 56px;
      background: var(--white);
      border-bottom: 1px solid var(--grey-200);
    }

    .step-row {
      display: flex;
      gap: 0;
      position: relative;
    }
    .step-row::before {
      content: '';
      position: absolute;
      top: 21px;
      left: 22px;
      right: 22px;
      height: 1px;
      background: var(--grey-200);
      z-index: 0;
    }
    @media (max-width: 767px) {
      .step-row { flex-direction: column; gap: 28px; }
      .step-row::before { display: none; }
    }

    .step-item {
      flex: 1;
      padding: 0 22px;
      position: relative;
      z-index: 1;
    }
    @media (max-width: 767px) { .step-item { padding: 0; } }

    .step-num-wrap {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: var(--white);
      border: 1.5px solid var(--grey-200);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 14px;
    }
    .step-num {
      font-family: var(--fh);
      font-size: .88rem;
      font-weight: 800;
      color: var(--pink);
    }
    .step-title {
      font-family: var(--fb);
      font-size: .86rem;
      font-weight: 800;
      color: var(--ink);
      margin-bottom: 5px;
    }
    .step-desc {
      font-size: .74rem;
      font-weight: 600;
      color: var(--ink2);
      line-height: 1.6;
    }

    /* ══════════════════════════════
       FOOTER
    ══════════════════════════════ */
    .idx-footer {
      background: var(--white);
      border-top: 1px solid var(--grey-200);
      padding: 20px 0;
    }
    .footer-logo {
      font-family: var(--fh);
      font-size: 1rem;
      font-weight: 800;
      color: var(--ink);
      letter-spacing: -.02em;
    }
    .footer-logo b { color: var(--pink); }

    .container { max-width: 1080px; }
    html { scroll-behavior: smooth; }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fu   { animation: fadeUp .46s cubic-bezier(.22,1,.36,1) both; }
    .fu-1 { animation-delay: .04s; }
    .fu-2 { animation-delay: .12s; }
    .fu-3 { animation-delay: .20s; }
    .fu-4 { animation-delay: .28s; }
  </style>
</head>
<body>
<div class="idx-page">

  <?php $activePage = ''; ?>
  @include('builder.includes.topbar')

  <main class="idx-main">

    {{-- ══ HERO ══ --}}
    <section class="idx-hero">
      <div class="container">
        <div class="row align-items-center g-4 g-lg-5">

          {{-- Copy --}}
          <div class="col-lg-6">
            <div class="hero-eyebrow fu fu-1">
              <i data-lucide="sparkles" style="width:11px;height:11px;"></i>
              Custom Design Studio
            </div>
            <h1 class="hero-title fu fu-2">
              Build your<br><em>perfect piece.</em>
            </h1>
            <p class="hero-sub fu fu-3">
              Design a bracelet, necklace, or keychain from scratch — choose every bead, charm, and color, then place your order in minutes.
            </p>
            <div class="hero-actions fu fu-4">
              <a href="{{ route('builder.bracelet') }}" class="btn-start">
                <i data-lucide="wand-2"></i>
                Start Designing
              </a>
              <a href="#products" class="btn-outline">
                <i data-lucide="layers"></i>
                Browse Products
              </a>
            </div>
          </div>


        </div>
      </div>
    </section>


    {{-- ══ PRODUCTS ══ --}}
    <section class="products-section" id="products">
      <div class="container">

        <div class="mb-4">
          <div class="section-label">Choose a Product</div>
          <div class="section-title">What are you making today?</div>
        </div>

        <div class="row g-3">

          {{-- Bracelet --}}
          <div class="col-md-4 fu fu-1">
            <a href="{{ route('builder.bracelet') }}" class="pcard">
              <div class="pcard-strip strip-pink"></div>
              <div class="pcard-top">
                <div class="pcard-icon" style="border-color:var(--pink-bd);">
                  <i data-lucide="circle" style="color:var(--pink);"></i>
                </div>
              </div>
              <div class="pcard-body">
                <div class="pcard-type" style="color:var(--pink);">Wrist Jewelry</div>
                <div class="pcard-name">Bracelet</div>
                <p class="pcard-desc">Beaded bracelet with your choice of string, clasp, and up to 20 beads — mix charms, figures, and letters.</p>

                <div class="pcard-foot">
                  <div>
                    <div class="pcard-price-lbl">Starts at</div>
                    <div class="pcard-price-val" style="color:var(--pink);">₱80</div>
                  </div>
                  <span class="pcard-btn btn-pink">Design Now <i data-lucide="arrow-right"></i></span>
                </div>
              </div>
            </a>
          </div>

          {{-- Necklace --}}
          <div class="col-md-4 fu fu-2">
            <a href="{{ route('builder.necklace') }}" class="pcard">
              <div class="pcard-strip strip-purple"></div>
              <div class="pcard-top">
                <div class="pcard-icon" style="border-color:var(--purple-bd);">
                  <i data-lucide="gem" style="color:var(--purple);"></i>
                </div>
              </div>
              <div class="pcard-body">
                <div class="pcard-type" style="color:var(--purple);">Neck Jewelry</div>
                <div class="pcard-name">Necklace</div>
                <p class="pcard-desc">From choker to matinee — up to 28 beads, charms, and letter tiles on your choice of chain or cord.</p>

                <div class="pcard-foot">
                  <div>
                    <div class="pcard-price-lbl">Starts at</div>
                    <div class="pcard-price-val" style="color:var(--purple);">₱100</div>
                  </div>
                  <span class="pcard-btn btn-purple">Design Now <i data-lucide="arrow-right"></i></span>
                </div>
              </div>
            </a>
          </div>

          {{-- Keychain --}}
          <div class="col-md-4 fu fu-3">
            <a href="{{ route('builder.keychain') }}" class="pcard">
              <div class="pcard-strip strip-teal"></div>
              <div class="pcard-top">
                <div class="pcard-icon" style="border-color:var(--teal-bd);">
                  <i data-lucide="key" style="color:var(--teal-dk);"></i>
                </div>
              </div>
              <div class="pcard-body">
                <div class="pcard-type" style="color:var(--teal-dk);">Bag / Key Charm</div>
                <div class="pcard-name">Keychain / Charm</div>
                <p class="pcard-desc">Beaded keychain or bag charm with 1–3 strands. Mix charms, letters, and beads across strands for a unique look.</p>
                <div class="pcard-foot">
                  <div>
                    <div class="pcard-price-lbl">Starts at</div>
                    <div class="pcard-price-val" style="color:var(--teal-dk);">₱65</div>
                  </div>
                  <span class="pcard-btn btn-teal">Design Now <i data-lucide="arrow-right"></i></span>
                </div>
              </div>
            </a>
          </div>

        </div>
      </div>
    </section>


    {{-- ══ HOW IT WORKS ══ --}}
    <section class="how-section">
      <div class="container">

        <div class="mb-5">
          <div class="section-label">The Process</div>
          <div class="section-title">How it works</div>
        </div>

        <div class="step-row">
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">1</span></div>
            <div class="step-title">Pick a product</div>
            <p class="step-desc">Choose bracelet, necklace, or keychain as your starting point.</p>
          </div>
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">2</span></div>
            <div class="step-title">Configure it</div>
            <p class="step-desc">Set string color, type, length, and any product-specific options.</p>
          </div>
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">3</span></div>
            <div class="step-title">Add elements</div>
            <p class="step-desc">Browse the library and click to place beads, charms, and letters.</p>
          </div>
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">4</span></div>
            <div class="step-title">Place your order</div>
            <p class="step-desc">Fill in your details, submit, and get a unique order code to track progress.</p>
          </div>
        </div>

      </div>
    </section>

  </main>

  <footer class="idx-footer">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="footer-logo">Artsy<b>Crate</b></div>
        <div style="font-size:.7rem;font-weight:600;color:var(--ink3);">
          © {{ date('Y') }} ArtsyCrate · Made with <span style="color:var(--pink);">♥</span>
        </div>
      </div>
    </div>
  </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
</script>
</body>
</html>