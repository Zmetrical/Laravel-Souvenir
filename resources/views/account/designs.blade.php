<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Saved Designs — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>
  <style>
    .acc-wrap  { max-width: 1000px; margin: 0 auto; padding: 36px 20px 72px; }
    .pg-head   { margin-bottom: 28px; }
    .pg-title  { font-family: var(--fh); font-size: 1.7rem; color: var(--ink); margin-bottom: 4px; }
    .pg-sub    { font-size: .85rem; font-weight: 700; color: var(--ink-md); }

    /* design grid */
    .design-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
    }
    .design-card {
      background: var(--white);
      border: 1.5px solid var(--ink-lt);
      border-radius: 16px;
      overflow: hidden;
      display: flex; flex-direction: column;
      transition: border-color .13s, box-shadow .13s, transform .12s;
    }
    .design-card:hover {
      border-color: var(--pink);
      box-shadow: 0 6px 20px rgba(255,95,160,.12);
      transform: translateY(-2px);
    }
    .design-thumb {
      width: 100%; aspect-ratio: 16/9;
      background: var(--offwhite); object-fit: cover; display: block;
    }
    .design-thumb-ph {
      width: 100%; aspect-ratio: 16/9;
      background: var(--offwhite);
      display: flex; align-items: center; justify-content: center;
      font-size: 2rem;
    }
    .design-body { padding: 12px 14px; flex: 1; display: flex; flex-direction: column; }
    .design-name { font-size: .88rem; font-weight: 900; color: var(--ink); margin-bottom: 3px; }
    .design-meta { font-size: .72rem; font-weight: 700; color: var(--ink-md); margin-bottom: 12px; }
    .design-actions { display: flex; gap: 8px; margin-top: auto; }
    .dbtn {
      flex: 1; display: flex; align-items: center; justify-content: center; gap: 5px;
      border-radius: 9px; padding: 7px 10px;
      font-family: var(--fb); font-weight: 800; font-size: .75rem;
      text-decoration: none; border: none; cursor: pointer;
      transition: background .12s, transform .1s;
    }
    .dbtn:active { transform: scale(.97); }
    .dbtn-primary { background: var(--pink); color: #fff; }
    .dbtn-primary:hover { background: var(--pink-dk); }
    .dbtn-ghost  { background: var(--offwhite); color: var(--ink-md); border: 1.5px solid var(--ink-lt); }
    .dbtn-ghost:hover  { background: var(--ink-lt); }

    /* new design CTA card */
    .design-new {
      background: transparent;
      border: 2px dashed var(--ink-lt);
      border-radius: 16px;
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      gap: 10px; padding: 32px 20px;
      text-decoration: none; text-align: center;
      transition: border-color .13s, background .13s;
      min-height: 180px;
    }
    .design-new:hover { border-color: var(--teal); background: var(--teal-bg); }
    .design-new-icon { font-size: 1.8rem; }
    .design-new-lbl  { font-size: .82rem; font-weight: 800; color: var(--ink-md); }

    .acc-empty {
      background: var(--white); border: 1.5px dashed var(--ink-lt);
      border-radius: 14px; padding: 60px 20px; text-align: center;
      grid-column: 1 / -1;
    }
    .acc-empty-icon { font-size: 2.2rem; margin-bottom: 10px; }
    .acc-empty-msg  { font-size: .9rem; font-weight: 700; color: var(--ink-md); margin-bottom: 16px; }
    .acc-empty-btn  {
      display: inline-flex; align-items: center; gap: 7px;
      background: var(--teal); color: var(--white);
      font-family: var(--fb); font-weight: 900; font-size: .85rem;
      border: none; border-radius: 10px; padding: 10px 22px; text-decoration: none;
    }

    /* pagination */
    .pg-links { display:flex;justify-content:center;gap:6px;margin-top:28px; }
    .pg-links a, .pg-links span {
      display:inline-flex;align-items:center;justify-content:center;
      min-width:36px;height:36px;border-radius:8px;
      font-size:.78rem;font-weight:800;text-decoration:none;
      border:1.5px solid var(--ink-lt);color:var(--ink-md);padding:0 10px;
    }
    .pg-links a:hover  { border-color:var(--teal);color:var(--teal-dk);background:var(--teal-bg); }
    .pg-links span[aria-current] { background:var(--teal);border-color:var(--teal);color:#fff; }

    @media (max-width: 700px) {
      .design-grid { grid-template-columns: repeat(2,1fr); }
    }
    @media (max-width: 480px) {
      .design-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body style="background:var(--offwhite,#F7F7FC);">

@include('builder.includes.topbar', ['activePage' => ''])

<div class="acc-wrap">

  <div class="pg-head">
    <a href="{{ route('account.dashboard') }}"
       style="font-size:.78rem;font-weight:800;color:var(--ink-md);
              text-decoration:none;display:inline-flex;align-items:center;gap:5px;margin-bottom:12px;">
      ← Back to Dashboard
    </a>
    <h1 class="pg-title">Saved Designs</h1>
    <p class="pg-sub">Load any saved design back into the builder to continue or place a new order.</p>
  </div>

  <div class="design-grid">

    {{-- New design CTA --}}
    <a class="design-new" href="{{ route('builder.keychain') }}">
      <div class="design-new-icon">＋</div>
      <div class="design-new-lbl">Start a new design</div>
    </a>

    @forelse ($designs as $design)
      <div class="design-card">
        @if ($design->snapshotUrl())
          <img class="design-thumb"
               src="{{ $design->snapshotUrl() }}"
               alt="{{ $design->name }}"/>
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
              Edit Design
            </a>
            <form method="POST"
                  action="{{ route('account.designs.destroy', $design) }}"
                  onsubmit="return confirm('Delete this saved design?')">
              @csrf @method('DELETE')
              <button class="dbtn dbtn-ghost" type="submit">Delete</button>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="acc-empty">
        <div class="acc-empty-icon">🎨</div>
        <div class="acc-empty-msg">
          No saved designs yet. Open the builder and hit Save to keep your work.
        </div>
        <a class="acc-empty-btn" href="{{ route('builder.bracelet') }}">
          Open Builder →
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

</body>
</html>