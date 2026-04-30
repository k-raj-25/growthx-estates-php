<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareersSettings extends Model
{
    use HasFactory;

    protected $table = 'website_careerssettings';

    protected $fillable = ['id', 'hr_email'];
    public $incrementing = false;

    protected static function booted(): void
    {
        static::saving(function (self $row): void {
            $row->id = 1;
        });
    }
}
