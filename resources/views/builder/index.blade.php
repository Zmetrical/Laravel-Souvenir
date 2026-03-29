{{--
  ArtsyCrate — Builder Index (AdminLTE Integrated & Main CSS Themed)
--}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Design Studio</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}">

</head>
<body class="layout-top-nav">
<div class="wrapper">

  {{-- ══ NAVBAR (AdminLTE Top Nav) ══ --}}
  <nav class="main-header navbar navbar-expand-md navbar-light bg-white border-bottom">
    <div class="container">
      <a href="/" class="navbar-brand">
        <div class="brand-text font-weight-bold" style="font-size: 1.4rem;">
          Artsy<span style="color: var(--pink);">Crate</span>
        </div>
      </a>
      <div class="ml-auto d-flex align-items-center">
        <a href="#products" class="btn btn-ghost btn-sm px-3 mr-2">Browse</a>
        <a href="{{ route('builder.bracelet') }}" class="btn btn-pink btn-sm px-3">Start Designing</a>
      </div>
    </div>
  </nav>

  <div class="content-wrapper bg-white">
    
    {{-- ══ HERO ══ --}}
    <section class="content pt-5 pb-5 border-bottom">
      <div class="container py-4">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <span class="badge bg-pink-light px-3 py-2 rounded-pill mb-3" style="font-size: 0.75rem; letter-spacing: 0.1em; text-transform: uppercase;">
              <i data-lucide="sparkles" class="mr-1" style="width:12px;"></i> Custom Design Studio
            </span>
            <h1 class="display-4" style="line-height: 1.1; color: var(--ink);">
              Build your<br><span class="text-pink">perfect piece.</span>
            </h1>
            <p class="lead font-weight-bold text-muted my-4" style="font-size: 1rem; max-width: 440px;">
              Design a bracelet, necklace, or keychain from scratch — choose every bead, charm, and color, then place your order in minutes.
            </p>
            <div>
              <a href="{{ route('builder.bracelet') }}" class="btn btn-pink px-4 py-2 mr-2">
                <i data-lucide="wand-2" class="mr-1" style="width:16px;"></i> Start Designing
              </a>
              <a href="#products" class="btn btn-ghost px-4 py-2">
                Browse Products
              </a>
            </div>
          </div>
          <div class="col-lg-6 d-none d-lg-block text-center">
             <img src="https://via.placeholder.com/500x350/FAFBFC/1AC8C4?text=ArtsyCrate+Builder+Preview" alt="Builder Preview" class="img-fluid rounded" style="border: 2px solid #E2DFE9; border-radius: 20px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
          </div>
        </div>
      </div>
    </section>

    {{-- ══ STATS BAR (Bootstrap Grid) ══ --}}
    <div class="bg-light border-bottom py-3">
      <div class="container">
        <div class="row text-center font-weight-bold">
          <div class="col-4 border-right"><h3 class="mb-0 text-ink">3</h3><small class="text-muted text-uppercase">Product Types</small></div>
          <div class="col-4 border-right"><h3 class="mb-0 text-pink">100+</h3><small class="text-muted text-uppercase">Beads & Charms</small></div>
          <div class="col-4"><h3 class="mb-0 text-teal">∞</h3><small class="text-muted text-uppercase">Combinations</small></div>
        </div>
      </div>
    </div>

    {{-- ══ PRODUCTS (AdminLTE Cards) ══ --}}
    <section class="content py-5 bg-white border-bottom" id="products">
      <div class="container">
        <div class="text-center mb-5">
          <span class="text-muted font-weight-bold text-uppercase" style="letter-spacing: 0.1em; font-size: 0.8rem;">Choose a Product</span>
          <h2>What are you making today?</h2>
        </div>

        <div class="row">
          {{-- Bracelet --}}
          <div class="col-md-4 mb-4">
            <a href="{{ route('builder.bracelet') }}" class="text-decoration-none text-dark">
              <div class="card card-outline card-pink product-card h-100 elevation-0">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-pink-light rounded p-2"><i data-lucide="circle" class="text-pink"></i></div>
                    <span class="badge bg-pink-light border border-pink text-uppercase">Wrist</span>
                  </div>
                  <h4 class="font-weight-bold">Bracelet</h4>
                  <p class="text-muted font-weight-bold" style="font-size: 0.85rem; flex: 1;">Beaded bracelet with your choice of string, clasp, and up to 20 beads — mix charms, figures, and letters.</p>
                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <div><small class="text-muted font-weight-bold">Starts at</small><br><strong class="text-pink text-lg">₱80</strong></div>
                    <span class="btn btn-pink btn-sm rounded-pill px-3 font-weight-bold">Design <i data-lucide="arrow-right" style="width:14px;"></i></span>
                  </div>
                </div>
              </div>
            </a>
          </div>

          {{-- Necklace --}}
          <div class="col-md-4 mb-4">
            <a href="{{ route('builder.necklace') }}" class="text-decoration-none text-dark">
              <div class="card card-outline card-purple product-card h-100 elevation-0">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-purple-light rounded p-2"><i data-lucide="gem" class="text-purple"></i></div>
                    <span class="badge bg-purple-light border text-uppercase" style="border-color: var(--purple) !important;">Neck</span>
                  </div>
                  <h4 class="font-weight-bold">Necklace</h4>
                  <p class="text-muted font-weight-bold" style="font-size: 0.85rem; flex: 1;">From choker to matinee — up to 28 beads, charms, and letter tiles on your choice of chain or cord.</p>
                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <div><small class="text-muted font-weight-bold">Starts at</small><br><strong class="text-purple text-lg">₱100</strong></div>
                    <span class="btn btn-sm rounded-pill px-3 font-weight-bold text-white" style="background-color: var(--purple);">Design <i data-lucide="arrow-right" style="width:14px;"></i></span>
                  </div>
                </div>
              </div>
            </a>
          </div>

          {{-- Keychain --}}
          <div class="col-md-4 mb-4">
            <a href="{{ route('builder.keychain') }}" class="text-decoration-none text-dark">
              <div class="card card-outline card-info product-card card-teal h-100 elevation-0">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-teal-light rounded p-2"><i data-lucide="key" class="text-teal"></i></div>
                    <span class="badge bg-teal-light border text-uppercase" style="border-color: var(--teal) !important;">Bag / Key</span>
                  </div>
                  <h4 class="font-weight-bold">Keychain</h4>
                  <p class="text-muted font-weight-bold" style="font-size: 0.85rem; flex: 1;">Beaded keychain or bag charm with 1–3 strands. Mix charms, letters, and beads for a unique look.</p>
                  <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                    <div><small class="text-muted font-weight-bold">Starts at</small><br><strong class="text-teal text-lg">₱65</strong></div>
                    <span class="btn btn-sm rounded-pill px-3 font-weight-bold text-white" style="background-color: var(--teal);">Design <i data-lucide="arrow-right" style="width:14px;"></i></span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    {{-- ══ HOW IT WORKS ══ --}}
    <section class="content py-5" style="background-color: var(--offwhite);">
      <div class="container">
        <div class="text-center mb-5">
          <span class="text-pink font-weight-bold text-uppercase" style="letter-spacing: 0.1em; font-size: 0.8rem;">The Process</span>
          <h2>How it works</h2>
        </div>
        <div class="row text-center position-relative">
          <div class="col-md-3 mb-4">
            <div class="step-circle mx-auto mb-3 text-pink">1</div>
            <h5 class="font-weight-bold">Pick a product</h5>
            <p class="text-muted font-weight-bold" style="font-size: 0.85rem;">Choose bracelet, necklace, or keychain.</p>
          </div>
          <div class="col-md-3 mb-4">
            <div class="step-circle mx-auto mb-3 text-purple">2</div>
            <h5 class="font-weight-bold">Configure it</h5>
            <p class="text-muted font-weight-bold" style="font-size: 0.85rem;">Set string color, type, and length.</p>
          </div>
          <div class="col-md-3 mb-4">
            <div class="step-circle mx-auto mb-3 text-teal">3</div>
            <h5 class="font-weight-bold">Add elements</h5>
            <p class="text-muted font-weight-bold" style="font-size: 0.85rem;">Browse beads, charms, and letters.</p>
          </div>
          <div class="col-md-3 mb-4">
            <div class="step-circle mx-auto mb-3 text-lime">4</div>
            <h5 class="font-weight-bold">Place order</h5>
            <p class="text-muted font-weight-bold" style="font-size: 0.85rem;">Get a unique code to track your order.</p>
          </div>
        </div>
      </div>
    </section>

    {{-- ══ FEATURES (AdminLTE Info Boxes) ══ --}}
    <section class="content py-5 bg-white border-top border-bottom">
      <div class="container">
        <div class="text-center mb-5">
          <span class="text-muted font-weight-bold text-uppercase" style="letter-spacing: 0.1em; font-size: 0.8rem;">Why ArtsyCrate</span>
          <h2>Everything you need to create</h2>
        </div>
        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm border" style="border-radius: 16px;">
              <span class="info-box-icon bg-pink-light rounded" style="width: 50px;"><i data-lucide="palette" class="text-pink"></i></span>
              <div class="info-box-content">
                <span class="info-box-text font-weight-bold text-dark">Live Preview</span>
                <span class="text-muted font-weight-bold" style="font-size: 0.75rem; white-space: normal;">See your design update instantly.</span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm border" style="border-radius: 16px;">
              <span class="info-box-icon bg-teal-light rounded" style="width: 50px;"><i data-lucide="package" class="text-teal"></i></span>
              <div class="info-box-content">
                <span class="info-box-text font-weight-bold text-dark">Order Tracking</span>
                <span class="text-muted font-weight-bold" style="font-size: 0.75rem; white-space: normal;">Follow your order with a unique code.</span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm border" style="border-radius: 16px;">
              <span class="info-box-icon bg-purple-light rounded" style="width: 50px;"><i data-lucide="refresh-cw" class="text-purple"></i></span>
              <div class="info-box-content">
                <span class="info-box-text font-weight-bold text-dark">Revisions</span>
                <span class="text-muted font-weight-bold" style="font-size: 0.75rem; white-space: normal;">Request changes after your mockup.</span>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm border" style="border-radius: 16px;">
              <span class="info-box-icon bg-pink-light rounded" style="width: 50px;"><i data-lucide="bookmark" class="text-pink"></i></span>
              <div class="info-box-content">
                <span class="info-box-text font-weight-bold text-dark">Save Designs</span>
                <span class="text-muted font-weight-bold" style="font-size: 0.75rem; white-space: normal;">Save and reload your designs anytime.</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>

  {{-- ══ FOOTER ══ --}}
  <footer class="main-footer border-top text-sm font-weight-bold" style="background-color: var(--offwhite);">
    <div class="container d-flex justify-content-between align-items-center">
      <div class="brand-text text-dark" style="font-size: 1.1rem;">Artsy<span style="color: var(--pink);">Crate</span></div>
      <div class="text-muted">
        © {{ date('Y') }} ArtsyCrate · Made with <span class="text-pink">♥</span>
      </div>
    </div>
  </footer>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>