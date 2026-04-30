<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    use HasFactory;

    protected $table = 'website_jobopening';

    protected $fillable = ['title','department','location','employment_type','description','responsibilities','qualifications','is_published','sort_order'];

    protected $casts = ['is_published' => 'boolean'];
}
