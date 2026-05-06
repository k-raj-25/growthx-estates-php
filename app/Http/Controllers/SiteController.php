<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\CareersSettings;
use App\Models\City;
use App\Models\JobOpening;
use App\Models\Property;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $citiesWithListings = City::query()
            ->whereHas('properties', fn ($q) => $q->where('is_published', true))
            ->withCount(['properties as listing_count' => fn ($q) => $q->where('is_published', true)])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredProperties = Property::query()
            ->where('is_published', true)
            ->where('is_featured', true)
            ->with('city')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(3)
            ->get();

        return view('index', [
            'cities_with_listings' => $citiesWithListings,
            'featured_properties' => $featuredProperties,
            'status_choices' => [
                ['Ready to move', 'Ready to move'],
                ['Under construction', 'Under construction'],
                ['New launch', 'New launch'],
            ],
            'project_type_choices' => Property::projectTypeTuples(),
        ]);
    }

    public function properties(Request $request)
    {
        $query = Property::query()->where('is_published', true)->with('city');

        if ($q = trim((string) $request->query('q', ''))) {
            $query->where(function ($inner) use ($q) {
                $inner->where('name', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%")
                    ->orWhere('project_type', 'like', "%{$q}%")
                    ->orWhere('developer_name', 'like', "%{$q}%")
                    ->orWhere('rera_id', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('project_size', 'like', "%{$q}%")
                    ->orWhere('amenities', 'like', "%{$q}%")
                    ->orWhereHas('city', fn ($city) => $city->where('name', 'like', "%{$q}%"));
            });
        }

        if ($statuses = array_values(array_filter((array) $request->query('status', [])))) {
            $query->whereIn('status', $statuses);
        }

        if ($citySlug = trim((string) $request->query('city', ''))) {
            $query->whereHas('city', fn ($city) => $city->where('slug', $citySlug));
        }

        $projectType = trim((string) $request->query('project_type', ''));
        if (in_array($projectType, Property::allowedProjectTypes(), true)) {
            $query->where('project_type', $projectType);
        }

        $properties = $query->orderBy('sort_order')->orderBy('name')->get();

        $citiesWithListings = City::query()
            ->whereHas('properties', fn ($q) => $q->where('is_published', true))
            ->withCount(['properties as listing_count' => fn ($q) => $q->where('is_published', true)])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('properties.list', [
            'properties' => $properties,
            'cities_with_listings' => $citiesWithListings,
            'status_choices' => [
                ['Ready to move', 'Ready to move'],
                ['Under construction', 'Under construction'],
                ['New launch', 'New launch'],
            ],
            'project_type_choices' => Property::projectTypeTuples(),
            'active_statuses' => $statuses ?? [],
            'active_city_slug' => $citySlug ?? '',
            'active_project_type' => in_array($projectType, Property::allowedProjectTypes(), true) ? $projectType : '',
            'active_q' => $q ?? '',
            'has_active_filters' => (bool) (($q ?? '') || !empty($statuses ?? []) || ($citySlug ?? '') || in_array($projectType, Property::allowedProjectTypes(), true)),
        ]);
    }

    public function propertyDetail(string $slug)
    {
        $property = Property::query()->where('slug', $slug)->where('is_published', true)->with('city')->firstOrFail();

        return view('properties.detail', [
            'property' => $property,
            'similar_properties' => Property::getSimilar($property),
        ]);
    }

    public function about() { return view('about'); }
    public function contact() { return view('contact'); }
    public function support() { return view('support'); }
    public function privacyPolicy() { return view('privacy_policy'); }
    public function terms() { return view('terms'); }
    public function sitemap() { return view('sitemap'); }

    public function careers()
    {
        $settings = CareersSettings::query()->first();
        $openings = JobOpening::query()->where('is_published', true)->orderBy('sort_order')->orderByDesc('created_at')->get();
        $departments = $openings->pluck('department')->filter()->unique()->sort()->values();

        $payload = $openings->map(fn (JobOpening $o) => [
            'id' => $o->id,
            'title' => $o->title,
            'department' => $o->department ?? '',
            'location' => $o->location ?? '',
            'employmentType' => ucfirst(str_replace('_', '-', $o->employment_type)),
            'description' => $o->description,
            'responsibilities' => $o->responsibilities ?? '',
            'qualifications' => $o->qualifications ?? '',
        ])->values();

        return view('careers', [
            'openings' => $openings,
            'opening_departments' => $departments,
            'openings_payload' => $payload,
            'hr_email' => $settings?->hr_email ?: 'hello@growthestates.com',
        ]);
    }

    public function blogList()
    {
        $posts = BlogPost::query()
            ->where('is_published', true)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->with('author')
            ->orderByDesc('published_at')
            ->paginate(6);
        return view('blog.list', ['posts' => $posts]);
    }

    public function blogDetail(string $slug)
    {
        $post = BlogPost::query()->where('is_published', true)->where('slug', $slug)->with('author')->firstOrFail();
        return view('blog.detail', ['post' => $post]);
    }
}
