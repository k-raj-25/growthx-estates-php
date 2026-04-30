<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory;

    protected $table = 'website_city';
    public $timestamps = false;

    protected $fillable = ['name', 'slug', 'sort_order'];

    public function properties()
    {
        return $this->hasMany(Property::class, 'city_id');
    }

    protected static function booted(): void
    {
        static::saving(function (City $city): void {
            if ($city->name && !$city->slug) {
                $base = Str::limit(Str::slug($city->name) ?: 'city', 120, '');
                $candidate = $base;
                $n = 1;
                while (static::query()->where('slug', $candidate)->when($city->id, fn ($q) => $q->where('id', '!=', $city->id))->exists()) {
                    $suffix = '-'.$n;
                    $candidate = substr($base, 0, max(1, 140 - strlen($suffix))).$suffix;
                    $n++;
                }
                $city->slug = $candidate;
            }
        });
    }
}
