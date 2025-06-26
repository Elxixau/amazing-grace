<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_tickets',
        'use_grouping',
    ];
    
    public function groups()
    {
        return $this->hasMany(TicketGroup::class);
    }
}
