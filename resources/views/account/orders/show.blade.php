<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order {{ $order->order_code }} — ArtsyCrate</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/builder/styles.css') }}"/>

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { overflow-y: auto !important; height: auto !important; background: var(--offwhite); display: block !important; }

    .page-wrap { max-width: 1120px; margin: 0 auto; padding: 28px 20px 60px; }

    /* ── Order header ── */
    .order-header {
      background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 16px; padding: 24px 32px; margin-bottom: 24px;
      display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }
    .order-code { font-family: var(--fh); font-size: 1.8rem; color: var(--ink); margin-bottom: 4px; letter-spacing: 1px; }
    .order-meta { font-size: 0.85rem; font-weight: 700; color: var(--ink-md); text-transform: uppercase; }

    /* ── Approval banner ── */
    .approval-banner { border-radius: 16px; border: 1.5px solid; padding: 20px 24px; margin-bottom: 24px; display: flex; align-items: flex-start; gap: 16px; }
    .ban-icon { width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
    .ban-title { font-family: var(--fh); font-size: 1.2rem; margin-bottom: 4px; letter-spacing: 0.5px; }
    .ban-desc  { font-size: 0.85rem; font-weight: 700; line-height: 1.5; opacity: 0.8; }

    /* ── Layout ── */
    .main-layout { display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start; }
    @media (max-width: 850px) { .main-layout { grid-template-columns: 1fr; } }

    /* ── Cards ── */
    .card { background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 16px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.02); }
    .card-header { padding: 16px 24px; border-bottom: 1.5px solid var(--grey-200); font-family: var(--fh); font-size: 1.1rem; color: var(--ink); display: flex; align-items: center; gap: 10px; background: var(--offwhite); }
    .card-header i[data-lucide] { width: 18px; height: 18px; color: var(--pink); flex-shrink: 0; }

    /* ── Thread ── */
    .thread-wrap { display: flex; flex-direction: column; }
    .msg-row { display: flex; gap: 12px; padding: 16px 24px; }
    .msg-row.msg-admin    { justify-content: flex-start; }
    .msg-row.msg-customer { justify-content: flex-end; }

    .msg-avatar { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.9rem; flex-shrink: 0; align-self: flex-end; }
    .msg-avatar.admin-av    { background: var(--teal-bg); border: 1.5px solid var(--teal); color: var(--teal-dk); }
    .msg-avatar.customer-av { background: var(--pink); color: var(--white); }

    .msg-bubble-wrap { max-width: 75%; display: flex; flex-direction: column; }
    .msg-row.msg-admin    .msg-bubble-wrap { align-items: flex-start; }
    .msg-row.msg-customer .msg-bubble-wrap { align-items: flex-end; }

    .msg-sender-name { font-size: 0.75rem; font-weight: 800; color: var(--ink-md); text-transform: uppercase; margin-bottom: 6px; padding: 0 4px; }

    .msg-bubble { border-radius: 16px; padding: 14px 18px; font-size: 0.9rem; font-weight: 700; line-height: 1.5; }
    .admin-bub    { background: var(--offwhite); border: 1.5px solid var(--grey-200); color: var(--ink); border-bottom-left-radius: 4px; }
    .customer-bub { background: var(--pink-bg); border: 1.5px solid var(--pink); color: var(--pink-dk); border-bottom-right-radius: 4px; }
    .approval-bub { background: var(--lime-bg); border: 1.5px solid var(--lime); color: var(--lime-dk); border-bottom-right-radius: 4px; }
    .revision-bub { background: var(--purple-bg); border: 1.5px solid var(--purple); color: var(--purple-dk); border-bottom-right-radius: 4px; }
    .note-bub     { background: var(--offwhite); border: 1.5px solid var(--grey-200); color: var(--ink); }

    .msg-time { font-size: 0.7rem; color: var(--ink-md); font-weight: 700; margin-top: 6px; padding: 0 4px; }

    .msg-type-badge { display: inline-block; font-size: 0.7rem; font-weight: 900; letter-spacing: 0.05em; text-transform: uppercase; border-radius: 6px; padding: 4px 10px; margin-bottom: 8px; }

    /* Mockup photo */
    .msg-mockup-img { margin-top: 12px; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--grey-200); max-width: 320px; }
    .msg-mockup-img img { width: 100%; display: block; cursor: pointer; }
    .msg-mockup-img a { display: block; text-align: center; padding: 10px; font-size: 0.8rem; font-weight: 800; color: var(--ink-md); background: var(--offwhite); text-decoration: none; border-top: 1.5px solid var(--grey-200); }
    .msg-mockup-img a:hover { color: var(--ink); background: var(--grey-200); }

    /* Revised design snapshot */
    .msg-snapshot { margin-top: 12px; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--purple); max-width: 260px; }
    .msg-snapshot img { width: 100%; display: block; }
    .msg-snapshot .snap-label { text-align: center; padding: 8px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; color: var(--purple-dk); background: var(--purple-bg); }

    .thread-date-divider { display: flex; align-items: center; gap: 12px; padding: 12px 24px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: var(--ink-md); }
    .thread-date-divider::before, .thread-date-divider::after { content: ''; flex: 1; height: 1.5px; background: var(--grey-200); }

    /* ── Action card ── */
    .action-card { background: var(--white); border: 2px solid var(--pink); border-radius: 16px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 8px 24px rgba(255,95,160,0.15); }
    .action-card-header { background: var(--pink); color: var(--white); padding: 16px 20px; font-family: var(--fh); font-size: 1.2rem; display: flex; align-items: center; gap: 10px; letter-spacing: 1px; }
    .action-card-body { padding: 20px; }

    .btn-approve {
      width: 100%; padding: 14px; background: var(--teal); color: var(--white); border: none; border-radius: 12px; font-family: var(--fh); font-size: 1.1rem;
      cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; text-decoration: none; margin-bottom: 12px;
    }
    .btn-approve:hover { background: var(--teal-dk); transform: translateY(-2px); color: var(--white); box-shadow: 0 4px 12px rgba(26,200,196,0.3); }

    .btn-revise {
      width: 100%; padding: 14px; background: var(--white); color: var(--ink-md); border: 1.5px solid var(--grey-200); border-radius: 12px; font-family: var(--fb); font-weight: 800; font-size: 0.95rem;
      cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s; text-decoration: none; margin-bottom: 12px;
    }
    .btn-revise:hover { border-color: var(--pink); background: var(--pink-bg); color: var(--pink-dk); }

    .revision-form-wrap { display: none; background: var(--offwhite); border: 1.5px solid var(--grey-200); border-radius: 12px; padding: 16px; margin-top: 12px; }
    .revision-form-wrap.open { display: block; }
    .finput { width: 100%; padding: 12px 16px; border: 1.5px solid var(--grey-200); border-radius: 10px; font-family: var(--fb); font-size: 0.9rem; font-weight: 700; color: var(--ink); background: var(--white); transition: all 0.2s; resize: vertical; }
    .finput:focus { outline: none; border-color: var(--pink); box-shadow: 0 0 0 4px var(--pink-bg); }
    .flbl { display: block; font-size: 0.75rem; font-weight: 800; color: var(--ink-md); margin-bottom: 8px; text-transform: uppercase; }

    .btn-submit-sm { width: 100%; margin-top: 12px; padding: 12px; background: var(--ink); color: var(--white); border: none; border-radius: 10px; font-family: var(--fh); font-size: 1rem; cursor: pointer; transition: all 0.2s; }
    .btn-submit-sm:hover { background: #000; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }

    /* ── Summary card ── */
    .sum-row { display: flex; justify-content: space-between; align-items: baseline; font-size: 0.9rem; margin-bottom: 12px; }
    .sum-row .lbl { color: var(--ink-md); font-weight: 800; text-transform: uppercase; font-size: 0.75rem; }
    .sum-row .val { font-weight: 800; color: var(--ink); }
    .sum-divider { height: 1.5px; background: var(--grey-200); margin: 16px 0; }
    .sum-total { display: flex; justify-content: space-between; align-items: center; font-weight: 800; font-family: var(--fh); font-size: 1.2rem; }
    .sum-total .total-amt { font-size: 1.6rem; color: var(--pink); }
    .design-thumb { border-radius: 12px; overflow: hidden; border: 1.5px solid var(--grey-200); background: var(--offwhite); margin-bottom: 20px; }
    .design-thumb img { width: 100%; display: block; }

    /* ── Modals ── */
    .overlay { display: none; position: fixed; inset: 0; background: rgba(30,30,46,0.6); z-index: 200; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
    .overlay.open { display: flex; }
    .modal-box { background: var(--white); border-radius: 20px; max-width: 460px; width: 90%; padding: 32px; text-align: center; box-shadow: 0 12px 32px rgba(0,0,0,0.1); border: 1.5px solid var(--grey-200); }
    .modal-icon { font-size: 3rem; margin-bottom: 16px; }
    .modal-title { font-family: var(--fh); font-size: 1.6rem; color: var(--ink); margin-bottom: 12px; }
    .modal-desc { font-size: 0.95rem; font-weight: 700; color: var(--ink-md); line-height: 1.5; margin-bottom: 24px; }
    .modal-btns { display: flex; gap: 12px; }
    .modal-cancel { flex: 1; padding: 14px; background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 12px; font-family: var(--fb); font-weight: 800; font-size: 0.95rem; cursor: pointer; color: var(--ink-md); transition: all 0.2s; }
    .modal-cancel:hover { background: var(--offwhite); color: var(--ink); }
    .modal-confirm { flex: 1; padding: 14px; background: var(--teal); border: none; border-radius: 12px; font-family: var(--fh); font-size: 1.1rem; cursor: pointer; color: var(--white); transition: all 0.2s; box-shadow: 0 4px 12px rgba(26,200,196,0.2); }
    .modal-confirm:hover { background: var(--teal-dk); transform: translateY(-2px); box-shadow: 0 6px 16px rgba(26,200,196,0.3); }

    .thread-empty { text-align: center; padding: 60px 20px; color: var(--ink-md); }
  </style>
</head>
<body>

@include('builder.includes.topbar', ['activePage' => ''])

<div class="page-wrap">

  <a href="{{ route('account.orders') }}" style="display:inline-flex; align-items:center; gap:6px; font-size: 0.85rem; font-weight: 800; color: var(--ink-md); text-decoration: none; margin-bottom: 16px; transition: color 0.2s;">
    <i data-lucide="arrow-left" style="width:16px;"></i> Back to Orders
  </a>

  @if(session('success'))
    <div style="background: var(--lime-bg); border: 1.5px solid var(--lime); color: var(--lime-dk); border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; font-size: 0.95rem; font-weight: 800; display: flex; align-items: center; gap: 12px;">
      <i data-lucide="check-circle" style="width: 20px;"></i> {{ session('success') }}
    </div>
  @endif

  {{-- ── Order header ── --}}
  <div class="order-header">
    <div>
      <div class="order-code">Order #{{ $order->order_code }}</div>
      <div class="order-meta">
        {{ $order->product->label ?? '—' }} &nbsp;·&nbsp; Placed {{ $order->created_at->format('F d, Y') }}
        @if($order->design?->length) &nbsp;·&nbsp; {{ $order->design->length }} @endif
      </div>
    </div>
    @php
      $orderSC = match($order->status) {
        'pending'     => ['bg' => 'var(--lime-bg)', 'text' => 'var(--lime-dk)'],
        'confirmed'   => ['bg' => 'var(--teal-bg)', 'text' => 'var(--teal-dk)'],
        'in_progress' => ['bg' => 'var(--purple-bg)', 'text' => 'var(--purple-dk)'],
        'ready'       => ['bg' => 'var(--teal-bg)', 'text' => 'var(--teal-dk)'],
        'completed'   => ['bg' => 'var(--grey-200)', 'text' => 'var(--ink-md)'],
        'cancelled'   => ['bg' => 'var(--pink-bg)', 'text' => 'var(--pink-dk)'],
        default       => ['bg' => 'var(--grey-200)', 'text' => 'var(--ink-md)'],
      };
    @endphp
    <span style="padding: 8px 16px; border-radius: 10px; font-size: 0.8rem; font-weight: 900; text-transform: uppercase; background: {{ $orderSC['bg'] }}; color: {{ $orderSC['text'] }}; border: 1.5px solid {{ $orderSC['text'] }};">
      {{ $order->statusLabel() ?? ucfirst($order->status) }}
    </span>
  </div>

  {{-- ── SAFELY CHECK FOR THREAD/APPROVAL BANNER ── --}}
  @if(isset($thread))
    @php $sc = $thread->statusColor(); @endphp
    <div class="approval-banner" style="background: {{ $sc['bg'] }}; border-color: {{ $sc['border'] }}; color: {{ $sc['text'] }};">
      <div class="ban-icon" style="background: {{ $sc['border'] }}; color: #fff;">{{ $thread->statusIcon() }}</div>
      <div>
        <div class="ban-title">{{ $thread->statusLabel() }}</div>
        <div class="ban-desc">{{ $thread->statusDescription() }}</div>
        @if($thread->revision_count > 0)
          <div style="margin-top: 8px; font-size: 0.75rem; font-weight: 800; opacity: 0.8; text-transform: uppercase;">Revision {{ $thread->revision_count }} submitted</div>
        @endif
      </div>
    </div>
  @endif

  <div class="main-layout">
    {{-- ══ LEFT — Thread ══ --}}
    <div>

      <div class="card">
        <div class="card-header">
          <i data-lucide="message-circle"></i> Design Conversation
          <span style="margin-left:auto; font-size: 0.75rem; font-family: var(--fb); font-weight: 800; background: var(--white); border: 1.5px solid var(--grey-200); color: var(--ink-md); border-radius: 6px; padding: 4px 10px;">
            {{ ($messages ?? collect())->count() }} message{{ ($messages ?? collect())->count() !== 1 ? 's' : '' }}
          </span>
        </div>

        <div class="thread-wrap">
          @forelse($messages ?? [] as $i => $msg)
            @php $showDate = $i === 0 || $msg->created_at->toDateString() !== $messages[$i-1]->created_at->toDateString(); @endphp

            @if($showDate)
              <div class="thread-date-divider">{{ $msg->created_at->isToday() ? 'Today' : $msg->created_at->format('M d, Y') }}</div>
            @endif

            @if($msg->isFromAdmin())
              <div class="msg-row msg-admin">
                <div class="msg-avatar admin-av"><i data-lucide="sparkles" style="width: 20px;"></i></div>
                <div class="msg-bubble-wrap">
                  <div class="msg-sender-name">ArtsyCrate Shop</div>
                  <div class="msg-bubble admin-bub">
                    <span class="msg-type-badge" style="{{ $msg->typeBadgeStyle() }}">{{ $msg->typeLabel() }}</span>
                    @if($msg->body) <div>{{ $msg->body }}</div> @endif
                    @if($msg->hasImage())
                      <div class="msg-mockup-img">
                        <img src="{{ asset('storage/' . $msg->image_path) }}" alt="Mockup Photo" onclick="openLightbox('{{ asset('storage/' . $msg->image_path) }}')"/>
                        <a href="{{ asset('storage/' . $msg->image_path) }}" target="_blank"><i data-lucide="external-link" style="width:14px;"></i> Open full size</a>
                      </div>
                    @endif
                  </div>
                  <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
                </div>
              </div>
            @else
              @php $bubbleClass = match($msg->type) { 'approval' => 'approval-bub', 'revision' => 'revision-bub', default => 'customer-bub' }; @endphp
              <div class="msg-row msg-customer">
                <div class="msg-bubble-wrap">
                  <div class="msg-sender-name">You</div>
                  <div class="msg-bubble {{ $bubbleClass }}">
                    <span class="msg-type-badge" style="{{ $msg->typeBadgeStyle() }}">{{ $msg->typeLabel() }}</span>
                    @if($msg->body) <div>{{ $msg->body }}</div> @endif
                    @if($msg->hasSnapshot())
                      <div class="msg-snapshot">
                        <img src="{{ asset('storage/' . $msg->snapshot_path) }}" alt="Revised Design"/>
                        <div class="snap-label">Revised Design</div>
                      </div>
                    @endif
                  </div>
                  <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
                </div>
                <div class="msg-avatar customer-av">{{ strtoupper(substr($order->first_name, 0, 1)) }}</div>
              </div>
            @endif

          @empty
            <div class="thread-empty">
              <i data-lucide="message-circle" style="width:48px; height:48px; display:block; margin:0 auto 16px; color: var(--pink); opacity: 0.5;"></i>
              <div style="font-weight:800; font-size: 1.1rem; color: var(--ink);">No messages yet</div>
              <div style="font-size: 0.9rem; margin-top:8px;">We'll reach out once your mockup is ready.</div>
            </div>
          @endforelse
        </div>
        <div style="height:24px;"></div>
      </div>
    </div>

    {{-- ══ RIGHT — Actions + Summary ══ --}}
    <div>

      {{-- SAFELY CHECK FOR ACTION CARD --}}
      @if(isset($thread) && $thread->canCustomerAct())
        <div class="action-card">
          <div class="action-card-header"><i data-lucide="zap" style="width:20px; color:#fff;"></i> Your Turn! Review the Mockup</div>
          <div class="action-card-body">
            <p style="font-size:0.9rem; font-weight:700; color:var(--ink-md); margin-bottom:20px; line-height:1.5;">Check the mockup photo above. Happy with it? Approve to confirm your order!</p>
            <button class="btn-approve" onclick="document.getElementById('approve-modal').classList.add('open')"><i data-lucide="check-circle" style="width:20px;"></i> Looks Great — Approve! </button>
            <button class="btn-revise" onclick="toggleRevisionForm('rev-form')"><i data-lucide="message-square" style="width:16px;"></i> Request Changes</button>
            
            <div id="rev-form" class="revision-form-wrap">
              <form action="{{ route('orders.request-revision', $order->order_code) }}" method="POST">
                @csrf
                <label class="flbl">What would you like changed?</label>
                <textarea name="body" class="finput" rows="3" required placeholder="e.g. Can we swap the pink bead for teal?"></textarea>
                <button type="submit" class="btn-submit-sm">Send Request →</button>
              </form>
            </div>

            <div style="border-top:1.5px solid var(--grey-200); margin-top:20px; padding-top:20px;">
              <a href="{{ route('orders.revise.form', $order->order_code) }}" class="btn-revise" style="margin-bottom:0; border-color: var(--pink); background: var(--pink-bg); color: var(--pink-dk);"><i data-lucide="wand-2" style="width:16px;"></i> Redesign It Myself →</a>
              <p style="font-size:0.75rem; color:var(--ink-md); font-weight:700; margin:10px 4px 0; text-align:center;">Opens the builder with your current design.</p>
            </div>
          </div>
        </div>
      @endif

      {{-- Order Summary --}}
      <div class="card">
        <div class="card-header"><i data-lucide="receipt"></i> Order Summary</div>
        <div style="padding:24px;">
          @if($order->design?->snapshot_path)
            <div class="design-thumb"><img src="{{ asset('storage/' . $order->design->snapshot_path) }}" alt="Your design"/></div>
          @endif

          <div class="sum-row"><span class="lbl">Product</span><span class="val">{{ $order->product->label ?? '—' }}</span></div>
          @if($order->design?->str_type)<div class="sum-row"><span class="lbl">String</span><span class="val">{{ $order->design->str_type }}</span></div>@endif
          @if($order->length)<div class="sum-row"><span class="lbl">Length</span><span class="val">{{ $order->length }}</span></div>@endif
          <div class="sum-row"><span class="lbl">Elements</span><span class="val">{{ $order->items->count() ?? 0 }} pieces</span></div>

          <div class="sum-divider"></div>
          <div class="sum-row"><span class="lbl">Base Price</span><span class="val">₱{{ number_format($order->base_price) }}</span></div>
          <div class="sum-row"><span class="lbl">Elements Cost</span><span class="val">₱{{ number_format($order->elements_cost) }}</span></div>
          <div class="sum-divider"></div>
          <div class="sum-total"><span>Total</span><span class="total-amt">₱{{ number_format($order->total_price) }}</span></div>
        </div>
      </div>

      {{-- Customer details --}}
      <div class="card">
        <div class="card-header"><i data-lucide="user"></i> Your Details</div>
        <div style="padding:24px;">
          <div class="sum-row"><span class="lbl">Name</span><span class="val">{{ $order->first_name }} {{ $order->last_name }}</span></div>
          <div class="sum-row"><span class="lbl">Contact</span><span class="val">{{ $order->contact_number }}</span></div>
          @if($order->notes)
            <div style="margin-top:16px; background:var(--offwhite); border-radius:12px; border:1.5px solid var(--grey-200); padding:16px;">
              <div style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--ink-md); margin-bottom:8px;">Notes</div>
              <p style="margin:0; font-size:0.9rem; font-weight:700; color:var(--ink); line-height:1.5;">{{ $order->notes }}</p>
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>

{{-- Approve Modal --}}
<div class="overlay" id="approve-modal">
  <div class="modal-box">
    <div class="modal-icon">✅</div>
    <div class="modal-title">Approve this design?</div>
    <div class="modal-desc">Once you approve, your order is confirmed and we'll start crafting it. This cannot be undone.</div>
    <div class="modal-btns">
      <button class="modal-cancel" onclick="document.getElementById('approve-modal').classList.remove('open')">Go Back</button>
      <form action="{{ route('account.orders.approve', $order->order_code) }}" method="POST" style="flex:1;">
        @csrf
        <button type="submit" class="modal-confirm">Yes, Approve! 🌸</button>
      </form>
    </div>
  </div>
</div>

{{-- Lightbox --}}
<div class="overlay" id="lightbox" onclick="document.getElementById('lightbox').classList.remove('open')">
  <div style="max-width:90%; max-height:90vh; position:relative;" onclick="event.stopPropagation()">
    <img id="lightbox-img" src="" alt="" style="max-width:100%; max-height:85vh; border-radius:16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);"/>
    <button onclick="document.getElementById('lightbox').classList.remove('open')" style="position:absolute; top:-16px; right:-16px; width:40px; height:40px; border-radius:50%; background:var(--white); border:1.5px solid var(--grey-200); cursor:pointer; font-size:1.4rem; font-weight:900; color:var(--ink); display:flex; align-items:center; justify-content:center; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">×</button>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
  function toggleRevisionForm(id) { document.getElementById(id).classList.toggle('open'); }
  function openLightbox(src) { document.getElementById('lightbox-img').src = src; document.getElementById('lightbox').classList.add('open'); }
</script>
</body>
</html>