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
    public function index()
    {
        // ในการใช้งานจริง ควรดึงข้อมูลจาก Database
        // $activities = DB::table('user_activities')->orderBy('timestamp', 'desc')->get();

        // สำหรับการทดสอบ ใช้ข้อมูลจำลอง
        $activities = $this->getMockActivities();

        // ส่งข้อมูลประเภทกิจกรรมไปยัง view
        $activityTypes = $this->getActivityTypes();

        return view('exportLogReport.index', [
            'activities' => json_encode($activities),
            'activityTypes' => json_encode($activityTypes)
        ]);
    }

    /**
     * สร้างข้อมูลจำลองสำหรับกิจกรรมผู้ใช้งาน
     */
    private function getMockActivities()
    {

        $mock_data = [
            ["timestamp" => "2025-03-09T08:15:23", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-08T08:15:23", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-07T08:15:23", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-07T08:30:45", "username" => "user123", "ipAddress" => "192.168.1.102", "type" => "loginFail", "details" => "รหัสผ่านไม่ถูกต้อง", "status" => "fail"],
            ["timestamp" => "2025-03-07T09:12:10", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "create", "details" => "สร้างรายการสินค้าใหม่ #12345", "status" => "success"],
            ["timestamp" => "2025-03-07T09:45:33", "username" => "user456", "ipAddress" => "192.168.1.104", "type" => "update", "details" => "แก้ไขข้อมูลลูกค้า #7890", "status" => "success"],
            ["timestamp" => "2025-03-07T10:05:21", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "error", "details" => "เกิดข้อผิดพลาดในการเข้าถึงฐานข้อมูล", "status" => "fail"],
            ["timestamp" => "2025-03-07T10:30:15", "username" => "user789", "ipAddress" => "192.168.1.105", "type" => "delete", "details" => "ลบรายการสินค้า #5432", "status" => "success"],
            ["timestamp" => "2025-03-07T11:20:42", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "update", "details" => "อัพเดทสถานะคำสั่งซื้อ #6543", "status" => "success"],
            ["timestamp" => "2025-03-07T12:05:18", "username" => "user123", "ipAddress" => "192.168.1.102", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-07T12:45:33", "username" => "admin002", "ipAddress" => "192.168.1.106", "type" => "update", "details" => "แก้ไขข้อมูลบัญชีผู้ใช้ #3456", "status" => "success"],
            ["timestamp" => "2025-03-07T13:10:59", "username" => "user456", "ipAddress" => "192.168.1.104", "type" => "logout", "details" => "ออกจากระบบ", "status" => "success"],
            ["timestamp" => "2025-03-06T08:30:12", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-06T09:15:40", "username" => "user123", "ipAddress" => "192.168.1.102", "type" => "create", "details" => "สร้างรายงานยอดขาย #7788", "status" => "success"],
            ["timestamp" => "2025-03-06T10:05:22", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "loginFail", "details" => "รหัสผ่านไม่ถูกต้อง", "status" => "fail"],
            ["timestamp" => "2025-03-06T10:07:33", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-06T11:30:44", "username" => "user456", "ipAddress" => "192.168.1.104", "type" => "error", "details" => "เกิดข้อผิดพลาดในการอัพโหลดไฟล์", "status" => "fail"],
            ["timestamp" => "2025-03-06T12:20:15", "username" => "admin002", "ipAddress" => "192.168.1.106", "type" => "delete", "details" => "ลบบัญชีผู้ใช้ #1122", "status" => "success"],
            ["timestamp" => "2025-03-06T13:45:08", "username" => "user789", "ipAddress" => "192.168.1.105", "type" => "update", "details" => "อัพเดทข้อมูลส่วนตัว", "status" => "success"],
            ["timestamp" => "2025-03-06T14:30:51", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "logout", "details" => "ออกจากระบบ", "status" => "success"],
            ["timestamp" => "2025-03-05T08:45:33", "username" => "user123", "ipAddress" => "192.168.1.102", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-05T09:20:17", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "create", "details" => "สร้างผู้ใช้งานใหม่ #8877", "status" => "success"],
            ["timestamp" => "2025-03-05T10:10:42", "username" => "admin002", "ipAddress" => "192.168.1.106", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-05T11:05:19", "username" => "user456", "ipAddress" => "192.168.1.104", "type" => "update", "details" => "แก้ไขรายการสินค้า #9900", "status" => "success"],
            ["timestamp" => "2025-03-05T12:30:27", "username" => "user123", "ipAddress" => "192.168.1.102", "type" => "error", "details" => "เกิดข้อผิดพลาดในการสร้างรายงาน", "status" => "fail"],
            ["timestamp" => "2025-03-05T13:15:38", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "delete", "details" => "ลบรายการสั่งซื้อ #6677", "status" => "success"],
            ["timestamp" => "2025-03-05T14:40:11", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "logout", "details" => "ออกจากระบบ", "status" => "success"],
            // เพิ่มข้อมูลเพื่อแสดงถึงกิจกรรมย้อนหลัง 7 วัน
            ["timestamp" => "2025-03-04T09:15:23", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "loginSuccess", "details" => "เข้าสู่ระบบสำเร็จ", "status" => "success"],
            ["timestamp" => "2025-03-04T10:30:45", "username" => "user123", "ipAddress" => "192.168.1.102", "type" => "create", "details" => "สร้างข้อมูลสินค้า #3344", "status" => "success"],
            ["timestamp" => "2025-03-04T11:45:10", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "update", "details" => "แก้ไขข้อมูลสินค้า #5566", "status" => "success"],
            ["timestamp" => "2025-03-03T08:20:33", "username" => "user456", "ipAddress" => "192.168.1.104", "type" => "loginFail", "details" => "รหัสผ่านไม่ถูกต้อง", "status" => "fail"],
            ["timestamp" => "2025-03-03T09:05:21", "username" => "admin001", "ipAddress" => "192.168.1.101", "type" => "delete", "details" => "ลบข้อมูลลูกค้า #7788", "status" => "success"],
            ["timestamp" => "2025-03-02T10:15:15", "username" => "user789", "ipAddress" => "192.168.1.105", "type" => "error", "details" => "เกิดข้อผิดพลาดในการอัพโหลดไฟล์", "status" => "fail"],
            ["timestamp" => "2025-03-02T11:30:42", "username" => "manager01", "ipAddress" => "192.168.1.103", "type" => "logout", "details" => "ออกจากระบบ", "status" => "success"],
            // เพิ่มข้อมูลกิจกรรม Call Paper
            ["timestamp" => "2025-03-07T14:25:30", "username" => "researcher01", "ipAddress" => "192.168.1.110", "type" => "callPaper", "details" => "ส่งบทความวิจัย #P001", "status" => "success"],
            ["timestamp" => "2025-03-06T15:40:12", "username" => "researcher02", "ipAddress" => "192.168.1.111", "type" => "callPaper", "details" => "ส่งบทความวิจัย #P002", "status" => "success"],
            ["timestamp" => "2025-03-05T16:15:45", "username" => "researcher03", "ipAddress" => "192.168.1.112", "type" => "callPaper", "details" => "ส่งบทความวิจัย #P003", "status" => "success"],
            ["timestamp" => "2025-03-04T13:50:22", "username" => "researcher01", "ipAddress" => "192.168.1.110", "type" => "callPaper", "details" => "อัพเดทบทความวิจัย #P001", "status" => "success"],
        ];

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
                "details" => $data->activity_details,
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
}
