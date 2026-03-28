@php
    $title       = 'Shop — ArtsyCrate | Custom Prints, Charms & More';
    $description = 'Browse all ArtsyCrate products — custom prints, DIY keychains & bracelets, personalized tumblers, 3D printing, and gift sets. Order online or walk in.';
    $active      = 'shop';

    /* ── Safe route helper ─────────────────────────────── */
    $builderHref = '#';
    try { $builderHref = route('builder.keychain'); } catch (\Exception $e) {}

    /* ── CATEGORIES ─────────────────────────────────────── */
    $categories = [
        'all'      => ['label' => 'All Products',    'icon' => 'grid-2x2'],
        'prints'   => ['label' => 'Custom Prints',   'icon' => 'printer'],
        'charms'   => ['label' => 'Charms & Keys',   'icon' => 'key'],
        'tumblers' => ['label' => 'Tumblers & Mugs', 'icon' => 'coffee'],
        '3d'       => ['label' => '3D Printing',     'icon' => 'box'],
        'gifts'    => ['label' => 'Gift Sets',       'icon' => 'gift'],
    ];

    /* ── PRODUCTS ─────────────────────────────────────── */
    $products = [
        /* Custom Prints */
        ['id'=>'sticker-sheet',   'name'=>'Custom Sticker Sheet',  'desc'=>'Full-color die-cut stickers on glossy or matte',         'price'=>'₱80 – ₱150',      'badge'=>'Popular', 'category'=>'prints',   'tags'=>['Stickers','Die-cut','Glossy'],      'icon'=>'star',        'iconColor'=>'var(--teal-bg)', 'iconStroke'=>'var(--teal-dk)', 'cta'=>'Order Stickers', 'ctaHref'=>$builderHref, 'inStock'=>true],
        ['id'=>'poster-print',    'name'=>'Custom Poster',         'desc'=>'Vibrant full-bleed posters, A4 to A1 sizes',             'price'=>'₱120 – ₱380',     'badge'=>'',        'category'=>'prints',   'tags'=>['Poster','Large Format'],            'icon'=>'image',       'iconColor'=>'var(--teal-bg)', 'iconStroke'=>'var(--teal-dk)', 'cta'=>'Order Poster',   'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'tarpaulin',       'name'=>'Tarpaulin / Streamer',  'desc'=>'Birthday, events, opening — any occasion',               'price'=>'₱180 – ₱450',     'badge'=>'',        'category'=>'prints',   'tags'=>['Tarpaulin','Events','Streamer'],     'icon'=>'flag',        'iconColor'=>'var(--teal-bg)', 'iconStroke'=>'var(--teal-dk)', 'cta'=>'Order Tarp',     'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'id-lace',         'name'=>'ID Lace / Lanyard',     'desc'=>'Sublimation-printed lanyards with custom logo',          'price'=>'₱55 – ₱90',       'badge'=>'New',     'category'=>'prints',   'tags'=>['Lanyard','ID Lace','Sublimation'],   'icon'=>'credit-card', 'iconColor'=>'var(--teal-bg)', 'iconStroke'=>'var(--teal-dk)', 'cta'=>'Order Lanyards', 'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'photo-print',     'name'=>'Photo Print',           'desc'=>'High-res prints on glossy or canvas paper',              'price'=>'₱60 – ₱200',      'badge'=>'',        'category'=>'prints',   'tags'=>['Photo','Canvas'],                   'icon'=>'camera',      'iconColor'=>'var(--teal-bg)', 'iconStroke'=>'var(--teal-dk)', 'cta'=>'Order Photo',    'ctaHref'=>'#',          'inStock'=>true],
        /* Charms & Keychains */
        ['id'=>'diy-keychain',    'name'=>'DIY Keychain',          'desc'=>'Build your own with beads, charms & letters',            'price'=>'₱65+',             'badge'=>'Popular', 'category'=>'charms',   'tags'=>['DIY','Keychain','Beads'],            'icon'=>'key',         'iconColor'=>'var(--pink-bg)', 'iconStroke'=>'var(--pink)',    'cta'=>'Design Now',     'ctaHref'=>$builderHref, 'inStock'=>true],
        ['id'=>'diy-bracelet',    'name'=>'DIY Bracelet',          'desc'=>'Custom bead bracelet with your choice of string',        'price'=>'₱80+',             'badge'=>'',        'category'=>'charms',   'tags'=>['DIY','Bracelet','Beads'],            'icon'=>'circle',      'iconColor'=>'var(--pink-bg)', 'iconStroke'=>'var(--pink)',    'cta'=>'Design Now',     'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'diy-necklace',    'name'=>'DIY Necklace',          'desc'=>'Charm necklace — pick your length and beads',            'price'=>'₱100+',            'badge'=>'',        'category'=>'charms',   'tags'=>['DIY','Necklace'],                   'icon'=>'heart',       'iconColor'=>'var(--pink-bg)', 'iconStroke'=>'var(--pink)',    'cta'=>'Design Now',     'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'acrylic-keychain','name'=>'Acrylic Keychain',      'desc'=>'Custom-printed acrylic charm with your design',          'price'=>'₱120 – ₱180',     'badge'=>'New',     'category'=>'charms',   'tags'=>['Acrylic','Custom Print'],            'icon'=>'sparkles',    'iconColor'=>'var(--pink-bg)', 'iconStroke'=>'var(--pink)',    'cta'=>'Order Acrylic',  'ctaHref'=>'#',          'inStock'=>true],
        /* Tumblers & Mugs */
        ['id'=>'tumbler-sub',     'name'=>'Sublimation Tumbler',   'desc'=>'Wrap-around full-color print on stainless tumbler',      'price'=>'₱350 – ₱550',     'badge'=>'Popular', 'category'=>'tumblers', 'tags'=>['Tumbler','Sublimation','Stainless'], 'icon'=>'coffee',      'iconColor'=>'#FFF5E0',        'iconStroke'=>'var(--orange)', 'cta'=>'Order Tumbler',  'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'mug-custom',      'name'=>'Custom Mug',            'desc'=>'Ceramic mug with photo or text sublimation',             'price'=>'₱180 – ₱280',     'badge'=>'',        'category'=>'tumblers', 'tags'=>['Mug','Ceramic','Photo'],             'icon'=>'cup-soda',    'iconColor'=>'#FFF5E0',        'iconStroke'=>'var(--orange)', 'cta'=>'Order Mug',      'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'bottle-custom',   'name'=>'Custom Water Bottle',   'desc'=>'Engraved or printed sports bottle',                      'price'=>'₱280 – ₱420',     'badge'=>'',        'category'=>'tumblers', 'tags'=>['Bottle','Sports','Engraved'],        'icon'=>'droplets',    'iconColor'=>'#FFF5E0',        'iconStroke'=>'var(--orange)', 'cta'=>'Order Bottle',   'ctaHref'=>'#',          'inStock'=>true],
        /* 3D Printing */
        ['id'=>'3d-figurine',     'name'=>'3D Figurine',           'desc'=>'Custom mini model of anything you can imagine',          'price'=>'₱280 – ₱680',     'badge'=>'',        'category'=>'3d',       'tags'=>['Figurine','3D Print','Custom'],      'icon'=>'box',         'iconColor'=>'#F0EEFF',        'iconStroke'=>'var(--purple)', 'cta'=>'Request Print',  'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'3d-name-stand',   'name'=>'3D Name Stand',         'desc'=>'Desk nameplate — any font, any color filament',          'price'=>'₱180 – ₱350',     'badge'=>'Popular', 'category'=>'3d',       'tags'=>['Name Stand','Desk','3D Print'],      'icon'=>'type',        'iconColor'=>'#F0EEFF',        'iconStroke'=>'var(--purple)', 'cta'=>'Request Print',  'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'3d-logo-object',  'name'=>'3D Logo Object',        'desc'=>'Your brand logo turned into a physical 3D object',       'price'=>'₱350 – ₱800',     'badge'=>'',        'category'=>'3d',       'tags'=>['Logo','Branding','3D Print'],        'icon'=>'layers',      'iconColor'=>'#F0EEFF',        'iconStroke'=>'var(--purple)', 'cta'=>'Request Print',  'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'3d-mini-model',   'name'=>'3D Mini Model',         'desc'=>'Architectural miniatures, game pieces, props',           'price'=>'₱220 – ₱580',     'badge'=>'New',     'category'=>'3d',       'tags'=>['Mini Model','Architecture'],         'icon'=>'mountain',    'iconColor'=>'#F0EEFF',        'iconStroke'=>'var(--purple)', 'cta'=>'Request Print',  'ctaHref'=>'#',          'inStock'=>false],
        /* Gift Sets */
        ['id'=>'gift-birthday',   'name'=>'Birthday Gift Set',     'desc'=>'Curated bundle — stickers, keychain & printed card',    'price'=>'₱280 – ₱450',     'badge'=>'Popular', 'category'=>'gifts',    'tags'=>['Birthday','Bundle','Gift'],          'icon'=>'gift',        'iconColor'=>'var(--lime-bg)', 'iconStroke'=>'var(--lime-dk)','cta'=>'Order Gift',     'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'gift-graduation', 'name'=>'Graduation Set',        'desc'=>'Personalized keepsake for the graduate',                 'price'=>'₱350 – ₱550',     'badge'=>'',        'category'=>'gifts',    'tags'=>['Graduation','Keepsake'],             'icon'=>'award',       'iconColor'=>'var(--lime-bg)', 'iconStroke'=>'var(--lime-dk)','cta'=>'Order Gift',     'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'gift-pasalubong', 'name'=>'Pasalubong Bundle',     'desc'=>'Cute take-home tokens for 10+ pcs minimum',             'price'=>'₱80 – ₱150 / pc', 'badge'=>'',        'category'=>'gifts',    'tags'=>['Pasalubong','Bulk','Souvenir'],      'icon'=>'package',     'iconColor'=>'var(--lime-bg)', 'iconStroke'=>'var(--lime-dk)','cta'=>'Order Bundle',   'ctaHref'=>'#',          'inStock'=>true],
        ['id'=>'gift-event',      'name'=>'Event Giveaway Pack',   'desc'=>'Branded items for corporate events or parties',          'price'=>'Request Quote',    'badge'=>'',        'category'=>'gifts',    'tags'=>['Events','Corporate','Bulk'],         'icon'=>'users',       'iconColor'=>'var(--lime-bg)', 'iconStroke'=>'var(--lime-dk)','cta'=>'Get a Quote',    'ctaHref'=>'#',          'inStock'=>true],
    ];

    $totalProducts   = count($products);
    $totalCategories = count($categories) - 1;
    $badgeClass      = ['Popular' => 'pb-pink', 'New' => 'pb-teal', 'Sale' => 'pb-lime'];
@endphp

@extends('layout.app')

{{-- ═══════════════════════════════════════
     PAGE STYLES
═══════════════════════════════════════ --}}
@push('styles')
<style>
/* ══════════════════════════════════════
   PAGE HERO
══════════════════════════════════════ */
.prod-hero {
    background: #fff;
    padding: 52px 0 44px;
    border-bottom: 1.5px solid var(--ink-lt);
}
.ph-breadcrumb { display:flex; align-items:center; gap:6px; margin-bottom:16px; }
.ph-bc-link { display:inline-flex; align-items:center; gap:4px; font-size:.75rem; font-weight:700; color:var(--ink-md); text-decoration:none; transition:color .14s; }
.ph-bc-link:hover { color:var(--teal-dk); }
.ph-bc-sep  { font-size:.75rem; color:var(--ink-lt); }
.ph-bc-cur  { font-size:.75rem; font-weight:700; color:var(--teal-dk); }
.ph-headline { font-family:var(--fh); font-size:clamp(1.9rem,3.8vw,3rem); color:var(--ink); line-height:1.1; margin-bottom:14px; }
.ph-hl-accent { color:var(--teal); }
.ph-sub { font-size:.93rem; font-weight:700; color:var(--ink-md); max-width:440px; line-height:1.7; margin-bottom:26px; }
.ph-ctas { display:flex; flex-wrap:wrap; gap:10px; }
.ph-btn-primary { display:inline-flex; align-items:center; gap:8px; background:var(--teal); color:#fff; font-family:var(--fb); font-weight:900; font-size:.88rem; border:none; border-radius:12px; padding:12px 24px; text-decoration:none; box-shadow:0 6px 20px rgba(26,200,196,.28); transition:background .14s,transform .12s,box-shadow .14s; }
.ph-btn-primary:hover { background:var(--teal-dk); transform:translateY(-2px); box-shadow:0 10px 28px rgba(26,200,196,.38); color:#fff; }
.ph-btn-ghost { display:inline-flex; align-items:center; gap:8px; background:transparent; color:var(--ink); font-family:var(--fb); font-weight:800; font-size:.88rem; border:1.5px solid var(--ink-lt); border-radius:12px; padding:11px 22px; text-decoration:none; transition:background .14s,border-color .14s; }
.ph-btn-ghost:hover { background:var(--offwhite); border-color:var(--ink-md); color:var(--ink); }
.ph-stats { display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:12px; margin-bottom:16px; }
.ph-stat { background:var(--offwhite); border:1.5px solid var(--ink-lt); border-radius:14px; padding:16px 12px; text-align:center; }
.ph-stat-num { font-family:var(--fh); font-size:1.4rem; color:var(--teal); line-height:1; margin-bottom:4px; }
.ph-stat-lbl { font-size:.68rem; font-weight:800; color:var(--ink-md); text-transform:uppercase; letter-spacing:.07em; }
.ph-tags { display:flex; flex-wrap:wrap; gap:8px; }
.ph-tag { display:inline-flex; align-items:center; gap:5px; background:var(--teal-bg); color:var(--teal-dk); border:1.5px solid rgba(26,200,196,.2); border-radius:999px; padding:4px 13px; font-size:.72rem; font-weight:800; }

/* ══════════════════════════════════════
   FILTER STRIP
══════════════════════════════════════ */
.prod-filters { background:#fff; border-bottom:1.5px solid var(--ink-lt); position:sticky; top:57px; z-index:100; padding:14px 0 10px; }
.pf-inner { display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.pf-cats { display:flex; align-items:center; gap:6px; flex-wrap:wrap; flex:1; }
.pf-cat { display:inline-flex; align-items:center; gap:6px; background:var(--offwhite); color:var(--ink-md); border:1.5px solid var(--ink-lt); border-radius:999px; padding:6px 16px; font-family:var(--fb); font-weight:800; font-size:.78rem; cursor:pointer; white-space:nowrap; transition:background .13s,border-color .13s,color .13s; }
.pf-cat:hover { background:var(--teal-bg); border-color:rgba(26,200,196,.25); color:var(--teal-dk); }
.pf-cat.active { background:var(--teal); border-color:var(--teal); color:#fff; }
.pf-right { display:flex; align-items:center; gap:8px; flex-shrink:0; }
.pf-search-wrap { position:relative; }
.pf-search-icon { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:var(--ink-md); pointer-events:none; }
.pf-search { border:1.5px solid var(--ink-lt); border-radius:10px; padding:7px 12px 7px 32px; font-family:var(--fb); font-weight:600; font-size:.8rem; background:var(--offwhite); color:var(--ink); width:200px; transition:border-color .13s,background .13s,width .2s; }
.pf-search:focus { outline:none; border-color:var(--teal); background:#fff; width:240px; }
.pf-sort { border:1.5px solid var(--ink-lt); border-radius:10px; padding:7px 12px; font-family:var(--fb); font-weight:700; font-size:.78rem; background:var(--offwhite); color:var(--ink); cursor:pointer; appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpolyline points='2,4 6,8 10,4' fill='none' stroke='%235A5470' stroke-width='1.5' stroke-linecap='round'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 10px center; padding-right:30px; transition:border-color .13s; }
.pf-sort:focus { outline:none; border-color:var(--teal); }
.pf-status { display:flex; align-items:center; gap:10px; margin-top:8px; }
.pf-count { font-size:.74rem; font-weight:700; color:var(--ink-md); }
.pf-clear { display:inline-flex; align-items:center; gap:4px; background:var(--pink-bg); color:var(--pink-dk); border:1.5px solid rgba(255,95,160,.18); border-radius:999px; padding:3px 11px; font-family:var(--fb); font-weight:800; font-size:.7rem; cursor:pointer; transition:background .13s; }
.pf-clear:hover { background:#FFD6E8; }

/* ══════════════════════════════════════
   PRODUCT GRID
══════════════════════════════════════ */
.prod-grid-wrap { background:var(--offwhite); padding:48px 0 72px; min-height:60vh; }
.prod-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:20px; }
.pcard { background:#fff; border:1.5px solid var(--ink-lt); border-radius:20px; overflow:hidden; display:flex; flex-direction:column; transition:transform .18s,box-shadow .18s,border-color .18s; }
.pcard:hover { transform:translateY(-4px); box-shadow:0 12px 36px rgba(30,30,46,.09); border-color:var(--teal); }
.pcard.pcard-out { opacity:.65; }
.pcard.pcard-hidden { display:none; }
.pcard-vis { position:relative; height:148px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pcard-icon { width:56px!important; height:56px!important; opacity:.55; }
.pcard-badge { position:absolute; top:12px; right:12px; font-size:.62rem; font-weight:900; letter-spacing:.08em; text-transform:uppercase; padding:3px 10px; border-radius:999px; }
.pb-pink { background:var(--pink-bg); color:var(--pink-dk); border:1.5px solid rgba(255,95,160,.2); }
.pb-teal { background:var(--teal-bg); color:var(--teal-dk); border:1.5px solid rgba(26,200,196,.2); }
.pb-lime { background:var(--lime-bg); color:var(--lime-dk); border:1.5px solid rgba(140,180,0,.2); }
.pcard-out-overlay { position:absolute; inset:0; background:rgba(255,255,255,.72); display:flex; align-items:center; justify-content:center; }
.pcard-out-overlay span { background:var(--ink); color:#fff; font-size:.7rem; font-weight:900; letter-spacing:.1em; text-transform:uppercase; padding:5px 14px; border-radius:999px; }
.pcard-body { padding:18px 18px 12px; flex:1; }
.pcard-cat { font-size:.62rem; font-weight:900; letter-spacing:.1em; text-transform:uppercase; color:var(--teal-dk); margin-bottom:6px; }
.pcard-name { font-family:var(--fh); font-size:1.05rem; color:var(--ink); margin-bottom:6px; line-height:1.2; }
.pcard-desc { font-size:.78rem; font-weight:700; color:var(--ink-md); line-height:1.6; margin-bottom:12px; }
.pcard-tags { display:flex; flex-wrap:wrap; gap:5px; }
.pcard-tag { font-size:.62rem; font-weight:800; background:var(--offwhite); color:var(--ink-md); border:1px solid var(--ink-lt); border-radius:5px; padding:2px 8px; }
.pcard-foot { padding:12px 18px 16px; display:flex; align-items:center; justify-content:space-between; border-top:1px solid var(--ink-lt); gap:8px; }
.pcard-price { font-family:var(--fh); font-size:1rem; color:var(--pink-dk); white-space:nowrap; }
.pcard-btn { display:inline-flex; align-items:center; gap:6px; background:var(--teal); color:#fff; font-family:var(--fb); font-weight:900; font-size:.75rem; border:none; border-radius:9px; padding:8px 14px; text-decoration:none; white-space:nowrap; cursor:pointer; transition:background .13s,transform .12s; }
.pcard-btn:hover { background:var(--teal-dk); transform:translateY(-1px); color:#fff; }
.pcard-btn-disabled { background:var(--ink-lt); color:var(--ink-md); cursor:not-allowed; }
.pcard-btn-disabled:hover { background:var(--ink-lt); transform:none; }
.prod-empty { text-align:center; padding:80px 20px; }
.pe-icon { width:72px; height:72px; background:var(--offwhite); border:1.5px solid var(--ink-lt); border-radius:20px; display:flex; align-items:center; justify-content:center; margin:0 auto 18px; color:var(--ink-md); }
.pe-title { font-family:var(--fh); font-size:1.4rem; color:var(--ink); margin-bottom:8px; }
.pe-sub { font-size:.88rem; font-weight:700; color:var(--ink-md); margin-bottom:22px; }
.pe-reset { display:inline-flex; align-items:center; gap:7px; background:var(--teal); color:#fff; font-family:var(--fb); font-weight:900; font-size:.86rem; border:none; border-radius:12px; padding:11px 24px; cursor:pointer; transition:background .13s; }
.pe-reset:hover { background:var(--teal-dk); }

/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width:991px) {
    .ph-stats { grid-template-columns:1fr 1fr; }
    .pf-inner { flex-direction:column; align-items:stretch; }
    .pf-right { width:100%; }
    .pf-search { width:100%; }
    .pf-search:focus { width:100%; }
    .pf-sort { flex:1; }
}
@media (max-width:575px) {
    .prod-grid { grid-template-columns:1fr 1fr; gap:12px; }
    .pcard-vis { height:110px; }
    .pcard-icon { width:40px!important; height:40px!important; }
    .pcard-name { font-size:.9rem; }
    .ph-stats { grid-template-columns:1fr 1fr; }
}
@media (max-width:400px) {
    .prod-grid { grid-template-columns:1fr; }
}
</style>
@endpush

{{-- ═══════════════════════════════════════
     SECTION: CONTENT
═══════════════════════════════════════ --}}
@section('content')

{{-- ═══════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════ --}}
<div class="prod-hero">
    <div class="container">
        <div class="row align-items-center g-4">

            <div class="col-lg-7">
                <div class="ph-breadcrumb">
                    <a href="{{ route('home') }}" class="ph-bc-link">
                        <i data-lucide="home" style="width:12px;height:12px;"></i> Home
                    </a>
                    <span class="ph-bc-sep">/</span>
                    <span class="ph-bc-cur">Shop</span>
                </div>
                <h1 class="ph-headline">
                    Everything You Can<br/>
                    <span class="ph-hl-accent">Create</span> With Us ✨
                </h1>
                <p class="ph-sub">
                    Browse our full collection — from custom prints to handmade charms.
                    Order online or walk in and make it yourself.
                </p>
                <div class="ph-ctas">
                    <a href="{{ $builderHref }}" class="ph-btn-primary">
                        <i data-lucide="scissors" style="width:15px;height:15px;"></i>
                        Start Designing
                    </a>
                    <a href="#prod-grid" class="ph-btn-ghost">
                        <i data-lucide="arrow-down" style="width:15px;height:15px;"></i>
                        Browse All
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="ph-stats">
                    <div class="ph-stat">
                        <div class="ph-stat-num">{{ $totalProducts }}+</div>
                        <div class="ph-stat-lbl">Products</div>
                    </div>
                    <div class="ph-stat">
                        <div class="ph-stat-num">{{ $totalCategories }}</div>
                        <div class="ph-stat-lbl">Categories</div>
                    </div>
                    <div class="ph-stat">
                        <div class="ph-stat-num">1 day</div>
                        <div class="ph-stat-lbl">Turnaround</div>
                    </div>
                    <div class="ph-stat">
                        <div class="ph-stat-num">₱55+</div>
                        <div class="ph-stat-lbl">Starting price</div>
                    </div>
                </div>
                <div class="ph-tags">
                    <span class="ph-tag">
                        <i data-lucide="map-pin" style="width:11px;height:11px;"></i>
                        Walk-in welcome
                    </span>
                    <span class="ph-tag">
                        <i data-lucide="package" style="width:11px;height:11px;"></i>
                        Bulk orders OK
                    </span>
                    <span class="ph-tag">
                        <i data-lucide="zap" style="width:11px;height:11px;"></i>
                        Same-day rush
                    </span>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
     FILTER STRIP
═══════════════════════════════════════ --}}
<div class="prod-filters" id="prod-filters">
    <div class="container">
        <div class="pf-inner">

            <div class="pf-cats" id="pfCats" role="tablist">
                @foreach ($categories as $key => $cat)
                <button
                    class="pf-cat {{ $key === 'all' ? 'active' : '' }}"
                    data-cat="{{ $key }}"
                    role="tab"
                    aria-selected="{{ $key === 'all' ? 'true' : 'false' }}">
                    <i data-lucide="{{ $cat['icon'] }}" style="width:13px;height:13px;"></i>
                    {{ $cat['label'] }}
                </button>
                @endforeach
            </div>

            <div class="pf-right">
                <div class="pf-search-wrap">
                    <i data-lucide="search" class="pf-search-icon" style="width:14px;height:14px;"></i>
                    <input type="search" class="pf-search" id="pfSearch"
                           placeholder="Search products..." autocomplete="off" aria-label="Search products"/>
                </div>
                <select class="pf-sort" id="pfSort" aria-label="Sort by">
                    <option value="default">Featured</option>
                    <option value="price-asc">Price: Low → High</option>
                    <option value="price-desc">Price: High → Low</option>
                    <option value="name-asc">Name: A → Z</option>
                </select>
            </div>

        </div>
        <div class="pf-status">
            <span id="pfCount" class="pf-count">Showing all products</span>
            <button class="pf-clear" id="pfClear" style="display:none;">
                <i data-lucide="x" style="width:11px;height:11px;"></i> Clear
            </button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════
     PRODUCT GRID
═══════════════════════════════════════ --}}
<div class="prod-grid-wrap" id="prod-grid">
    <div class="container">

        <div class="prod-grid" id="prodGrid">
            @foreach ($products as $p)
            @php
                preg_match('/\d+/', str_replace(['₱',',',' '], '', $p['price']), $m);
                $priceRaw = $m[0] ?? 0;
            @endphp
            <div class="pcard {{ !$p['inStock'] ? 'pcard-out' : '' }}"
                 data-cat="{{ $p['category'] }}"
                 data-name="{{ strtolower($p['name'] . ' ' . implode(' ', $p['tags'])) }}"
                 data-price-raw="{{ $priceRaw }}">

                <div class="pcard-vis" style="background:{{ $p['iconColor'] }};">
                    <i data-lucide="{{ $p['icon'] }}" class="pcard-icon" style="color:{{ $p['iconStroke'] }};"></i>
                    @if (!empty($p['badge']))
                    <span class="pcard-badge {{ $badgeClass[$p['badge']] ?? 'pb-teal' }}">{{ $p['badge'] }}</span>
                    @endif
                    @if (!$p['inStock'])
                    <div class="pcard-out-overlay"><span>Out of Stock</span></div>
                    @endif
                </div>

                <div class="pcard-body">
                    <div class="pcard-cat">{{ $categories[$p['category']]['label'] ?? $p['category'] }}</div>
                    <h3 class="pcard-name">{{ $p['name'] }}</h3>
                    <p class="pcard-desc">{{ $p['desc'] }}</p>
                    <div class="pcard-tags">
                        @foreach (array_slice($p['tags'], 0, 3) as $tag)
                        <span class="pcard-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="pcard-foot">
                    <div class="pcard-price">{{ $p['price'] }}</div>
                    @if ($p['inStock'])
                    <a href="{{ $p['ctaHref'] }}" class="pcard-btn">
                        {{ $p['cta'] }} <i data-lucide="arrow-right" style="width:13px;height:13px;"></i>
                    </a>
                    @else
                    <button class="pcard-btn pcard-btn-disabled" disabled>Unavailable</button>
                    @endif
                </div>

            </div>
            @endforeach
        </div>

        <div class="prod-empty" id="prodEmpty" style="display:none;">
            <div class="pe-icon">
                <i data-lucide="search-x" style="width:40px;height:40px;"></i>
            </div>
            <div class="pe-title">No products found</div>
            <div class="pe-sub">Try a different category or search term</div>
            <button class="pe-reset" onclick="resetFilters()">
                <i data-lucide="rotate-ccw" style="width:14px;height:14px;"></i>
                Show all products
            </button>
        </div>

    </div>
</div>

@endsection

{{-- ═══════════════════════════════════════
     PUSH: PAGE JAVASCRIPT
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
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up,.fade-left,.fade-right').forEach(el => io.observe(el));
    } else {
        document.querySelectorAll('.fade-up,.fade-left,.fade-right').forEach(el => el.classList.add('vis'));
    }

    /* ── Filter / Search / Sort ── */
    const grid    = document.getElementById('prodGrid');
    const empty   = document.getElementById('prodEmpty');
    const catBtns = document.querySelectorAll('.pf-cat');
    const search  = document.getElementById('pfSearch');
    const sort    = document.getElementById('pfSort');
    const count   = document.getElementById('pfCount');
    const clear   = document.getElementById('pfClear');
    const cards   = Array.from(document.querySelectorAll('.pcard'));

    let activeCat = 'all', searchTerm = '', sortMode = 'default';

    function applyFilters() {
        let visible = cards.filter(card => {
            const catOk  = activeCat === 'all' || card.dataset.cat === activeCat;
            const termOk = !searchTerm || card.dataset.name.includes(searchTerm);
            return catOk && termOk;
        });

        if (sortMode === 'name-asc')   visible.sort((a,b) => a.dataset.name.localeCompare(b.dataset.name));
        if (sortMode === 'price-asc')  visible.sort((a,b) => +a.dataset.priceRaw - +b.dataset.priceRaw);
        if (sortMode === 'price-desc') visible.sort((a,b) => +b.dataset.priceRaw - +a.dataset.priceRaw);

        const vis = new Set(visible);
        cards.forEach(c => c.classList.toggle('pcard-hidden', !vis.has(c)));
        visible.forEach(c => grid.appendChild(c));

        const n = visible.length;
        count.textContent = n === cards.length ? `Showing all ${n} products` : `${n} product${n!==1?'s':''} found`;
        empty.style.display = n === 0 ? 'block' : 'none';
        grid.style.display  = n === 0 ? 'none'  : '';
        clear.style.display = (activeCat !== 'all' || searchTerm) ? '' : 'none';
    }

    catBtns.forEach(btn => btn.addEventListener('click', () => {
        activeCat = btn.dataset.cat;
        catBtns.forEach(b => { b.classList.toggle('active', b===btn); b.setAttribute('aria-selected', b===btn?'true':'false'); });
        applyFilters();
        if (window.innerWidth < 768) document.getElementById('prod-grid')?.scrollIntoView({behavior:'smooth',block:'start'});
    }));

    let st;
    search.addEventListener('input', () => { clearTimeout(st); st = setTimeout(() => { searchTerm = search.value.toLowerCase().trim(); applyFilters(); }, 180); });
    sort.addEventListener('change', () => { sortMode = sort.value; applyFilters(); });
    clear.addEventListener('click', resetFilters);

    window.resetFilters = function () {
        activeCat = 'all'; searchTerm = ''; sortMode = 'default';
        search.value = ''; sort.value = 'default';
        catBtns.forEach(b => { b.classList.toggle('active', b.dataset.cat==='all'); b.setAttribute('aria-selected', b.dataset.cat==='all'?'true':'false'); });
        applyFilters();
    };

    /* ── URL hash → auto-select category ── */
    function checkHash() {
        const hash = window.location.hash.replace('#','').toLowerCase();
        if (hash && hash !== 'all') {
            const btn = Array.from(catBtns).find(b => b.dataset.cat === hash);
            if (btn) btn.click();
        }
    }
    window.addEventListener('hashchange', checkHash);
    checkHash();

    applyFilters();
})();
</script>
@endpush