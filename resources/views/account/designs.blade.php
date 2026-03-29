<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Saved Designs — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    body { overflow: auto !important; height: auto !important; background: var(--grey-50); display: block !important; }

    .acc-wrap { max-width: 1000px; margin: 0 auto; padding: 36px 20px 72px; }

    .pg-back {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: .76rem; font-weight: 800; color: var(--ink2);
      text-decoration: none; margin-bottom: 14px;
      transition: color .13s;
    }
    .pg-back:hover { color: var(--pink); }
    .pg-back i[data-lucide] { width: 12px; height: 12px; }
    .pg-title { font-family: var(--fh); font-size: 1.55rem; font-weight: 800; color: var(--ink); margin-bottom: 4px; letter-spacing: -.025em; }
    .pg-sub { font-size: .82rem; font-weight: 600; color: var(--ink2); margin-bottom: 28px; }

    /* ── Design grid ── */
    .design-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }

    .design-card {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-md); overflow: hidden;
      display: flex; flex-direction: column;
      transition: border-color .14s, box-shadow .14s, transform .12s;
    }
    .design-card:hover { border-color: var(--pink-bd); box-shadow: var(--sh-md); transform: translateY(-2px); }

    .design-thumb { width: 100%; aspect-ratio: 16/9; background: var(--grey-50); object-fit: cover; display: block; }
    .design-thumb-ph {
      width: 100%; aspect-ratio: 16/9; background: var(--grey-50);
      display: flex; align-items: center; justify-content: center; font-size: 2rem;
    }
    .design-body { padding: 13px 14px; flex: 1; display: flex; flex-direction: column; }
    .design-name { font-size: .86rem; font-weight: 800; color: var(--ink); margin-bottom: 3px; }
    .design-meta { font-size: .7rem; font-weight: 600; color: var(--ink3); margin-bottom: 13px; }
    .design-actions { display: flex; gap: 7px; margin-top: auto; }

    .dbtn {
      flex: 1; display: flex; align-items: center; justify-content: center; gap: 5px;
      border-radius: var(--r-sm); padding: 8px 10px;
      font-family: var(--fb); font-weight: 800; font-size: .74rem;
      text-decoration: none; border: none; cursor: pointer;
      transition: background .12s, transform .1s;
    }
    .dbtn:active { transform: scale(.97); }
    .dbtn i[data-lucide] { width: 12px; height: 12px; }
    .dbtn-primary { background: var(--pink); color: var(--white); }
    .dbtn-primary:hover { background: var(--pink-dk); color: var(--white); }
    .dbtn-ghost { background: var(--grey-50); color: var(--ink2); border: 1.5px solid var(--grey-200); }
    .dbtn-ghost:hover { background: var(--grey-100); }

    /* ── New design card ── */
    .design-new {
      background: transparent; border: 2px dashed var(--grey-200);
      border-radius: var(--r-md);
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: 10px; padding: 36px 20px; text-decoration: none; text-align: center;
      min-height: 180px;
      transition: border-color .13s, background .13s;
    }
    .design-new:hover { border-color: var(--teal); background: var(--teal-lt); }
    .design-new-icon {
      width: 42px; height: 42px; border-radius: var(--r-sm);
      background: var(--grey-50); border: 1.5px solid var(--grey-200);
      display: flex; align-items: center; justify-content: center;
      transition: background .13s, border-color .13s;
    }
    .design-new-icon i[data-lucide] { width: 18px; height: 18px; color: var(--ink3); }
    .design-new:hover .design-new-icon { background: var(--white); border-color: var(--teal-bd); }
    .design-new:hover .design-new-icon i[data-lucide] { color: var(--teal-dk); }
    .design-new-lbl { font-size: .8rem; font-weight: 800; color: var(--ink2); }
    .design-new:hover .design-new-lbl { color: var(--teal-dk); }

    /* ── Empty ── */
    .acc-empty {
      background: var(--white); border: 1.5px dashed var(--grey-200);
      border-radius: var(--r-md); padding: 60px 20px; text-align: center;
      grid-column: 1 / -1;
    }
    .acc-empty-icon { font-size: 2.2rem; margin-bottom: 11px; }
    .acc-empty-msg { font-size: .88rem; font-weight: 700; color: var(--ink2); margin-bottom: 18px; }
    .acc-empty-btn {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--teal); color: var(--white);
      font-weight: 800; font-size: .84rem;
      border: none; border-radius: var(--r-sm); padding: 10px 22px; text-decoration: none;
    }
    .acc-empty-btn:hover { background: var(--teal-dk); color: var(--white); }

    /* ── Pagination ── */
    .pg-links { display: flex; justify-content: center; gap: 6px; margin-top: 28px; }
    .pg-links a, .pg-links span {
      display: inline-flex; align-items: center; justify-content: center;
      min-width: 36px; height: 36px; border-radius: var(--r-sm);
      font-size: .76rem; font-weight: 800; text-decoration: none;
      border: 1.5px solid var(--grey-200); color: var(--ink2); padding: 0 10px;
    }
    .pg-links a:hover { border-color: var(--teal); color: var(--teal-dk); background: var(--teal-lt); }
    .pg-links span[aria-current] { background: var(--teal); border-color: var(--teal); color: var(--white); }

    @media (max-width: 700px) { .design-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 440px) { .design-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body>

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  <a href="{{ route('account.dashboard') }}" class="pg-back">
    <i data-lucide="arrow-left"></i> Back to Dashboard
  </a>
  <h1 class="pg-title">Saved Designs</h1>
  <p class="pg-sub">Load any saved design back into the builder to continue or place a new order.</p>

  <div class="design-grid">

    {{-- New design CTA --}}
    <a class="design-new" href="{{ route('builder.keychain') }}">
      <div class="design-new-icon"><i data-lucide="plus"></i></div>
      <div class="design-new-lbl">Start a new design</div>
    </a>

    @forelse ($designs as $design)
      <div class="design-card">
        @if ($design->snapshotUrl())
          <img class="design-thumb" src="{{ $design->snapshotUrl() }}" alt="{{ $design->name }}"/>
        @else
          <div class="design-thumb-ph">✽</div>
        @endif
        <div class="design-body">
          <div class="design-name">{{ $design->name }}</div>
          <div class="design-meta">
            {{ ucfirst($design->product_slug) }}
            · {{ $design->updated_at->diffForHumans() }}
          </div>
          <div class="design-actions">
            <a class="dbtn dbtn-primary" href="{{ $design->builderUrl() }}">
              <i data-lucide="edit-3"></i> Edit
            </a>
            <form method="POST"
                  action="{{ route('account.designs.destroy', $design) }}"
                  onsubmit="return confirm('Delete this saved design?')">
              @csrf @method('DELETE')
              <button class="dbtn dbtn-ghost" type="submit">
                <i data-lucide="trash-2"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="acc-empty">
        <div class="acc-empty-icon">🎨</div>
        <div class="acc-empty-msg">No saved designs yet. Open the builder and hit Save to keep your work.</div>
        <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}">
          <i data-lucide="wand-2" style="width:14px;height:14px;"></i>
          Open Builder
        </a>
      </div>
    @endforelse

  </div>

  @if ($designs->hasPages())
    <div class="pg-links">
      {{ $designs->onEachSide(1)->links('pagination::simple-tailwind') }}
    </div>
  @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>