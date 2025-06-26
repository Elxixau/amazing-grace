<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QrAccess extends Model
{
     public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = ['is_scanned','scanned_by', 'scanned_at','qr_path', 'ticket_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'scanned_by', 'id');
    }
}
