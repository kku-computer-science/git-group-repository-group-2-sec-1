<?php

namespace App\Http\Controllers;

use App\Models\CriticalEvent;
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

        $criticalEvents = CriticalEvent::whereDate('event_time', $date)->get();
        $criticalEvents = $criticalEvents->map(function ($event) {
            return [
            'type' => $event->event_type,
            'title' => $event->title,
            'email' => $event->email,
            'description' => $event->count. ' ครั้ง' . 'จาก ip :' . $event->ip_address,
            'timeAgo' => Carbon::parse($event->created_at)->diffForHumans(),
            'date' => Carbon::parse($event->event_time)->format('Y-m-d')
            ];
        });
        $activeUser = User::where('last_activity', '>=', Carbon::now()->subMinutes(5))->count();

        $loginFailed = [];
        $loginAttempts = CriticalEvent::where('event_type', 'Login Failed')
            ->whereDate('event_time', $date)
            ->where('count', '>=', 5)
            ->get();
        foreach ($loginAttempts as $record) {
            $loginFailed[] = [
                'type' => 'Login Failed',
                'title' => 'การล็อกอินผิดพลาดหลายครั้ง',
                'user_pointer' => $record->ip_address,
                'login_count' => $record->count,
                'date' => $date,
                'last_call' => Carbon::parse($record->event_time)->toDateTimeString(),
                'description' => 'IP: ' . $record->ip_address . ' - พยายามเข้าระบบ ' . $record->count . ' ครั้งภายใน 1 นาที',
                'time_diff' => Carbon::parse($record->event_time)->diffInMinutes(Carbon::now()),
            ];
        }

        $apiCallWarning = [];
        $apiCallAttempts = CriticalEvent::where('event_type', 'Call Paper')
            ->whereDate('event_time', $date)
            ->where('count', '>=', 5)
            ->get();

        foreach ($apiCallAttempts as $record) {
            $apiCallWarning[] = [
            'type' => 'Call Paper',
            'title' => 'API ถูกเรียกเกินจำนวนที่กำหนด',
            'user_pointer' => $record->email,
            'call_count' => $record->count,
            'date' => $date,
            'last_call' => Carbon::parse($record->event_time)->toDateTimeString(),
            'description' => 'Email: ' . $record->email . ' - พยายามเรียก API ' . $record->count . ' ครั้งภายใน 1 นาที',
            'time_diff' => Carbon::parse($record->event_time)->diffInMinutes(Carbon::now()),
            ];
        }

        // ส่งวันที่ที่เลือกไปให้ blade
        session(['selectedDate' => $date]);

        // dump($loginFailed);

        return view('dashboards.users.index', compact('summary', 'activeUser', 'apiCallWarning', 'loginFailed'));
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
