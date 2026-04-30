<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteEnquiry extends Model
{
    use HasFactory;

    protected $table = 'website_siteenquiry';

    public const TYPE_CALLBACK = 'callback';
    public const TYPE_CONTACT = 'contact';

    protected $fillable = ['enquiry_type','name','phone','message','property_id'];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
