<?php

namespace App\Http\Controllers;

use App\Models\Logs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExportReportController extends Controller
{
    /**
     * Display the activity report page.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     // ในการใช้งานจริง ควรดึงข้อมูลจาก Database
    //     // $activities = DB::table('user_activities')->orderBy('timestamp', 'desc')->get();

    //     // สำหรับการทดสอบ ใช้ข้อมูลจำลอง
    //     $activities = $this->getMockActivities();

    //     // ส่งข้อมูลประเภทกิจกรรมไปยัง view
    //     $activityTypes = $this->getActivityTypes();

    //     return view('exportLogReport.index', [
    //         'activities' => json_encode($activities),
    //         'activityTypes' => json_encode($activityTypes)
    //     ]);
    // }
    public function index()
    {
        // Get activity data
        $activities = $this->getMockActivities();
        
        // Get activity type config
        $activityTypes = $this->getActivityTypes();
        
        // Get current date range (default to last 7 days)
        $endDate = Carbon::now()->format('Y-m-d');
        $startDate = Carbon::now()->subDays(7)->format('Y-m-d');
        
        // Get visitor count for the default date range
        $visitorCount = DB::table('visitors')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();
        
        return view('exportLogReport.index', [
            'activities' => json_encode($activities),
            'activityTypes' => json_encode($activityTypes),
            'visitorCount' => json_encode($visitorCount)
        ]);
    }
    /**
     * สร้างข้อมูลจำลองสำหรับกิจกรรมผู้ใช้งาน
     */
    private function getMockActivities()
    {

        $log_data = [];
        $raw_data = Logs::all();

        foreach ($raw_data as $data) {
            $date = new \DateTime($data->created_at);
            $timestamp = $date->format('Y-m-d\TH:i:s');
            $log_data[] = [
                "timestamp" => $timestamp,
                "username" => $data->email,
                "ipAddress" => $data->ip_address,
                "type" => $data->activity_type,
                "details" => $data->details,
                "status" => $data->status,
                "device" => $data->device,
                "browser" => $data->browser,
            ];
        }

        // dd($log_data);

        return $log_data;
    }

    /**
     * ข้อมูลประเภทกิจกรรมและการแสดงผล
     */
    private function getActivityTypes()
    {
        return [
            "Login" => ["color" => "rgba(46, 204, 113, 0.7)", "label" => "Login Success"],
            "Login Failed" => ["color" => "rgba(231, 76, 60, 0.7)", "label" => "Login Failed"],
            "Logout" => ["color" => "rgba(52, 152, 219, 0.7)", "label" => "Logout"],
            "Error" => ["color" => "rgba(243, 156, 18, 0.7)", "label" => "Error"],
            "Create" => ["color" => "rgba(155, 89, 182, 0.7)", "label" => "Create"],
            "Update" => ["color" => "rgba(26, 188, 156, 0.7)", "label" => "Update"],
            "Delete" => ["color" => "rgba(211, 84, 0, 0.7)", "label" => "Delete"],
            "Call Paper" => ["color" => "rgba(41, 128, 185, 0.7)", "label" => "Call Paper"]
        ];
    }

    /**
     * สำหรับนำไปพัฒนาต่อในอนาคต: API สำหรับดึงข้อมูลตามเงื่อนไข
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilteredActivities(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $activityTypes = $request->input('activityTypes', []);

        // สำหรับการใช้งานจริง จะต้องดึงข้อมูลจาก Database
        // $query = DB::table('user_activities')->orderBy('timestamp', 'desc');

        // ถ้ามีการกำหนดช่วงวันที่
        // if ($startDate && $endDate) {
        //     $query->whereBetween('timestamp', [$startDate, $endDate]);
        // }

        // ถ้ามีการกำหนดประเภทกิจกรรม
        // if (!empty($activityTypes)) {
        //     $query->whereIn('type', $activityTypes);
        // }

        // $activities = $query->get();

        // สำหรับการทดสอบ ใช้ข้อมูลจำลอง และกรองข้อมูล
        $activities = $this->getMockActivities();

        // กรองข้อมูลตามเงื่อนไข
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate)->endOfDay();

            $activities = array_filter($activities, function ($activity) use ($start, $end) {
                $timestamp = Carbon::parse($activity['timestamp']);
                return $timestamp->between($start, $end);
            });
        }

        if (!empty($activityTypes)) {
            $activities = array_filter($activities, function ($activity) use ($activityTypes) {
                return in_array($activity['type'], $activityTypes);
            });
        }

        return response()->json([
            'success' => true,
            'data' => array_values($activities)
        ]);
    }

    public function getVisitors(Request $request)
    {
        try {
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            // Make sure we have valid date values
            if (!$startDate || !$endDate) {
                // Fallback to last 7 days if no dates provided
                $endDate = Carbon::now()->format('Y-m-d');
                $startDate = Carbon::now()->subDays(7)->format('Y-m-d');
            }

            // Log for debugging
            \Log::info('Visitor query params', [
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

            // Query visitors count
            $numVisitors = DB::table('visitors')
                ->whereDate('created_at', '>=', $startDate)
                ->whereDate('created_at', '<=', $endDate)
                ->count();

            // Log the result
            \Log::info('Visitor count', ['count' => $numVisitors]);

            return response()->json([
                'success' => true,
                'data' => $numVisitors
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching visitor count: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error fetching visitor count: ' . $e->getMessage()
            ], 500);
        }
    }
}
