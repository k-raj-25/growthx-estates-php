@extends('base')
@section('title', 'Properties — GrowthX Estates')
@section('content')
  <main class="page-main properties-page">
    @include('partials.page_decor_properties')
    <section class="section properties-hero-section">
      <div class="section-inner">
        <p class="eyebrow reveal">BROWSE</p>
        <h1 class="section-title reveal">Find your next address</h1>
        <p class="properties-lede reveal">
          Search projects or combine filters. Cities listed below are managed in admin and only appear when at least one
          published property is linked to them.
        </p>

        <div class="properties-refine-block reveal">
          <div class="properties-refine-shell">
          <form
            id="properties-filter-form"
            class="properties-filter-form"
            method="get"
            action="{{ route('properties.list') }}"
            aria-label="Filter and search properties"
          >
            <div class="properties-search-row">
              <label class="properties-search-wrap">
                <span class="visually-hidden">Search properties</span>
                <svg class="properties-search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                  <circle cx="11" cy="11" r="7" />
                  <path d="M21 21l-4.2-4.2" />
                </svg>
                <input
                  type="search"
                  name="q"
                  id="properties-search"
                  class="properties-search-input"
                  value="{{ $active_q }}"
                  placeholder="Search by name, area, developer, RERA, amenities…"
                  autocomplete="off"
                />
              </label>
              <button type="submit" class="btn btn-primary properties-search-submit">Search</button>
              <p class="properties-count" aria-live="polite">
                <span class="properties-count-num">{{ $properties->count() }}</span>
                <span class="properties-count-label">{{ $properties->count() === 1 ? 'listing' : 'listings' }}</span>
              </p>
            </div>

            <div class="properties-filters-panel">
              <div class="properties-filters-panel-head">
                <span class="properties-filters-panel-icon" aria-hidden="true">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round">
                    <path d="M4 6h16M4 12h10M4 18h16" />
                    <circle cx="18" cy="6" r="2" fill="currentColor" stroke="none" />
                    <circle cx="14" cy="12" r="2" fill="currentColor" stroke="none" />
                    <circle cx="20" cy="18" r="2" fill="currentColor" stroke="none" />
                  </svg>
                </span>
                <h2 class="properties-filters-panel-title">Refine</h2>
                @if($has_active_filters)
                  <a href="{{ route('properties.list') }}" class="properties-filters-reset">Reset all</a>
                @endif
              </div>

              <div class="properties-filters-panel-body">
                <div class="properties-filter-segment properties-filter-segment--status">
                  <h3 class="properties-filter-segment-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                      <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Status
                  </h3>
                  <div class="properties-status-pills">
                    @foreach($status_choices as [$value, $label])
                      <label class="properties-status-pill">
                        <input
                          type="checkbox"
                          name="status"
                          value="{{ $value }}"
                          @checked(in_array($value, $active_statuses, true))
                        />
                        <span class="properties-status-pill-ui">{{ $label }}</span>
                      </label>
                    @endforeach
                  </div>
                </div>

                <div class="properties-filter-row-type-location{{ $cities_with_listings->isEmpty() ? ' properties-filter-row-type-location--single' : '' }}">
                  <div class="properties-filter-segment properties-filter-segment--project-type">
                    <h3 class="properties-filter-segment-title">
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        <rect x="4" y="2" width="16" height="20" rx="1" />
                        <path d="M9 22V12h6v10M9 6h6M9 10h6" />
                      </svg>
                      Project type
                    </h3>
                    <div class="properties-project-type-wrap">
                      <select name="project_type" id="filter-project-type" class="properties-filter-select" aria-label="Filter by project type">
                        <option value="" @selected(!$active_project_type)>All types</option>
                        @foreach($project_type_choices as [$val, $label])
                          <option value="{{ $val }}" @selected($val === $active_project_type)>{{ $label }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  @if($cities_with_listings->isNotEmpty())
                    <div class="properties-filter-segment properties-filter-segment--location">
                      <h3 class="properties-filter-segment-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                          <circle cx="12" cy="10" r="3" />
                        </svg>
                        Location
                      </h3>
                      <div class="properties-city-select-wrap">
                        <select name="city" id="filter-city" class="properties-filter-select properties-filter-select--accent" aria-label="Filter by location">
                          <option value="" @selected(!$active_city_slug)>All locations with listings</option>
                          @foreach($cities_with_listings as $c)
                            <option value="{{ $c->slug }}" @selected($c->slug === $active_city_slug)>
                              {{ $c->name }} ({{ $c->listing_count }})
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </section>

    <section class="section properties-results-section">
      <div class="section-inner">
        @if($properties->isNotEmpty())
          <div class="properties-results-grid" id="properties-results">
            @foreach($properties as $p)
              @include('properties.partials.property_browse_card', ['p' => $p, 'extra_class' => 'reveal'])
            @endforeach
          </div>
        @else
          <p class="properties-empty" role="status">No properties match your filters. Try resetting filters or broadening your search.</p>
          @if($has_active_filters)
            <p class="properties-empty-actions">
              <a href="{{ route('properties.list') }}" class="btn btn-outline">View all properties</a>
            </p>
          @endif
        @endif
      </div>
    </section>
  </main>
@endsection
@section('extra_js')
  <script src="{{ asset('static/js/properties-filters.js') }}" defer></script>
@endsection
