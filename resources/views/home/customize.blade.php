@php
    $title       = 'Customize — ArtsyCrate | Design Your Own Charm, Keychain & More';
    $description = 'Use the ArtsyCrate online builder to design your own bag charm, keychain, or bracelet. Pick beads, charms, and colors — then order for pickup or delivery.';
    $active      = 'customize';

    /* Safe route helpers */
    $keychainHref  = '#'; try { $keychainHref  = route('builder.keychain');  } catch (\Exception $e) {}
    $braceletHref  = '#'; try { $braceletHref  = route('builder.bracelet');  } catch (\Exception $e) {}
    $necklaceHref  = '#'; try { $necklaceHref  = route('builder.necklace');  } catch (\Exception $e) {}
    $homeHref      = '#'; try { $homeHref      = route('home');              } catch (\Exception $e) {}
@endphp

@extends('layout.app')

{{-- ═══════════════════════════════════════
     PAGE-LEVEL STYLES
═══════════════════════════════════════ --}}
@push('styles')
<style>
/* ══════════════════════════════════════
   PAGE TOKENS  (page-scoped, no global leak)
══════════════════════════════════════ */
:root {
  --cust-pink:      #FF5FA0;
  --cust-pink-lt:   #FFF0F6;
  --cust-pink-dk:   #E04080;
  --cust-teal:      #1AC8C4;
  --cust-teal-lt:   #E8FAFA;
  --cust-teal-dk:   #0FA8A4;
  --cust-lime:      #BFDF38;
  --cust-lime-lt:   #F5FAE0;
  --cust-lime-dk:   #91AA00;
  --cust-purple:    #7B5FD4;
  --cust-purple-lt: #F0EEFF;
  --cust-yellow:    #FFD93D;
  --cust-orange:    #FF7A2F;
}

/* ══════════════════════════════════════
   HERO
══════════════════════════════════════ */
.cust-hero {
  position: relative; background: var(--cust-pink);
  overflow: hidden; padding: 80px 0 72px;
}
.cust-hero .hd-doodle {
  position: absolute; pointer-events: none; opacity: .10; color: #fff;
  animation: acFloat 5s ease-in-out infinite;
}
.cust-hero .hd-doodle:nth-child(2) { animation-delay: -1.4s; }
.cust-hero .hd-doodle:nth-child(3) { animation-delay: -3.1s; }
.cust-hero .hd-doodle:nth-child(4) { animation-delay: -2.0s; }
.cust-hero .hd-doodle:nth-child(5) { animation-delay: -0.6s; }

