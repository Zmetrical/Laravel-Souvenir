@php
    $pageTitle       = 'ArtsyCrate — Prints, Customs & Creative Fun';
    $pageDescription = 'Your one-stop creative shop for personalized gifts, custom prints, bag charms, keychains, and 3D printed wonders in Parañaque City.';
    $activePage      = 'home';
    $baseUrl         = '';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  @include('home.includes.head')
</head> 
<body>

  @include('home.includes.navbar')
  @include('home.includes.slider')
  @include('home.includes.svc-strip')
  @include('home.includes.section-personalized')
  @include('home.includes.cta-band')
  @include('home.includes.footer')

  {{-- Page-level JS (scroll reveal) --}}
  <script>
  (function () {

    /* Navbar shadow on scroll */
    const nav = document.getElementById('mainNav');
    if (nav) {
      window.addEventListener('scroll', () => {
        nav.classList.toggle('scrolled', window.scrollY > 30);
      }, { passive: true });
    }

    /* Scroll-reveal for .fade-up / .fade-left / .fade-right */
    const revEls = document.querySelectorAll('.fade-up, .fade-left, .fade-right');
    if ('IntersectionObserver' in window) {
      const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
          if (e.isIntersecting) { e.target.classList.add('vis'); io.unobserve(e.target); }
        });
      }, { threshold: 0.1 });
      revEls.forEach(el => io.observe(el));
    } else {
      revEls.forEach(el => el.classList.add('vis'));
    }

  })();
  </script>

</body>
</html>