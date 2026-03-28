@php
$shopLinks    = ['Custom Prints' => '#', 'Tumblers & Mugs' => '#', 'Charms & Keys' => '#', '3D Prints' => '#', 'Gift Sets' => '#'];
$serviceLinks = ['Business Orders' => '#', 'Bulk Printing' => '#', 'DIY Workshop' => '#', 'Event Souvenirs' => '#'];
$helpLinks    = ['How to Order' => '#', 'FAQs' => '#', 'Pickup & Delivery' => '#', 'Contact Us' => '#'];
$socials      = [
    ['icon' => 'instagram',     'label' => '@artsycrate', 'href' => '#'],
    ['icon' => 'facebook',      'label' => 'ArtsyCrate',  'href' => '#'],
    ['icon' => 'shopping-cart', 'label' => 'Shopee',      'href' => '#'],
    ['icon' => 'video',         'label' => 'TikTok',      'href' => '#'],
];
@endphp

<footer class="ac-foot">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-4 col-md-6">
                <div class="flogo">
                    <span class="lc1">a</span><span class="lc2">r</span><span class="lc3">t</span><span class="lc4">s</span><span class="lc5">y</span><span class="lsp"></span><span class="lc3">c</span><span class="lc2">r</span><span class="lc1">a</span><span class="lc4">t</span><span class="lc5">e</span>
                </div>
                <div class="fsub">Prints, Customs & Creative Fun</div>
                <p class="fabout">Your one-stop creative shop for personalized gifts, custom prints, bag charms, keychains, and 3D printed wonders. Walk in. Create. Smile.</p>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="fhd">Shop</div>
                @foreach ($shopLinks as $label => $href)
                    <a href="{{ $href }}" class="flink">{{ $label }}</a>
                @endforeach
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="fhd">Services</div>
                @foreach ($serviceLinks as $label => $href)
                    <a href="{{ $href }}" class="flink">{{ $label }}</a>
                @endforeach
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="fhd">Help</div>
                @foreach ($helpLinks as $label => $href)
                    <a href="{{ $href }}" class="flink">{{ $label }}</a>
                @endforeach
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="fhd">Connect</div>
                @foreach ($socials as $s)
                    <a href="{{ $s['href'] }}" class="flink">
                        <i data-lucide="{{ $s['icon'] }}" style="width:12px;height:12px;margin-right:5px;"></i>
                        {{ $s['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

        <hr class="fdiv"/>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="fcopy mb-0">
                &copy; {{ date('Y') }} ArtsyCrate. All rights reserved.
                Made with <span class="fhrt">♥</span> in Parañaque.
            </p>
            <div class="d-flex gap-3">
                <a href="#" style="color:rgba(255,255,255,.22);font-size:.74rem;text-decoration:none;">Privacy Policy</a>
                <a href="#" style="color:rgba(255,255,255,.22);font-size:.74rem;text-decoration:none;">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>