<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $table = 'website_property';

    protected $fillable = [
        'slug','name','city_id','location','price_display','rating','status','project_type','brochure_url','description',
        'developer_name','about_developer','rera_id','project_size','map_embed_url','images','amenities','videos','faq','is_published','is_featured','sort_order',
    ];

    protected $casts = [
        'images' => 'array',
        'amenities' => 'array',
        'videos' => 'array',
        'faq' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'decimal:2',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function enquiries()
    {
        return $this->hasMany(SiteEnquiry::class, 'property_id');
    }

    public function getDisplayLocationAttribute(): string
    {
        return $this->city?->name ?: $this->location;
    }

    public static function getSimilar(self $property, int $limit = 3)
    {
        $others = static::query()->where('is_published', true)->where('id', '!=', $property->id)->with('city')->orderBy('sort_order')->orderBy('name')->get();
        $same = $others->where('status', $property->status);
        $rest = $others->where('status', '!=', $property->status);

        return $same->concat($rest)->take($limit)->values();
    }

    /** @return array<string, string> slug => label */
    public static function projectTypeOptions(): array
    {
        return [
            'commercial' => 'Commercial',
            'residential' => 'Residential',
            'sco' => 'SCO',
            'industrial' => 'Industrial',
        ];
    }

    /** @return list<array{0:string,1:string}> [slug, label] for Blade selects */
    public static function projectTypeTuples(): array
    {
        $out = [];
        foreach (self::projectTypeOptions() as $slug => $label) {
            $out[] = [$slug, $label];
        }

        return $out;
    }

    /** @return list<string> */
    public static function allowedProjectTypes(): array
    {
        return array_keys(self::projectTypeOptions());
    }

    public static function projectTypeLabel(?string $type): string
    {
        if ($type === null || $type === '') {
            return '';
        }

        return self::projectTypeOptions()[$type] ?? ucfirst($type);
    }

    protected static function booted(): void
    {
        static::saving(function (Property $property): void {
            if ($property->name && !$property->slug) {
                $base = Str::limit(Str::slug($property->name) ?: 'property', 120, '');
                $candidate = $base;
                $n = 1;
                while (static::query()->where('slug', $candidate)->when($property->id, fn ($q) => $q->where('id', '!=', $property->id))->exists()) {
                    $suffix = '-'.$n;
                    $candidate = substr($base, 0, max(1, 140 - strlen($suffix))).$suffix;
                    $n++;
                }
                $property->slug = $candidate;
            }
        });
    }
}
