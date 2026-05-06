@php
  $projectTypeLabel = \App\Models\Property::projectTypeLabel($p->project_type);
@endphp
<article
  class="property-browse-card {{ $extra_class ?? '' }}"
  @if(!empty($search_blob))data-search="{{ $search_blob }}"@endif
>
  <a href="{{ route('properties.detail', ['slug' => $p->slug]) }}" class="property-browse-card__link">
    <div class="property-browse-card__media">
      <img src="{{ $p->images[0] ?? '' }}" alt="" width="640" height="420" loading="lazy" />
      <span class="property-type-badge property-type-badge--{{ $p->project_type }}">{{ $projectTypeLabel }}</span>
      <span class="property-status-badge property-status-badge--{{ Illuminate\Support\Str::slug($p->status) }}">{{ $p->status }}</span>
    </div>
    <div class="property-browse-card__body">
      <div class="property-browse-card__row">
        <p class="property-browse-price">{{ $p->price_display }}</p>
        <p class="property-browse-rating" title="Average rating">{{ $p->rating }} / 5</p>
      </div>
      <p class="property-browse-name">{{ $p->name }}</p>
      <p class="property-browse-loc">{{ $p->display_location }}</p>
      <p class="property-browse-meta">{{ $p->project_size }}</p>
    </div>
  </a>
</article>
