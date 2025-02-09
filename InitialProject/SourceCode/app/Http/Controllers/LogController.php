<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index()
    {
        // ดึงข้อมูล Log ทั้งหมด
        $logs = Log::orderBy('date_time', 'desc')->paginate(10); // แสดง 10 รายการต่อหน้า

        return view('logs.index', compact('logs'));
    }

    function logAction($action)
    {
        Log::create([
            'kkumail' => Auth::check() ? Auth::user()->email : 'Guest', // ใช้ Auth::check() เพื่อตรวจสอบว่ามีผู้ใช้ล็อกอินหรือไม่
            'action' => $action,
            'date_time' => now()
        ]);
    }
}
