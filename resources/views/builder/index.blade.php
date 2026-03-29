{{--
  ArtsyCrate — Builder Index  (improved)
  resources/views/builder/index.blade.php
--}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Design Studio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    body { overflow: auto !important; height: auto !important; background: var(--grey-50); display: block !important; }
    .idx-page { min-height: 100vh; display: flex; flex-direction: column; }
    .idx-main { flex: 1; }

    /* ── Hero ── */
    .idx-hero {
      background: var(--white);
      border-bottom: 1px solid var(--grey-200);
      padding: 64px 0 60px;
      position: relative;
      overflow: hidden;
    }
    .idx-hero::before {
      content: '';
      position: absolute;
      top: -80px; right: -120px;
      width: 520px; height: 520px;
      border-radius: 50%;
      background: radial-gradient(circle, var(--pink-lt) 0%, transparent 70%);
      pointer-events: none;
    }
    .idx-hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: radial-gradient(var(--grey-300) 1px, transparent 1px);
      background-size: 20px 20px;
      opacity: .22;
      pointer-events: none;
    }
    .idx-hero > .container { position: relative; z-index: 1; }

    .hero-eyebrow {
      display: inline-flex; align-items: center; gap: 6px;
      background: var(--pink-lt);
      border: 1.5px solid var(--pink-bd);
      border-radius: var(--r-pill);
      padding: 4px 13px;
      font-size: .63rem; font-weight: 800; color: var(--pink-dk);
      letter-spacing: .08em; text-transform: uppercase;
      margin-bottom: 20px;
    }
    .hero-title {
      font-family: var(--fh);
      font-size: clamp(2rem, 4.5vw, 3.4rem);
      font-weight: 800;
      line-height: 1.08;
      letter-spacing: -.03em;
      color: var(--ink);
      margin-bottom: 18px;
    }
    .hero-title em { font-style: normal; color: var(--pink); }
    .hero-sub {
      font-size: .88rem; font-weight: 600; color: var(--ink2);
      line-height: 1.75; max-width: 400px; margin-bottom: 32px;
    }
    .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .btn-hero-primary {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--pink); color: var(--white) !important;
      text-decoration: none; border: none;
      border-radius: var(--r-pill); padding: 12px 26px;
      font-family: var(--fb); font-weight: 800; font-size: .86rem;
      box-shadow: 0 6px 22px rgba(232,37,122,.28);
      transition: background .14s, transform .12s, box-shadow .14s;
    }
    .btn-hero-primary:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(232,37,122,.38); }

    .btn-hero-ghost {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--white); color: var(--ink2) !important;
      text-decoration: none;
      border: 1.5px solid var(--grey-200);
      border-radius: var(--r-pill); padding: 11px 22px;
      font-family: var(--fb); font-weight: 700; font-size: .84rem;
      transition: border-color .13s, background .13s;
    }
    .btn-hero-ghost:hover { background: var(--grey-50); border-color: var(--grey-300); }

    /* ── Bead strip (decorative) ── */
    .bead-strip {
      display: flex; gap: 8px; align-items: center; flex-wrap: wrap;
      margin-top: 40px;
    }
    .bead-s {
      width: 32px; height: 32px; border-radius: 50%;
      border: 2px solid rgba(0,0,0,.06);
      box-shadow: 0 2px 6px rgba(0,0,0,.08);
      flex-shrink: 0;
    }
    .bead-s.lg { width: 44px; height: 44px; }

    /* ── Stats bar ── */
    .stats-bar {
      border-top: 1px solid var(--grey-200);
      padding: 16px 0;
      background: var(--grey-50);
      border-bottom: 1px solid var(--grey-200);
    }
    .stat-item { text-align: center; }
    .stat-num {
      font-family: var(--fh); font-size: 1.4rem; font-weight: 800;
      color: var(--ink); line-height: 1;
    }
    .stat-num b { color: var(--pink); }
    .stat-lbl { font-size: .68rem; font-weight: 700; color: var(--ink3); margin-top: 3px; }

    /* ── Products ── */
    .products-section { padding: 60px 0 68px; background: var(--white); border-bottom: 1px solid var(--grey-200); }

    .sec-eyebrow {
      font-size: .6rem; font-weight: 800; letter-spacing: .12em;
      text-transform: uppercase; color: var(--ink3); margin-bottom: 5px;
    }
    .sec-title {
      font-family: var(--fh); font-size: 1.5rem; font-weight: 800;
      color: var(--ink); letter-spacing: -.025em; margin-bottom: 36px;
    }

    /* Product cards */
    .pcard {
      background: var(--white);
      border: 1.5px solid var(--grey-200);
      border-radius: var(--r-lg);
      overflow: hidden;
      display: flex; flex-direction: column;
      text-decoration: none; color: inherit; height: 100%;
      transition: border-color .18s, box-shadow .18s, transform .18s;
    }
    .pcard:hover {
      border-color: var(--pink-bd);
      box-shadow: 0 8px 32px rgba(232,37,122,.1);
      transform: translateY(-3px);
      text-decoration: none; color: inherit;
    }
    .pcard-accent { height: 4px; flex-shrink: 0; }
    .pcard-inner { padding: 22px 22px 20px; flex: 1; display: flex; flex-direction: column; }

    .pcard-icon-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .pcard-icon {
      width: 46px; height: 46px; border-radius: var(--r-md);
      border: 1.5px solid var(--grey-200); background: var(--grey-50);
      display: flex; align-items: center; justify-content: center;
    }
    .pcard-icon i[data-lucide] { width: 20px; height: 20px; }
    .pcard-tag {
      font-size: .58rem; font-weight: 800; letter-spacing: .09em;
      text-transform: uppercase;
      background: var(--grey-50); border: 1px solid var(--grey-200);
      border-radius: var(--r-pill); padding: 3px 9px; color: var(--ink3);
    }

    .pcard-name {
      font-family: var(--fh); font-size: 1.15rem; font-weight: 800;
      color: var(--ink); letter-spacing: -.02em; margin-bottom: 7px;
    }
    .pcard-desc {
      font-size: .77rem; font-weight: 600; color: var(--ink2);
      line-height: 1.65; flex: 1; margin-bottom: 18px;
    }
    .pcard-foot {
      border-top: 1px solid var(--grey-100); padding-top: 16px;
      display: flex; align-items: center; justify-content: space-between;
    }
    .pcard-price-lbl { font-size: .6rem; font-weight: 700; color: var(--ink3); }
    .pcard-price-val { font-family: var(--fh); font-size: 1.1rem; font-weight: 800; }
    .pcard-cta {
      display: inline-flex; align-items: center; gap: 5px;
      border-radius: var(--r-pill); padding: 7px 16px;
      font-family: var(--fb); font-weight: 800; font-size: .74rem;
      color: var(--white) !important; border: none;
      transition: opacity .13s, transform .12s; text-decoration: none;
    }
    .pcard-cta:hover { opacity: .88; transform: translateY(-1px); }
    .pcard-cta i[data-lucide] { width: 12px; height: 12px; }

    /* ── How it works ── */
    .how-section { padding: 60px 0 64px; background: var(--grey-50); border-bottom: 1px solid var(--grey-200); }

    .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2px; position: relative; }
    .steps-grid::before {
      content: ''; position: absolute;
      top: 20px; left: calc(12.5% + 10px); right: calc(12.5% + 10px);
      height: 1px; background: var(--grey-200);
    }
    @media (max-width: 767px) {
      .steps-grid { grid-template-columns: 1fr 1fr; }
      .steps-grid::before { display: none; }
    }

    .step-item { padding: 0 16px; position: relative; z-index: 1; }
    .step-num-wrap {
      width: 40px; height: 40px; border-radius: 50%;
      background: var(--white); border: 1.5px solid var(--grey-200);
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 14px; box-shadow: var(--sh-xs);
    }
    .step-num { font-family: var(--fh); font-size: .88rem; font-weight: 800; color: var(--pink); }
    .step-title { font-size: .84rem; font-weight: 800; color: var(--ink); margin-bottom: 5px; }
    .step-desc { font-size: .73rem; font-weight: 600; color: var(--ink2); line-height: 1.6; }

    /* ── Features row ── */
    .features-section { padding: 60px 0; background: var(--white); }
    .feat-card {
      background: var(--grey-50);
      border: 1.5px solid var(--grey-200);
      border-radius: var(--r-lg);
      padding: 22px 20px;
      height: 100%;
    }
    .feat-icon {
      width: 38px; height: 38px;
      border-radius: var(--r-sm);
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 13px;
    }
    .feat-icon i[data-lucide] { width: 18px; height: 18px; }
    .feat-title { font-size: .86rem; font-weight: 800; color: var(--ink); margin-bottom: 6px; }
    .feat-desc { font-size: .76rem; font-weight: 600; color: var(--ink2); line-height: 1.6; }

    /* ── Footer ── */
    .idx-footer { background: var(--white); border-top: 1px solid var(--grey-200); padding: 22px 0; }
    .footer-logo { font-family: var(--fh); font-size: 1rem; font-weight: 800; color: var(--ink); }
    .footer-logo b { color: var(--pink); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    .fu   { animation: fadeUp .46s cubic-bezier(.22,1,.36,1) both; }
    .fu-1 { animation-delay: .04s; }
    .fu-2 { animation-delay: .11s; }
    .fu-3 { animation-delay: .18s; }
    .fu-4 { animation-delay: .25s; }
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
          <div class="col-lg-6">
            <div class="hero-eyebrow fu fu-1">
              <i data-lucide="sparkles" style="width:10px;height:10px;"></i>
              Custom Design Studio
            </div>
            <h1 class="hero-title fu fu-2">
              Build your<br><em>perfect piece.</em>
            </h1>
            <p class="hero-sub fu fu-3">
              Design a bracelet, necklace, or keychain from scratch — choose every bead, charm, and color, then place your order in minutes.
            </p>
            <div class="hero-actions fu fu-4">
              <a href="{{ route('builder.bracelet') }}" class="btn-hero-primary">
                <i data-lucide="wand-2" style="width:15px;height:15px;"></i>
                Start Designing
              </a>
              <a href="#products" class="btn-hero-ghost">
                <i data-lucide="layers" style="width:14px;height:14px;"></i>
                Browse Products
              </a>
            </div>
            <div class="bead-strip fu fu-4">
              <div class="bead-s" style="background:#E8257A;"></div>
              <div class="bead-s lg" style="background:#F9B8CF;"></div>
              <div class="bead-s" style="background:#0DBCB4;"></div>
              <div class="bead-s lg" style="background:#7C4DFF;"></div>
              <div class="bead-s" style="background:#FFD700;"></div>
              <div class="bead-s lg" style="background:#3B82F6;"></div>
              <div class="bead-s" style="background:#EF4444;"></div>
              <div class="bead-s lg" style="background:#fff;border-color:var(--grey-200);"></div>
              <div class="bead-s" style="background:#90DDD9;"></div>
            </div>
          </div>
          <div class="col-lg-6 d-none d-lg-block">
            {{-- Right side decorative canvas mockup --}}
            <div style="background:var(--grey-50);border:1.5px solid var(--grey-200);border-radius:var(--r-lg);padding:28px;box-shadow:var(--sh-md);">
              <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--pink);"></div>
                <div style="width:8px;height:8px;border-radius:50%;background:var(--teal);"></div>
                <div style="width:8px;height:8px;border-radius:50%;background:var(--grey-300);"></div>
                <div style="margin-left:auto;font-size:.6rem;font-weight:800;color:var(--ink3);letter-spacing:.08em;text-transform:uppercase;">Bracelet Builder</div>
              </div>
              <div style="background:var(--white);border:1px solid var(--grey-200);border-radius:var(--r-md);height:200px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;">
                <div style="position:absolute;inset:0;background-image:radial-gradient(var(--grey-300) 1px,transparent 1px);background-size:18px 18px;opacity:.3;"></div>
                <div style="display:flex;gap:6px;align-items:center;position:relative;z-index:1;flex-wrap:wrap;justify-content:center;padding:12px;">
                  @foreach(['#E8257A','#F9B8CF','#0DBCB4','#7C4DFF','#FFD700','#E8257A','#3B82F6','#F9B8CF','#0DBCB4','#EF4444','#E8257A','#7C4DFF'] as $c)
                    <div style="width:34px;height:34px;border-radius:50%;background:{{$c}};border:2px solid rgba(255,255,255,.6);box-shadow:0 2px 6px rgba(0,0,0,.12);"></div>
                  @endforeach
                </div>
              </div>
              <div style="display:flex;gap:8px;margin-top:14px;">
                <div style="flex:1;background:var(--pink-lt);border:1.5px solid var(--pink-bd);border-radius:var(--r-sm);padding:8px 12px;text-align:center;">
                  <div style="font-size:.6rem;font-weight:800;color:var(--pink3);letter-spacing:.08em;text-transform:uppercase;">Total</div>
                  <div style="font-family:var(--fh);font-size:.95rem;font-weight:800;color:var(--pink);">₱176</div>
                </div>
                <div style="flex:1;background:var(--teal-lt);border:1.5px solid var(--teal-bd);border-radius:var(--r-sm);padding:8px 12px;text-align:center;">
                  <div style="font-size:.6rem;font-weight:800;color:var(--teal-dk);letter-spacing:.08em;text-transform:uppercase;">Beads</div>
                  <div style="font-family:var(--fh);font-size:.95rem;font-weight:800;color:var(--teal-dk);">12 / 20</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- ══ STATS BAR ══ --}}
    <div class="stats-bar">
      <div class="container">
        <div class="row g-0">
          <div class="col-4 stat-item" style="border-right:1px solid var(--grey-200);">
            <div class="stat-num"><b>3</b></div>
            <div class="stat-lbl">Product Types</div>
          </div>
          <div class="col-4 stat-item" style="border-right:1px solid var(--grey-200);">
            <div class="stat-num"><b>100+</b></div>
            <div class="stat-lbl">Beads & Charms</div>
          </div>
          <div class="col-4 stat-item">
            <div class="stat-num"><b>∞</b></div>
            <div class="stat-lbl">Combinations</div>
          </div>
        </div>
      </div>
    </div>

    {{-- ══ PRODUCTS ══ --}}
    <section class="products-section" id="products">
      <div class="container">
        <div class="sec-eyebrow">Choose a Product</div>
        <div class="sec-title">What are you making today?</div>

        <div class="row g-3">
          {{-- Bracelet --}}
          <div class="col-md-4 fu fu-1">
            <a href="{{ route('builder.bracelet') }}" class="pcard">
              <div class="pcard-accent" style="background:var(--pink);"></div>
              <div class="pcard-inner">
                <div class="pcard-icon-row">
                  <div class="pcard-icon" style="border-color:var(--pink-bd);background:var(--pink-lt);">
                    <i data-lucide="circle" style="color:var(--pink);"></i>
                  </div>
                  <span class="pcard-tag" style="color:var(--pink-dk);background:var(--pink-lt);border-color:var(--pink-bd);">Wrist</span>
                </div>
                <div class="pcard-name">Bracelet</div>
                <p class="pcard-desc">Beaded bracelet with your choice of string, clasp, and up to 20 beads — mix charms, figures, and letters.</p>
                <div class="pcard-foot">
                  <div>
                    <div class="pcard-price-lbl">Starts at</div>
                    <div class="pcard-price-val" style="color:var(--pink);">₱80</div>
                  </div>
                  <span class="pcard-cta" style="background:var(--pink);">
                    Design <i data-lucide="arrow-right"></i>
                  </span>
                </div>
              </div>
            </a>
          </div>

          {{-- Necklace --}}
          <div class="col-md-4 fu fu-2">
            <a href="{{ route('builder.necklace') }}" class="pcard">
              <div class="pcard-accent" style="background:var(--purple);"></div>
              <div class="pcard-inner">
                <div class="pcard-icon-row">
                  <div class="pcard-icon" style="border-color:var(--purple-bd);background:var(--purple-lt);">
                    <i data-lucide="gem" style="color:var(--purple);"></i>
                  </div>
                  <span class="pcard-tag" style="color:var(--purple-dk);background:var(--purple-lt);border-color:var(--purple-bd);">Neck</span>
                </div>
                <div class="pcard-name">Necklace</div>
                <p class="pcard-desc">From choker to matinee — up to 28 beads, charms, and letter tiles on your choice of chain or cord.</p>
                <div class="pcard-foot">
                  <div>
                    <div class="pcard-price-lbl">Starts at</div>
                    <div class="pcard-price-val" style="color:var(--purple);">₱100</div>
                  </div>
                  <span class="pcard-cta" style="background:var(--purple);">
                    Design <i data-lucide="arrow-right"></i>
                  </span>
                </div>
              </div>
            </a>
          </div>

          {{-- Keychain --}}
          <div class="col-md-4 fu fu-3">
            <a href="{{ route('builder.keychain') }}" class="pcard">
              <div class="pcard-accent" style="background:var(--teal);"></div>
              <div class="pcard-inner">
                <div class="pcard-icon-row">
                  <div class="pcard-icon" style="border-color:var(--teal-bd);background:var(--teal-lt);">
                    <i data-lucide="key" style="color:var(--teal-dk);"></i>
                  </div>
                  <span class="pcard-tag" style="color:var(--teal-dk);background:var(--teal-lt);border-color:var(--teal-bd);">Bag / Key</span>
                </div>
                <div class="pcard-name">Keychain / Charm</div>
                <p class="pcard-desc">Beaded keychain or bag charm with 1–3 strands. Mix charms, letters, and beads for a unique look.</p>
                <div class="pcard-foot">
                  <div>
                    <div class="pcard-price-lbl">Starts at</div>
                    <div class="pcard-price-val" style="color:var(--teal-dk);">₱65</div>
                  </div>
                  <span class="pcard-cta" style="background:var(--teal-dk);">
                    Design <i data-lucide="arrow-right"></i>
                  </span>
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
        <div class="sec-eyebrow">The Process</div>
        <div class="sec-title">How it works</div>
        <div class="steps-grid">
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">1</span></div>
            <div class="step-title">Pick a product</div>
            <p class="step-desc">Choose bracelet, necklace, or keychain as your starting point.</p>
          </div>
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">2</span></div>
            <div class="step-title">Configure it</div>
            <p class="step-desc">Set string color, type, length, and product-specific options.</p>
          </div>
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">3</span></div>
            <div class="step-title">Add elements</div>
            <p class="step-desc">Browse beads, charms, and letters from the library.</p>
          </div>
          <div class="step-item">
            <div class="step-num-wrap"><span class="step-num">4</span></div>
            <div class="step-title">Place your order</div>
            <p class="step-desc">Fill in your details and get a unique code to track your order.</p>
          </div>
        </div>
      </div>
    </section>

    {{-- ══ FEATURES ══ --}}
    <section class="features-section">
      <div class="container">
        <div class="sec-eyebrow">Why ArtsyCrate</div>
        <div class="sec-title">Everything you need to create</div>
        <div class="row g-3">
          <div class="col-md-3 col-6">
            <div class="feat-card">
              <div class="feat-icon" style="background:var(--pink-lt);"><i data-lucide="palette" style="color:var(--pink);"></i></div>
              <div class="feat-title">Live Preview</div>
              <p class="feat-desc">See your design update instantly as you add or move elements.</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="feat-card">
              <div class="feat-icon" style="background:var(--teal-lt);"><i data-lucide="package" style="color:var(--teal-dk);"></i></div>
              <div class="feat-title">Order Tracking</div>
              <p class="feat-desc">Follow your order from submission to completion with a unique code.</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="feat-card">
              <div class="feat-icon" style="background:var(--purple-lt);"><i data-lucide="refresh-cw" style="color:var(--purple);"></i></div>
              <div class="feat-title">Design Revisions</div>
              <p class="feat-desc">Request changes or redesign after seeing your mockup.</p>
            </div>
          </div>
          <div class="col-md-3 col-6">
            <div class="feat-card">
              <div class="feat-icon" style="background:var(--pink-lt);"><i data-lucide="bookmark" style="color:var(--pink);"></i></div>
              <div class="feat-title">Save Designs</div>
              <p class="feat-desc">Create an account to save and reload your designs anytime.</p>
            </div>
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
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>