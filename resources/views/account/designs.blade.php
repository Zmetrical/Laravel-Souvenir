<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Saved Designs — ArtsyCrate</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { overflow-y: auto !important; height: auto !important; background: var(--offwhite); display: block !important; }

    .acc-wrap { max-width: 1000px; margin: 0 auto; padding: 36px 20px 72px; }

    .pg-back {
      display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem; font-weight: 800; color: var(--ink-md);
      text-decoration: none; margin-bottom: 16px; transition: color 0.2s;
    }
    .pg-back:hover { color: var(--pink); }
    .pg-title { font-family: var(--fh); font-size: 2.2rem; color: var(--ink); margin-bottom: 4px; letter-spacing: 1px; }
    .pg-sub { font-size: 0.95rem; font-weight: 700; color: var(--ink-md); margin-bottom: 32px; }

    /* ── Design grid ── */
    .design-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

    .design-card {
      background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 16px; overflow: hidden;
      display: flex; flex-direction: column; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .design-card:hover { border-color: var(--pink); box-shadow: 0 8px 24px rgba(255,95,160,0.1); transform: translateY(-2px); }

    .design-thumb { width: 100%; aspect-ratio: 16/9; background: var(--offwhite); object-fit: cover; display: block; border-bottom: 1.5px solid var(--grey-200); }
    .design-thumb-ph { width: 100%; aspect-ratio: 16/9; background: var(--offwhite); border-bottom: 1.5px solid var(--grey-200); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: var(--grey-300); }
    .design-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .design-name { font-size: 1rem; font-weight: 800; color: var(--ink); margin-bottom: 4px; }
    .design-meta { font-size: 0.75rem; font-weight: 700; color: var(--ink-md); text-transform: uppercase; margin-bottom: 16px; }
    .design-actions { display: flex; gap: 8px; margin-top: auto; }

    .dbtn {
      flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; border-radius: 10px; padding: 10px 12px;
      font-family: var(--fb); font-weight: 800; font-size: 0.85rem; text-decoration: none; border: none; cursor: pointer; transition: all 0.2s;
    }
    .dbtn:active { transform: scale(0.98); }
    .dbtn-primary { background: var(--teal); color: var(--white); }
    .dbtn-primary:hover { background: var(--teal-dk); color: var(--white); box-shadow: 0 4px 12px rgba(26,200,196,0.2); }
    .dbtn-ghost { background: var(--white); color: var(--ink-md); border: 1.5px solid var(--grey-200); flex: 0 0 auto; padding: 10px 14px; }
    .dbtn-ghost:hover { background: var(--pink-bg); border-color: var(--pink); color: var(--pink-dk); }

    /* ── New design card ── */
    .design-new {
      background: transparent; border: 2px dashed var(--grey-200); border-radius: 16px;
      display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; padding: 40px 20px;
      text-decoration: none; text-align: center; min-height: 220px; transition: all 0.2s;
    }
    .design-new:hover { border-color: var(--pink); background: var(--pink-bg); }
    .design-new-icon {
      width: 50px; height: 50px; border-radius: 12px; background: var(--white); border: 1.5px solid var(--grey-200);
      display: flex; align-items: center; justify-content: center; transition: all 0.2s;
    }
    .design-new:hover .design-new-icon { background: var(--pink); border-color: var(--pink); color: var(--white); }
    .design-new-lbl { font-size: 0.95rem; font-weight: 800; color: var(--ink-md); transition: all 0.2s; }
    .design-new:hover .design-new-lbl { color: var(--pink-dk); }

    /* ── Empty ── */
    .acc-empty { background: var(--white); border: 2px dashed var(--grey-200); border-radius: 16px; padding: 60px 20px; text-align: center; grid-column: 1 / -1; }
    .acc-empty-icon { font-size: 2.5rem; margin-bottom: 12px; }
    .acc-empty-msg { font-size: 0.95rem; font-weight: 700; color: var(--ink-md); margin-bottom: 20px; }
    .acc-empty-btn {
      display: inline-flex; align-items: center; gap: 8px; background: var(--pink); color: var(--white); font-weight: 800;
      font-size: 0.9rem; border: none; border-radius: 10px; padding: 12px 24px; text-decoration: none; transition: all 0.2s;
    }
    .acc-empty-btn:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,95,160,0.2); color: var(--white); }

    @media (max-width: 800px) { .design-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .design-grid { grid-template-columns: 1fr; } }
  </style>
</head>
<body>

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  <a href="{{ route('account.dashboard') }}" class="pg-back"><i data-lucide="arrow-left" style="width:16px;"></i> Back to Dashboard</a>
  <h1 class="pg-title">Saved Designs</h1>
  <p class="pg-sub">Load any saved design back into the builder to continue or place a new order.</p>

  <div class="design-grid">

    {{-- New design CTA --}}
    <a class="design-new" href="{{ route('builder.bracelet') }}">
      <div class="design-new-icon"><i data-lucide="plus" style="width: 24px; height: 24px;"></i></div>
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
            {{ ucfirst($design->product_slug) }} · {{ $design->updated_at->diffForHumans() }}
          </div>
          <div class="design-actions">
            <a class="dbtn dbtn-primary" href="{{ $design->builderUrl() }}">
              <i data-lucide="edit-3" style="width:16px;"></i> Edit
            </a>
            <form method="POST" action="{{ route('account.designs.destroy', $design) }}" onsubmit="return confirm('Delete this saved design?')">
              @csrf @method('DELETE')
              <button class="dbtn dbtn-ghost" type="submit"><i data-lucide="trash-2" style="width:16px;"></i></button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="acc-empty">
        <div class="acc-empty-icon">🎨</div>
        <div class="acc-empty-msg">No saved designs yet. Open the builder and hit Save to keep your work.</div>
        <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}">
          <i data-lucide="wand-2" style="width:16px;"></i> Open Builder
        </a>
      </div>
    @endforelse

  </div>

  @if ($designs->hasPages())
    <div style="margin-top: 32px;">
      {{ $designs->onEachSide(1)->links('pagination::simple-tailwind') }}
    </div>
  @endif

</div>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>