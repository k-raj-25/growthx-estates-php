<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsEventsItem extends Model
{
    use HasFactory;

    protected $table = 'website_newseventsitem';

    protected $fillable = ['section','title','summary','image','image_url','link_url','is_published','sort_order'];

    protected $casts = ['is_published' => 'boolean'];
}