.ch-breadcrumb { display: flex; align-items: center; gap: 6px; margin-bottom: 20px; }
.ch-bc-a {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: .75rem; font-weight: 800; color: rgba(255,255,255,.6);
  text-decoration: none; transition: color .14s;
}
.ch-bc-a:hover { color: #fff; }
.ch-bc-sep { font-size: .75rem; color: rgba(255,255,255,.3); }
.ch-bc-cur { font-size: .75rem; font-weight: 800; color: rgba(255,255,255,.9); }

.ch-eyebrow {
  display: inline-flex; align-items: center; gap: 7px;
  background: rgba(255,255,255,.22); border: 1.5px solid rgba(255,255,255,.35);
  border-radius: 999px; padding: 5px 18px;
  font-size: .7rem; font-weight: 900; letter-spacing: .14em; text-transform: uppercase;
  color: rgba(255,255,255,.9); margin-bottom: 18px;
}
.ch-headline {
  font-family: var(--fh); font-size: clamp(2.6rem, 6vw, 4.6rem);
  color: #fff; line-height: 1.05; margin-bottom: 16px;
}
.ch-sub {
  font-size: .96rem; font-weight: 700; color: rgba(255,255,255,.82);
  max-width: 440px; line-height: 1.75; margin-bottom: 34px;
}
.ch-ctas { display: flex; flex-wrap: wrap; gap: 10px; }
.ch-btn-w {
  display: inline-flex; align-items: center; gap: 8px;
  background: #fff; color: var(--cust-pink-dk);
  font-family: var(--fb); font-weight: 900; font-size: .9rem;
  border: none; border-radius: 12px; padding: 13px 28px;
  text-decoration: none; cursor: pointer;
  box-shadow: 0 8px 24px rgba(0,0,0,.15); transition: transform .14s, box-shadow .14s;
}
.ch-btn-w:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(0,0,0,.22); color: var(--cust-pink-dk); }
.ch-btn-g {
  display: inline-flex; align-items: center; gap: 8px;
  background: transparent; color: #fff;
  font-family: var(--fb); font-weight: 800; font-size: .9rem;
  border: 2px solid rgba(255,255,255,.5); border-radius: 12px;
  padding: 11px 24px; text-decoration: none; transition: background .14s;
}
.ch-btn-g:hover { background: rgba(255,255,255,.18); color: #fff; }

.ch-stats { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 38px; }
.ch-stat {
  display: inline-flex; align-items: center; gap: 8px;
  background: rgba(255,255,255,.18); border: 1.5px solid rgba(255,255,255,.28);
  border-radius: 12px; padding: 8px 16px;
}
.ch-stat-num { font-family: var(--fh); font-size: 1.1rem; color: #fff; }
.ch-stat-lbl { font-size: .72rem; font-weight: 800; color: rgba(255,255,255,.7); }

.ch-vis {
  position: relative; min-height: 360px;
  display: flex; align-items: center; justify-content: center;
}
.ch-vis-ring {
  width: 280px; height: 280px; border-radius: 50%;
  background: rgba(255,255,255,.12); border: 2px dashed rgba(255,255,255,.25);
  display: flex; align-items: center; justify-content: center; position: relative;
  animation: acFloat 5s ease-in-out infinite;
}
.ch-vis-inner {
  width: 160px; height: 160px; border-radius: 50%;
  background: rgba(255,255,255,.22); backdrop-filter: blur(12px);
  display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 8px;
  box-shadow: 0 12px 40px rgba(0,0,0,.15);
}
.ch-vis-inner svg  { color: #fff; }
.ch-vis-inner span { font-family: var(--fh); font-size: .9rem; color: #fff; }

.ch-orbit {
  position: absolute; background: #fff; border-radius: 12px;
  padding: 9px 14px; display: flex; align-items: center; gap: 8px;
  box-shadow: 0 8px 24px rgba(0,0,0,.18);
  font-weight: 800; font-size: .76rem; color: var(--ink); white-space: nowrap;
  animation: acFloat 3.5s ease-in-out infinite;
}
.ch-orbit:nth-child(2) { animation-delay: -1s; }
.ch-orbit:nth-child(3) { animation-delay: -2.2s; }
.ch-orbit:nth-child(4) { animation-delay: -0.5s; }
.ch-orbit-dot {
  width: 28px; height: 28px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ch-orbit-dot svg { width: 14px; height: 14px; }

/* ══════════════════════════════════════
   HOW IT WORKS STRIP
══════════════════════════════════════ */
.how-strip { background: #fff; border-bottom: 1.5px solid var(--ink-lt); padding: 40px 0; }
.how-grid  { display: grid; grid-template-columns: repeat(4, 1fr); }
.how-step {
  display: flex; flex-direction: column; align-items: center;
  text-align: center; gap: 10px; padding: 20px 16px;
  border-right: 1.5px solid var(--ink-lt); position: relative;
}
.how-step:last-child { border-right: none; }
.how-step-icon {
  width: 52px; height: 52px; border-radius: 16px;
  display: flex; align-items: center; justify-content: center; margin-bottom: 4px;
}
.how-step-label { font-family: var(--fh); font-size: 1rem; color: var(--ink); margin-bottom: 4px; }
.how-step-desc  { font-size: .78rem; font-weight: 700; color: var(--ink-md); line-height: 1.6; }
.hs-arrow {
  position: absolute; right: -12px; top: 50%; transform: translateY(-50%);
  width: 22px; height: 22px;
  background: var(--offwhite); border: 1.5px solid var(--ink-lt); border-radius: 50%;
  display: flex; align-items: center; justify-content: center; z-index: 1; color: var(--ink-md);
}
.how-step:last-child .hs-arrow { display: none; }

/* ══════════════════════════════════════
   BUILDER CARDS
══════════════════════════════════════ */
.builders-section { background: var(--offwhite); padding: 88px 0 96px; }
.bs-eyebrow {
  display: flex; align-items: center; gap: 8px; justify-content: center;
  font-size: .71rem; font-weight: 900; letter-spacing: .14em;
  text-transform: uppercase; color: var(--cust-teal-dk); margin-bottom: 12px;
}
.bs-eyebrow-bar { display: inline-block; width: 26px; height: 3px; border-radius: 2px; background: var(--cust-teal); }
.bs-headline {
  font-family: var(--fh); font-size: clamp(2rem, 4vw, 3.2rem);
  color: var(--ink); text-align: center; line-height: 1.1; margin-bottom: 12px;
}
.bs-sub {
  font-size: .94rem; font-weight: 700; color: var(--ink-md);
  text-align: center; max-width: 420px; margin: 0 auto 60px; line-height: 1.7;
}

.bcard {
  background: #fff; border: 2px solid var(--ink-lt); border-radius: 28px;
  overflow: hidden; display: flex; flex-direction: column; height: 100%;
  transition: transform .2s, box-shadow .2s, border-color .2s; position: relative;
}
.bcard:hover { transform: translateY(-6px); box-shadow: 0 20px 56px rgba(30,30,46,.1); }

.bcard-ribbon {
  position: absolute; top: 20px; right: -10px;
  background: var(--cust-pink); color: #fff;
  font-size: .63rem; font-weight: 900; letter-spacing: .1em; text-transform: uppercase;
  padding: 4px 18px 4px 14px; border-radius: 4px 0 0 4px;
  box-shadow: 0 4px 12px rgba(255,95,160,.35);
}
.bcard-ribbon::after {
  content: ''; position: absolute; right: 0; top: 100%;
  border-style: solid; border-width: 0 10px 6px 0;
  border-color: transparent var(--cust-pink-dk) transparent transparent;
}

.bcard-vis {
  position: relative; height: 200px;
  display: flex; align-items: center; justify-content: center; overflow: hidden;
}
.bcard-vis-bg { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; }
.bcard-big-icon { opacity: .08; animation: acFloat 4s ease-in-out infinite; }
.bcard-big-icon svg { width: 160px; height: 160px; }

.canvas-preview {
  position: relative; z-index: 2; background: #fff; border: 1.5px solid var(--ink-lt);
  border-radius: 20px; box-shadow: 0 12px 36px rgba(30,30,46,.1);
  padding: 14px; width: 200px; display: flex; flex-direction: column; gap: 8px;
  animation: acFloat 4.5s ease-in-out infinite;
}
.cvp-bar  { display: flex; gap: 5px; margin-bottom: 2px; }
.cvp-dot  { width: 8px; height: 8px; border-radius: 50%; }
.cvp-area {
  height: 80px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  gap: 5px; flex-wrap: wrap; padding: 8px;
}
.cvp-bead  { width: 18px; height: 18px; border-radius: 50%; border: 1.5px solid rgba(0,0,0,.08); flex-shrink: 0; }
.cvp-charm {
  width: 24px; height: 24px; border-radius: 8px;
  background: rgba(255,255,255,.8); border: 1.5px solid rgba(0,0,0,.08);
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cvp-charm svg { width: 12px; height: 12px; }
.cvp-label { font-size: .66rem; font-weight: 800; color: var(--ink-md); text-align: center; }

.bcard-body     { padding: 26px 26px 20px; flex: 1; }
.bcard-category { font-size: .63rem; font-weight: 900; letter-spacing: .12em; text-transform: uppercase; margin-bottom: 10px; }
.bcard-title    { font-family: var(--fh); font-size: 1.5rem; color: var(--ink); line-height: 1.1; margin-bottom: 10px; }
.bcard-desc     { font-size: .85rem; font-weight: 700; color: var(--ink-md); line-height: 1.7; margin-bottom: 18px; }

.bcard-features { list-style: none; padding: 0; margin: 0 0 22px; display: flex; flex-direction: column; gap: 7px; }
.bcf-item { display: flex; align-items: center; gap: 8px; font-size: .79rem; font-weight: 800; color: var(--ink); }
.bcf-check { width: 20px; height: 20px; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.bcf-check svg { width: 11px; height: 11px; color: #fff; }

.bcard-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 6px; }
.bcard-tag  { font-size: .66rem; font-weight: 800; background: var(--offwhite); color: var(--ink-md); border: 1.5px solid var(--ink-lt); border-radius: 7px; padding: 3px 10px; }

.bcard-foot { padding: 0 26px 26px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
.bcard-cta {
  flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 8px;
  color: #fff; font-family: var(--fb); font-weight: 900; font-size: .88rem;
  border: none; border-radius: 14px; padding: 13px 20px; text-decoration: none; cursor: pointer;
  transition: filter .15s, transform .12s;
}
.bcard-cta:hover { filter: brightness(1.08); transform: translateY(-1px); color: #fff; }

/* colour variants */
.bc-pink .bcard-category { color: var(--cust-pink-dk); }
.bc-pink .bcard-cta      { background: var(--cust-pink); box-shadow: 0 6px 20px rgba(255,95,160,.3); }
.bc-pink:hover            { border-color: var(--cust-pink); }
.bc-pink .bcf-check       { background: var(--cust-pink); }
.bc-pink .bcard-vis       { background: var(--cust-pink-lt); }
.bc-pink .bcard-big-icon  { color: var(--cust-pink); }

.bc-teal .bcard-category { color: var(--cust-teal-dk); }
.bc-teal .bcard-cta      { background: var(--cust-teal); box-shadow: 0 6px 20px rgba(26,200,196,.28); }
.bc-teal:hover            { border-color: var(--cust-teal); }
.bc-teal .bcf-check       { background: var(--cust-teal); }
.bc-teal .bcard-vis       { background: var(--cust-teal-lt); }
.bc-teal .bcard-big-icon  { color: var(--cust-teal); }

.bc-lime .bcard-category { color: var(--cust-lime-dk); }
.bc-lime .bcard-cta      { background: var(--cust-lime-dk); box-shadow: 0 6px 20px rgba(140,180,0,.28); }
.bc-lime:hover            { border-color: var(--cust-lime); }
.bc-lime .bcf-check       { background: var(--cust-lime-dk); }
.bc-lime .bcard-vis       { background: var(--cust-lime-lt); }
.bc-lime .bcard-big-icon  { color: var(--cust-lime-dk); }

/* ══════════════════════════════════════
   WALK-IN VS ONLINE COMPARISON
══════════════════════════════════════ */
.compare-section { background: var(--offwhite); padding: 88px 0; border-top: 1.5px solid var(--ink-lt); }
.cmp-card {
  background: #fff; border: 2px solid var(--ink-lt); border-radius: 24px;
  padding: 34px 30px; height: 100%; transition: border-color .16s, box-shadow .16s;
}
.cmp-card:hover { border-color: var(--cust-teal); box-shadow: 0 10px 32px rgba(26,200,196,.1); }
.cmp-icon  { width: 60px; height: 60px; border-radius: 18px; display: flex; align-items: center; justify-content: center; margin-bottom: 18px; }
.cmp-icon svg { width: 28px; height: 28px; }
.cmp-title { font-family: var(--fh); font-size: 1.35rem; color: var(--ink); margin-bottom: 8px; }
.cmp-sub   { font-size: .84rem; font-weight: 700; color: var(--ink-md); line-height: 1.65; margin-bottom: 24px; }
.cmp-list  { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 9px; }
.cmp-li    { display: flex; align-items: center; gap: 9px; font-size: .82rem; font-weight: 800; color: var(--ink); }
.cmp-li-icon { width: 22px; height: 22px; border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.cmp-li-icon svg { width: 12px; height: 12px; }
.cmp-btn {
  display: inline-flex; align-items: center; gap: 8px;
  font-family: var(--fb); font-weight: 900; font-size: .88rem;
  border-radius: 12px; padding: 12px 24px; text-decoration: none;
  margin-top: 28px; transition: filter .14s, transform .12s;
}
.cmp-btn:hover { filter: brightness(1.08); transform: translateY(-1px); }
.cmp-btn-teal { background: var(--cust-teal); color: #fff; box-shadow: 0 6px 18px rgba(26,200,196,.3); }
.cmp-btn-teal:hover { color: #fff; }
.cmp-btn-pink { background: var(--cust-pink); color: #fff; box-shadow: 0 6px 18px rgba(255,95,160,.3); }
.cmp-btn-pink:hover { color: #fff; }
.cmp-or { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; }
.cmp-or-pill { background: var(--ink); color: #fff; font-family: var(--fh); font-size: 1.1rem; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
.cmp-or-line { width: 2px; height: 60px; background: var(--ink-lt); border-radius: 2px; }

/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width: 991px) {
  .how-grid { grid-template-columns: 1fr 1fr; }
  .how-step:nth-child(2) { border-right: none; }
  .cmp-or { flex-direction: row; }
  .cmp-or-line { width: 60px; height: 2px; }
}
@media (max-width: 767px) {
  .cust-hero { padding: 56px 0 52px; }
  .ch-vis    { display: none; }
}
@media (max-width: 575px) {
  .how-grid  { grid-template-columns: 1fr 1fr; }
  .bcard-foot { flex-direction: column; }
  .bcard-cta  { width: 100%; }
}
</style>
@endpush

{{-- ═══════════════════════════════════════
     CONTENT
═══════════════════════════════════════ --}}
@section('content')

{{-- ────────────────────────────────────
     HERO
──────────────────────────────────── --}}
<section class="cust-hero">
  <div class="hd-doodle" style="top:6%;left:4%;transform:rotate(-14deg);">
    <i data-lucide="scissors" style="width:80px;height:80px;"></i>
  </div>
  <div class="hd-doodle" style="top:18%;right:5%;transform:rotate(20deg);">
    <i data-lucide="key" style="width:100px;height:100px;"></i>
  </div>
  <div class="hd-doodle" style="bottom:8%;left:10%;transform:rotate(8deg);">
    <i data-lucide="palette" style="width:66px;height:66px;"></i>
  </div>
  <div class="hd-doodle" style="bottom:14%;right:3%;transform:rotate(-18deg);">
    <i data-lucide="sparkles" style="width:72px;height:72px;"></i>
  </div>
  <div class="hd-doodle" style="top:50%;left:2%;transform:rotate(6deg);">
    <i data-lucide="gem" style="width:56px;height:56px;"></i>
  </div>

  <div class="container position-relative" style="z-index:2;">
    <div class="row align-items-center g-5">

      <div class="col-lg-6 fade-up">
        <div class="ch-breadcrumb">
          <a href="{{ $homeHref }}" class="ch-bc-a">
            <i data-lucide="home" style="width:12px;height:12px;"></i> Home
          </a>
          <span class="ch-bc-sep">/</span>
          <span class="ch-bc-cur">Customize</span>
        </div>
        <div class="ch-eyebrow">
          <i data-lucide="sparkles" style="width:12px;height:12px;"></i>
          Online Design Studio
        </div>
        <h1 class="ch-headline">
          Design It.<br/>Build It.<br/>Love It. 🎀
        </h1>
        <p class="ch-sub">
          Use our interactive builder to create your dream keychain, bag charm, or bracelet
          right from your browser — then order for in-store pickup or delivery.
        </p>
        <div class="ch-ctas">
          <a href="{{ $keychainHref }}" class="ch-btn-w">
            <i data-lucide="scissors" style="width:15px;height:15px;"></i>
            Start Designing Free
          </a>
          <a href="#builders" class="ch-btn-g">
            <i data-lucide="arrow-down" style="width:15px;height:15px;"></i>
            See All Builders
          </a>
        </div>
        <div class="ch-stats">
          <div class="ch-stat">
            <span class="ch-stat-num">3</span>
            <span class="ch-stat-lbl">Builder Modules</span>
          </div>
          <div class="ch-stat">
            <span class="ch-stat-num">50+</span>
            <span class="ch-stat-lbl">Charm Options</span>
          </div>
          <div class="ch-stat">
            <span class="ch-stat-num">∞</span>
            <span class="ch-stat-lbl">Combinations</span>
          </div>
        </div>
      </div>

      <div class="col-lg-6 fade-right">
        <div class="ch-vis">
          <div class="ch-vis-ring">
            <div class="ch-vis-inner">
              <i data-lucide="scissors" style="width:40px;height:40px;"></i>
              <span>Builder</span>
            </div>
          </div>
          <div class="ch-orbit" style="top:-10px;left:-30px;">
            <div class="ch-orbit-dot" style="background:var(--cust-pink-lt);">
              <i data-lucide="heart" style="width:14px;height:14px;color:var(--cust-pink);"></i>
            </div>
            Bag Charms
          </div>
          <div class="ch-orbit" style="bottom:-10px;left:10px;">
            <div class="ch-orbit-dot" style="background:var(--cust-teal-lt);">
              <i data-lucide="key" style="width:14px;height:14px;color:var(--cust-teal-dk);"></i>
            </div>
            Keychains
          </div>
          <div class="ch-orbit" style="top:60px;right:-40px;">
            <div class="ch-orbit-dot" style="background:var(--cust-lime-lt);">
              <i data-lucide="circle" style="width:14px;height:14px;color:var(--cust-lime-dk);"></i>
            </div>
            Bracelets
          </div>
          <div class="ch-orbit" style="bottom:60px;right:-20px;">
            <div class="ch-orbit-dot" style="background:#F0EEFF;">
              <i data-lucide="sparkles" style="width:14px;height:14px;color:var(--cust-purple);"></i>
            </div>
            Live Preview
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ────────────────────────────────────
     HOW IT WORKS
──────────────────────────────────── --}}
<div class="how-strip">
  <div class="container">
    <div class="how-grid">

      <div class="how-step">
        <div class="how-step-icon" style="background:var(--cust-pink-lt);">
          <i data-lucide="mouse-pointer-click" style="width:22px;height:22px;color:var(--cust-pink-dk);"></i>
        </div>
        <div class="how-step-label">Choose a Builder</div>
        <div class="how-step-desc">Pick keychain, bracelet, or necklace. Each has its own canvas and charm set.</div>
        <div class="hs-arrow"><i data-lucide="chevron-right" style="width:12px;height:12px;"></i></div>
      </div>

      <div class="how-step">
        <div class="how-step-icon" style="background:var(--cust-teal-lt);">
          <i data-lucide="palette" style="width:22px;height:22px;color:var(--cust-teal-dk);"></i>
        </div>
        <div class="how-step-label">Drag &amp; Design</div>
        <div class="how-step-desc">Drop beads and charms onto the canvas. Resize, recolor, and rearrange freely.</div>
        <div class="hs-arrow"><i data-lucide="chevron-right" style="width:12px;height:12px;"></i></div>
      </div>

      <div class="how-step">
        <div class="how-step-icon" style="background:var(--cust-lime-lt);">
          <i data-lucide="eye" style="width:22px;height:22px;color:var(--cust-lime-dk);"></i>
        </div>
        <div class="how-step-label">Preview Live</div>
        <div class="how-step-desc">See exactly how your design looks in real-time before you commit to anything.</div>
        <div class="hs-arrow"><i data-lucide="chevron-right" style="width:12px;height:12px;"></i></div>
      </div>

      <div class="how-step">
        <div class="how-step-icon" style="background:#F0EEFF;">
          <i data-lucide="send" style="width:22px;height:22px;color:var(--cust-purple);"></i>
        </div>
        <div class="how-step-label">Order &amp; Pick Up</div>
        <div class="how-step-desc">Submit your design with your info. Get a unique order code and track your status.</div>
      </div>

    </div>
  </div>
</div>

{{-- ────────────────────────────────────
     BUILDER CARDS
──────────────────────────────────── --}}
<section class="builders-section" id="builders">
  <div class="container">

    <div class="bs-eyebrow">
      <span class="bs-eyebrow-bar"></span> Pick Your Builder <span class="bs-eyebrow-bar"></span>
    </div>
    <h2 class="bs-headline">Three Ways to <span style="color:var(--cust-teal);">Create</span> 🎨</h2>
    <p class="bs-sub">Each builder is tuned for a different product. Open one, design away, and submit your order — all in one place.</p>

    <div class="row g-4">

      {{-- KEYCHAIN --}}
      <div class="col-lg-4 col-md-6 fade-up">
        <div class="bcard bc-pink">
          <div class="bcard-ribbon">Most Popular</div>
          <div class="bcard-vis">
            <div class="bcard-vis-bg">
              <div class="bcard-big-icon"><i data-lucide="key" style="width:160px;height:160px;"></i></div>
            </div>
            <div class="canvas-preview">
              <div class="cvp-bar">
                <div class="cvp-dot" style="background:#FF5FA0;"></div>
                <div class="cvp-dot" style="background:#FFD93D;"></div>
                <div class="cvp-dot" style="background:#1AC8C4;"></div>
              </div>
              <div class="cvp-area" style="background:var(--cust-pink-lt);">
                <div class="cvp-bead" style="background:#FF5FA0;"></div>
                <div class="cvp-bead" style="background:#FFD93D;"></div>
                <div class="cvp-charm" style="background:var(--cust-pink-lt);">
                  <i data-lucide="heart" style="width:12px;height:12px;color:var(--cust-pink);"></i>
                </div>
                <div class="cvp-bead" style="background:#7B5FD4;"></div>
                <div class="cvp-bead" style="background:#1AC8C4;"></div>
                <div class="cvp-charm" style="background:var(--cust-pink-lt);">
                  <i data-lucide="star" style="width:12px;height:12px;color:var(--cust-orange);"></i>
                </div>
              </div>
              <div class="cvp-label">Keychain Canvas</div>
            </div>
          </div>
          <div class="bcard-body">
            <div class="bcard-category">
              <i data-lucide="key" style="width:11px;height:11px;vertical-align:middle;margin-right:4px;"></i>
              Keychain Builder
            </div>
            <h3 class="bcard-title">Bag Charm &amp;<br/>Keychain</h3>
            <p class="bcard-desc">Design a fully custom keychain with your choice of beads, charms, letters, and accessories. Perfect for gifts or everyday carry.</p>
            <ul class="bcard-features">
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Drag-and-drop bead &amp; charm canvas</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Live colour picker for every element</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Add custom letter beads &amp; initials</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Export design image with your order</li>
            </ul>
            <div class="bcard-tags">
              <span class="bcard-tag">Acrylic</span><span class="bcard-tag">Resin</span>
              <span class="bcard-tag">Metal</span><span class="bcard-tag">Letter Beads</span><span class="bcard-tag">Bag Charm</span>
            </div>
          </div>
          <div class="bcard-foot">
            <a href="{{ $keychainHref }}" class="bcard-cta">
              <i data-lucide="scissors" style="width:15px;height:15px;"></i> Open Keychain Builder
            </a>
          </div>
        </div>
      </div>

      {{-- BRACELET --}}
      <div class="col-lg-4 col-md-6 fade-up d1">
        <div class="bcard bc-teal">
          <div class="bcard-vis">
            <div class="bcard-vis-bg">
              <div class="bcard-big-icon"><i data-lucide="circle" style="width:160px;height:160px;"></i></div>
            </div>
            <div class="canvas-preview">
              <div class="cvp-bar">
                <div class="cvp-dot" style="background:#1AC8C4;"></div>
                <div class="cvp-dot" style="background:#BFDF38;"></div>
                <div class="cvp-dot" style="background:#FF5FA0;"></div>
              </div>
              <div class="cvp-area" style="background:var(--cust-teal-lt);">
                <div class="cvp-bead" style="background:#1AC8C4;"></div>
                <div class="cvp-bead" style="background:#BFDF38;"></div>
                <div class="cvp-bead" style="background:#FFD93D;"></div>
                <div class="cvp-charm" style="background:var(--cust-teal-lt);">
                  <i data-lucide="moon" style="width:12px;height:12px;color:var(--cust-teal-dk);"></i>
                </div>
                <div class="cvp-bead" style="background:#FF5FA0;"></div>
                <div class="cvp-bead" style="background:#7B5FD4;"></div>
              </div>
              <div class="cvp-label">Bracelet Canvas</div>
            </div>
          </div>
          <div class="bcard-body">
            <div class="bcard-category">
              <i data-lucide="circle" style="width:11px;height:11px;vertical-align:middle;margin-right:4px;"></i>
              Bracelet Builder
            </div>
            <h3 class="bcard-title">Custom Bead<br/>Bracelet</h3>
            <p class="bcard-desc">Build a stretch or elastic bead bracelet with your colour palette. Stack them, mix them, or create a matching set.</p>
            <ul class="bcard-features">
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Circular bracelet preview canvas</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Choose bead size, shape &amp; finish</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Add spacer beads &amp; feature charms</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Design stackable matching sets</li>
            </ul>
            <div class="bcard-tags">
              <span class="bcard-tag">Stretch</span><span class="bcard-tag">Elastic</span>
              <span class="bcard-tag">Stackable</span><span class="bcard-tag">Friendship</span>
            </div>
          </div>
          <div class="bcard-foot">
            <a href="{{ $braceletHref }}" class="bcard-cta">
              <i data-lucide="circle" style="width:15px;height:15px;"></i> Open Bracelet Builder
            </a>
          </div>
        </div>
      </div>

      {{-- NECKLACE --}}
      <div class="col-lg-4 col-md-6 fade-up d2">
        <div class="bcard bc-lime">
          <div class="bcard-vis">
            <div class="bcard-vis-bg">
              <div class="bcard-big-icon"><i data-lucide="heart" style="width:160px;height:160px;"></i></div>
            </div>
            <div class="canvas-preview">
              <div class="cvp-bar">
                <div class="cvp-dot" style="background:#BFDF38;"></div>
                <div class="cvp-dot" style="background:#7B5FD4;"></div>
                <div class="cvp-dot" style="background:#FFD93D;"></div>
              </div>
              <div class="cvp-area" style="background:var(--cust-lime-lt);">
                <div class="cvp-bead" style="background:#BFDF38;"></div>
                <div class="cvp-charm" style="background:var(--cust-lime-lt);">
                  <i data-lucide="star" style="width:12px;height:12px;color:var(--cust-lime-dk);"></i>
                </div>
                <div class="cvp-bead" style="background:#7B5FD4;"></div>
                <div class="cvp-bead" style="background:#FFD93D;"></div>
                <div class="cvp-charm" style="background:var(--cust-lime-lt);">
                  <i data-lucide="gem" style="width:12px;height:12px;color:var(--cust-purple);"></i>
                </div>
                <div class="cvp-bead" style="background:#FF7A2F;"></div>
              </div>
              <div class="cvp-label">Necklace Canvas</div>
            </div>
          </div>
          <div class="bcard-body">
            <div class="bcard-category">
              <i data-lucide="heart" style="width:11px;height:11px;vertical-align:middle;margin-right:4px;"></i>
              Necklace Builder
            </div>
            <h3 class="bcard-title">Charm<br/>Necklace</h3>
            <p class="bcard-desc">Choose your chain length and layer on pendants and charms. Great for personalised gifts or statement accessories.</p>
            <ul class="bcard-features">
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Chain length selector (14"–24")</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Multi-pendant layering canvas</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Initial, date &amp; symbol pendants</li>
              <li class="bcf-item"><div class="bcf-check"><i data-lucide="check" style="width:11px;height:11px;"></i></div>Silver, gold &amp; rose-gold finishes</li>
            </ul>
            <div class="bcard-tags">
              <span class="bcard-tag">Pendant</span><span class="bcard-tag">Chain</span>
              <span class="bcard-tag">Layered</span><span class="bcard-tag">Initial</span>
            </div>
          </div>
          <div class="bcard-foot">
            <a href="{{ $necklaceHref }}" class="bcard-cta">
              <i data-lucide="heart" style="width:15px;height:15px;"></i> Open Necklace Builder
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ────────────────────────────────────
     WALK-IN VS ONLINE COMPARISON
──────────────────────────────────── --}}
<section class="compare-section">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <div class="col-lg-6 fade-up">
        <div class="eye-row justify-content-center">
          <span class="eye-bar"></span> Choose Your Way <span class="eye-bar"></span>
        </div>
        <h2 class="sec-h">Online or <span class="pc">In-Store</span>?</h2>
        <p class="sec-p mx-auto">Both options are awesome — pick whatever works for you!</p>
      </div>
    </div>

    <div class="row align-items-center g-4">

      <div class="col-lg-5 col-md-6 fade-left">
        <div class="cmp-card">
          <div class="cmp-icon" style="background:var(--cust-teal-lt);">
            <i data-lucide="monitor" style="width:28px;height:28px;color:var(--cust-teal-dk);"></i>
          </div>
          <div class="cmp-title">Design Online</div>
          <div class="cmp-sub">Perfect if you are busy or want to plan ahead. Build your design on any device, anytime.</div>
          <ul class="cmp-list">
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-teal-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-teal-dk);"></i></div>Design from home at your own pace</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-teal-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-teal-dk);"></i></div>Upload reference images or logos</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-teal-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-teal-dk);"></i></div>Track your order status online</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-teal-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-teal-dk);"></i></div>Delivery or in-store pickup options</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-teal-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-teal-dk);"></i></div>Great for bulk &amp; business orders</li>
          </ul>
          <a href="{{ $keychainHref }}" class="cmp-btn cmp-btn-teal">
            <i data-lucide="scissors" style="width:15px;height:15px;"></i> Start Designing
          </a>
        </div>
      </div>

      <div class="col-lg-2 col-md-12 fade-up d1">
        <div class="cmp-or">
          <div class="cmp-or-line"></div>
          <div class="cmp-or-pill">OR</div>
          <div class="cmp-or-line"></div>
        </div>
      </div>

      <div class="col-lg-5 col-md-6 fade-right">
        <div class="cmp-card">
          <div class="cmp-icon" style="background:var(--cust-pink-lt);">
            <i data-lucide="store" style="width:28px;height:28px;color:var(--cust-pink-dk);"></i>
          </div>
          <div class="cmp-title">Walk In &amp; Create</div>
          <div class="cmp-sub">Come visit us! Our in-store workshop has all materials laid out — just walk in and get crafty.</div>
          <ul class="cmp-list">
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-pink-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-pink-dk);"></i></div>Touch and feel real materials</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-pink-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-pink-dk);"></i></div>Staff assistance for beginners</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-pink-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-pink-dk);"></i></div>Take your creation home same day</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-pink-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-pink-dk);"></i></div>Fun group activity for friends</li>
            <li class="cmp-li"><div class="cmp-li-icon" style="background:var(--cust-pink-lt);"><i data-lucide="check" style="width:12px;height:12px;color:var(--cust-pink-dk);"></i></div>No experience required — ever!</li>
          </ul>
          <a href="#about" class="cmp-btn cmp-btn-pink">
            <i data-lucide="map-pin" style="width:15px;height:15px;"></i> Find Our Store
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

@endsection

{{-- ═══════════════════════════════════════
     PAGE SCRIPTS
═══════════════════════════════════════ --}}
@push('scripts')
<script>
(function () {
  'use strict';

  /* ── Navbar shadow on scroll ── */
  const nav = document.getElementById('mainNav');
  if (nav) {
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 30);
    }, { passive: true });
  }

  /* ── Scroll-reveal ── */
  if ('IntersectionObserver' in window) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('vis'); io.unobserve(e.target); }
      });
    }, { threshold: 0.12 });
    document.querySelectorAll('.fade-up,.fade-left,.fade-right').forEach(el => io.observe(el));
  } else {
    document.querySelectorAll('.fade-up,.fade-left,.fade-right').forEach(el => el.classList.add('vis'));
  }

})();
</script>
@endpush