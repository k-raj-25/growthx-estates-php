<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'website_blogpost';

    protected $fillable = ['title','slug','excerpt','body','featured_image','featured_image_url','author_id','is_published','published_at'];

    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected static function booted(): void
    {
        static::saving(function (BlogPost $post): void {
            if ($post->title && !$post->slug) {
                $base = Str::limit(Str::slug($post->title) ?: 'post', 200, '');
                $candidate = $base;
                $n = 1;
                while (static::query()->where('slug', $candidate)->when($post->id, fn ($q) => $q->where('id', '!=', $post->id))->exists()) {
                    $suffix = '-'.$n;
                    $candidate = substr($base, 0, max(1, 220 - strlen($suffix))).$suffix;
                    $n++;
                }
                $post->slug = $candidate;
            }

            if ($post->is_published && !$post->published_at) {
                $post->published_at = now();
            }
        });
    }
}
