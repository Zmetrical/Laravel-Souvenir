<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receipt — {{ $order->order_code }}</title>

  <style>
    @media print {
      .no-print { display: none !important; }
      body       { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', system-ui, sans-serif;
      background: #f4f4f8;
      color: #1E1E2A;
      padding: 24px;
    }

    .page {
      max-width: 560px;
      margin: 0 auto;
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 2px 20px rgba(0,0,0,.1);
    }

    /* ── Header band ───────────────────────────────────────────────────── */
    .receipt-header {
      background: linear-gradient(135deg, #FF5FA0 0%, #C0136A 100%);
      color: #fff;
      padding: 24px 28px 20px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    .receipt-header .brand {
      font-size: 1.1rem;
      font-weight: 900;
      letter-spacing: -.3px;
    }
    .receipt-header .brand small {
      display: block;
      font-size: .7rem;
      font-weight: 400;
      opacity: .7;
      margin-top: 1px;
    }
    .receipt-header .order-code {
      text-align: right;
    }
    .receipt-header .order-code .code {
      font-size: .85rem;
      font-weight: 800;
      font-family: monospace;
      background: rgba(255,255,255,.2);
      border-radius: 6px;
      padding: 3px 10px;
    }
    .receipt-header .order-code small {
      display: block;
      font-size: .68rem;
      opacity: .65;
      margin-top: 4px;
    }

    /* ── Status band ───────────────────────────────────────────────────── */
    .status-band {
      padding: 8px 28px;
      font-size: .75rem;
      font-weight: 700;
      text-align: center;
      letter-spacing: .04em;
    }

    /* ── Sections ──────────────────────────────────────────────────────── */
    .section {
      padding: 18px 28px;
      border-bottom: 1px solid #EEEDF3;
    }
    .section:last-child { border-bottom: none; }

    .section-title {
      font-size: .65rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: .1em;
      color: #9896A8;
      margin-bottom: 10px;
    }

    /* ── Customer / Specs rows ─────────────────────────────────────────── */
    .info-row {
      display: flex;
      justify-content: space-between;
      font-size: .82rem;
      margin-bottom: 5px;
      align-items: baseline;
    }
    .info-row .label { color: #9896A8; }
    .info-row .value { font-weight: 600; color: #1E1E2A; text-align: right; }

    /* ── Design snapshot ───────────────────────────────────────────────── */
    .snapshot-wrap {
      text-align: center;
      padding: 8px 0;
    }
    .snapshot-wrap img {
      max-width: 200px;
      border-radius: 10px;
      border: 1px solid #EEEDF3;
    }

    /* ── Items list ────────────────────────────────────────────────────── */
    .items-table { width: 100%; border-collapse: collapse; font-size: .8rem; }
    .items-table th {
      text-align: left; padding: 4px 0;
      font-size: .67rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .07em;
      color: #9896A8; border-bottom: 1px solid #EEEDF3;
    }
    .items-table th:last-child { text-align: right; }
    .items-table td {
      padding: 7px 0;
      border-bottom: 1px solid #F4F4F8;
      vertical-align: middle;
    }
    .items-table td:last-child { text-align: right; font-weight: 600; }
    .items-table tr:last-child td { border-bottom: none; }

    /* ── Totals ────────────────────────────────────────────────────────── */
    .totals { width: 100%; }
    .totals tr td { padding: 3px 0; font-size: .83rem; }
    .totals tr td:last-child { text-align: right; font-weight: 600; }
    .totals .total-row td {
      font-size: .95rem; font-weight: 800;
      color: #FF5FA0; padding-top: 9px;
      border-top: 2px solid #F0EFF7;
    }

    /* ── Color chip ────────────────────────────────────────────────────── */
    .chip {
      display: inline-block; width: 13px; height: 13px;
      border-radius: 50%; vertical-align: middle;
      border: 1px solid rgba(0,0,0,.1); margin-right: 4px;
    }

    /* ── Footer ────────────────────────────────────────────────────────── */
    .receipt-footer {
      background: #F8F7FA;
      padding: 16px 28px;
      text-align: center;
      font-size: .72rem;
      color: #9896A8;
      line-height: 1.6;
    }

    /* ── Print button ──────────────────────────────────────────────────── */
    .print-actions {
      max-width: 560px;
      margin: 16px auto 0;
      display: flex;
      gap: 10px;
      justify-content: flex-end;
    }
    .btn-print {
      background: #FF5FA0; color: #fff;
      border: none; border-radius: 8px;
      padding: 8px 20px; font-size: .82rem; font-weight: 700;
      cursor: pointer;
    }
    .btn-back {
      background: #fff; color: #5E5C6E;
      border: 1px solid #E2E0EF; border-radius: 8px;
      padding: 8px 18px; font-size: .82rem;
      text-decoration: none; display: inline-block;
    }
  </style>
</head>
<body>

{{-- Print / Back buttons (hidden when printing) --}}
<div class="print-actions no-print">
  <a href="{{ route('admin.orders.show', $order) }}" class="btn-back">← Back to Order</a>
  <button class="btn-print" onclick="window.print()">🖨 Print / Save PDF</button>
</div>

<div class="page">

  {{-- Header --}}
  <div class="receipt-header">
    <div class="brand">
      ArtsyCrate
      <small>Prints, Customs &amp; Creative Fun</small>
    </div>
    <div class="order-code">
      <div class="code">{{ $order->order_code }}</div>
      <small>{{ $order->created_at->format('M d, Y') }}</small>
    </div>
  </div>

  {{-- Status band --}}
  @php
    $bandStyles = match($order->status) {
      'pending'     => 'background:#FEF3C7;color:#92400E;',
      'confirmed'   => 'background:#DBEAFE;color:#1E40AF;',
      'in_progress' => 'background:#F3E8FF;color:#6D28D9;',
      'ready'       => 'background:#D1FAE5;color:#065F46;',
      'completed'   => 'background:#D1FAE5;color:#065F46;',
      'cancelled'   => 'background:#FEE2E2;color:#991B1B;',
      default       => 'background:#F3F4F6;color:#374151;',
    };
  @endphp
  <div class="status-band" style="{{ $bandStyles }}">
    {{ strtoupper($order->statusLabel()) }}
  </div>

  {{-- Customer --}}
  <div class="section">
    <div class="section-title">Customer</div>
    <div class="info-row">
      <span class="label">Name</span>
      <span class="value">{{ $order->first_name }} {{ $order->last_name }}</span>
    </div>
    <div class="info-row">
      <span class="label">Contact</span>
      <span class="value">{{ $order->contact_number }}</span>
    </div>
    @if($order->notes)
    <div class="info-row" style="align-items:flex-start;margin-top:6px;">
      <span class="label">Notes</span>
      <span class="value" style="max-width:60%;text-align:right;line-height:1.4;font-weight:400;color:#5E5C6E;">
        {{ $order->notes }}
      </span>
    </div>
    @endif
  </div>

  {{-- Design --}}
  @if($order->design)
    @php $d = $order->design; @endphp
  <div class="section">
    <div class="section-title">Design Specs</div>

    @if($d->snapshot_path)
    <div class="snapshot-wrap">
      <img src="{{ asset('storage/' . $d->snapshot_path) }}" alt="Design"/>
    </div>
    @endif

    @if($d->str_type)
    <div class="info-row">
      <span class="label">String</span>
      <span class="value">{{ $d->str_type }}</span>
    </div>
    @endif

    @if($d->str_color)
    <div class="info-row">
      <span class="label">String Color</span>
      <span class="value">
        <span class="chip" style="background:{{ $d->str_color }};"></span>
        <code style="font-size:.75rem;">{{ $d->str_color }}</code>
      </span>
    </div>
    @endif

    @if($d->clasp)
    <div class="info-row">
      <span class="label">Clasp</span>
      <span class="value">{{ $d->clasp }}</span>
    </div>
    @endif

    @if($d->ring_type)
    <div class="info-row">
      <span class="label">Ring</span>
      <span class="value">{{ $d->ring_type }}</span>
    </div>
    @endif

    @if($d->ring_color)
    <div class="info-row">
      <span class="label">Ring Color</span>
      <span class="value">
        <span class="chip" style="background:{{ $d->ring_color }};"></span>
        <code style="font-size:.75rem;">{{ $d->ring_color }}</code>
      </span>
    </div>
    @endif

    @if($d->letter_shape)
    <div class="info-row">
      <span class="label">Letter Shape</span>
      <span class="value">{{ $d->letter_shape }}</span>
    </div>
    @endif
  </div>
  @endif

  {{-- Items --}}
  @if($order->items->count())
  <div class="section">
    <div class="section-title">Elements ({{ $order->items->count() }} items)</div>
    <table class="items-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Element</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td style="color:#9896A8;width:24px;">{{ $item->sort_order + 1 }}</td>
          <td>
            @if($item->isLetter())
              <span style="display:inline-flex;width:20px;height:20px;border-radius:4px;
                           align-items:center;justify-content:center;font-weight:900;font-size:.75rem;
                           background:{{ $item->letter_bg ?? '#F9B8CF' }};
                           color:{{ $item->letter_text_color ?? '#C0136A' }};
                           border:1px solid rgba(0,0,0,.08);margin-right:6px;">
                {{ strtoupper($item->letter) }}
              </span>
              Letter "{{ strtoupper($item->letter) }}"
            @else
              {{ $item->element->name ?? '(deleted element)' }}
            @endif
          </td>
          <td>₱{{ $item->price_at_order }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  {{-- Totals --}}
  <div class="section">
    <table class="totals">
      <tr>
        <td style="color:#9896A8;">Product ({{ $order->product->label ?? '—' }}, {{ $order->length }})</td>
        <td>₱{{ number_format($order->base_price) }}</td>
      </tr>
      <tr>
        <td style="color:#9896A8;">Elements</td>
        <td>₱{{ number_format($order->elements_cost) }}</td>
      </tr>
      <tr class="total-row">
        <td>Total</td>
        <td>₱{{ number_format($order->total_price) }}</td>
      </tr>
    </table>
  </div>

  {{-- Footer --}}
  <div class="receipt-footer">
    Thank you for your order! 🌸<br/>
    ArtsyCrate — Prints, Customs &amp; Creative Fun<br/>
    <span style="opacity:.6;">Order placed {{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
  </div>

</div>

</body>
</html>