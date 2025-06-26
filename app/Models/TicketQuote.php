<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketQuote extends Model
{
    protected $fillable = ['group_name', 'total_seats', 'available_seats'];
}
