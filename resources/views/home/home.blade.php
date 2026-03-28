@php
    $title       = 'ArtsyCrate — Prints, Customs & Creative Fun';
    $description = 'Your one-stop creative shop for personalized gifts, custom prints, bag charms, keychains, and 3D printed wonders. Walk in. Create. Smile.';
    $active      = 'home';
@endphp

@extends('layout.app')

{{-- ═══════════════════════════════════════
     SECTION: CONTENT
═══════════════════════════════════════ --}}
@section('content')


{{-- ═══════════════════════════════════════
     HERO SLIDER
═══════════════════════════════════════ --}}
<div class="ac-slider" id="acSlider">

  {{-- Slide 0 — Custom Prints · TEAL --}}
  <div class="ac-slide s0 is-active" data-slide="0">
    <div class="sl-bg" data-depth="bg">
      <div class="sl-bg-color"></div>
      <div class="doodle-layer">
        <div class="dk" style="top:8%;left:5%;transform:rotate(-15deg)"><i data-lucide="printer" style="width:64px;height:64px;"></i></div>
        <div class="dk" style="top:15%;right:8%;transform:rotate(20deg)"><i data-lucide="image" style="width:80px;height:80px;"></i></div>
        <div class="dk" style="bottom:12%;left:12%;transform:rotate(10deg)"><i data-lucide="star" style="width:48px;height:48px;"></i></div>
        <div class="dk" style="top:55%;right:3%;transform:rotate(-8deg)"><i data-lucide="layers" style="width:60px;height:60px;"></i></div>
        <div class="dk" style="bottom:20%;right:22%;transform:rotate(30deg)"><i data-lucide="sparkles" style="width:40px;height:40px;"></i></div>
        <div class="dk" style="top:30%;left:2%;transform:rotate(5deg)"><i data-lucide="tag" style="width:50px;height:50px;"></i></div>
        <div class="dk" style="bottom:5%;right:8%;transform:rotate(-20deg)"><i data-lucide="scissors" style="width:56px;height:56px;"></i></div>
      </div>
    </div>
    <div class="sl-fg">
      <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
          <div class="col-lg-6">
            <div data-enter="left" data-delay="0" class="sl-tag">
              <i data-lucide="printer" style="width:12px;height:12px;"></i> Custom Prints
            </div>
            <h1 class="sl-headline" data-enter="left" data-delay="80">Stickers, Posters,<br/>Labels &amp; More!</h1>
            <p class="sl-body" data-enter="up" data-delay="180">Print anything you can imagine — from cute stickers to full-size posters. Perfect for gifts, events, branding, or just because.</p>
            <div data-enter="up" data-delay="280">
              <a href="#shop" class="btn-sl-a"><i data-lucide="shopping-bag" style="width:15px;height:15px;"></i> Shop Prints</a>
              <a href="#" class="btn-sl-b"><i data-lucide="arrow-right" style="width:15px;height:15px;"></i> See Catalog</a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="sl-visual">
              <div class="vis-shape" style="width:220px;height:220px;background:rgba(255,255,255,.1);top:10px;right:30px;animation:acFloat 6s ease-in-out infinite;" data-enter="scale" data-delay="100"></div>
              <div class="vis-float" data-enter="right" data-delay="160">
                <div class="vf-icon"><i data-lucide="image"></i></div>
                <div class="vf-name">Custom Prints</div>
                <div class="vf-chips">
                  <span class="vfc">Stickers</span><span class="vfc">Posters</span><span class="vfc">Labels</span><span class="vfc">Tarpaulin</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Slide 1 — Gifts · PINK --}}
  <div class="ac-slide s1" data-slide="1">
    <div class="sl-bg" data-depth="bg">
      <div class="sl-bg-color"></div>
      <div class="doodle-layer">
        <div class="dk" style="top:6%;left:8%;transform:rotate(12deg)"><i data-lucide="gift" style="width:72px;height:72px;"></i></div>
        <div class="dk" style="top:20%;right:5%;transform:rotate(-18deg)"><i data-lucide="heart" style="width:90px;height:90px;"></i></div>
        <div class="dk" style="bottom:10%;left:4%;transform:rotate(-8deg)"><i data-lucide="sparkles" style="width:54px;height:54px;"></i></div>
        <div class="dk" style="top:50%;right:2%;transform:rotate(15deg)"><i data-lucide="package" style="width:64px;height:64px;"></i></div>
        <div class="dk" style="bottom:18%;right:18%;transform:rotate(-25deg)"><i data-lucide="star" style="width:44px;height:44px;"></i></div>
        <div class="dk" style="top:70%;left:3%"><i data-lucide="smile" style="width:48px;height:48px;"></i></div>
      </div>
    </div>
    <div class="sl-fg">
      <div class="container">
        <div class="row align-items-center g-4 g-lg-5 flex-lg-row-reverse">
          <div class="col-lg-6">
            <div data-enter="right" data-delay="0" class="sl-tag">
              <i data-lucide="gift" style="width:12px;height:12px;"></i> Gifts &amp; Souvenirs
            </div>
            <h1 class="sl-headline" data-enter="right" data-delay="80">Gifts They Will<br/>Never Forget 🎀</h1>
            <p class="sl-body" data-enter="up" data-delay="180">Personalized tokens, pasalubong sets, and souvenirs for every occasion — birthdays, graduation, despedida, or just to make someone smile.</p>
            <div data-enter="up" data-delay="280">
              <a href="#gifts" class="btn-sl-a"><i data-lucide="gift" style="width:15px;height:15px;"></i> Browse Gifts</a>
              <a href="#customize" class="btn-sl-b"><i data-lucide="sparkles" style="width:15px;height:15px;"></i> Customize</a>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="sl-visual">
              <div class="vis-float" data-enter="left" data-delay="160">
                <div class="vf-icon"><i data-lucide="gift"></i></div>
                <div class="vf-name">Gift Sets</div>
                <div class="vf-chips">
                  <span class="vfc">Birthday</span><span class="vfc">Pasalubong</span><span class="vfc">Graduation</span><span class="vfc">Events</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Slide 2 — DIY Charms · LIME --}}
  <div class="ac-slide s2" data-slide="2">
    <div class="sl-bg" data-depth="bg">
      <div class="sl-bg-color"></div>
      <div class="doodle-layer">
        <div class="dk" style="top:5%;left:3%;transform:rotate(-10deg)"><i data-lucide="scissors" style="width:68px;height:68px;"></i></div>
        <div class="dk" style="top:12%;right:6%;transform:rotate(22deg)"><i data-lucide="key" style="width:80px;height:80px;"></i></div>
        <div class="dk" style="bottom:8%;left:8%;transform:rotate(8deg)"><i data-lucide="palette" style="width:58px;height:58px;"></i></div>
        <div class="dk" style="top:60%;right:4%;transform:rotate(-15deg)"><i data-lucide="heart" style="width:54px;height:54px;"></i></div>
        <div class="dk" style="bottom:22%;right:14%;transform:rotate(28deg)"><i data-lucide="star" style="width:46px;height:46px;"></i></div>
        <div class="dk" style="bottom:6%;right:5%"><i data-lucide="gem" style="width:60px;height:60px;"></i></div>
      </div>
    </div>
    <div class="sl-fg">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-7">
            <div data-enter="scale" data-delay="0" class="sl-tag" style="margin-inline:auto;display:inline-flex;">
              <i data-lucide="scissors" style="width:12px;height:12px;"></i> DIY In-Store
            </div>
            <h1 class="sl-headline" data-enter="up" data-delay="60" style="font-size:clamp(2.6rem,7vw,5.5rem);">Make Your Own<br/>Charm In-Store!</h1>
            <p class="sl-body" data-enter="up" data-delay="160" style="margin-inline:auto;text-align:center;">Walk in, pick your materials, shapes, and colors. Our in-store workshop is open for everyone — no experience needed!</p>
            <div data-enter="up" data-delay="250" style="display:flex;justify-content:center;flex-wrap:wrap;gap:10px;margin-bottom:18px;">
              <span style="background:rgba(0,0,0,.1);color:var(--ink);font-weight:800;font-size:.78rem;padding:5px 16px;border-radius:var(--pill);">Bag Charms</span>
              <span style="background:rgba(0,0,0,.1);color:var(--ink);font-weight:800;font-size:.78rem;padding:5px 16px;border-radius:var(--pill);">Keychains</span>
              <span style="background:rgba(0,0,0,.1);color:var(--ink);font-weight:800;font-size:.78rem;padding:5px 16px;border-radius:var(--pill);">Resin Craft</span>
              <span style="background:rgba(0,0,0,.1);color:var(--ink);font-weight:800;font-size:.78rem;padding:5px 16px;border-radius:var(--pill);">Pins</span>
            </div>
            <div data-enter="up" data-delay="330">
              <a href="#about" class="btn-sl-a"><i data-lucide="map-pin" style="width:15px;height:15px;"></i> Visit the Store</a>
              <a href="#" class="btn-sl-b"><i data-lucide="play-circle" style="width:15px;height:15px;"></i> Watch a Demo</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Slide 3 — Business · DARK PURPLE --}}
  <div class="ac-slide s3" data-slide="3">
    <div class="sl-bg" data-depth="bg">
      <div class="sl-bg-color"></div>
      <div class="doodle-layer">
        <div class="dk" style="top:8%;left:4%;transform:rotate(-12deg)"><i data-lucide="briefcase" style="width:70px;height:70px;"></i></div>
        <div class="dk" style="top:14%;right:6%;transform:rotate(18deg)"><i data-lucide="layers" style="width:84px;height:84px;"></i></div>
        <div class="dk" style="bottom:10%;left:6%;transform:rotate(6deg)"><i data-lucide="send" style="width:56px;height:56px;"></i></div>
        <div class="dk" style="top:55%;right:3%;transform:rotate(-10deg)"><i data-lucide="award" style="width:62px;height:62px;"></i></div>
        <div class="dk" style="bottom:20%;right:16%;transform:rotate(24deg)"><i data-lucide="trending-up" style="width:48px;height:48px;"></i></div>
        <div class="dk" style="top:38%;left:2%;transform:rotate(4deg)"><i data-lucide="star" style="width:52px;height:52px;"></i></div>
        <div class="dk" style="bottom:5%;right:6%"><i data-lucide="zap" style="width:58px;height:58px;"></i></div>
      </div>
    </div>
    <div class="sl-fg">
      <div class="container">
        <div class="row align-items-center g-4 g-lg-5">
          <div class="col-lg-5">
            <div data-enter="down" data-delay="0" class="sl-tag">
              <i data-lucide="briefcase" style="width:12px;height:12px;"></i> For Business
            </div>
            <h1 class="sl-headline" data-enter="left" data-delay="70">Level Up<br/>Your <span class="ac">Brand</span> 💼</h1>
            <p class="sl-body" data-enter="up" data-delay="170">Custom merch, branded prints, and promo items. Bulk orders, corporate gifts, event giveaways — we've got everything your business needs.</p>
            <div data-enter="up" data-delay="260">
              <a href="#" class="btn-sl-a" style="color:var(--purple-dk);"><i data-lucide="send" style="width:15px;height:15px;"></i> Get a Quote</a>
              <a href="#" class="btn-sl-b"><i data-lucide="layers" style="width:15px;height:15px;"></i> Our Portfolio</a>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="sl-visual">
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;position:relative;z-index:2;" data-enter="right" data-delay="120">
                <div style="background:rgba(255,255,255,.1);backdrop-filter:blur(12px);border:1.5px solid rgba(255,255,255,.18);border-radius:20px;padding:22px 20px;grid-column:span 2;animation:acFloat 4.5s ease-in-out infinite;">
                  <div style="font-family:var(--fh);font-size:2.2rem;color:var(--yellow);margin-bottom:4px;">500+</div>
                  <div style="font-weight:800;font-size:.85rem;color:rgba(255,255,255,.8);">Happy Business Clients</div>
                </div>
                <div style="background:rgba(255,255,255,.1);backdrop-filter:blur(12px);border:1.5px solid rgba(255,255,255,.18);border-radius:20px;padding:20px;animation:acFloat 4s ease-in-out infinite;animation-delay:-1.5s;">
                  <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                    <div style="width:36px;height:36px;background:rgba(255,211,61,.2);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                      <i data-lucide="package" style="width:18px;height:18px;color:var(--yellow);"></i>
                    </div>
                  </div>
                  <div style="font-weight:900;font-size:.82rem;color:#fff;">Bulk Orders</div>
                  <div style="font-size:.74rem;color:rgba(255,255,255,.55);margin-top:3px;">Min. 10 pcs</div>
                </div>
                <div style="background:rgba(255,255,255,.1);backdrop-filter:blur(12px);border:1.5px solid rgba(255,255,255,.18);border-radius:20px;padding:20px;animation:acFloat 4.2s ease-in-out infinite;animation-delay:-2.8s;">
                  <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                    <div style="width:36px;height:36px;background:rgba(26,200,196,.25);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                      <i data-lucide="zap" style="width:18px;height:18px;color:var(--teal);"></i>
                    </div>
                  </div>
                  <div style="font-weight:900;font-size:.82rem;color:#fff;">Fast Turnaround</div>
                  <div style="font-size:.74rem;color:rgba(255,255,255,.55);margin-top:3px;">3–5 business days</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <button class="sl-arrow sl-arrow-prev" id="slPrev" aria-label="Previous"><i data-lucide="chevron-left" style="width:20px;height:20px;"></i></button>
  <button class="sl-arrow sl-arrow-next" id="slNext" aria-label="Next"><i data-lucide="chevron-right" style="width:20px;height:20px;"></i></button>
  <div class="sl-dots" id="slDots">
    <button class="sl-dot active" data-idx="0" aria-label="Slide 1"></button>
    <button class="sl-dot" data-idx="1" aria-label="Slide 2"></button>
    <button class="sl-dot" data-idx="2" aria-label="Slide 3"></button>
    <button class="sl-dot" data-idx="3" aria-label="Slide 4"></button>
  </div>
  <div class="sl-counter" id="slCounter"><span class="cur" id="slCur">01</span> / 04</div>
