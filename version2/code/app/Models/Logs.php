<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $table = 'logs';

    protected $fillable = [
        'email', 'user_id', 'first_name', 'last_name', 'role',
        'ip_address', 'browser', 'device', 'activity_type', 'details'
    ];
}
