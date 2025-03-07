<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalEvent extends Model
{
    use HasFactory;
    protected $table = 'critical_events';

    protected $fillable = [
        'event_type', 'ip_address',	'email', 'count', 'event_time'
    ];
}
