<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'subtitle', 'excerpt', 'content', 
        'price', 'banner_image', 'start_date', 'end_date',
        'location_name', 'location_details', 'map_embed_url',
        'weekday_service_hours', 'weekend_service_hours',
        'admin_name', 'admin_phone', 'admin_email', 'admin_whatsapp', 'admin_photo',
        'status','show', 'published_at'
    ];

      protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'published_at' => 'datetime',
    ];

      // Relasi
    public function guestStars()
    {
        return $this->hasMany(GuestStar::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }
}
