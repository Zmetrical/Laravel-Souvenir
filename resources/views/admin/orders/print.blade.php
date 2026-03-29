<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Receipt — {{ $order->order_code }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>

  <style>
    @media print {
      .no-print { display: none !important; }
      body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Nunito', sans-serif; background: #FAFBFC; color: #1E1E2E; padding: 24px; }
    
    .page { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,.05); border: 1.5px solid #E2DFE9; }

    .receipt-header { background: linear-gradient(135deg, #FF5FA0 0%, #E04080 100%); color: #fff; padding: 32px; display: flex; justify-content: space-between; align-items: flex-start; }
    .receipt-header .brand { font-family: 'Lilita One', cursive; font-size: 1.8rem; letter-spacing: 0.5px; }
    .receipt-header .brand small { font-family: 'Nunito', sans-serif; display: block; font-size: .85rem; font-weight: 800; opacity: .9; margin-top: 4px; }
    
    .order-code { text-align: right; }
    .order-code .code { font-family: monospace; font-size: 1.2rem; font-weight: 900; background: rgba(255,255,255,.2); border-radius: 8px; padding: 6px 14px; }
    
    .section { padding: 24px 32px; border-bottom: 1.5px solid #E2DFE9; }
    .section-title { font-family: 'Lilita One', cursive; font-size: 1.2rem; color: #0FA8A4; margin-bottom: 16px; letter-spacing: 0.5px; }
    
    .info-row { display: flex; justify-content: space-between; font-size: .95rem; margin-bottom: 10px; font-weight: 800; }
    .info-row .label { color: #6c757d; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em; }
    .info-row .value { color: #1E1E2E; text-align: right; }

    .snapshot-wrap { text-align: center; padding: 16px 0; }
    .snapshot-wrap img { max-width: 240px; border-radius: 16px; border: 1.5px solid #E2DFE9; }

    .items-table { width: 100%; border-collapse: collapse; font-size: .9rem; font-weight: 800; }
    .items-table th { text-align: left; padding: 10px 0; color: #6c757d; border-bottom: 2px solid #E2DFE9; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; }
    .items-table th:last-child { text-align: right; }
    .items-table td { padding: 12px 0; border-bottom: 1.5px solid #FAFBFC; }
    .items-table td:last-child { text-align: right; font-weight: 900; color: #E04080; }

    .totals { width: 100%; font-weight: 800; font-size: .95rem; }
    .totals tr td { padding: 6px 0; }
    .totals tr td:first-child { color: #6c757d; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.05em; }
    .totals tr td:last-child { text-align: right; }
    .totals .total-row td { font-family: 'Lilita One', cursive; font-size: 1.6rem; color: #FF5FA0; padding-top: 16px; margin-top: 16px; border-top: 2px dashed #E2DFE9; text-transform: none; letter-spacing: 0.5px; }

    .receipt-footer { background: #FAFBFC; padding: 24px 32px; text-align: center; font-size: .85rem; font-weight: 800; color: #6c757d; }
    
    .print-actions { max-width: 560px; margin: 16px auto 24px; display: flex; gap: 12px; justify-content: flex-end; }
    .btn-print { background: #FF5FA0; color: #fff; border: none; border-radius: 12px; padding: 12px 24px; font-weight: 900; font-size: 1rem; font-family: 'Nunito', sans-serif; cursor: pointer; box-shadow: 0 4px 12px rgba(255,95,160,0.3); }
    .btn-back { background: #fff; color: #1E1E2E; border: 1.5px solid #E2DFE9; border-radius: 12px; padding: 12px 24px; font-weight: 900; font-size: 1rem; font-family: 'Nunito', sans-serif; text-decoration: none; }
  </style>
</head>
<body>

<div class="print-actions no-print">
  <a href="{{ route('admin.orders.show', $order) }}" class="btn-back">← Back to Order</a>
  <button class="btn-print" onclick="window.print()">🖨 Print Receipt</button>
</div>

<div class="page">
  <div class="receipt-header">
    <div class="brand">ArtsyCrate<small>Prints & Customs</small></div>
    <div class="order-code">
      <div class="code">{{ $order->order_code }}</div>
      <div style="font-size: 0.85rem; font-weight: 800; margin-top: 6px; opacity: 0.9;">{{ $order->created_at->format('M d, Y') }}</div>
    </div>
  </div>

  <div class="section">
    <div class="section-title">Customer Details</div>
    <div class="info-row"><span class="label">Name</span><span class="value">{{ $order->first_name }} {{ $order->last_name }}</span></div>
    <div class="info-row"><span class="label">Contact</span><span class="value">{{ $order->contact_number }}</span></div>
    @if($order->notes)
      <div class="info-row" style="margin-top: 12px; flex-direction: column; gap: 4px;"><span class="label">Notes</span><span class="value text-muted" style="font-weight: 700; text-align: left; background: #FAFBFC; padding: 10px; border-radius: 8px; border: 1px solid #E2DFE9;">{{ $order->notes }}</span></div>
    @endif
  </div>

  @if($order->design)
  <div class="section">
    <div class="section-title">Design Specs</div>
    @if($order->design->snapshot_path)
      <div class="snapshot-wrap"><img src="{{ asset('storage/' . $order->design->snapshot_path) }}" alt="Design"/></div>
    @endif
    @if($order->design->str_type) <div class="info-row"><span class="label">String</span><span class="value">{{ $order->design->str_type }}</span></div> @endif
    @if($order->design->clasp) <div class="info-row"><span class="label">Clasp</span><span class="value">{{ $order->design->clasp }}</span></div> @endif
  </div>
  @endif

  @if($order->items->count())
  <div class="section">
    <div class="section-title">Elements ({{ $order->items->count() }})</div>
    <table class="items-table">
      <thead><tr><th>#</th><th>Element</th><th>Price</th></tr></thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td style="color:#6c757d;">{{ $item->sort_order + 1 }}</td>
          <td>{{ $item->isLetter() ? 'Letter "' . strtoupper($item->letter) . '"' : ($item->element->name ?? '(deleted)') }}</td>
          <td>₱{{ $item->price_at_order }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif

  <div class="section">
    <table class="totals">
      <tr><td class="label">Product Base</td><td>₱{{ number_format($order->base_price) }}</td></tr>
      <tr><td class="label">Elements</td><td>₱{{ number_format($order->elements_cost) }}</td></tr>
      <tr class="total-row"><td>Total</td><td>₱{{ number_format($order->total_price) }}</td></tr>
    </table>
  </div>

  <div class="receipt-footer">
    Thank you for your order! 🌸<br/>
    <span style="opacity:0.6; font-size: 0.8rem;">Placed {{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
  </div>
</div>

</body>
</html>