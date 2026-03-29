{{-- resources/views/order/confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Order Placed — ArtsyCrate</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800;900&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    body { overflow: auto !important; height: auto !important; background: var(--grey-50); display: block !important; }

    /* ── Topbar ── */
    .topbar {
      background: var(--white); padding: 0 24px; height: 48px;
      display: flex; align-items: center; justify-content: space-between;
      border-bottom: 1px solid var(--grey-200); position: sticky; top: 0; z-index: 50;
    }
    .logo { font-family: var(--fh); font-size: 1.1rem; font-weight: 800; color: var(--ink); text-decoration: none; }
    .logo b { color: var(--pink); }

    /* ── Page ── */
    .conf-page { max-width: 560px; margin: 0 auto; padding: 52px 20px 72px; }

    /* ── Success ring ── */
    .success-ring {
      width: 80px; height: 80px; border-radius: 50%;
      background: var(--pink-lt); border: 2.5px solid var(--pink-bd);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 22px;
      box-shadow: 0 0 0 10px rgba(232,37,122,.06);
      animation: popIn .4s cubic-bezier(.22,1,.36,1) both;
    }
    .success-ring i[data-lucide] { width: 30px; height: 30px; color: var(--pink); }
    @keyframes popIn { from { transform: scale(.5); opacity: 0; } to { transform: scale(1); opacity: 1; } }

    .conf-title {
      font-family: var(--fh); font-size: 1.8rem; font-weight: 800;
      color: var(--ink); text-align: center; margin-bottom: 6px;
      letter-spacing: -.025em;
    }
    .conf-sub {
      text-align: center; font-size: .84rem; font-weight: 600;
      color: var(--ink2); line-height: 1.65; margin-bottom: 28px;
    }

    /* ── Order code box ── */
    .order-code-box {
      background: var(--white); border: 2px dashed var(--pink-bd);
      border-radius: var(--r-md); padding: 20px 24px; margin-bottom: 24px;
      text-align: center; box-shadow: var(--sh-xs);
    }
    .ocb-lbl {
      font-size: .6rem; font-weight: 800; color: var(--ink3);
      letter-spacing: .10em; text-transform: uppercase; margin-bottom: 7px;
    }
    .ocb-code {
      font-family: var(--fh); font-size: 1.75rem; font-weight: 800;
      color: var(--pink-dk); letter-spacing: .05em;
    }
    .ocb-hint { font-size: .72rem; font-weight: 600; color: var(--ink3); margin-top: 5px; }

    /* ── Detail card ── */
    .detail-card {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: var(--r-md); overflow: hidden; margin-bottom: 16px;
      box-shadow: var(--sh-xs);
    }
    .dc-head {
      padding: 11px 18px; border-bottom: 1px solid var(--grey-200);
      background: var(--grey-50);
      font-size: .6rem; font-weight: 800; letter-spacing: .08em;
      text-transform: uppercase; color: var(--ink3);
      display: flex; align-items: center; gap: 7px;
    }
    .dc-head i[data-lucide] { width: 13px; height: 13px; }
    .dc-body { padding: 16px 18px; }

    .dc-row {
      display: flex; justify-content: space-between; align-items: center;
      padding: 7px 0; border-bottom: 1px solid var(--grey-100);
      font-size: .81rem;
    }
    .dc-row:last-child { border: none; padding-bottom: 0; }
    .dc-lbl { color: var(--ink2); font-weight: 600; }
    .dc-val { font-weight: 700; color: var(--ink); }
    .dc-val.total { font-family: var(--fh); font-size: 1.05rem; color: var(--pink-dk); }

    /* Status badge */
    .sbd {
      display: inline-flex; align-items: center; gap: 4px;
      border-radius: var(--r-pill); padding: 3px 10px;
      font-size: .62rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase;
    }
    .sbd::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    .s-pending { background: #FFF7E0; color: #B47D00; border: 1px solid #F0D080; }

    /* Snapshot */
    .snapshot-wrap {
      border-radius: var(--r-sm); overflow: hidden;
      border: 1px solid var(--grey-200); margin-bottom: 14px;
      background: var(--grey-50);
    }
    .snapshot-wrap img { width: 100%; display: block; }

    /* ── Notice ── */
    .notice {
      display: flex; align-items: flex-start; gap: 10px;
      padding: 12px 15px; border-radius: var(--r-sm);
      font-size: .76rem; font-weight: 600; line-height: 1.55;
      margin-bottom: 20px;
    }
    .notice-teal { background: var(--teal-lt); border: 1.5px solid var(--teal-bd); color: var(--teal-dk); }
    .notice i[data-lucide] { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }

    /* ── CTA buttons ── */
    .conf-actions { display: flex; flex-direction: column; gap: 9px; }
    .conf-btn-primary {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      background: var(--pink); color: var(--white);
      border: none; border-radius: var(--r-sm); padding: 13px;
      font-family: var(--fb); font-weight: 800; font-size: .88rem;
      text-decoration: none; cursor: pointer;
      box-shadow: 0 6px 18px rgba(232,37,122,.24);
      transition: background .14s, transform .12s;
    }
    .conf-btn-primary:hover { background: var(--pink-dk); transform: translateY(-1px); color: var(--white); }
    .conf-btn-primary i[data-lucide] { width: 16px; height: 16px; }

    .conf-btn-ghost {
      display: flex; align-items: center; justify-content: center; gap: 8px;
      background: var(--white); color: var(--ink2);
      border: 1.5px solid var(--grey-200); border-radius: var(--r-sm); padding: 12px;
      font-family: var(--fb); font-weight: 700; font-size: .84rem;
      text-decoration: none; cursor: pointer;
      transition: border-color .13s, background .13s;
    }
    .conf-btn-ghost:hover { border-color: var(--grey-300); background: var(--grey-50); color: var(--ink); }
    .conf-btn-ghost i[data-lucide] { width: 15px; height: 15px; }
  </style>
</head>
<body>

<div class="topbar">
  <a href="{{ route('builder.index') }}" class="logo">Artsy<b>Crate</b></a>
  @auth
    <a href="{{ route('account.dashboard') }}" style="display:flex;align-items:center;gap:6px;font-size:.76rem;font-weight:800;color:var(--ink2);text-decoration:none;">
      <i data-lucide="user" style="width:14px;height:14px;"></i> My Account
    </a>
  @endauth
</div>

<div class="conf-page">

  {{-- Success icon --}}
  <div class="success-ring">
    <i data-lucide="check"></i>
  </div>

  <h1 class="conf-title">Order Placed! 🌸</h1>
  <p class="conf-sub">
    Thanks, <strong>{{ $order->first_name }}</strong>! We've received your custom order
    and will message you at <strong>{{ $order->contact_number }}</strong> to confirm.
  </p>

  {{-- Order code --}}
  <div class="order-code-box">
    <div class="ocb-lbl">Your Order Code</div>
    <div class="ocb-code">{{ $order->order_code }}</div>
    <div class="ocb-hint">Show this at the store or use it to track your order online.</div>
  </div>

  {{-- Design snapshot --}}
  @if($order->design && $order->design->snapshot_path)
    <div class="detail-card">
      <div class="dc-head"><i data-lucide="image"></i> Your Design</div>
      <div class="dc-body" style="padding:12px;">
        <div class="snapshot-wrap" style="margin-bottom:0;">
          <img src="{{ Storage::url($order->design->snapshot_path) }}" alt="Design snapshot"/>
        </div>
      </div>
    </div>
  @endif

  {{-- Order details --}}
  <div class="detail-card">
    <div class="dc-head"><i data-lucide="receipt"></i> Order Details</div>
    <div class="dc-body">
      <div class="dc-row">
        <span class="dc-lbl">Status</span>
        <span class="dc-val"><span class="sbd s-pending">Pending Review</span></span>
      </div>
      <div class="dc-row">
        <span class="dc-lbl">Product</span>
        <span class="dc-val">{{ $order->product?->label ?? ucfirst($order->product_id) }}</span>
      </div>
      <div class="dc-row">
        <span class="dc-lbl">Length</span>
        <span class="dc-val">{{ $order->length }}</span>
      </div>
      <div class="dc-row">
        <span class="dc-lbl">Base Price</span>
        <span class="dc-val">₱{{ number_format($order->base_price) }}</span>
      </div>
      <div class="dc-row">
        <span class="dc-lbl">Elements</span>
        <span class="dc-val">₱{{ number_format($order->elements_cost) }}</span>
      </div>
      <div class="dc-row">
        <span class="dc-lbl">Estimated Total</span>
        <span class="dc-val total">₱{{ number_format($order->total_price) }}.00</span>
      </div>
    </div>
  </div>

  {{-- Notice --}}
  <div class="notice notice-teal">
    <i data-lucide="info"></i>
    Keep your order code handy — you'll need it to check your order status. We'll confirm pricing and availability before we begin crafting your piece.
  </div>

  {{-- Actions --}}
  <div class="conf-actions">
    @auth
      <a href="{{ route('account.orders') }}" class="conf-btn-primary">
        <i data-lucide="package"></i> Track My Order
      </a>
    @endauth
    <a href="{{ route('builder.index') }}" class="conf-btn-ghost">
      <i data-lucide="wand-2"></i> Design Another Piece
    </a>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
</body>
</html>