<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestStar extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id', 'name', 'role', 'photo',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
