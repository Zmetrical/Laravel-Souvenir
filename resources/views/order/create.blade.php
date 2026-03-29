{{-- resources/views/order/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Place Your Order</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    /* 👇 THIS FIXES THE OVERLAPPING INPUTS! 👇 */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    
    body { overflow-y: auto !important; height: auto !important; display: block !important; }
    
    .page-wrapper { max-width: 1000px; margin: 0 auto; padding: 40px 20px 80px; }
    
    .checkout-card {
      background: #fff; border: 1.5px solid var(--grey-200);
      border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);
      overflow: hidden; margin-bottom: 24px;
    }
    .checkout-head {
      padding: 16px 20px; border-bottom: 1.5px solid var(--grey-200);
      font-family: var(--fh); font-size: 1.1rem; display: flex; align-items: center; gap: 10px;
    }
    
    .snapshot-box { background: var(--offwhite); border: 1.5px solid var(--grey-200); border-radius: 12px; padding: 12px; text-align: center; margin-bottom: 20px; }
    .snapshot-box img { width: 100%; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    
    /* Elements Dropdown Styles */
    .elements-dropdown { background: #fff; border: 1.5px solid var(--grey-200); border-radius: 12px; margin-top: 16px; overflow: hidden; }
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

    /* Inputs */
    .form-group { margin-bottom: 16px; width: 100%; }
    .form-label { display: block; font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .form-label span.req { color: var(--pink); }
    .form-control {
      width: 100%; padding: 12px 16px; border: 1.5px solid var(--grey-200);
      border-radius: 10px; font-family: var(--fb); font-size: 0.9rem; font-weight: 700;
      color: var(--ink); background: var(--offwhite); transition: all 0.2s;
    }
    .form-control:focus { outline: none; border-color: var(--pink); background: #fff; box-shadow: 0 0 0 4px var(--pink-bg); }
    
    .btn-submit {
      width: 100%; padding: 16px; background: var(--pink); color: #fff;
      border: none; border-radius: 12px; font-family: var(--fh); font-size: 1.1rem;
      cursor: pointer; box-shadow: 0 8px 24px rgba(255,95,160,0.25);
      transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn-submit:hover { background: var(--pink-dk); transform: translateY(-2px); box-shadow: 0 12px 32px rgba(255,95,160,0.35); }
  </style>
</head>
<body>

@php
  $snap      = session('order_snapshot');
  $elems     = session('order_design') ? json_decode(session('order_design'), true) : [];
  $slug      = session('order_product_slug', 'bracelet');
  
  $productLabel = match($slug) {
    'bracelet' => 'Bracelet',
    'necklace' => 'Necklace',
    'keychain' => 'Keychain / Bag Charm',
    default    => ucfirst($slug),
  };

  // Group elements by strand
  $byStrand  = [];
  $elemsCost = 0;
  foreach ($elems as $i => $el) {
    $byStrand[$el['strand'] ?? 0][] = array_merge($el, ['_pos' => $i]);
    $elemsCost += $el['price'] ?? 8;
  }
  $multiStrand = count($byStrand) > 1;
  $total = ($product->base_price ?? 0) + $elemsCost;
@endphp

<div class="topbar" style="padding: 0 24px; height: 64px; display: flex; align-items: center; justify-content: space-between; background: #fff; border-bottom: 1.5px solid var(--grey-200);">
  <a href="{{ route('builder.index') }}" class="logo" style="font-family: var(--fh); font-size: 1.4rem; color: var(--ink); text-decoration: none;">Artsy<b style="color: var(--pink);">Crate</b></a>
  <a href="{{ url()->previous() }}" class="btn btn-sm font-weight-bold" style="border: 1.5px solid var(--grey-200); border-radius: 999px; padding: 6px 16px; color: var(--ink-md); text-decoration: none; font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
    <i data-lucide="arrow-left" style="width: 14px;"></i> Back to Builder
  </a>
</div>

<div class="page-wrapper">
  <div style="text-align: center; margin-bottom: 40px;">
    <h1 style="font-family: var(--fh); font-size: 2.5rem; color: var(--ink); margin-bottom: 8px;">Checkout</h1>
    <p style="color: var(--ink-md); font-weight: 700;">Review your design and fill in your details.</p>
  </div>

  <form method="POST" action="{{ route('builder.order.store') }}" id="order-form" novalidate>
    @csrf

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px;">
      
      {{-- LEFT COLUMN: Design Summary --}}
      <div>
        <div class="checkout-card">
          <div class="checkout-head" style="color: var(--teal-dk);">
            <i data-lucide="image" style="color: var(--teal);"></i> Your Design
          </div>
          <div style="padding: 20px;">
            <div class="snapshot-box">
              @if($snap) <img src="{{ $snap }}" alt="Design snapshot"/> @endif
            </div>

            <div style="background: var(--offwhite); border-radius: 12px; padding: 16px; border: 1.5px solid var(--grey-200);">
              <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 700; color: var(--ink-md);">
                <span>{{ $productLabel }} Base</span>
                <span>₱{{ $product->base_price ?? 0 }}</span>
              </div>
              <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-weight: 700; color: var(--ink-md);">
                <span>Elements ({{ count($elems) }})</span>
                <span>₱{{ $elemsCost }}</span>
              </div>
              <div style="height: 1.5px; background: var(--grey-200); margin: 12px 0;"></div>
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-family: var(--fh); font-size: 1.1rem; color: var(--ink);">Total Estimate</span>
                <span style="font-family: var(--fh); font-size: 1.4rem; color: var(--pink);">₱{{ $total }}.00</span>
              </div>
            </div>

            {{-- ELEMENTS DROPDOWN LIST --}}
            @if(count($elems))
            <details class="elements-dropdown">
              <summary>
                <span><i data-lucide="layers" style="width: 16px; margin-right: 8px; vertical-align: text-bottom;"></i> View Elements ({{ count($elems) }})</span>
                <i data-lucide="chevron-down" class="chevron" style="width: 16px; transition: transform 0.2s;"></i>
              </summary>
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

          </div>
        </div>
      </div>

      {{-- RIGHT COLUMN: Form Details --}}
      <div>
        <div class="checkout-card">
          <div class="checkout-head" style="color: var(--purple-dk);">
            <i data-lucide="user" style="color: var(--purple);"></i> Your Details
          </div>
          <div style="padding: 20px;">
            
            {{-- NEW CLEAN DB AUTOfill --}}
            @php
              $defaultFirst = auth()->check() ? auth()->user()->first_name : '';
              $defaultLast  = auth()->check() ? auth()->user()->last_name : '';
            @endphp

            <div style="display: flex; gap: 16px; margin-bottom: 16px;">
              <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label class="form-label" for="first_name">First Name <span class="req">*</span></label>
                <input class="form-control" type="text" id="first_name" name="first_name" 
                       value="{{ old('first_name', $defaultFirst) }}" placeholder="Maria" required/>
              </div>
              <div class="form-group" style="flex: 1; margin-bottom: 0;">
                <label class="form-label" for="last_name">Last Name <span class="req">*</span></label>
                <input class="form-control" type="text" id="last_name" name="last_name" 
                       value="{{ old('last_name', $defaultLast) }}" placeholder="Santos" required/>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact_number">Contact Number <span class="req">*</span></label>
              {{-- STRICTLY no default phone autofill --}}
              <input class="form-control" type="tel" id="contact_number" name="contact_number" 
                     value="{{ old('contact_number') }}" placeholder="09xx-xxx-xxxx" required/>
            </div>

            <div class="form-group">
              <label class="form-label" for="quantity">Quantity</label>
              <select class="form-control" id="quantity" name="quantity">
                @for($i = 1; $i <= 10; $i++)
                  <option value="{{ $i }}" {{ old('quantity') == $i ? 'selected' : '' }}>
                    {{ $i }} piece{{ $i > 1 ? 's' : '' }}
                  </option>
                @endfor
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="notes">Special Notes</label>
              <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any requests, gift messages…">{{ old('notes') }}</textarea>
            </div>

            <div style="background: var(--teal-bg); border: 1.5px solid var(--teal); border-radius: 10px; padding: 12px; display: flex; gap: 12px; margin: 24px 0;">
              <i data-lucide="info" style="color: var(--teal-dk); flex-shrink: 0;"></i>
              <span style="font-size: 0.8rem; font-weight: 700; color: var(--teal-dk);">We'll message you via your contact number to confirm availability, finalize the design, and arrange payment.</span>
            </div>

            <button type="submit" class="btn-submit" id="submit-btn">
              Place Order <i data-lucide="check" style="width: 18px;"></i>
            </button>

          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
  document.getElementById('submit-btn').addEventListener('click', function (e) {
    if(document.getElementById('order-form').checkValidity()) {
      this.style.pointerEvents = 'none';
      this.innerHTML = 'Submitting... <i data-lucide="loader" class="fa-spin" style="width: 18px;"></i>';
      lucide.createIcons();
    }
  });
</script>

</body>
</html>