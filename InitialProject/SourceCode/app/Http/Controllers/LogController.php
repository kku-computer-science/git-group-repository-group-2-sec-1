<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use App\Models\Logs;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $activityType = $request->input('activity_type');
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $logs = Logs::when($search, function ($query) use ($search) {
            return $query->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('activity_type', 'like', "%$search%");
        })
            ->when($activityType, function ($query) use ($activityType) {
                return $query->where('activity_type', $activityType);
            })
            ->when($date, function ($query) use ($date) {
                return $query->whereDate('created_at', $date);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10); // ใช้ pagination แทนการดึงข้อมูลทั้งหมด

        // ส่งข้อมูลไปยัง View
        return view('logs.index', compact('logs', 'search', 'activityType', 'date', 'sortBy', 'sortOrder'));
    }

    // ฟังก์ชันบันทึก Log ใหม่
    public function store(Request $request)
    {
        // Validation to ensure data is correct
        $request->validate([
            'email' => 'required|email',
            'activity_type' => 'required|string',
            'details' => 'nullable|string',
        ]);

        // Create Agent instance
        $agent = new \Jenssegers\Agent\Agent();

        // Get Browser and Device from User-Agent
        $browser = $agent->browser();   // Gets browser name
        $device = $agent->device();     // Gets device (e.g., Desktop, Mobile)

        // If request is coming from a real HTTP request (e.g., browser), then get the IP address
        $ipAddress = $request->ip();    // Gets IP address from the request

        // Save the log data to the database
        $log = Logs::create([
            'email' => $request->email,
            'user_id' => $request->user_id ?? null,
            'first_name' => $request->first_name ?? null,
            'last_name' => $request->last_name ?? null,
            'role' => $request->role ?? 'guest',
            'ip_address' => $ipAddress,        // IP Address from Request
            'browser' => $browser,             // Browser name extracted
            'device' => $device,               // Device type extracted
            'activity_type' => $request->activity_type,
            'details' => $request->details,
        ]);

        return response()->json([
            'message' => 'Log created successfully',
            'log' => $log
        ], 201);
    }

    // ใน Controller หรือ Middleware ที่ตอบสนองไฟล์
    public function downloadLog()
    {
        $logFile = storage_path('logs/laravel.log');

        // ตรวจสอบว่าไฟล์มีอยู่
        if (!file_exists($logFile)) {
            return redirect()->back()->with('error', 'Log file not found.');
        }
        $headers = [
            'Content-Type' => 'application/text',
        ];

        // ตั้ง headers สำหรับไฟล์ที่ดาวน์โหลด
        return response()->download($logFile, 'logFile.txt', $headers);
    }





}