</div>
{{-- / #acSlider --}}

{{-- ═══════════════════════════════════════
     SERVICES STRIP
═══════════════════════════════════════ --}}
<section class="svc-strip" id="shop">
  <div class="container">
    <div class="svc-grid">
      <div class="svc-cell">
        <div class="svc-icon-wrap" style="background:var(--teal-bg);">
          <i data-lucide="printer" style="color:var(--teal-dk);width:22px;height:22px;"></i>
        </div>
        <span>Custom Prints</span>
      </div>
      <div class="svc-cell">
        <div class="svc-icon-wrap" style="background:var(--pink-bg);">
          <i data-lucide="key" style="color:var(--pink-dk);width:22px;height:22px;"></i>
        </div>
        <span>Charms &amp; Keychains</span>
      </div>
      <div class="svc-cell">
        <div class="svc-icon-wrap" style="background:#FFF5E0;">
          <i data-lucide="coffee" style="color:var(--orange);width:22px;height:22px;"></i>
        </div>
        <span>Tumblers &amp; Mugs</span>
      </div>
      <div class="svc-cell">
        <div class="svc-icon-wrap" style="background:#F0EEFF;">
          <i data-lucide="box" style="color:var(--purple);width:22px;height:22px;"></i>
        </div>
        <span>3D Printing</span>
      </div>
      <div class="svc-cell">
        <div class="svc-icon-wrap" style="background:var(--lime-bg);">
          <i data-lucide="gift" style="color:var(--lime-dk);width:22px;height:22px;"></i>
        </div>
        <span>Gift Sets</span>
      </div>
    </div>
  </div>
</section>

{{-- ═══════════════════════════════════════
     GET PERSONALIZED
═══════════════════════════════════════ --}}
<section id="customize">

  {{-- Intro heading --}}
  <div class="pers-intro">
    <div class="container">
      <div class="row justify-content-center text-center">
        <div class="col-lg-6 fade-up">
          <div class="eye-row justify-content-center">
            <span class="eye-bar"></span> Get Personalized <span class="eye-bar"></span>
          </div>
          <h2 class="sec-h">Make It <span class="tc">Yours</span>,<br/>Make It <span class="pc">Special</span></h2>
          <p class="sec-p mx-auto text-center" style="max-width:400px;">Choose your medium, pick your style. Everything at ArtsyCrate can be customized — for yourself or for someone you love.</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Row 01 — Tumblers & Mugs --}}
  <div class="pers-row">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6 fade-left">
          <div class="row-num">01</div>
          <div class="row-lbl rl-t"><i data-lucide="coffee" style="width:12px;height:12px;"></i> Drinkware</div>
          <h3 class="row-h">Tumblers &amp;<br/>Custom Mugs</h3>
          <p class="row-p">Your favorite drink deserves a vessel as unique as you are. We personalize tumblers, mugs, and bottles with names, photos, or any design you want.</p>
          <div class="row-chips">
            <span class="rchip rc-t">Name Prints</span>
            <span class="rchip rc-t">Photo Wrap</span>
            <span class="rchip rc-t">Sublimation</span>
            <span class="rchip rc-t">Glitter Finish</span>
          </div>
          <a href="#" class="btn-r br-t"><i data-lucide="arrow-right" style="width:15px;height:15px;"></i> Customize Now</a>
        </div>
        <div class="col-lg-6 fade-right">
          <div class="row-vis">
            <div class="vis-bg-circle vbc-t">
              <i data-lucide="coffee" class="bg-icon"></i>
            </div>
            <div class="mc" style="top:-14px;right:-20px;"><div class="mc-i mi-t"><i data-lucide="droplets"></i></div>Sublimation Print</div>
            <div class="mc" style="bottom:8px;left:-36px;"><div class="mc-i mi-k"><i data-lucide="sparkles"></i></div>Glitter Finish</div>
            <div class="mc" style="top:80px;right:-56px;font-size:.7rem;"><div class="mc-i mi-t"><i data-lucide="type"></i></div>Name Engraving</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Row 02 — Bag Charms --}}
  <div class="pers-row alt" id="gifts">
    <div class="container">
      <div class="row align-items-center g-5 flex-lg-row-reverse">
        <div class="col-lg-6 fade-right">
          <div class="row-num">02</div>
          <div class="row-lbl rl-l"><i data-lucide="scissors" style="width:12px;height:12px;"></i> DIY In-Store</div>
          <h3 class="row-h">Bag Charms &amp;<br/>Keychains</h3>
          <p class="row-p">Walk in and create something just for you. Pick your shapes, colors, and materials — our in-store workshop has everything you need to get crafty.</p>
          <div class="row-chips">
            <span class="rchip rc-l">Bag Charms</span>
            <span class="rchip rc-l">Acrylic Keychains</span>
            <span class="rchip rc-l">Resin Craft</span>
            <span class="rchip rc-l">Pins &amp; Badges</span>
          </div>
          <a href="{{ route('builder.keychain') }}" class="btn-r br-l">
            <i data-lucide="scissors" style="width:15px;height:15px;"></i> Design Online
          </a>
        </div>
        <div class="col-lg-6 fade-left">
          <div class="row-vis">
            <div class="vis-bg-circle vbc-l">
              <i data-lucide="scissors" class="bg-icon"></i>
            </div>
            <div class="mc" style="top:-14px;left:-20px;"><div class="mc-i mi-l"><i data-lucide="scissors"></i></div>DIY Workshop</div>
            <div class="mc" style="bottom:8px;right:-36px;"><div class="mc-i mi-l"><i data-lucide="palette"></i></div>Custom Colors</div>
            <div class="mc" style="top:80px;left:-56px;font-size:.7rem;"><div class="mc-i mi-k"><i data-lucide="heart"></i></div>All Skill Levels</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Row 03 — 3D Printing --}}
  <div class="pers-row" id="business">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6 fade-left">
          <div class="row-num">03</div>
          <div class="row-lbl rl-p"><i data-lucide="box" style="width:12px;height:12px;"></i> 3D Printing</div>
          <h3 class="row-h">3D Printed<br/>Customs</h3>
          <p class="row-p">Bring any idea into the real world. Figurines, logo objects, custom name stands, miniature models — if you can imagine it, we can print it in any color.</p>
          <div class="row-chips">
            <span class="rchip rc-p">Figurines</span>
            <span class="rchip rc-p">Logo Objects</span>
            <span class="rchip rc-p">Name Stands</span>
            <span class="rchip rc-p">Mini Models</span>
          </div>
          <a href="#" class="btn-r br-p"><i data-lucide="arrow-right" style="width:15px;height:15px;"></i> Request a Print</a>
        </div>
        <div class="col-lg-6 fade-right">
          <div class="row-vis">
            <div class="vis-bg-circle vbc-p">
              <i data-lucide="box" class="bg-icon"></i>
            </div>
            <div class="mc" style="top:-14px;right:-20px;"><div class="mc-i mi-p"><i data-lucide="layers"></i></div>Any Color</div>
            <div class="mc" style="bottom:8px;left:-36px;"><div class="mc-i mi-p"><i data-lucide="cpu"></i></div>FDM Printing</div>
            <div class="mc" style="top:80px;right:-56px;font-size:.7rem;"><div class="mc-i mi-t"><i data-lucide="zap"></i></div>Quick Turnaround</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>
{{-- / #customize --}}

@endsection
{{-- / @section('content') --}}


{{-- ═══════════════════════════════════════
     PUSH: SLIDER JAVASCRIPT
     Injected into @stack('scripts') in layout
═══════════════════════════════════════ --}}
@push('scripts')
<script>
(function () {
    /* ── Navbar shadow on scroll ── */
    const nav = document.getElementById('mainNav');
    if (nav) {
        window.addEventListener('scroll', () => {
            nav.classList.toggle('scrolled', window.scrollY > 30);
        }, { passive: true });
    }

    /* ── Scroll-reveal (shared with layout, but safe to double-call) ── */
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) { e.target.classList.add('vis'); io.unobserve(e.target); }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up, .fade-left, .fade-right').forEach(el => io.observe(el));
    } else {
        document.querySelectorAll('.fade-up, .fade-left, .fade-right').forEach(el => el.classList.add('vis'));
    }

    /* ── Hero Slider ── */
    const slides   = Array.from(document.querySelectorAll('.ac-slide'));
    const dots     = Array.from(document.querySelectorAll('.sl-dot'));
    const curEl    = document.getElementById('slCur');
    const TOTAL    = slides.length;
    const AUTO_MS  = 5000;
    let current    = 0;
    let autoTimer  = null;

    function pad(n) { return String(n).padStart(2, '0'); }

    function playEntrances(slide) {
        slide.querySelectorAll('[data-enter]').forEach(el => {
            el.classList.remove('entered');
            void el.offsetWidth; // force reflow
            setTimeout(() => el.classList.add('entered'), parseInt(el.dataset.delay || 0));
        });
    }

    function resetEntrances(slide) {
        slide.querySelectorAll('[data-enter]').forEach(el => el.classList.remove('entered'));
    }

    function goTo(idx) {
        if (idx === current) return;
        const out = slides[current];
        const inn = slides[idx];

        out.classList.remove('is-active');
        out.classList.add('is-exiting', 'is-prev');
        resetEntrances(out);
        setTimeout(() => out.classList.remove('is-exiting', 'is-prev'), 560);

        inn.classList.add('is-active');
        playEntrances(inn);

        dots[current].classList.remove('active');
        dots[idx].classList.add('active');
        if (curEl) curEl.textContent = pad(idx + 1);
        current = idx;
    }

    function startAuto() { autoTimer = setInterval(() => goTo((current + 1) % TOTAL), AUTO_MS); }
    function resetAuto()  { clearInterval(autoTimer); startAuto(); }

    playEntrances(slides[0]);
    startAuto();

    /* Arrow buttons */
    const btnPrev = document.getElementById('slPrev');
    const btnNext = document.getElementById('slNext');
    if (btnPrev) btnPrev.addEventListener('click', () => { goTo((current - 1 + TOTAL) % TOTAL); resetAuto(); });
    if (btnNext) btnNext.addEventListener('click', () => { goTo((current + 1) % TOTAL); resetAuto(); });

    /* Dot buttons */
    dots.forEach(dot => dot.addEventListener('click', () => {
        goTo(parseInt(dot.dataset.idx));
        resetAuto();
    }));

    /* Touch / swipe */
    const sl = document.getElementById('acSlider');
    let tx = 0;
    sl.addEventListener('touchstart', e => { tx = e.touches[0].clientX; }, { passive: true });
    sl.addEventListener('touchend', e => {
        const dx = e.changedTouches[0].clientX - tx;
        if (Math.abs(dx) > 50) { goTo(dx < 0 ? (current + 1) % TOTAL : (current - 1 + TOTAL) % TOTAL); resetAuto(); }
    });

    /* Parallax on mouse-move */
    const STRENGTH = 12;
    let mx = 0, my = 0, raf = null;
    sl.addEventListener('mousemove', e => {
        const r = sl.getBoundingClientRect();
        mx = ((e.clientX - r.left) / r.width  - .5) * 2;
        my = ((e.clientY - r.top)  / r.height - .5) * 2;
        if (!raf) raf = requestAnimationFrame(() => {
            raf = null;
            slides.forEach(s => {
                const bg = s.querySelector('.sl-bg');
                if (bg) bg.style.transform = `translate(${-mx * STRENGTH}px,${-my * STRENGTH * .6}px)`;
            });
        });
    });
    sl.addEventListener('mouseleave', () => { mx = 0; my = 0; });
})();
</script>
@endpush