@php
    // When included via @include, $active is passed as the second argument array.
    // Fallback to empty string if not provided.
    $active = $active ?? '';

    $links = [
        'shop'      => ['href' => '#shop',      'label' => 'Shop'],
        'customize' => ['href' => '#customize', 'label' => 'Customize'],
        'gifts'     => ['href' => '#gifts',     'label' => 'Gifts'],
        'about'     => ['href' => '#about',     'label' => 'About'],
    ];
@endphp

<nav class="ac-nav navbar navbar-expand-lg py-2" id="mainNav">
    <div class="container">
        <a class="logo-wrap navbar-brand" href="{{ route('home') }}">
            <div class="logo-badge">
                <i data-lucide="package" style="width:20px;height:20px;"></i>
            </div>
            <span class="logo-letters ms-2">
                <span class="lc1">a</span><span class="lc2">r</span><span class="lc3">t</span><span class="lc4">s</span><span class="lc5">y</span><span class="lsp"></span><span class="lc3">c</span><span class="lc2">r</span><span class="lc1">a</span><span class="lc4">t</span><span class="lc5">e</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center gap-1 my-2 my-lg-0">
                @foreach ($links as $key => $link)
                <li>
                    <a class="nav-link nav-a {{ $active === $key ? 'active' : '' }}"
                       href="{{ $link['href'] }}">
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
                <li class="ms-2">
                    <a class="nav-link btn-nav" href="{{ route('builder.keychain') }}">
                        Order Now 🛍
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>