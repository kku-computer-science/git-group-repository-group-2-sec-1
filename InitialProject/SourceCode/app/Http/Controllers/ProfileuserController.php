<?php

namespace App\Http\Controllers;

use App\Models\Educaton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Paper;
use App\Models\Logs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ProfileuserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index(Request $request)
    {

        // รับค่าวันที่มาจากหน้าเว็บ
        $date = $request->input('date', old('date', Carbon::today()->format('Y-m-d')));
        $date_carbon = Carbon::parse($date);

        // query ข้อมูลของ logs ตามวันที่ที่ได้รับมา
        $logs = Logs::whereDate('created_at', $date)->get();

        // หาค่าผลรวมต่างๆ
        $summary = [
            'totalUsers' => User::count(),
            'totalResearch' => Paper::count(),
            'totalLogin' => $logs->where('activity_type', 'Login')->count(),
            'totalApiCall' => $logs->where('activity_type', 'Call Paper')->count(),
            'totalError' => $logs->where('activity_type', 'Error'),
        ];

        $criticalEvents = [
            [
                'type' => 'Login Failed',
                'title' => 'การพยายามเข้าสู่ระบบผิดพลาดหลายครั้ง',
                'email' => "example@gmail.com",
                'description' => 'IP: 192.168.1.100 - พยายามเข้าระบบ 12 ครั้งใน 5 นาที',
                'timeAgo' => '5 นาทีที่แล้ว',
                'date' => '2025-02-23'
            ],
            [
                'type' => 'Call Paper',
                'title' => 'API ถูกเรียกเกินจำนวนที่กำหนด',
                'email' => "example@gmail.com",
                'description' => 'API: Call Paper - ถูกเรียก 15 ครั้งใน 1 นาที',
                'timeAgo' => '2 นาทีที่แล้ว',
                'date' => '2025-02-22'
            ]
        ];

        // หาผู้ใช้ที่ยังอยู่ในระบบ
        $activeUser = Logs::select('email')
                            ->groupby('email')
                            ->havingRaw("COUNT(CASE WHEN activity_type = 'Login' THEN 1 END) > 
                                         COUNT(CASE WHEN activity_type = 'Logout' THEN 1 END)")
                            ->pluck('email');


        // เหตุการณ์สำคัญ (Critical event)
        // เช็คการล็อกอินไม่สําเร็จ
        $loginLastCalls = Logs::select('ip_address', DB::raw('MAX(created_at) as last_call'))
                                ->where('activity_type', 'Login Failed')
                                ->whereDate('created_at', $date)
                                ->groupBy('ip_address')
                                ->get();

        $loginFailed = [];

        foreach ($loginLastCalls as $record) {
            $endTime = Carbon::parse($record->last_call)->toDateTimeString();
            $startTime = Carbon::parse($record->last_call)->subMinute(2)->toDateTimeString();
        
            $loginAttempts = Logs::select('ip_address')
                                 ->where('activity_type', 'Login Failed')
                                 ->where('ip_address', $record->ip_address)
                                 ->whereBetween('created_at', [$startTime, $endTime])
                                 ->whereDate('created_at', $date)
                                 ->get();
        
            if ($loginAttempts->count() >= 5) {
                $loginFailed[] = [
                    'type' => 'Login Failed',
                    'title' => 'การล็อกอินผิดพลาดหลายครั้ง',
                    'user_pointer' => $record->ip_address,
                    'login_count' => $loginAttempts->count(),
                    'date' => $date,
                    'last_call' => $endTime,
                    'description' => 'IP: ' . $record->ip_address . ' - พยายามเข้าระบบ ' . $loginAttempts->count() . ' ครั้งภายใน 2 นาที',
                    'time_diff' => Carbon::parse($endTime)->diffInMinutes(Carbon::now()),
                ];
            }
        }



        // เช็คการเรียก API ที่มากเกินไป
        $apiLastCall = Logs::select('email', DB::raw('MAX(created_at) as last_call'))
                   ->where('activity_type', 'Call Paper')
                   ->whereDate('created_at', $date)
                   ->groupBy('email')
                   ->get();

        $apiCallWarning = [];

        foreach ($apiLastCall as $record) {
            $endTime = Carbon::parse($record->last_call)->toDateTimeString();
            $startTime = Carbon::parse($record->last_call)->subMinute(5)->toDateTimeString();

            // ตรวจสอบการเรียก API ในช่วงเวลา 1 นาที
            $emailCall = Logs::select('email')
                            ->where('activity_type', 'Call Paper')
                            ->where('email', $record->email)
                            ->whereBetween('created_at', [$startTime , $endTime])
                            ->whereDate('created_at', $date)
                            ->get();

            // ถ้าเรียก API เกิน 10 ครั้งในช่วงเวลา 5 นาที
            if ($emailCall->count() >= 10) {
                $apiCallWarning[] = [
                    'type' => 'Call Paper',
                    'title' => 'API ถูกเรียกเกินจำนวนที่กำหนด',
                    'user_pointer' => $record->email,
                    'call_count' => $emailCall->count(),
                    'date' => $date,
                    'last_call' => $endTime,
                    'description' => 'Email: ' . $record->email . ' - พยายามเรียก API ' . $emailCall->count() . ' ครั้งภายใน 5 นาที',
                    'time_diff' => Carbon::parse($endTime)->diffInMinutes(Carbon::now()),
                ];
            }
            // $apiCallWarning[] = $emailCall;
        }


        $warning = [
            'loginFailed' => $loginFailed,
            'apiCallWarning' => $apiCallWarning,
        ];
        // ส่งวันที่ที่เลือกไปให้ blade
        session(['selectedDate' => $date]);

        // dump($loginFailed);
      
        return view('dashboards.users.index', compact('summary', 'warning', 'criticalEvents', 'activeUser', 'apiLastCall', 'apiCallWarning', 'loginFailed'));
    }

    function profile()
    {
        return view('dashboards.users.profile');
    }
    function settings()
    {
        return view('dashboards.users.settings');
    }

    function updateInfo(Request $request)
    {
        event(new \App\Events\UserAction(Auth::user(), 'Update', 'Update Profile'));


        $validator = Validator::make($request->all(), [
            'fname_en' => 'required',
            'lname_en' => 'required',
            'fname_th' => 'required',
            'lname_th' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,

        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $id = Auth::user()->id;

            if ($request->title_name_en == "Mr.") {
                $title_name_th = 'นาย';
            }
            if ($request->title_name_en == "Miss") {
                $title_name_th = 'นางสาว';
            }
            if ($request->title_name_en == "Mrs.") {
                $title_name_th = 'นาง';
            }
            // $pos_en='';
            // $pos_th='';
            // $doctoral = '';
            $pos_eng = '';
            $pos_thai = '';
            if (Auth::user()->hasRole('admin') or Auth::user()->hasRole('student')) {
                $request->academic_ranks_en = null;
                $request->academic_ranks_th = null;
                $pos_eng = null;
                $pos_thai = null;
                $doctoral = null;
            } else {
                if ($request->academic_ranks_en == "Professor") {
                    $pos_en = 'Prof.';
                    $pos_th = 'ศ.';
                }
                if ($request->academic_ranks_en == "Associate Professo") {
                    $pos_en = 'Assoc. Prof.';
                    $pos_th = 'รศ.';
                }
                if ($request->academic_ranks_en == "Assistant Professor") {
                    $pos_en = 'Asst. Prof.';
                    $pos_th = 'ผศ.';
                }
                if ($request->academic_ranks_en == "Lecturer") {
                    $pos_en = 'Lecturer';
                    $pos_th = 'อ.';
                }
                if ($request->has('pos')) {
                    $pos_eng = $pos_en;
                    $pos_thai = $pos_th;
                    //$doctoral = null ;
                } else {
                    if ($pos_en == "Lecturer") {
                        $pos_eng = $pos_en;
                        $pos_thai = $pos_th . 'ดร.';
                        $doctoral = 'Ph.D.';
                    } else {
                        $pos_eng = $pos_en . ' Dr.';
                        $pos_thai = $pos_th . 'ดร.';
                        $doctoral = 'Ph.D.';
                    }
                }
            }
            $query = User::find($id)->update([
                'fname_en' => $request->fname_en,
                'lname_en' => $request->lname_en,
                'fname_th' => $request->fname_th,
                'lname_th' => $request->lname_th,
                'email' => $request->email,
                'academic_ranks_en' => $request->academic_ranks_en,
                'academic_ranks_th' => $request->academic_ranks_th,
                'position_en' => $pos_eng,
                'position_th' => $pos_thai,
                'title_name_en' => $request->title_name_en,
                'title_name_th' => $title_name_th,
                'doctoral_degree' => $doctoral,

            ]);

            if (!$query) {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'success']);
            }
        }
    }

    function updatePicture(Request $request)
    {
        event(new \App\Events\UserAction(Auth::user(), 'Update', 'Update Profile Picture'));
        $path = 'images/imag_user/';
        //return 'aaaaaa';
        $file = $request->file('admin_image');
        $new_name = 'UIMG_' . date('Ymd') . uniqid() . '.jpg';

        //dd(public_path());
        //Upload new image
        $upload = $file->move(public_path($path), $new_name);
        //$filename = time() . '.' . $file->getClientOriginalExtension();
        //$upload = $file->move('user/images', $filename);


        if (!$upload) {
            return response()->json(['status' => 0, 'msg' => 'Something went wrong, upload new picture failed.']);
        } else {
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

            if ($oldPicture != '') {
                if (\File::exists(public_path($path . $oldPicture))) {
                    \File::delete(public_path($path . $oldPicture));
                }
            }

            //Update DB
            $update = User::find(Auth::user()->id)->update(['picture' => $new_name]);

            if (!$upload) {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong, updating picture in db failed.']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Your profile picture has been updated successfully']);
            }
        }
    }


    function changePassword(Request $request)
    {
        event(new \App\Events\UserAction(Auth::user(), 'Update', 'Change Password'));
        //Validate form
        $validator = \Validator::make($request->all(), [
            'oldpassword' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, Auth::user()->password)) {
                        return $fail(__('The current password is incorrect'));
                    }
                },
                'min:8',
                'max:30'
            ],
            'newpassword' => 'required|min:8|max:30',
            'cnewpassword' => 'required|same:newpassword'
        ], [
            'oldpassword.required' => 'Enter your current password',
            'oldpassword.min' => 'Old password must have atleast 8 characters',
            'oldpassword.max' => 'Old password must not be greater than 30 characters',
            'newpassword.required' => 'Enter new password',
            'newpassword.min' => 'New password must have atleast 8 characters',
            'newpassword.max' => 'New password must not be greater than 30 characters',
            'cnewpassword.required' => 'ReEnter your new password',
            'cnewpassword.same' => 'New password and Confirm new password must match'
        ]);

        if (!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        } else {

            $update = User::find(Auth::user()->id)->update(['password' => \Hash::make($request->newpassword)]);

            if (!$update) {
                return response()->json(['status' => 0, 'msg' => 'Something went wrong, Failed to update password in db']);
            } else {
                return response()->json(['status' => 1, 'msg' => 'Your password has been changed successfully']);
            }
        }
    }
}
