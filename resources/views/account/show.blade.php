<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order {{ $order->order_code }} — ArtsyCrate</title>
  <meta name="csrf-token" content="{{ csrf_token() }}"/>

  <link rel="preconnect" href="https://fonts.googleapis.com"/>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

  <style>
    :root {
      --pink:     #FF5FA0;
      --pink-lt:  #FFD6E8;
      --pink-dk:  #C0136A;
      --pink-bd:  #F9B8CF;
      --teal:     #1AC8C4;
      --teal-dk:  #0D9488;
      --ink:      #1E1E2A;
      --ink-2:    #3A3A4A;
      --ink-3:    #6E6C80;
      --white:    #FFFFFF;
      --grey-50:  #F8F8FB;
      --grey-100: #F0EFF7;
      --grey-200: #E2E0EF;
      --grey-300: #C8C6D8;
      --grey-400: #9896A8;
      --fb: 'Nunito', system-ui, sans-serif;
      --fh: 'Syne', system-ui, sans-serif;
    }

    * { box-sizing: border-box; }
    body { font-family: var(--fb); background: var(--grey-50); color: var(--ink); margin: 0; }

    .topbar {
      background: var(--white); border-bottom: 1px solid var(--grey-200);
      padding: 12px 24px; display: flex; align-items: center;
      justify-content: space-between; position: sticky; top: 0; z-index: 100;
    }
    .logo { font-family: var(--fh); font-size: 1.05rem; font-weight: 800; color: var(--ink); text-decoration: none; }
    .logo b { color: var(--pink); }
    .topbar-nav { display: flex; align-items: center; gap: 20px; font-size: .82rem; font-weight: 700; }
    .topbar-nav a { color: var(--ink-3); text-decoration: none; transition: color .13s; }
    .topbar-nav a:hover { color: var(--pink); }

    .page-wrap { max-width: 1120px; margin: 0 auto; padding: 28px 20px 60px; }

    /* ── Order header ─────────────────────────────────────────────── */
    .order-header {
      background: var(--white); border: 1.5px solid var(--grey-200);
      border-radius: 14px; padding: 22px 28px; margin-bottom: 22px;
      display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;
    }
    .order-code { font-family: var(--fh); font-size: 1.25rem; font-weight: 800; color: var(--ink); margin-bottom: 3px; }
    .order-meta { font-size: .78rem; font-weight: 600; color: var(--grey-400); }

    /* ── Approval banner ──────────────────────────────────────────── */
    .approval-banner {
      border-radius: 12px; border: 1.5px solid; padding: 16px 20px;
      margin-bottom: 22px; display: flex; align-items: flex-start; gap: 14px;
    }
    .ban-icon {
      width: 38px; height: 38px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem; flex-shrink: 0;
    }
    .ban-title { font-weight: 800; font-size: .88rem; margin-bottom: 2px; }
    .ban-desc  { font-size: .78rem; font-weight: 600; line-height: 1.55; opacity: .8; }

    /* ── Layout ───────────────────────────────────────────────────── */
    .main-layout { display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start; }
    @media (max-width: 800px) { .main-layout { grid-template-columns: 1fr; } }

    /* ── Cards ────────────────────────────────────────────────────── */
    .card { background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 14px; overflow: hidden; margin-bottom: 18px; }
    .card-header {
      padding: 13px 20px; border-bottom: 1px solid var(--grey-200);
      font-weight: 800; font-size: .82rem; color: var(--ink-2);
      display: flex; align-items: center; gap: 8px;
    }
    .card-header i[data-lucide] { width: 14px; height: 14px; flex-shrink: 0; }

    /* ── Thread ───────────────────────────────────────────────────── */
    .thread-wrap { display: flex; flex-direction: column; }

    .msg-row { display: flex; gap: 10px; padding: 12px 20px; }
    .msg-row.msg-admin    { justify-content: flex-start; }
    .msg-row.msg-customer { justify-content: flex-end; }

    .msg-avatar {
      width: 34px; height: 34px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-weight: 900; font-size: .72rem; flex-shrink: 0; align-self: flex-end;
    }
    .msg-avatar.admin-av    { background: var(--pink-lt); color: var(--pink-dk); }
    .msg-avatar.customer-av { background: var(--teal); color: var(--white); }

    .msg-bubble-wrap { max-width: 75%; display: flex; flex-direction: column; }
    .msg-row.msg-admin    .msg-bubble-wrap { align-items: flex-start; }
    .msg-row.msg-customer .msg-bubble-wrap { align-items: flex-end; }

    .msg-sender-name { font-size: .65rem; font-weight: 700; color: var(--grey-400); margin-bottom: 4px; padding: 0 4px; }

    .msg-bubble {
      border-radius: 14px; padding: 12px 15px;
      font-size: .83rem; font-weight: 600; line-height: 1.55;
    }
    .admin-bub    { background: var(--grey-50); border: 1.5px solid var(--grey-200); color: var(--ink); border-bottom-left-radius: 4px; }
    .customer-bub { background: var(--pink-lt); border: 1.5px solid var(--pink-bd); color: var(--pink-dk); border-bottom-right-radius: 4px; }
    .approval-bub { background: #D1FAE5; border: 1.5px solid #A7F3D0; color: #065F46; border-bottom-right-radius: 4px; }
    .revision-bub { background: #F3E8FF; border: 1.5px solid #DDD6FE; color: #6D28D9; border-bottom-right-radius: 4px; }
    .note-bub     { background: var(--grey-50); border: 1.5px solid var(--grey-200); color: var(--ink); }

    .msg-time { font-size: .63rem; color: var(--grey-400); font-weight: 600; margin-top: 5px; padding: 0 4px; }

    .msg-type-badge {
      display: inline-block; font-size: .6rem; font-weight: 800;
      letter-spacing: .05em; text-transform: uppercase;
      border-radius: 4px; padding: 2px 7px; margin-bottom: 6px;
    }

    /* Mockup photo */
    .msg-mockup-img {
      margin-top: 10px; border-radius: 10px; overflow: hidden;
      border: 1.5px solid var(--grey-200); max-width: 300px;
    }
    .msg-mockup-img img { width: 100%; display: block; cursor: pointer; }
    .msg-mockup-img a {
      display: block; text-align: center; padding: 7px;
      font-size: .7rem; font-weight: 700; color: var(--grey-400);
      background: var(--grey-50); text-decoration: none;
      border-top: 1px solid var(--grey-200);
    }
    .msg-mockup-img a:hover { color: var(--ink); }

    /* Revised design snapshot */
    .msg-snapshot {
      margin-top: 10px; border-radius: 10px; overflow: hidden;
      border: 1.5px solid #DDD6FE; max-width: 240px;
    }
    .msg-snapshot img { width: 100%; display: block; }
    .msg-snapshot .snap-label {
      text-align: center; padding: 6px; font-size: .68rem;
      font-weight: 700; color: #6D28D9; background: #F3E8FF;
    }

    .thread-date-divider {
      display: flex; align-items: center; gap: 10px;
      padding: 6px 20px; font-size: .65rem; font-weight: 700;
      text-transform: uppercase; letter-spacing: .07em; color: var(--grey-400);
    }
    .thread-date-divider::before, .thread-date-divider::after {
      content: ''; flex: 1; height: 1px; background: var(--grey-200);
    }

    /* ── Action card ──────────────────────────────────────────────── */
    .action-card { background: var(--white); border: 2px solid var(--pink-bd); border-radius: 14px; overflow: hidden; margin-bottom: 18px; }
    .action-card-header { background: linear-gradient(135deg, var(--pink) 0%, var(--pink-dk) 100%); color: var(--white); padding: 13px 18px; font-weight: 800; font-size: .85rem; display: flex; align-items: center; gap: 8px; }
    .action-card-body { padding: 18px; }

    .btn-approve {
      width: 100%; padding: 12px; background: #10B981; color: var(--white);
      border: none; border-radius: 10px; font-family: var(--fb); font-weight: 800;
      font-size: .88rem; cursor: pointer; display: flex; align-items: center;
      justify-content: center; gap: 8px; transition: background .14s, transform .1s;
      text-decoration: none; margin-bottom: 10px;
    }
    .btn-approve:hover { background: #059669; transform: translateY(-1px); color: var(--white); }
    .btn-approve i[data-lucide] { width: 16px; height: 16px; }

    .btn-revise {
      width: 100%; padding: 10px; background: var(--white); color: var(--ink-2);
      border: 1.5px solid var(--grey-200); border-radius: 10px; font-family: var(--fb);
      font-weight: 700; font-size: .82rem; cursor: pointer; display: flex;
      align-items: center; justify-content: center; gap: 7px;
      transition: border-color .13s, background .13s; text-decoration: none; margin-bottom: 10px;
    }
    .btn-revise:hover { border-color: var(--pink); background: #FFF8FB; color: var(--pink-dk); }

    .revision-form-wrap { display: none; background: var(--grey-50); border: 1px solid var(--grey-200); border-radius: 10px; padding: 14px; margin-top: 8px; }
    .revision-form-wrap.open { display: block; }

    .finput {
      width: 100%; padding: 9px 12px; border: 1.5px solid var(--grey-200);
      border-radius: 8px; font-family: var(--fb); font-size: .8rem; font-weight: 600;
      color: var(--ink); background: var(--white); outline: none;
      transition: border-color .13s; resize: vertical;
    }
    .finput:focus { border-color: var(--pink); }

    .flbl { display: block; font-size: .72rem; font-weight: 800; color: var(--grey-400); margin-bottom: 5px; text-transform: uppercase; letter-spacing: .05em; }

    .btn-submit-sm {
      width: 100%; margin-top: 10px; padding: 9px; background: var(--ink);
      color: var(--white); border: none; border-radius: 8px; font-family: var(--fb);
      font-weight: 800; font-size: .8rem; cursor: pointer; transition: background .13s;
    }
    .btn-submit-sm:hover { background: var(--ink-2); }

    /* ── Summary card ─────────────────────────────────────────────── */
    .sum-row { display: flex; justify-content: space-between; align-items: baseline; font-size: .82rem; margin-bottom: 8px; }
    .sum-row .lbl { color: var(--grey-400); font-weight: 600; }
    .sum-row .val { font-weight: 700; color: var(--ink); }
    .sum-divider { height: 1px; background: var(--grey-200); margin: 12px 0; }
    .sum-total { display: flex; justify-content: space-between; align-items: center; font-weight: 800; }
    .sum-total .total-amt { font-family: var(--fh); font-size: 1.1rem; color: var(--pink); }

    .design-thumb { border-radius: 10px; overflow: hidden; border: 1.5px solid var(--grey-200); background: var(--grey-50); margin-bottom: 14px; }
    .design-thumb img { width: 100%; display: block; }

    /* ── Flash ────────────────────────────────────────────────────── */
    .flash-success {
      background: #D1FAE5; border: 1.5px solid #A7F3D0; color: #065F46;
      border-radius: 10px; padding: 12px 16px; margin-bottom: 18px;
      font-size: .83rem; font-weight: 700; display: flex; align-items: center; gap: 9px;
    }

    /* ── Modals ───────────────────────────────────────────────────── */
    .overlay { display: none; position: fixed; inset: 0; background: rgba(30,30,42,.55); z-index: 200; align-items: center; justify-content: center; }
    .overlay.open { display: flex; }
    .modal-box { background: var(--white); border-radius: 16px; max-width: 420px; width: 90%; padding: 28px; text-align: center; }
    .modal-icon { font-size: 2.5rem; margin-bottom: 12px; }
    .modal-title { font-family: var(--fh); font-size: 1.1rem; font-weight: 800; color: var(--ink); margin-bottom: 8px; }
    .modal-desc { font-size: .82rem; font-weight: 600; color: var(--ink-3); line-height: 1.55; margin-bottom: 16px; }
    .modal-btns { display: flex; gap: 10px; }
    .modal-cancel { flex: 1; padding: 10px; background: var(--white); border: 1.5px solid var(--grey-200); border-radius: 8px; font-family: var(--fb); font-weight: 700; font-size: .83rem; cursor: pointer; color: var(--ink-2); }
    .modal-confirm { flex: 1; padding: 10px; background: #10B981; border: none; border-radius: 8px; font-family: var(--fb); font-weight: 800; font-size: .83rem; cursor: pointer; color: var(--white); }

    .thread-empty { text-align: center; padding: 40px 20px; color: var(--grey-400); }
  </style>
</head>
<body>

<div class="topbar">
  <a href="{{ route('builder.index') }}" class="logo">Artsy<b>Crate</b></a>
  <nav class="topbar-nav">
    @auth
      <a href="{{ route('account.dashboard') }}">My Account</a>
      <a href="{{ route('account.orders') }}">Orders</a>
    @else
      <a href="{{ route('login') }}">Log In</a>
    @endauth
    <a href="{{ route('builder.index') }}"
       style="background:var(--pink);color:#fff;padding:6px 16px;border-radius:20px;">
      Design Studio
    </a>
  </nav>
</div>

<div class="page-wrap">

  @if(session('success'))
    <div class="flash-success">
      <i data-lucide="check-circle"></i>
      {{ session('success') }}
    </div>
  @endif

  {{-- ── Order header ──────────────────────────────────────────────────────── --}}
  <div class="order-header">
    <div>
      <div class="order-code">Order #{{ $order->order_code }}</div>
      <div class="order-meta">
        {{ $order->product->label ?? '—' }} &nbsp;·&nbsp;
        Placed {{ $order->created_at->format('F d, Y') }}
        @if($order->design?->length)
          &nbsp;·&nbsp; {{ $order->design->length }}
        @endif
      </div>
    </div>
    @php
      $orderSC = match($order->status) {
        'pending'     => ['bg' => '#FEF3C7', 'text' => '#92400E'],
        'confirmed'   => ['bg' => '#DBEAFE', 'text' => '#1E40AF'],
        'in_progress' => ['bg' => '#F3E8FF', 'text' => '#6D28D9'],
        'ready'       => ['bg' => '#D1FAE5', 'text' => '#065F46'],
        'completed'   => ['bg' => '#D1FAE5', 'text' => '#065F46'],
        'cancelled'   => ['bg' => '#FEE2E2', 'text' => '#991B1B'],
        default       => ['bg' => '#F3F4F6', 'text' => '#374151'],
      };
    @endphp
    <span style="padding:5px 14px;border-radius:20px;font-size:.75rem;font-weight:800;
                 background:{{ $orderSC['bg'] }};color:{{ $orderSC['text'] }};">
      {{ $order->statusLabel() }}
    </span>
  </div>

  {{-- ── Approval banner ───────────────────────────────────────────────────── --}}
  @php $sc = $thread->statusColor(); @endphp
  <div class="approval-banner"
       style="background:{{ $sc['bg'] }};border-color:{{ $sc['border'] }};color:{{ $sc['text'] }};">
    <div class="ban-icon" style="background:{{ $sc['border'] }};">
      {{ $thread->statusIcon() }}
    </div>
    <div>
      <div class="ban-title">{{ $thread->statusLabel() }}</div>
      <div class="ban-desc">{{ $thread->statusDescription() }}</div>
      @if($thread->revision_count > 0)
        <div style="margin-top:5px;font-size:.7rem;font-weight:700;opacity:.7;">
          Revision {{ $thread->revision_count }} submitted
        </div>
      @endif
    </div>
  </div>

  <div class="main-layout">

    {{-- ══ LEFT — Thread ══════════════════════════════════════════════════════ --}}
    <div>
      <div class="card">
        <div class="card-header">
          <i data-lucide="message-circle"></i>
          Design Conversation
          <span style="margin-left:auto;font-size:.68rem;font-weight:700;
                       background:var(--grey-100);color:var(--grey-400);
                       border-radius:4px;padding:2px 8px;">
            {{ $messages->count() }} message{{ $messages->count() !== 1 ? 's' : '' }}
          </span>
        </div>

        <div class="thread-wrap">

          @forelse($messages as $i => $msg)

            @php
              $showDate = $i === 0 ||
                $msg->created_at->toDateString() !== $messages[$i-1]->created_at->toDateString();
            @endphp

            @if($showDate)
              <div class="thread-date-divider">
                {{ $msg->created_at->isToday() ? 'Today' : $msg->created_at->format('M d, Y') }}
              </div>
            @endif

            {{-- ── Admin message: type = mockup or note ─────────────────────── --}}
            @if($msg->isFromAdmin())
              <div class="msg-row msg-admin">
                <div class="msg-avatar admin-av">🌸</div>
                <div class="msg-bubble-wrap">
                  <div class="msg-sender-name">ArtsyCrate Shop</div>
                  <div class="msg-bubble admin-bub">
                    <span class="msg-type-badge" style="{{ $msg->typeBadgeStyle() }}">
                      {{ $msg->typeLabel() }}
                    </span>
                    @if($msg->body)
                      <div>{{ $msg->body }}</div>
                    @endif

                    {{-- Mockup photo (image_path) ──────────────────────────── --}}
                    @if($msg->hasImage())
                      <div class="msg-mockup-img">
                        <img src="{{ asset('storage/' . $msg->image_path) }}"
                             alt="Mockup Photo"
                             onclick="openLightbox('{{ asset('storage/' . $msg->image_path) }}')"/>
                        <a href="{{ asset('storage/' . $msg->image_path) }}" target="_blank">
                          <i data-lucide="external-link" style="width:11px;height:11px;"></i>
                          Open full size
                        </a>
                      </div>
                    @endif
                  </div>
                  <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
                </div>
              </div>

            {{-- ── Customer message: type = approval, revision, or note ─────── --}}
            @else
              @php
                $bubbleClass = match($msg->type) {
                  'approval' => 'approval-bub',
                  'revision' => 'revision-bub',
                  default    => 'customer-bub',
                };
              @endphp
              <div class="msg-row msg-customer">
                <div class="msg-bubble-wrap">
                  <div class="msg-sender-name">You</div>
                  <div class="msg-bubble {{ $bubbleClass }}">
                    <span class="msg-type-badge" style="{{ $msg->typeBadgeStyle() }}">
                      {{ $msg->typeLabel() }}
                    </span>
                    @if($msg->body)
                      <div>{{ $msg->body }}</div>
                    @endif

                    {{-- Revised design snapshot ──────────────────────────────── --}}
                    @if($msg->hasSnapshot())
                      <div class="msg-snapshot">
                        <img src="{{ asset('storage/' . $msg->snapshot_path) }}"
                             alt="Revised Design"/>
                        <div class="snap-label">Revised Design</div>
                      </div>
                    @endif
                  </div>
                  <div class="msg-time">{{ $msg->created_at->format('h:i A') }}</div>
                </div>
                <div class="msg-avatar customer-av">
                  {{ strtoupper(substr($order->first_name, 0, 1)) }}
                </div>
              </div>
            @endif

          @empty
            <div class="thread-empty">
              <i data-lucide="message-circle" style="width:32px;height:32px;display:block;margin:0 auto 10px;"></i>
              <div style="font-weight:700;font-size:.85rem;">No messages yet</div>
              <div style="font-size:.75rem;margin-top:4px;">
                We'll reach out once your mockup is ready.
              </div>
            </div>
          @endforelse

        </div>

        <div style="height:16px;"></div>
      </div>
    </div>{{-- /left --}}

    {{-- ══ RIGHT — Actions + Summary ════════════════════════════════════════ --}}
    <div>

      {{-- Action buttons — only when mockup_sent ───────────────────────────── --}}
      @if($thread->canCustomerAct())
        <div class="action-card">
          <div class="action-card-header">
            <i data-lucide="zap" style="width:15px;height:15px;"></i>
            Your Turn! Review the Mockup
          </div>
          <div class="action-card-body">
            <p style="font-size:.8rem;font-weight:600;color:var(--ink-3);margin-bottom:16px;line-height:1.55;">
              Check the mockup photo above. Happy with it? Approve to confirm your order!
            </p>

            <button class="btn-approve"
                    onclick="document.getElementById('approve-modal').classList.add('open')">
              <i data-lucide="check-circle"></i>
              Looks Great — Approve It! ✅
            </button>

            <button class="btn-revise" onclick="toggleRevisionForm('rev-form')">
              <i data-lucide="edit-3" style="width:13px;height:13px;"></i>
              Request Changes
            </button>
            <div id="rev-form" class="revision-form-wrap">
              <form action="{{ route('orders.request-revision', $order->order_code) }}"
                    method="POST">
                @csrf
                <label class="flbl">What would you like changed?</label>
                <textarea name="body" class="finput" rows="3" required
                          placeholder="e.g. Can we swap the pink bead for teal? And make the charm bigger?"></textarea>
                <button type="submit" class="btn-submit-sm">Send Request →</button>
              </form>
            </div>

            <div style="border-top:1px solid var(--grey-200);margin-top:14px;padding-top:14px;">
              <a href="{{ route('orders.revise.form', $order->order_code) }}" class="btn-revise" style="margin-bottom:0;">
                <i data-lucide="wand-2" style="width:13px;height:13px;"></i>
                Redesign It Myself →
              </a>
              <p style="font-size:.7rem;color:var(--grey-400);font-weight:600;margin:7px 4px 0;line-height:1.4;">
                Opens the builder pre-loaded with your current design.
              </p>
            </div>
          </div>
        </div>
      @endif

      {{-- Redesign prompt when revision_requested ──────────────────────────── --}}
      @if($thread->approval_status === 'revision_requested' && $thread->canCustomerRevise())
        <div class="card" style="border-color:var(--pink-bd);">
          <div class="card-body" style="padding:20px;text-align:center;">
            <div style="font-size:1.2rem;margin-bottom:8px;">✏️</div>
            <div style="font-weight:800;font-size:.88rem;margin-bottom:6px;">Ready to redesign?</div>
            <p style="font-size:.78rem;color:var(--ink-3);font-weight:600;margin-bottom:14px;line-height:1.5;">
              Open the builder with your current design pre-loaded and submit your revision.
            </p>
            <a href="{{ route('orders.revise.form', $order->order_code) }}"
               style="display:inline-flex;align-items:center;gap:7px;
                      background:var(--pink);color:#fff;border-radius:10px;
                      padding:10px 20px;font-weight:800;font-size:.83rem;text-decoration:none;">
              <i data-lucide="wand-2" style="width:14px;height:14px;"></i>
              Open Builder → Revise
            </a>
          </div>
        </div>
      @endif

      {{-- Order Summary ────────────────────────────────────────────────────── --}}
      <div class="card">
        <div class="card-header"><i data-lucide="receipt"></i> Order Summary</div>
        <div style="padding:20px;">

          @if($order->design?->snapshot_path)
            <div class="design-thumb">
              <img src="{{ asset('storage/' . $order->design->snapshot_path) }}" alt="Your design"/>
            </div>
          @endif

          <div class="sum-row">
            <span class="lbl">Product</span>
            <span class="val">{{ $order->product->label ?? '—' }}</span>
          </div>
          @if($order->design?->str_type)
            <div class="sum-row">
              <span class="lbl">String</span>
              <span class="val">{{ $order->design->str_type }}</span>
            </div>
          @endif
          @if($order->length)
            <div class="sum-row">
              <span class="lbl">Length</span>
              <span class="val">{{ $order->length }}</span>
            </div>
          @endif
          <div class="sum-row">
            <span class="lbl">Elements</span>
            <span class="val">{{ $order->items->count() }} pieces</span>
          </div>

          <div class="sum-divider"></div>

          <div class="sum-row">
            <span class="lbl">Base Price</span>
            <span class="val">₱{{ number_format($order->base_price) }}</span>
          </div>
          <div class="sum-row">
            <span class="lbl">Elements</span>
            <span class="val">₱{{ number_format($order->elements_cost) }}</span>
          </div>

          <div class="sum-divider"></div>

          <div class="sum-total">
            <span style="font-weight:800;font-size:.88rem;">Total</span>
            <span class="total-amt">₱{{ number_format($order->total_price) }}</span>
          </div>
        </div>
      </div>

      {{-- Customer details ─────────────────────────────────────────────────── --}}
      <div class="card">
        <div class="card-header"><i data-lucide="user"></i> Your Details</div>
        <div style="padding:20px;">
          <div class="sum-row">
            <span class="lbl">Name</span>
            <span class="val">{{ $order->first_name }} {{ $order->last_name }}</span>
          </div>
          <div class="sum-row">
            <span class="lbl">Contact</span>
            <span class="val">{{ $order->contact_number }}</span>
          </div>
          @if($order->notes)
            <div style="margin-top:10px;background:var(--grey-50);border-radius:8px;
                        border:1px solid var(--grey-200);padding:10px 12px;">
              <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;
                          letter-spacing:.06em;color:var(--grey-400);margin-bottom:4px;">Notes</div>
              <p style="margin:0;font-size:.8rem;font-weight:600;color:var(--ink-2);line-height:1.5;">
                {{ $order->notes }}
              </p>
            </div>
          @endif
        </div>
      </div>

      {{-- Order code ──────────────────────────────────────────────────────── --}}
      <div style="border:1.5px dashed var(--grey-300);border-radius:12px;
                  padding:16px;text-align:center;background:var(--white);">
        <div style="font-size:.65rem;font-weight:800;text-transform:uppercase;
                    letter-spacing:.08em;color:var(--grey-400);margin-bottom:6px;">
          Your Order Code
        </div>
        <div style="font-family:monospace;font-size:1.2rem;font-weight:900;
                    color:var(--pink-dk);letter-spacing:.06em;">
          {{ $order->order_code }}
        </div>
        <div style="font-size:.7rem;font-weight:600;color:var(--grey-400);margin-top:6px;">
          Show this at the shop to track your order.
        </div>
      </div>

    </div>{{-- /right --}}

  </div>{{-- /main-layout --}}

</div>{{-- /page-wrap --}}

{{-- ── Approve modal ─────────────────────────────────────────────────────────── --}}
<div class="overlay" id="approve-modal">
  <div class="modal-box">
    <div class="modal-icon">✅</div>
    <div class="modal-title">Approve this design?</div>
    <div class="modal-desc">
      Once you approve, your order is confirmed and we'll start crafting it.
      This cannot be undone.
    </div>
    <div class="modal-btns">
      <button class="modal-cancel"
              onclick="document.getElementById('approve-modal').classList.remove('open')">
        Go Back
      </button>
      <form action="{{ route('orders.approve', $order->order_code) }}"
            method="POST" style="flex:1;">
        @csrf
        <button type="submit" class="modal-confirm" style="width:100%;">
          Yes, Approve! 🌸
        </button>
      </form>
    </div>
  </div>
</div>

{{-- ── Lightbox ──────────────────────────────────────────────────────────────── --}}
<div class="overlay" id="lightbox"
     onclick="document.getElementById('lightbox').classList.remove('open')">
  <div style="max-width:90%;max-height:90vh;position:relative;"
       onclick="event.stopPropagation()">
    <img id="lightbox-img" src="" alt=""
         style="max-width:100%;max-height:85vh;border-radius:12px;"/>
    <button onclick="document.getElementById('lightbox').classList.remove('open')"
            style="position:absolute;top:-12px;right:-12px;width:32px;height:32px;
                   border-radius:50%;background:#fff;border:none;cursor:pointer;
                   font-size:1rem;font-weight:900;color:var(--ink);
                   display:flex;align-items:center;justify-content:center;">×</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => lucide.createIcons());

  function toggleRevisionForm(id) {
    document.getElementById(id).classList.toggle('open');
  }

  function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').classList.add('open');
  }
</script>
</body>
</html>