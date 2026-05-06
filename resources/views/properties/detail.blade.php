@extends('base')
@section('title', $property->name . ' — GrowthX Estates')
@section('content')
  @php
    $projectTypeLabel = \App\Models\Property::projectTypeLabel($property->project_type);
  @endphp
  <main class="page-main property-detail-page">
    @include('partials.page_decor_property_detail')
    <section class="section pd-hero-section">
      <div class="section-inner">
        <nav class="props-breadcrumbs reveal" aria-label="Breadcrumb">
          <a href="{{ route('index') }}">Home</a>
          <span class="props-bc-sep" aria-hidden="true">/</span>
          <a href="{{ route('properties.list') }}">Properties</a>
          <span class="props-bc-sep" aria-hidden="true">/</span>
          <span>{{ $property->name }}</span>
        </nav>

        <div class="pd-hero reveal">
          <div class="pd-hero-main">
            <p class="eyebrow">PROJECT</p>
            <h1 class="pd-title">{{ $property->name }}</h1>
            <p class="pd-location">{{ $property->display_location }}@if($property->city && $property->location) · {{ $property->location }}@endif</p>
            <div class="pd-hero-chips">
              <span class="property-type-badge property-type-badge--{{ $property->project_type }} property-type-badge--lg">{{ $projectTypeLabel }}</span>
              <span class="property-status-badge property-status-badge--{{ Illuminate\Support\Str::slug($property->status) }}">{{ $property->status }}</span>
              <span class="pd-chip pd-chip--muted">{{ $property->rating }} / 5 rating</span>
            </div>
          </div>
          <div class="pd-hero-side">
            <p class="pd-price">{{ $property->price_display }}</p>
            <a class="btn btn-primary pd-brochure-btn" href="{{ $property->brochure_url }}" target="_blank" rel="noopener noreferrer">
              Download brochure (PDF)
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="section pd-gallery-section">
      <div class="section-inner">
        <div class="pd-gallery reveal">
          <figure class="pd-gallery-main">
            <img
              id="pd-gallery-main-img"
              src="{{ $property->images[0] ?? '' }}"
              alt="{{ $property->name }} — photo 1 of {{ count($property->images ?? []) }}"
              width="1200"
              height="750"
              loading="eager"
            />
          </figure>
          <div class="pd-gallery-thumbs" role="tablist" aria-label="Gallery images">
            @foreach(($property->images ?? []) as $img)
              <button
                type="button"
                class="pd-gallery-thumb{{ $loop->first ? ' is-active' : '' }}"
                data-full-src="{{ $img }}"
                data-index="{{ $loop->iteration }}"
                aria-label="Show image {{ $loop->iteration }} of {{ count($property->images ?? []) }}"
                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
              >
                <img src="{{ $img }}" alt="" width="200" height="132" loading="lazy" />
              </button>
            @endforeach
          </div>
        </div>
      </div>
    </section>

    <section class="section pd-body-section">
      <div class="section-inner pd-body-grid">
        <div class="pd-body-primary">
          <div class="pd-block reveal">
            <h2 class="pd-block-title">Description</h2>
            <div class="pd-prose">
              <p>{{ $property->description }}</p>
            </div>
          </div>

          <div class="pd-block reveal">
            <h2 class="pd-block-title">Amenities</h2>
            <ul class="pd-amenities">
              @foreach(($property->amenities ?? []) as $a)
                <li class="pd-amenity">@include('properties.partials.amenity_icon', ['label' => $a])</li>
              @endforeach
            </ul>
          </div>

          <div class="pd-block reveal">
            <h2 class="pd-block-title">Videos</h2>
            <div class="pd-videos">
              @foreach(($property->videos ?? []) as $v)
                <div class="pd-video">
                  <p class="pd-video-label">{{ $v['title'] ?? '' }}</p>
                  <div class="pd-video-frame">
                    <iframe
                      src="{{ $v['embed_url'] ?? '' }}"
                      title="{{ $v['title'] ?? '' }}"
                      loading="lazy"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowfullscreen
                    ></iframe>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div class="pd-block reveal">
            <h2 class="pd-block-title">Location</h2>
            <div class="pd-map-frame">
              <iframe
                src="{{ $property->map_embed_url }}"
                title="Map — {{ $property->name }}"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen
              ></iframe>
            </div>
          </div>

          <div class="pd-block reveal">
            <h2 class="pd-block-title">About {{ $property->developer_name }}</h2>
            <p class="pd-prose">{{ $property->about_developer }}</p>
          </div>

          <div class="pd-block reveal">
            <h2 class="pd-block-title">FAQ</h2>
            <div class="pd-faq">
              @foreach(($property->faq ?? []) as $item)
                <details class="pd-faq-item"{{ $loop->first ? ' open' : '' }}>
                  <summary>{{ $item['q'] ?? '' }}</summary>
                  <p>{{ $item['a'] ?? '' }}</p>
                </details>
              @endforeach
            </div>
          </div>
        </div>

        <aside class="pd-body-aside reveal">
          <div class="pd-aside-card">
            <h3 class="pd-aside-title">Project facts</h3>
            <dl class="pd-dl">
              <div>
                <dt>Project type</dt>
                <dd>{{ $projectTypeLabel }}</dd>
              </div>
              <div>
                <dt>RERA ID</dt>
                <dd>{{ $property->rera_id }}</dd>
              </div>
              <div>
                <dt>Project size</dt>
                <dd>{{ $property->project_size }}</dd>
              </div>
              <div>
                <dt>Status</dt>
                <dd>{{ $property->status }}</dd>
              </div>
            </dl>
            <a class="btn btn-outline pd-aside-cta" href="{{ $property->brochure_url }}" target="_blank" rel="noopener noreferrer">Brochure PDF</a>
            <button type="button" class="btn btn-primary pd-aside-callback" data-open-callback-modal>
              Request a callback
            </button>
          </div>
        </aside>
      </div>
    </section>

    @if($similar_properties->isNotEmpty())
      <section class="section pd-similar-section" aria-labelledby="pd-similar-heading">
        <div class="section-inner">
          <p class="eyebrow reveal">YOU MAY ALSO LIKE</p>
          <h2 class="section-title reveal" id="pd-similar-heading">Similar properties</h2>
          <p class="pd-similar-lede reveal">
            More projects with matching availability—or curated alternatives our clients explore next.
          </p>
          <div class="properties-results-grid pd-similar-grid">
            @foreach($similar_properties as $p)
              @include('properties.partials.property_browse_card', ['p' => $p, 'extra_class' => 'reveal pd-similar-card'])
            @endforeach
          </div>
          <p class="pd-similar-all reveal">
            <a href="{{ route('properties.list') }}" class="btn btn-outline">View all properties</a>
          </p>
        </div>
      </section>
    @endif

    <div
      class="enquiry-modal"
      data-callback-modal
      aria-hidden="true"
      role="presentation"
    >
      <div class="enquiry-modal__backdrop" data-close-callback-modal tabindex="-1"></div>
      <div
        class="enquiry-modal__panel"
        role="dialog"
        aria-modal="true"
        aria-labelledby="callback-modal-title"
      >
        <button
          type="button"
          class="enquiry-modal__close"
          data-close-callback-modal
          aria-label="Close"
        >
          ×
        </button>
        <h2 class="enquiry-modal__title" id="callback-modal-title">Request a callback</h2>
        <p class="enquiry-modal__context">Regarding: <strong>{{ $property->name }}</strong></p>
        <form class="enquiry-modal__form js-enquiry-form" novalidate>
          @csrf
          <input type="hidden" name="enquiry_type" value="callback" />
          <input type="hidden" name="property_slug" value="{{ $property->slug }}" />
          <label class="enquiry-label">
            <span class="enquiry-label-text">Name</span>
            <input type="text" name="name" class="enquiry-input" required autocomplete="name" maxlength="120" />
            <span class="enquiry-field-error" data-error-for="name" hidden></span>
          </label>
          <label class="enquiry-label">
            <span class="enquiry-label-text">Phone (10 digits)</span>
            <input type="tel" name="phone" class="enquiry-input" required autocomplete="tel" inputmode="numeric" maxlength="20" />
            <span class="enquiry-field-error" data-error-for="phone" hidden></span>
          </label>
          <label class="enquiry-label">
            <span class="enquiry-label-text">Message <span class="enquiry-optional">(optional)</span></span>
            <textarea name="message" class="enquiry-input enquiry-textarea" rows="3" maxlength="2000"></textarea>
            <span class="enquiry-field-error" data-error-for="message" hidden></span>
          </label>
          <span class="enquiry-field-error enquiry-field-error--block" data-error-for="property_slug" hidden></span>
          <button type="submit" class="btn btn-primary enquiry-modal__submit">Send request</button>
          <p class="enquiry-form-status" data-enquiry-status hidden role="status"></p>
        </form>
      </div>
    </div>
  </main>
@endsection
@section('extra_js')
  <script src="{{ asset('static/js/property-detail.js') }}" defer></script>
@endsection
