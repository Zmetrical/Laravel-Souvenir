@php
    $title       = 'Contact Us — ArtsyCrate | Get In Touch';
    $description = 'Have a question or custom order in mind? Reach out to ArtsyCrate — we\'re based in Parañaque City and always happy to help with prints, charms, bulk orders, and more.';
    $active      = 'contact';

    $homeHref  = '#'; try { $homeHref  = route('home');            } catch (\Exception $e) {}
    $buildHref = '#'; try { $buildHref = route('builder.keychain'); } catch (\Exception $e) {}
@endphp

@extends('layout.app')

@push('styles')
<style>
/* ══════════════════════════════════════
   HERO
══════════════════════════════════════ */
.ct-hero {
    position: relative;
    background: var(--orange);
    overflow: hidden;
    padding: 84px 0 76px;
}
.ct-doodle {
    position: absolute; pointer-events: none;
    opacity: .10; color: #fff;
    animation: acFloat 5s ease-in-out infinite;
}
.ct-doodle:nth-child(2) { animation-delay: -1.8s; }
.ct-doodle:nth-child(3) { animation-delay: -3.2s; }
.ct-doodle:nth-child(4) { animation-delay: -0.7s; }
.ct-doodle:nth-child(5) { animation-delay: -2.4s; }

.ct-breadcrumb { display:flex; align-items:center; gap:6px; margin-bottom:20px; }
.ct-bc-a {
    display:inline-flex; align-items:center; gap:4px;
    font-size:.75rem; font-weight:800; color:rgba(255,255,255,.55);
    text-decoration:none; transition:color .14s;
}
.ct-bc-a:hover { color:#fff; }
.ct-bc-sep { font-size:.75rem; color:rgba(255,255,255,.28); }
.ct-bc-cur { font-size:.75rem; font-weight:800; color:rgba(255,255,255,.88); }

.ct-eyebrow {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(255,255,255,.18); border:1.5px solid rgba(255,255,255,.3);
    border-radius:999px; padding:5px 18px;
    font-size:.7rem; font-weight:900; letter-spacing:.14em; text-transform:uppercase;
    color:rgba(255,255,255,.9); margin-bottom:18px;
}
.ct-headline {
    font-family: var(--fh);
    font-size: clamp(2.6rem, 6vw, 4.6rem);
    color: #fff; line-height: 1.05; margin-bottom: 16px;
}
.ct-sub {
    font-size:.97rem; font-weight:700;
    color:rgba(255,255,255,.82); max-width:440px; line-height:1.75; margin-bottom:34px;
}

/* Hero quick-links */
.ct-ql { display:flex; flex-wrap:wrap; gap:10px; }
.ct-ql-pill {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.18); border:1.5px solid rgba(255,255,255,.3);
    border-radius:12px; padding:10px 18px; text-decoration:none;
    font-weight:800; font-size:.82rem; color:#fff;
    transition:background .14s, transform .12s;
}
.ct-ql-pill:hover { background:rgba(255,255,255,.3); transform:translateY(-2px); color:#fff; }
.ct-ql-dot {
    width:28px; height:28px; border-radius:8px;
    background:rgba(255,255,255,.22);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}

/* Hero visual */
.ct-vis { position:relative; min-height:360px; display:flex; align-items:center; justify-content:center; }
.ct-vis-ring {
    width:290px; height:290px; border-radius:50%;
    border:2px dashed rgba(255,255,255,.22);
    display:flex; align-items:center; justify-content:center;
    position:relative; animation:acFloat 5.5s ease-in-out infinite;
}
.ct-vis-core {
    width:164px; height:164px; border-radius:50%;
    background:rgba(255,255,255,.18); backdrop-filter:blur(14px);
    display:flex; flex-direction:column; align-items:center;
    justify-content:center; gap:8px;
    box-shadow:0 12px 40px rgba(0,0,0,.18);
}
.ct-vis-core span { font-family:var(--fh); font-size:.9rem; color:#fff; }
.ct-badge {
    position:absolute; background:#fff; border-radius:12px;
    padding:9px 14px; display:flex; align-items:center; gap:8px;
    box-shadow:0 8px 24px rgba(0,0,0,.18); font-weight:800;
    font-size:.76rem; color:var(--ink); white-space:nowrap;
    animation:acFloat 3.5s ease-in-out infinite;
}
.ct-badge:nth-child(2) { animation-delay:-1s; }
.ct-badge:nth-child(3) { animation-delay:-2.2s; }
.ct-badge:nth-child(4) { animation-delay:-0.5s; }
.ct-badge-dot {
    width:28px; height:28px; border-radius:8px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}

/* ══════════════════════════════════════
   CHANNELS STRIP
══════════════════════════════════════ */
.channels-strip {
    background:#fff; border-bottom:1.5px solid var(--ink-lt); padding:0;
}
.channels-grid {
    display:grid; grid-template-columns:repeat(4,1fr);
    border-top:1.5px solid var(--ink-lt);
}
.channel-cell {
    display:flex; flex-direction:column; align-items:center;
    justify-content:center; gap:8px; padding:24px 16px;
    text-align:center; border-right:1.5px solid var(--ink-lt);
    text-decoration:none; transition:background .15s;
    cursor:pointer;
}
.channel-cell:last-child { border-right:none; }
.channel-cell:hover { background:var(--offwhite); }
.channel-icon {
    width:48px; height:48px; border-radius:14px;
    display:flex; align-items:center; justify-content:center;
}
.channel-icon svg { width:22px; height:22px; }
.channel-label { font-family:var(--fh); font-size:.95rem; color:var(--ink); }
.channel-val   { font-size:.75rem; font-weight:800; color:var(--ink-md); }

/* ══════════════════════════════════════
   MAIN CONTENT — FORM + INFO
══════════════════════════════════════ */
.contact-section { background:var(--offwhite); padding:92px 0 96px; }

/* ── Contact Form ── */
.cf-wrap {
    background:#fff; border:2px solid var(--ink-lt);
    border-radius:28px; padding:40px 36px;
    transition:box-shadow .2s;
}
.cf-wrap:focus-within { box-shadow:0 12px 48px rgba(30,30,46,.08); border-color:var(--orange); }

.cf-eyebrow {
    display:inline-flex; align-items:center; gap:7px;
    background:#FFF0E6; color:var(--orange);
    border:1.5px solid rgba(255,122,47,.2);
    border-radius:999px; padding:4px 14px;
    font-size:.7rem; font-weight:900; letter-spacing:.12em; text-transform:uppercase;
    margin-bottom:12px;
}
.cf-title { font-family:var(--fh); font-size:1.7rem; color:var(--ink); margin-bottom:6px; }
.cf-sub   { font-size:.84rem; font-weight:700; color:var(--ink-md); line-height:1.65; margin-bottom:28px; }

/* Form fields */
.cf-row   { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px; }
.cf-group { display:flex; flex-direction:column; gap:6px; margin-bottom:14px; }
.cf-label {
    font-size:.74rem; font-weight:900; color:var(--ink);
    letter-spacing:.06em; text-transform:uppercase;
}
.cf-label span { color:var(--orange); margin-left:2px; }
.cf-input, .cf-select, .cf-textarea {
    border:1.5px solid var(--ink-lt); border-radius:12px;
    padding:11px 14px; font-family:var(--fb); font-weight:600;
    font-size:.88rem; color:var(--ink); background:#fff;
    transition:border-color .15s, box-shadow .15s;
    width:100%;
}
.cf-input:focus, .cf-select:focus, .cf-textarea:focus {
    outline:none; border-color:var(--orange);
    box-shadow:0 0 0 3px rgba(255,122,47,.12);
}
.cf-input::placeholder, .cf-textarea::placeholder { color:var(--ink-lt); font-weight:600; }
.cf-select { appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpolyline points='2,4 6,8 10,4' fill='none' stroke='%235A5470' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 12px center; padding-right:34px; cursor:pointer; }
.cf-textarea { resize:vertical; min-height:120px; }

/* Topic chips */
.cf-topics { display:flex; flex-wrap:wrap; gap:8px; margin-bottom:20px; }
.cf-topic {
    display:inline-flex; align-items:center; gap:6px;
    border:1.5px solid var(--ink-lt); border-radius:999px;
    padding:6px 14px; font-size:.76rem; font-weight:800;
    color:var(--ink-md); cursor:pointer; background:#fff;
    transition:all .15s; user-select:none;
}
.cf-topic:hover  { border-color:var(--orange); color:var(--orange); background:#FFF5EE; }
.cf-topic.active { border-color:var(--orange); color:var(--orange); background:#FFF0E6; }
.cf-topic input  { display:none; }

.cf-submit {
    width:100%; display:flex; align-items:center; justify-content:center; gap:9px;
    background:var(--orange); color:#fff;
    font-family:var(--fb); font-weight:900; font-size:.94rem;
    border:none; border-radius:14px; padding:14px 28px;
    cursor:pointer; box-shadow:0 6px 20px rgba(255,122,47,.3);
    transition:background .14s, transform .12s, box-shadow .14s;
}
.cf-submit:hover { background:#e06520; transform:translateY(-2px); box-shadow:0 10px 28px rgba(255,122,47,.4); }
.cf-submit:active { transform:translateY(0); }

/* Success state */
.cf-success {
    display:none; text-align:center; padding:48px 24px;
}
.cf-success-icon {
    width:72px; height:72px; border-radius:50%;
    background:#F0FFF8; border:2px solid rgba(26,200,196,.3);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 20px;
}
.cf-success-title { font-family:var(--fh); font-size:1.6rem; color:var(--ink); margin-bottom:8px; }
.cf-success-sub   { font-size:.88rem; font-weight:700; color:var(--ink-md); line-height:1.65; }

/* ── Info sidebar ── */
.ci-card {
    background:#fff; border:2px solid var(--ink-lt); border-radius:24px;
    padding:28px 24px; margin-bottom:14px;
    transition:border-color .16s, box-shadow .16s;
}
.ci-card:hover { border-color:var(--orange); box-shadow:0 6px 24px rgba(255,122,47,.1); }
.ci-icon {
    width:44px; height:44px; border-radius:13px;
    background:#FFF0E6; display:flex; align-items:center;
    justify-content:center; margin-bottom:14px;
}
.ci-icon svg { width:21px; height:21px; color:var(--orange); }
.ci-title { font-family:var(--fh); font-size:1.05rem; color:var(--ink); margin-bottom:6px; }
.ci-body  { font-size:.8rem; font-weight:700; color:var(--ink-md); line-height:1.7; }
.ci-tag {
    display:inline-flex; align-items:center; gap:5px;
    background:#FFF0E6; color:var(--orange);
    border:1.5px solid rgba(255,122,47,.2);
    border-radius:999px; padding:3px 12px;
    font-size:.68rem; font-weight:900; margin-top:10px;
}

/* Hours table */
.hours-row {
    display:flex; justify-content:space-between; align-items:center;
    padding:7px 0; border-bottom:1px dashed var(--ink-lt);
    font-size:.8rem; font-weight:700;
}
.hours-row:last-child { border-bottom:none; }
.hours-day  { color:var(--ink-md); }
.hours-time { background:var(--teal-bg); color:var(--teal-dk); font-size:.72rem; font-weight:900; border-radius:6px; padding:2px 10px; }

/* Social links */
.socials-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
.social-btn {
    display:flex; align-items:center; gap:9px;
    border:1.5px solid var(--ink-lt); border-radius:13px;
    padding:11px 14px; text-decoration:none;
    font-weight:800; font-size:.78rem; color:var(--ink);
    transition:border-color .14s, background .14s, transform .12s;
}
.social-btn:hover { border-color:var(--orange); background:#FFF5EE; transform:translateY(-2px); color:var(--ink); }
.social-icon {
    width:32px; height:32px; border-radius:9px;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.social-icon svg { width:15px; height:15px; }

/* ══════════════════════════════════════
   FAQ SECTION
══════════════════════════════════════ */
.faq-section { background:#fff; padding:92px 0; border-top:1.5px solid var(--ink-lt); }
.faq-item {
    border:1.5px solid var(--ink-lt); border-radius:16px;
    margin-bottom:10px; overflow:hidden;
    transition:border-color .15s, box-shadow .15s;
}
.faq-item.open { border-color:var(--orange); box-shadow:0 4px 18px rgba(255,122,47,.1); }
.faq-q {
    display:flex; align-items:center; justify-content:space-between;
    padding:18px 22px; cursor:pointer;
    font-family:var(--fh); font-size:1rem; color:var(--ink);
    user-select:none; gap:12px;
}
.faq-q:hover { background:var(--offwhite); }
.faq-chevron {
    width:28px; height:28px; border-radius:8px;
    background:var(--offwhite); border:1.5px solid var(--ink-lt);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; transition:transform .25s, background .15s;
}
.faq-item.open .faq-chevron { transform:rotate(180deg); background:#FFF0E6; border-color:rgba(255,122,47,.2); }
.faq-chevron svg { width:14px; height:14px; color:var(--ink-md); }
.faq-item.open .faq-chevron svg { color:var(--orange); }
.faq-a {
    max-height:0; overflow:hidden;
    transition:max-height .35s cubic-bezier(.22,1,.36,1), padding .3s;
    padding:0 22px;
    font-size:.86rem; font-weight:700; color:var(--ink-md); line-height:1.75;
}
.faq-item.open .faq-a { max-height:300px; padding:0 22px 20px; }

/* ══════════════════════════════════════
   MAP PLACEHOLDER
══════════════════════════════════════ */
.map-section { background:var(--offwhite); padding:92px 0; border-top:1.5px solid var(--ink-lt); }
.map-placeholder {
    background:var(--ink); border-radius:24px; overflow:hidden;
    min-height:320px; position:relative;
    display:flex; align-items:center; justify-content:center;
}
.map-placeholder-doodle { position:absolute; opacity:.06; color:#fff; }
.map-pin-wrap {
    position:relative; z-index:2; text-align:center;
    background:rgba(255,255,255,.1); backdrop-filter:blur(14px);
    border:1.5px solid rgba(255,255,255,.15); border-radius:20px;
    padding:32px 36px;
}
.map-pin-wrap svg { width:48px; height:48px; color:var(--orange); margin-bottom:14px; }
.map-pin-wrap h3 { font-family:var(--fh); font-size:1.3rem; color:#fff; margin-bottom:6px; }
.map-pin-wrap p  { font-size:.82rem; font-weight:700; color:rgba(255,255,255,.6); margin-bottom:18px; }
.map-cta {
    display:inline-flex; align-items:center; gap:7px;
    background:var(--orange); color:#fff;
    font-family:var(--fb); font-weight:900; font-size:.84rem;
    border:none; border-radius:10px; padding:10px 22px;
    text-decoration:none; box-shadow:0 4px 16px rgba(255,122,47,.4);
    transition:transform .12s;
}
.map-cta:hover { transform:translateY(-2px); color:#fff; }

/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width:991px) {
    .channels-grid { grid-template-columns:repeat(2,1fr); }
    .channel-cell:nth-child(2) { border-right:none; }
    .cf-row { grid-template-columns:1fr; }
}
@media (max-width:767px) {
    .ct-hero { padding:56px 0 52px; }
    .ct-vis  { display:none; }
    .cf-wrap { padding:28px 20px; }
    .socials-grid { grid-template-columns:1fr; }
}
@media (max-width:575px) {
    .channels-grid { grid-template-columns:1fr 1fr; }
}
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════
     HERO
════════════════════════════════════ --}}
<section class="ct-hero">
    <div class="ct-doodle" style="top:6%;left:4%;transform:rotate(-14deg);">
        <i data-lucide="message-circle" style="width:88px;height:88px;"></i>
    </div>
    <div class="ct-doodle" style="top:18%;right:5%;transform:rotate(20deg);">
        <i data-lucide="send" style="width:108px;height:108px;"></i>
    </div>
    <div class="ct-doodle" style="bottom:8%;left:10%;transform:rotate(8deg);">
        <i data-lucide="phone" style="width:70px;height:70px;"></i>
    </div>
    <div class="ct-doodle" style="bottom:14%;right:3%;transform:rotate(-18deg);">
        <i data-lucide="mail" style="width:76px;height:76px;"></i>
    </div>
    <div class="ct-doodle" style="top:50%;left:2%;transform:rotate(6deg);">
        <i data-lucide="map-pin" style="width:58px;height:58px;"></i>
    </div>

    <div class="container position-relative" style="z-index:2;">
        <div class="row align-items-center g-5">

            <div class="col-lg-6 fade-up">
                <div class="ct-breadcrumb">
                    <a href="{{ $homeHref }}" class="ct-bc-a">
                        <i data-lucide="home" style="width:12px;height:12px;"></i> Home
                    </a>
                    <span class="ct-bc-sep">/</span>
                    <span class="ct-bc-cur">Contact</span>
                </div>

                <div class="ct-eyebrow">
                    <i data-lucide="message-circle" style="width:12px;height:12px;"></i>
                    Get In Touch
                </div>

                <h1 class="ct-headline">
                    Let's Talk<br/>
                    Craft &amp; <br/>
                    Creativity 💬
                </h1>
                <p class="ct-sub">
                    Have a custom order, bulk inquiry, or just want to say hi? We're always happy to
                    hear from you — online, on social, or in person at our studio.
                </p>

                <div class="ct-ql">
                    <a href="#contact-form" class="ct-ql-pill">
                        <div class="ct-ql-dot">
                            <i data-lucide="send" style="width:13px;height:13px;"></i>
                        </div>
                        Send a Message
                    </a>
                    <a href="#workshop" class="ct-ql-pill">
                        <div class="ct-ql-dot">
                            <i data-lucide="map-pin" style="width:13px;height:13px;"></i>
                        </div>
                        Visit the Studio
                    </a>
                    <a href="#faq" class="ct-ql-pill">
                        <div class="ct-ql-dot">
                            <i data-lucide="help-circle" style="width:13px;height:13px;"></i>
                        </div>
                        Read FAQs
                    </a>
                </div>
            </div>

            <div class="col-lg-6 fade-right">
                <div class="ct-vis">
                    <div class="ct-vis-ring">
                        <div class="ct-vis-core">
                            <i data-lucide="message-circle" style="width:40px;height:40px;color:#fff;"></i>
                            <span>Say Hello!</span>
                        </div>
                    </div>
                    <div class="ct-badge" style="top:-8px;left:-20px;">
                        <div class="ct-badge-dot" style="background:var(--pink-bg);">
                            <i data-lucide="instagram" style="width:13px;height:13px;color:var(--pink);"></i>
                        </div>
                        @artsycrate
                    </div>
                    <div class="ct-badge" style="bottom:-8px;left:10px;">
                        <div class="ct-badge-dot" style="background:var(--teal-bg);">
                            <i data-lucide="clock" style="width:13px;height:13px;color:var(--teal-dk);"></i>
                        </div>
                        Replies within 1 hr
                    </div>
                    <div class="ct-badge" style="top:60px;right:-44px;">
                        <div class="ct-badge-dot" style="background:#FFF5E0;">
                            <i data-lucide="map-pin" style="width:13px;height:13px;color:var(--orange);"></i>
                        </div>
                        Parañaque City
                    </div>
                    <div class="ct-badge" style="bottom:60px;right:-20px;">
                        <div class="ct-badge-dot" style="background:#F0EEFF;">
                            <i data-lucide="package" style="width:13px;height:13px;color:var(--purple);"></i>
                        </div>
                        Bulk Orders OK
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ════════════════════════════════════
     CHANNELS STRIP
════════════════════════════════════ --}}
<div class="channels-strip">
    <div class="container">
        <div class="channels-grid">
            <a href="https://instagram.com/artsycrate" target="_blank" rel="noopener" class="channel-cell">
                <div class="channel-icon" style="background:var(--pink-bg);">
                    <i data-lucide="instagram" style="color:var(--pink);"></i>
                </div>
                <div class="channel-label">Instagram</div>
                <div class="channel-val">@artsycrate</div>
            </a>
            <a href="https://facebook.com/artsycrate" target="_blank" rel="noopener" class="channel-cell">
                <div class="channel-icon" style="background:#EEF2FF;">
                    <i data-lucide="facebook" style="color:#3B5998;"></i>
                </div>
                <div class="channel-label">Facebook</div>
                <div class="channel-val">ArtsyCrate</div>
            </a>
            <a href="tel:+639XXXXXXXXX" class="channel-cell">
                <div class="channel-icon" style="background:var(--teal-bg);">
                    <i data-lucide="phone" style="color:var(--teal-dk);"></i>
                </div>
                <div class="channel-label">Call / Viber</div>
                <div class="channel-val">+63 9XX XXX XXXX</div>
            </a>
            <a href="mailto:hello@artsycrate.ph" class="channel-cell">
                <div class="channel-icon" style="background:#FFF0E6;">
                    <i data-lucide="mail" style="color:var(--orange);"></i>
                </div>
                <div class="channel-label">Email</div>
                <div class="channel-val">hello@artsycrate.ph</div>
            </a>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════
     CONTACT FORM + INFO
════════════════════════════════════ --}}
<section class="contact-section" id="contact-form">
    <div class="container">
        <div class="row g-4 align-items-start">

            {{-- ── FORM ── --}}
            <div class="col-lg-7 fade-left">
                <div class="cf-wrap">
                    <div class="cf-eyebrow">
                        <i data-lucide="send" style="width:11px;height:11px;"></i>
                        Send Us a Message
                    </div>
                    <div class="cf-title">We'd Love to Hear From You ✉️</div>
                    <div class="cf-sub">Fill in the form below and we'll get back to you within the day. For urgent orders, DM us on Instagram!</div>

                    {{-- Topic selector --}}
                    <div style="margin-bottom:18px;">
                        <div class="cf-label" style="margin-bottom:10px;">What's this about? <span>*</span></div>
                        <div class="cf-topics">
                            <label class="cf-topic active">
                                <input type="radio" name="topic" value="custom-order" checked/>
                                <i data-lucide="scissors" style="width:13px;height:13px;"></i> Custom Order
                            </label>
                            <label class="cf-topic">
                                <input type="radio" name="topic" value="bulk"/>
                                <i data-lucide="package" style="width:13px;height:13px;"></i> Bulk / Corporate
                            </label>
                            <label class="cf-topic">
                                <input type="radio" name="topic" value="design-help"/>
                                <i data-lucide="palette" style="width:13px;height:13px;"></i> Design Help
                            </label>
                            <label class="cf-topic">
                                <input type="radio" name="topic" value="order-status"/>
                                <i data-lucide="truck" style="width:13px;height:13px;"></i> Order Status
                            </label>
                            <label class="cf-topic">
                                <input type="radio" name="topic" value="other"/>
                                <i data-lucide="help-circle" style="width:13px;height:13px;"></i> Other
                            </label>
                        </div>
                    </div>

                    <form id="contactForm" novalidate>
                        @csrf
                        <div class="cf-row">
                            <div class="cf-group" style="margin-bottom:0;">
                                <label class="cf-label">First Name <span>*</span></label>
                                <input type="text" class="cf-input" name="first_name" placeholder="e.g. Maria" required/>
                            </div>
                            <div class="cf-group" style="margin-bottom:0;">
                                <label class="cf-label">Last Name <span>*</span></label>
                                <input type="text" class="cf-input" name="last_name" placeholder="e.g. Santos" required/>
                            </div>
                        </div>

                        <div class="cf-row">
                            <div class="cf-group" style="margin-bottom:0;">
                                <label class="cf-label">Email Address <span>*</span></label>
                                <input type="email" class="cf-input" name="email" placeholder="you@email.com" required/>
                            </div>
                            <div class="cf-group" style="margin-bottom:0;">
                                <label class="cf-label">Contact Number</label>
                                <input type="tel" class="cf-input" name="phone" placeholder="+63 9XX XXX XXXX"/>
                            </div>
                        </div>

                        <div class="cf-group">
                            <label class="cf-label">Product / Service Interested In</label>
                            <select class="cf-select" name="product">
                                <option value="">— Select one —</option>
                                <option value="custom-prints">Custom Prints (Stickers, Posters, Tarp…)</option>
                                <option value="keychain">DIY Keychain / Bag Charm</option>
                                <option value="bracelet">DIY Bracelet / Necklace</option>
                                <option value="tumbler">Tumblers &amp; Mugs</option>
                                <option value="3d">3D Printing</option>
                                <option value="gift-set">Gift Sets / Pasalubong</option>
                                <option value="bulk">Bulk / Corporate Order</option>
                                <option value="other">Something else</option>
                            </select>
                        </div>

                        <div class="cf-group">
                            <label class="cf-label">Your Message <span>*</span></label>
                            <textarea class="cf-textarea" name="message" placeholder="Tell us what you need — quantity, occasion, size, colors, deadline, anything! The more detail, the better." required></textarea>
                        </div>

                        {{-- Quantity hint --}}
                        <div style="background:var(--teal-bg);border:1.5px solid rgba(26,200,196,.2);border-radius:12px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:flex-start;gap:10px;">
                            <i data-lucide="info" style="width:16px;height:16px;color:var(--teal-dk);flex-shrink:0;margin-top:2px;"></i>
                            <p style="font-size:.78rem;font-weight:700;color:var(--teal-dk);margin:0;line-height:1.6;">
                                For <strong>bulk orders (10+ pcs)</strong> we offer special pricing. Mention your quantity in the message and we'll send you a custom quote!
                            </p>
                        </div>

                        <button type="submit" class="cf-submit">
                            <i data-lucide="send" style="width:16px;height:16px;"></i>
                            Send Message
                        </button>
                    </form>

                    {{-- Success state --}}
                    <div class="cf-success" id="cfSuccess">
                        <div class="cf-success-icon">
                            <i data-lucide="check-circle" style="width:36px;height:36px;color:var(--teal-dk);"></i>
                        </div>
                        <div class="cf-success-title">Message Sent! 🎉</div>
                        <div class="cf-success-sub">
                            Thanks for reaching out! We'll get back to you within the day.<br/>
                            For urgent inquiries, DM us on Instagram <strong>@artsycrate</strong>.
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── INFO SIDEBAR ── --}}
            <div class="col-lg-5 fade-right">

                {{-- Hours --}}
                <div class="ci-card">
                    <div class="ci-icon"><i data-lucide="clock"></i></div>
                    <div class="ci-title">Store Hours</div>
                    <div style="margin-top:10px;">
                        <div class="hours-row">
                            <span class="hours-day">Monday – Friday</span>
                            <span class="hours-time">10AM – 8PM</span>
                        </div>
                        <div class="hours-row">
                            <span class="hours-day">Saturday</span>
                            <span class="hours-time">10AM – 9PM</span>
                        </div>
                        <div class="hours-row">
                            <span class="hours-day">Sunday</span>
                            <span class="hours-time">10AM – 9PM</span>
                        </div>
                    </div>
                    <div class="ci-tag">
                        <i data-lucide="check-circle" style="width:11px;height:11px;"></i>
                        Open most holidays
                    </div>
                </div>

                {{-- Location --}}
                <div class="ci-card" id="workshop">
                    <div class="ci-icon"><i data-lucide="map-pin"></i></div>
                    <div class="ci-title">Visit the Studio</div>
                    <div class="ci-body">
                        We're based in <strong>Parañaque City, Metro Manila</strong>. Walk-ins are always welcome — no appointment needed!<br/><br/>
                        Exact address is sent when you message us, or find us on social media.
                    </div>
                    <div class="ci-tag">
                        <i data-lucide="users" style="width:11px;height:11px;"></i>
                        Walk-ins welcome daily
                    </div>
                </div>


                {{-- Socials --}}
                <div class="ci-card">
                    <div class="ci-icon" style="background:var(--pink-bg);">
                        <i data-lucide="heart" style="color:var(--pink);"></i>
                    </div>
                    <div class="ci-title">Follow &amp; Shop</div>
                    <div class="ci-body" style="margin-bottom:14px;">Stay updated on new products, promos, and behind-the-scenes content!</div>
                    <div class="socials-grid">
                        <a href="#" class="social-btn">
                            <div class="social-icon" style="background:var(--pink-bg);">
                                <i data-lucide="instagram" style="color:var(--pink);"></i>
                            </div>
                            <div>
                                <div style="font-size:.7rem;color:var(--ink-md);">Instagram</div>
                                <div>@artsycrate</div>
                            </div>
                        </a>
                        <a href="#" class="social-btn">
                            <div class="social-icon" style="background:#EEF2FF;">
                                <i data-lucide="facebook" style="color:#3B5998;"></i>
                            </div>
                            <div>
                                <div style="font-size:.7rem;color:var(--ink-md);">Facebook</div>
                                <div>ArtsyCrate</div>
                            </div>
                        </a>
                        <a href="#" class="social-btn">
                            <div class="social-icon" style="background:#FFF5E0;">
                                <i data-lucide="shopping-cart" style="color:var(--orange);"></i>
                            </div>
                            <div>
                                <div style="font-size:.7rem;color:var(--ink-md);">Shopee</div>
                                <div>ArtsyCrate</div>
                            </div>
                        </a>
                        <a href="#" class="social-btn">
                            <div class="social-icon" style="background:var(--ink);">
                                <i data-lucide="video" style="color:#fff;"></i>
                            </div>
                            <div>
                                <div style="font-size:.7rem;color:var(--ink-md);">TikTok</div>
                                <div>@artsycrate</div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════
     FAQ
════════════════════════════════════ --}}
<section class="faq-section" id="faq">
    <div class="container">

        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-6 fade-up">
                <div class="eye-row justify-content-center">
                    <span class="eye-bar"></span> Quick Answers <span class="eye-bar"></span>
                </div>
                <h2 class="sec-h">Frequently Asked <span class="tc">Questions</span> 🤔</h2>
                <p class="sec-p mx-auto">Can't find the answer? Just send us a message — we don't bite!</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8 fade-up">

                @php
                $faqs = [
                    [
                        'q' => 'How do I place a custom order?',
                        'a' => 'You can use our online Design Builder to create your keychain, bracelet, or bag charm, then submit it directly. Alternatively, fill in the contact form above or DM us on Instagram with your design ideas and we\'ll guide you from there.',
                    ],
                    [
                        'q' => 'What is your turnaround time?',
                        'a' => 'Most orders are ready within 1–3 business days. Rush same-day orders are available for an additional fee — just let us know your deadline when ordering. Bulk orders (50+ pcs) may take 3–5 business days.',
                    ],
                    [
                        'q' => 'Do you accept bulk and corporate orders?',
                        'a' => 'Absolutely! We love bulk orders for events, graduations, pasalubong, and company giveaways. Minimum is usually 10 pieces per design, and we offer discounted pricing for larger quantities. Message us for a custom quote.',
                    ],
                    [
                        'q' => 'Can I walk in without an appointment?',
                        'a' => 'Yes! Walk-ins are always welcome during store hours (10AM–9PM daily). Our in-store DIY workshop has all materials ready — just come in and start creating. No experience or booking needed.',
                    ],
                    [
                        'q' => 'Do you offer delivery?',
                        'a' => 'We offer local delivery within Metro Manila via Lalamove or Grab Express. You can also pick up your order in-store for free. Shipping to provincial areas is available via courier on a per-order basis.',
                    ],
                    [
                        'q' => 'Can I request a fully custom design I don\'t see in the builder?',
                        'a' => 'Of course! The builder covers our most popular configurations, but we handle fully custom requests all the time. Just describe or sketch your idea and send it to us — we\'ll work something out.',
                    ],
                    [
                        'q' => 'What payment methods do you accept?',
                        'a' => 'We accept GCash, Maya, bank transfer (BDO / BPI), and cash on pickup. Online orders require a 50% downpayment to confirm the order, with the balance due upon pickup or delivery.',
                    ],
                ];
                @endphp

                @foreach ($faqs as $i => $faq)
                <div class="faq-item {{ $i === 0 ? 'open' : '' }}" data-faq="{{ $i }}">
                    <div class="faq-q" onclick="toggleFaq({{ $i }})">
                        <span>{{ $faq['q'] }}</span>
                        <div class="faq-chevron">
                            <i data-lucide="chevron-down"></i>
                        </div>
                    </div>
                    <div class="faq-a">{{ $faq['a'] }}</div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════
     MAP PLACEHOLDER
════════════════════════════════════ --}}
<section class="map-section">
    <div class="container">
        <div class="row justify-content-center text-center mb-4">
            <div class="col-lg-6 fade-up">
                <div class="eye-row justify-content-center">
                    <span class="eye-bar"></span> Find Us <span class="eye-bar"></span>
                </div>
                <h2 class="sec-h">Come <span class="pc">Visit</span> Us 📍</h2>
                <p class="sec-p mx-auto">We're in Parañaque City — drop by anytime between 10AM and 9PM.</p>
            </div>
        </div>
        <div class="map-placeholder fade-up">
            <div class="map-placeholder-doodle" style="top:10%;left:5%;transform:rotate(-10deg);">
                <i data-lucide="map" style="width:200px;height:200px;"></i>
            </div>
            <div class="map-placeholder-doodle" style="bottom:8%;right:6%;transform:rotate(14deg);">
                <i data-lucide="navigation" style="width:160px;height:160px;"></i>
            </div>
            <div class="map-pin-wrap">
                <i data-lucide="map-pin"></i>
                <h3>ArtsyCrate Studio</h3>
                <p>Parañaque City, Metro Manila, Philippines<br/>Open Daily · 10AM – 9PM</p>
                <a href="https://maps.google.com" target="_blank" rel="noopener" class="map-cta">
                    <i data-lucide="external-link" style="width:14px;height:14px;"></i>
                    Open in Google Maps
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    /* ── Navbar shadow ── */
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
        }, { threshold: 0.10 });
        document.querySelectorAll('.fade-up,.fade-left,.fade-right').forEach(el => io.observe(el));
    } else {
        document.querySelectorAll('.fade-up,.fade-left,.fade-right').forEach(el => el.classList.add('vis'));
    }

    /* ── Topic chip toggle ── */
    document.querySelectorAll('.cf-topic').forEach(chip => {
        chip.addEventListener('click', () => {
            document.querySelectorAll('.cf-topic').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
        });
    });

    /* ── Contact form submit (frontend demo — wire to Laravel controller) ── */
    const form      = document.getElementById('contactForm');
    const success   = document.getElementById('cfSuccess');
    const submitBtn = form ? form.querySelector('.cf-submit') : null;

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (!form.checkValidity()) { form.reportValidity(); return; }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-lucide="loader" style="width:16px;height:16px;"></i> Sending…';
            lucide.createIcons();

            /* Simulate async — replace with fetch('/contact', { method:'POST', ... }) */
            setTimeout(() => {
                form.style.display    = 'none';
                success.style.display = 'block';
                lucide.createIcons();
            }, 1200);
        });
    }

    /* ── FAQ accordion ── */
    window.toggleFaq = function (idx) {
        const item = document.querySelector(`.faq-item[data-faq="${idx}"]`);
        if (!item) return;
        const isOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!isOpen) item.classList.add('open');
        lucide.createIcons();
    };

})();
</script>
@endpush