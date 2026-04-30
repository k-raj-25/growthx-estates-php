@extends('base')
@section('title', $post->title . ' — GrowthX Estates')
@section('content')
    @php
      $featuredImage = null;
      if (!empty($post->featured_image)) {
          $featuredImage = \Illuminate\Support\Str::startsWith($post->featured_image, ['http://', 'https://'])
              ? $post->featured_image
              : asset('storage/'.$post->featured_image);
      } elseif (!empty($post->featured_image_url)) {
          $featuredImage = $post->featured_image_url;
      }
    @endphp
    <main class="page-main blog-page blog-detail-page">
      @include('partials.page_decor_blog')
      <article class="section blog-article">
        <div class="section-inner blog-article-inner">
          <header class="blog-article-header reveal">
            <p class="eyebrow"><a href="{{ route('blog.list') }}">← Journal</a></p>
            <h1 class="blog-article-title">{{ $post->title }}</h1>
            <p class="blog-article-meta">
              <time datetime="{{ optional($post->published_at)->toIso8601String() }}">{{ optional($post->published_at)->format('F j, Y') }}</time>
              @if($post->author)
                <span class="blog-meta-sep">·</span>
                <span>{{ $post->author->name ?? $post->author->email }}</span>
              @endif
            </p>
          </header>

          @if($featuredImage)
            <div class="blog-article-featured reveal">
              <img src="{{ $featuredImage }}" alt="{{ $post->title }}" width="1200" height="675" loading="lazy" />
            </div>
          @endif

          <div class="blog-article-body ck-content reveal">
            {!! $post->body !!}
          </div>

          <footer class="blog-article-footer reveal">
            <a href="{{ route('blog.list') }}" class="btn btn-outline">All articles</a>
          </footer>
        </div>
      </article>
    </main>
@endsection