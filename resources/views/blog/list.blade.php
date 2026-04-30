@extends('base')
@section('title', 'Blog — GrowthX Estates')
@section('content')
    <main class="page-main blog-page">
      @include('partials.page_decor_blog')
      <section class="section blog-hero">
        <div class="section-inner blog-hero-inner">
          <p class="eyebrow reveal">INSIGHTS</p>
          <h1 class="section-title reveal">Journal</h1>
          <p class="blog-intro reveal">Market perspective, lifestyle, and stories from luxury real estate.</p>
        </div>
      </section>

      <section class="section blog-list-section">
        <div class="section-inner">
          @if($posts->count())
            <div class="blog-grid">
              @foreach($posts as $post)
                @php
                  $featuredImage = null;
                  if (!empty($post->featured_image)) {
                      $featuredImage = \Illuminate\Support\Str::startsWith($post->featured_image, ['http://', 'https://'])
                          ? $post->featured_image
                          : asset('storage/'.$post->featured_image);
                  } elseif (!empty($post->featured_image_url)) {
                      $featuredImage = $post->featured_image_url;
                  }
                  $excerpt = !empty($post->excerpt)
                      ? \Illuminate\Support\Str::words($post->excerpt, 28)
                      : \Illuminate\Support\Str::words(strip_tags((string) $post->body), 28);
                @endphp
                <article class="blog-card reveal">
                  <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}" class="blog-card-link">
                    @if($featuredImage)
                      <div class="blog-card-image">
                        <img src="{{ $featuredImage }}" alt="{{ $post->title }}" width="800" height="500" loading="lazy" />
                      </div>
                    @endif
                    <div class="blog-card-body">
                      <time class="blog-meta" datetime="{{ optional($post->published_at)->toIso8601String() }}">
                        {{ optional($post->published_at)->format('F j, Y') }}
                      </time>
                      <h2 class="blog-card-title">{{ $post->title }}</h2>
                      <p class="blog-card-excerpt">{{ $excerpt }}</p>
                      <span class="blog-read-more">Read article →</span>
                    </div>
                  </a>
                </article>
              @endforeach
            </div>

            @if($posts->hasPages())
              <nav class="blog-pagination" aria-label="Blog pagination">
                @if($posts->onFirstPage())
                @else
                  <a href="{{ $posts->previousPageUrl() }}" class="btn btn-outline">Newer</a>
                @endif
                <span class="blog-page-status">Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>
                @if($posts->hasMorePages())
                  <a href="{{ $posts->nextPageUrl() }}" class="btn btn-outline">Older</a>
                @endif
              </nav>
            @endif
          @else
            <p class="blog-empty">No articles yet. Check back soon.</p>
          @endif
        </div>
      </section>
    </main>
@endsection