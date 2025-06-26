<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_code',
        'group_name',
        'name',
        'quota',
        'ticket_setting_id',
    ];                  
    
    public function setting()
    {
        return $this->belongsTo(TicketSetting::class, 'ticket_setting_id');
    }

}
