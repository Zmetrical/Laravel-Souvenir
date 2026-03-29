{{-- resources/views/order/confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Order Placed — ArtsyCrate</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: var(--offwhite); overflow-y: auto !important; height: auto !important; display: block !important; }
    
    .conf-page { max-width: 500px; margin: 60px auto; padding: 0 20px; text-align: center; }
    
    .success-ring {
      width: 80px; height: 80px; border-radius: 50%;
      background: var(--pink-bg); border: 3px solid var(--pink);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 24px;
      box-shadow: 0 0 0 12px rgba(255,95,160,0.1);
      animation: popIn 0.5s cubic-bezier(.22,1,.36,1) both;
    }
    .success-ring i { color: var(--pink-dk); width: 36px; height: 36px; }
    @keyframes popIn { from { transform: scale(.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    .order-code-box {
      background: #fff; border: 2px dashed var(--pink);
      border-radius: 16px; padding: 24px; margin: 32px 0;
      box-shadow: 0 8px 24px rgba(0,0,0,0.04);
    }
    .ocb-code { font-family: var(--fh); font-size: 2.2rem; color: var(--pink-dk); letter-spacing: 0.1em; }

    /* Elements Dropdown Styles */
    .elements-dropdown { background: #fff; border: 1.5px solid var(--grey-200); border-radius: 12px; margin-bottom: 24px; overflow: hidden; text-align: left; }
    .elements-dropdown summary {
      padding: 14px 16px; font-family: var(--fb); font-size: 0.9rem; font-weight: 800; color: var(--ink);
      cursor: pointer; list-style: none; display: flex; justify-content: space-between; align-items: center;
      background: var(--offwhite); transition: background 0.2s;
    }
    .elements-dropdown summary::-webkit-details-marker { display: none; }
    .elements-dropdown[open] summary { border-bottom: 1.5px solid var(--grey-200); }
    .elements-dropdown[open] summary .chevron { transform: rotate(180deg); }
    
    .elem-row { display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-bottom: 1px solid var(--grey-100); }
    .elem-row:last-child { border-bottom: none; }
    .elem-thumb {
      width: 40px; height: 40px; border-radius: 8px; background: #fff;
      border: 1.5px solid var(--grey-200); display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; overflow: hidden;
    }
    .strand-header { background: var(--grey-50); padding: 6px 16px; font-size: 0.7rem; font-weight: 900; text-transform: uppercase; color: var(--ink-md); border-bottom: 1px solid var(--grey-100); }

    .conf-btn-primary {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      background: var(--ink); color: #fff; border: none; border-radius: 12px; padding: 16px;
      font-family: var(--fh); font-size: 1.1rem; text-decoration: none; cursor: pointer;
      box-shadow: 0 8px 24px rgba(30,30,46,0.2); transition: all 0.2s; margin-bottom: 12px;
    }
    .conf-btn-primary:hover { background: #000; transform: translateY(-2px); color: #fff; }

    .conf-btn-ghost {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      background: #fff; color: var(--ink-md); border: 1.5px solid var(--grey-200); border-radius: 12px; padding: 16px;
      font-family: var(--fb); font-weight: 800; font-size: 0.95rem; text-decoration: none; transition: all 0.2s;
    }
    .conf-btn-ghost:hover { background: var(--grey-50); color: var(--ink); border-color: var(--grey-300); }
  </style>
</head>
<body>

@php
  // Extract and group the elements directly from the saved order JSON!
  $elems = json_decode($order->design_json ?? '[]', true) ?? [];
  $byStrand  = [];
  foreach ($elems as $i => $el) {
    $byStrand[$el['strand'] ?? 0][] = array_merge($el, ['_pos' => $i]);
  }
  $multiStrand = count($byStrand) > 1;
@endphp

<div class="topbar" style="padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; background: #fff; border-bottom: 1.5px solid var(--grey-200);">
  <a href="{{ route('builder.index') }}" class="logo" style="font-family: var(--fh); font-size: 1.4rem; color: var(--ink); text-decoration: none;">Artsy<b style="color: var(--pink);">Crate</b></a>
  @auth
    <a href="{{ route('account.dashboard') }}" style="display:flex; align-items:center; gap:6px; font-weight:800; color:var(--ink-md); text-decoration:none; font-size: 0.85rem;">
      <i data-lucide="user" style="width:16px;"></i> My Account
    </a>
  @endauth
</div>

<div class="conf-page">

  <div class="success-ring"><i data-lucide="check"></i></div>

  <h1 style="font-family: var(--fh); font-size: 2.2rem; color: var(--ink); margin-bottom: 8px;">Order Placed!</h1>
  <p style="font-size: 0.95rem; font-weight: 700; color: var(--ink-md); line-height: 1.6;">
    Thanks, <strong>{{ $order->first_name }}</strong>! We've received your custom order
    and will message you at <strong style="color: var(--ink);">{{ $order->contact_number }}</strong> to confirm.
  </p>

  <div class="order-code-box">
    <div style="font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 4px;">Your Tracking Code</div>
    <div class="ocb-code">{{ $order->order_code }}</div>
  </div>

  {{-- ⭐️ NEW: ELEMENTS DROPDOWN ON CONFIRMATION PAGE ⭐️ --}}
  @if(count($elems))
  <details class="elements-dropdown">
    <summary>
      <span><i data-lucide="layers" style="width: 16px; margin-right: 8px; vertical-align: text-bottom;"></i> View Design Details</span>
      <i data-lucide="chevron-down" class="chevron" style="width: 16px; transition: transform 0.2s;"></i>
    </summary>
    
    @if($order->design && $order->design->snapshot_path)
      <div style="padding: 16px; background: var(--offwhite); text-align: center; border-bottom: 1.5px solid var(--grey-200);">
        <img src="{{ Storage::url($order->design->snapshot_path) }}" alt="Design snapshot" style="max-width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1.5px solid var(--grey-200);"/>
      </div>
    @endif

    <div style="max-height: 280px; overflow-y: auto;">
      @foreach($byStrand as $strandIdx => $strandElems)
        @if($multiStrand)
          <div class="strand-header">Strand {{ $strandIdx + 1 }}</div>
        @endif
        @foreach($strandElems as $el)
          <div class="elem-row">
            <span style="font-size: 0.75rem; font-weight: 800; color: var(--ink-md); width: 18px;">{{ $el['_pos'] + 1 }}</span>
            <div class="elem-thumb">
              @if(!empty($el['useImg']) && !empty($el['imgUrl']))
                <img src="{{ $el['imgUrl'] }}" style="width:80%; height:80%; object-fit:contain;">
              @elseif(!empty($el['isLetter']))
                <div style="background:{{ $el['ltrBg'] ?? '#fff' }}; color:{{ $el['ltrText'] ?? '#000' }}; width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-weight:900; font-size:1.1rem; border-radius: {{ ($el['letterShape'] ?? 'square') === 'square' ? '6px' : '50%' }};">
                  {{ strtoupper($el['label'] ?? '') }}
                </div>
              @else
                <div style="background:{{ $el['color'] ?? '#ccc' }}; width:60%; height:60%; border-radius:50%;"></div>
              @endif
            </div>
            <div style="flex: 1;">
              <div style="font-weight: 800; font-size: 0.85rem; color: var(--ink);">{{ $el['name'] ?? 'Element' }}</div>
              <div style="font-size: 0.65rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase;">{{ $el['category'] ?? 'bead' }}</div>
            </div>
            <div style="font-weight: 800; color: var(--pink);">₱{{ $el['price'] ?? 8 }}</div>
          </div>
        @endforeach
      @endforeach
    </div>
  </details>
  @endif

  <div style="display: flex; flex-direction: column;">
    @auth
      <a href="{{ route('account.orders') }}" class="conf-btn-primary">
        Track My Order <i data-lucide="arrow-right" style="width: 18px;"></i>
      </a>
    @endauth
    <a href="{{ route('builder.index') }}" class="conf-btn-ghost">
      <i data-lucide="wand-2" style="width: 16px;"></i> Design Another Piece
    </a>
  </div>

</div>

<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>