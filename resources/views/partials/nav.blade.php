<header class="header">
  <a href="{{ route('index') }}" class="logo" aria-label="GrowthX Estates — Home">
    <img class="logo-img" src="{{ asset('static/img/Logo/growthX-logo-PNG.png') }}" width="180" height="40" alt="" />
  </a>
  <div class="nav-drawer"><nav class="nav" id="site-nav" aria-label="Main">
    <a href="{{ route('index') }}">Home</a>
    <a href="{{ route('properties.list') }}">Properties</a>
    <a href="{{ route('blog.list') }}">Blog</a>
    <a href="{{ route('careers') }}">Careers</a>
    <a href="{{ route('about') }}">About</a>
  </nav><a href="{{ route('contact') }}" class="btn btn-nav">Contact Us</a></div>
</header>