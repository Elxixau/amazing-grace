<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteLog extends Model
{
    use HasFactory;
     protected $fillable = ['user_id', 'method', 'uri', 'route', 'ip', 'logged_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSummaryAttribute()
{
    $action = match ($this->method) {
        'POST' => 'Menambahkan',
        'PUT', 'PATCH' => 'Mengedit',
        'DELETE' => 'Menghapus',
        'GET' => 'Mengakses',
        default => 'Mengakses',
    };

    // Ambil segmen route yang relevan, misal admin.tickets.store → tickets
    $nameParts = explode('.', $this->route ?? '');
    $target = $nameParts[1] ?? $this->uri;

    return "$action " . str_replace('_', ' ', $target);
}

}
