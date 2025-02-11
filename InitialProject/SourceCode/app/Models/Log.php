<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs'; // กำหนดชื่อตาราง

    protected $fillable = [
        'date_time',  // วันที่และเวลา
        'kkumail',    // อีเมลของผู้ใช้
        'action',     // กิจกรรมที่เกิดขึ้น
        'details',    // รายละเอียดเพิ่มเติม
    ];

    public $timestamps = false; // ไม่ใช้ timestamps (created_at, updated_at) อัตโนมัติ
}

