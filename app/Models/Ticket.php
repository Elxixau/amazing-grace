<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['name','ticket_id', 'email', 'seat_count','seat_group'];

     public function QrAccess()
    {
        return $this->hasOne(QrAccess::class, 'ticket_id', 'ticket_id');
    }

    public function group()
{
    return $this->belongsTo(TicketGroup::class, 'seat_group', 'group_code');
}
}
