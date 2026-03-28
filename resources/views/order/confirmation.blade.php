{{-- resources/views/order/confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>ArtsyCrate — Order Confirmed!</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
  <style>
    :root {
      --pink:    #FF5FA0; --pink-lt: #FFF0F6; --pink-bd: #FFD0E8; --pink-dk: #C0136A;
      --teal:    #1AC8C4; --teal-lt: #E8FAFA;
      --lime:    #CCE86A; --lime-lt: #F5FFD8;
      --ink:     #1C1C2E; --ink-2:   #3D3D52;
      --grey-100:#F4F4F6; --grey-200:#E8E8EE; --grey-400:#A0A0B8;
      --white:   #FFFFFF;
      --fh: 'Syne', sans-serif; --fb: 'Nunito', sans-serif;
      --r: 14px; --r-sm: 8px;
      --shadow: 0 4px 24px rgba(0,0,0,.07);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: var(--fb); background: var(--grey-100); color: var(--ink); min-height: 100vh; }

    .topbar {
      height: 52px; background: var(--white); border-bottom: 1.5px solid var(--grey-200);
      display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
    }
    .logo { font-family: var(--fh); font-size: 1.15rem; color: var(--ink); text-decoration: none; }
    .logo b { color: var(--pink); }

    .page { max-width: 560px; margin: 60px auto; padding: 0 20px 60px; text-align: center; }

    .confetti-ring {
      width: 88px; height: 88px;
      border-radius: 50%;
      background: var(--pink-lt);
      border: 3px solid var(--pink-bd);
      display: flex; align-items: center; justify-content: center;
      font-size: 2.4rem;
      margin: 0 auto 24px;
      box-shadow: 0 0 0 8px rgba(255,95,160,.08);
      animation: pop .4s cubic-bezier(.4,0,.2,1.6) both;
    }
    @keyframes pop { from { transform: scale(.5); opacity:0; } to { transform: scale(1); opacity:1; } }

    .conf-title {
      font-family: var(--fh); font-size: 2rem; font-weight: 800;
      color: var(--ink); margin-bottom: 6px;
    }
    .conf-sub { font-size: .88rem; color: var(--grey-400); margin-bottom: 28px; line-height: 1.6; }

    .order-code-box {
      background: var(--white); border: 2px dashed var(--pink-bd);
      border-radius: var(--r); padding: 18px 24px; margin-bottom: 28px;
      box-shadow: var(--shadow);
    }
    .ocb-lbl { font-size: .7rem; font-weight: 800; color: var(--grey-400); letter-spacing: .08em; text-transform: uppercase; margin-bottom: 6px; }
    .ocb-code { font-family: var(--fh); font-size: 1.8rem; font-weight: 800; color: var(--pink-dk); letter-spacing: .06em; }

    .detail-card {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r); padding: 20px; margin-bottom: 20px;
      text-align: left; box-shadow: var(--shadow);
    }
    .dc-head { font-family: var(--fh); font-size: .75rem; font-weight: 800; color: var(--grey-400); letter-spacing: .06em; text-transform: uppercase; margin-bottom: 12px; }
    .dc-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px dashed var(--grey-200); font-size: .82rem; }
    .dc-row:last-child { border: none; }
    .dc-lbl { color: var(--grey-400); font-weight: 600; }
    .dc-val { font-weight: 700; }
    .dc-val.big { font-family: var(--fh); font-size: 1.1rem; color: var(--pink-dk); }

    .snapshot-wrap {
      background: var(--grey-100); border-radius: var(--r-sm);
      overflow: hidden; margin-top: 12px; text-align: center;
    }
    .snapshot-wrap img { width: 100%; display: block; }

    .notice {
      display: flex; align-items: flex-start; gap: 10px;
      padding: 12px 14px; background: var(--teal-lt); border: 1.5px solid #A0E8E6;
      border-radius: var(--r-sm); font-size: .75rem; font-weight: 600;
      color: #0A6E6A; margin-bottom: 20px; line-height: 1.5; text-align: left;
    }
    .notice-ico { font-size: 1rem; flex-shrink: 0; }

    .cta-link {
      display: inline-block; padding: 13px 28px;
      background: var(--pink); color: white;
      font-family: var(--fh); font-size: .9rem; font-weight: 800;
      border-radius: var(--r-sm); text-decoration: none;
      box-shadow: 0 4px 16px rgba(255,95,160,.3);
      transition: background .15s, transform .1s;
    }
    .cta-link:hover { background: var(--pink-dk); transform: translateY(-1px); }

    .status-badge {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 4px 10px; border-radius: 20px;
      font-size: .68rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase;
      background: #FEF9C3; color: #92400E; border: 1px solid #FDE68A;
    }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
  </style>
</head>
<body>

<div class="topbar">
  <a href="{{ route('builder.bracelet') }}" class="logo">Artsy<b>Crate</b></a>
</div>

<div class="page">
  <div class="confetti-ring">✓</div>
  <div class="conf-title">Order Placed!</div>
  <div class="conf-sub">
    Thanks, {{ $order->first_name }}! We've received your custom order<br>
    and will message you at <strong>{{ $order->contact_number }}</strong> soon.
  </div>

  <div class="order-code-box">
    <div class="ocb-lbl">Your Order Code</div>
    <div class="ocb-code">{{ $order->order_code }}</div>
  </div>

  <!-- Order details -->
  <div class="detail-card">
    <div class="dc-head">Order Details</div>
    <div class="dc-row">
      <span class="dc-lbl">Status</span>
      <span class="dc-val">
        <span class="status-badge"><span class="status-dot"></span>Pending Review</span>
      </span>
    </div>
    <div class="dc-row">
      <span class="dc-lbl">Product</span>
      <span class="dc-val">{{ ucfirst($order->product?->label ?? $order->product_id) }}</span>
    </div>
    <div class="dc-row">
      <span class="dc-lbl">Length</span>
      <span class="dc-val">{{ $order->length }}</span>
    </div>
    <div class="dc-row">
      <span class="dc-lbl">Base Price</span>
      <span class="dc-val">₱{{ $order->base_price }}</span>
    </div>
    <div class="dc-row">
      <span class="dc-lbl">Elements</span>
      <span class="dc-val">₱{{ $order->elements_cost }}</span>
    </div>
    <div class="dc-row">
      <span class="dc-lbl">Estimated Total</span>
      <span class="dc-val big">₱{{ $order->total_price }}.00</span>
    </div>

    @if($order->design && $order->design->snapshot_path)
      <div class="snapshot-wrap" style="margin-top:14px;">
        <img src="{{ Storage::url($order->design->snapshot_path) }}" alt="Design snapshot"/>
      </div>
    @endif
  </div>

  <div class="notice">
    <span class="notice-ico">💬</span>
    <span>Keep your order code handy — you'll need it to check your order status. We'll confirm pricing and availability before production begins.</span>
  </div>

  <a href="{{ route('builder.bracelet') }}" class="cta-link">Design Another ✦</a>
</div>

</body>
</html>