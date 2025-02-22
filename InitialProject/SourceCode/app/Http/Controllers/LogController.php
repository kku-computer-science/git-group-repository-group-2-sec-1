<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use App\Models\Logs;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Concerns\ToArray;
use Illuminate\Support\Facades\Validator;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // รายการประเภทของกิจกรรมที่ใช้ในการค้นหา
        $activityTypesSelection = ["Login", "Login Failed", "Logout", "Create", "Update", "Delete", "Error", "Call Paper"];

        // รับค่าจาก Query String หรือ Form แบบ GET
        $search = trim($request->input('search', old('search')));
        $activityTypes = $request->input('activity_type', old('activity_type', []));
        $startDate = $request->input('start_date', old('start_date', Carbon::today()->format('Y-m-d')));
        $endDate = $request->input('end_date', old('end_date', Carbon::today()->format('Y-m-d')));
        $sortBy = $request->input('sort_by', old('sort_by', 'created_at'));
        $sortOrder = $request->input('sort_order', old('sort_order', 'desc'));

        // Validation
        $validator = Validator::make($request->all(), [
            'start_date' => [
                'nullable',
                'date',
                'before_or_equal:' . Carbon::today()->format('Y-m-d'),
                'after_or_equal:' . Carbon::today()->subDays(90)->format('Y-m-d'),
            ],
            'end_date' => [
                'nullable',
                'date',
                'before_or_equal:' . Carbon::today()->format('Y-m-d'),
                'after_or_equal:' . $startDate,
            ],
        ]);

        // ถ้า Validation ไม่ผ่าน ให้ Redirect กลับไปที่หน้าเดิมพร้อมกับข้อผิดพลาด
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ดึงข้อมูล Logs จากฐานข้อมูล
        $logs = Logs::query()
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('activity_type', 'like', "%$search%");
                });
            })
            ->when(!empty($activityTypes), function ($query) use ($activityTypes) {
                return $query->whereIn('activity_type', $activityTypes);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                return $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        // เพิ่ม Query String ให้กับ Pagination Links
        $logs->appends([
            'search' => $search,
            'activity_type' => $activityTypes,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ]);

        // ส่งข้อมูลไปยัง View
        return view('logs.index', compact(
            'logs',
            'search',
            'activityTypes',
            'activityTypesSelection',
            'startDate',
            'endDate',
            'sortBy',
            'sortOrder'
        ));
    }
    public function getLogs(Request $request)
    {
        // ดึงข้อมูล Logs ล่าสุด
        $logs = Logs::latest()->take(10)->get();  // หรือดัดแปลงตามที่ต้องการ

        // ส่งข้อมูล JSON กลับไปยัง client
        return response()->json($logs);
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

