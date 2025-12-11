<?php

namespace App\Http\Controllers;

use App\Models\Approve;
use App\Models\Cause;
use App\Models\Safety;
use App\Models\Tracking;
use App\Models\User;
use App\Models\Valldataemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon; 

class ApproveLoginController extends Controller
{

    public function loginWithToken(Request $request)
    {
        $token = $request->query('token');
        $Cause = null;
        $Safety = null;
        $approve = Tracking::where('login_token', $token)
            ->where('token_expires_at', '>=', now())
            ->first();           
 
        if(!$approve){
             return response()->view('approve.approve_expired', [
                        'message' => 'ไม่พบข้อมูลพนักงานในระบบภายนอก'
            ]);
        }

        // ล้าง token เพื่อป้องกัน Re-Use
        // $approve->login_token = null;
        // $approve->save();

        // ค้นหา user ตาม empid
        $user = User::where('empid', $approve->assign_id)->first();

        if (!$user) {
            // ✅ สร้าง user ใหม่อัตโนมัติ
            $DetailEmp = Valldataemp::where('CODEMPID', $approve->empid)
                ->where('STAEMP', '!=', '9')
                ->first();

                if (!$DetailEmp) {
                    return response()->view('approve.approve_expired', [
                        'message' => 'ไม่พบข้อมูลพนักงานในระบบภายนอก'
                    ]);
                }
            $user = User::create([
                'empid'         => $approve->empid,
                'fullname'      => $approve->approvename ?? 'Auto-generated',
                'email'         => $DetailEmp->EMAIL ?? null,
                'bu'            => $DetailEmp->alias_name ?? null,
                'dept'          =>  $DetailEmp->DEPT ?? null,
                'status'        => 1,
                'deleted'       => 0,
                'password'      => bcrypt(Str::random(16)), // รหัสผ่านสุ่ม (ไม่ได้ใช้จริง)
                'created_by'    => 'system-auto'
            ]);
        }
 

        // ล็อกอิน user (ทั้งที่มีอยู่แล้วหรือเพิ่งสร้าง)
        Auth::login($user);
        session()->regenerate();

        return redirect()->route('approve.page', 
            [
                // 'message' => 'เข้าสู่ระบบสำเร็จ',
                'id' => $approve->id, 
                             
            ]
        );
    }

  public function sheLoginWithToken(Request $request)
    {
         $token = $request->query('token');
        $Cause = null;
        $Safety = null;
        $approve = Tracking::where('login_token', $token)
            ->where('token_expires_at', '>=', now())
            ->first();           
 
        if(!$approve){
             return response()->view('sheapprove.sheapprove_expired', [
                        'message' => 'ไม่พบข้อมูลพนักงานในระบบภายนอก'
            ]);
        }

        // ล้าง token เพื่อป้องกัน Re-Use
        // $approve->login_token = null;
        // $approve->save();

        // ค้นหา user ตาม empid
        $user = User::where('empid', $approve->assign_id)->first();

        if (!$user) {
            // ✅ สร้าง user ใหม่อัตโนมัติ
            $DetailEmp = Valldataemp::where('CODEMPID', $approve->empid)
                ->where('STAEMP', '!=', '9')
                ->first();

                if (!$DetailEmp) {
                    return response()->view('approve.approve_expired', [
                        'message' => 'ไม่พบข้อมูลพนักงานในระบบภายนอก'
                    ]);
                }
            $user = User::create([
                'empid'         => $approve->empid,
                'fullname'      => $approve->approvename ?? 'Auto-generated',
                'email'         => $DetailEmp->EMAIL ?? null,
                'bu'            => $DetailEmp->alias_name ?? null,
                'dept'          =>  $DetailEmp->DEPT ?? null,
                'status'        => 1,
                'deleted'       => 0,
                'password'      => bcrypt(Str::random(16)), // รหัสผ่านสุ่ม (ไม่ได้ใช้จริง)
                'created_by'    => 'system-auto'
            ]);
        }
 

        // ล็อกอิน user (ทั้งที่มีอยู่แล้วหรือเพิ่งสร้าง)
        Auth::login($user);
        session()->regenerate();

        return redirect()->route('sheapprove.page', 
            [ 
                'id' => $approve->id, 
                             
            ]
        );
    }




      public function managerLoginWithToken(Request $request)
    {
         $token = $request->query('token');
        $Cause = null;
        $Safety = null;
        $approve = Tracking::where('login_token', $token)
            ->where('token_expires_at', '>=', now())
            ->first();           
 
        if(!$approve){
             return response()->view('manager.manager_expired', [
                        'message' => 'ไม่พบข้อมูลพนักงานในระบบภายนอก'
            ]);
        }

        // ล้าง token เพื่อป้องกัน Re-Use
        // $approve->login_token = null;
        // $approve->save();

        // ค้นหา user ตาม empid
        $user = User::where('empid', $approve->assign_id)->first();

        if (!$user) {
            // ✅ สร้าง user ใหม่อัตโนมัติ
            $DetailEmp = Valldataemp::where('CODEMPID', $approve->empid)
                ->where('STAEMP', '!=', '9')
                ->first();

                if (!$DetailEmp) {
                    return response()->view('manager.manager_expired', [
                        'message' => 'ไม่พบข้อมูลพนักงานในระบบภายนอก'
                    ]);
                }
            $user = User::create([
                'empid'         => $approve->empid,
                'fullname'      => $approve->approvename ?? 'Auto-generated',
                'email'         => $DetailEmp->EMAIL ?? null,
                'bu'            => $DetailEmp->alias_name ?? null,
                'dept'          =>  $DetailEmp->DEPT ?? null,
                'status'        => 1,
                'deleted'       => 0,
                'password'      => bcrypt(Str::random(16)), // รหัสผ่านสุ่ม (ไม่ได้ใช้จริง)
                'created_by'    => 'system-auto'
            ]);
        }
 

        // ล็อกอิน user (ทั้งที่มีอยู่แล้วหรือเพิ่งสร้าง)
        Auth::login($user);
        session()->regenerate();

        return redirect()->route('manager.page', 
            [ 
                'id' => $approve->id, 
                             
            ]
        );
    }

        // ✅ ใช้สำหรับลิงก์จากอีเมล
    public function showByToken(Request $request)
    {
        // ดึง token จาก query string ?token=...
        $token = $request->query('token');

        if (!$token) {
            abort(404, 'Token not found');
        }

        // หา tracking จาก token และยังไม่หมดอายุ
        $tracking = Tracking::where('login_token', $token)
            ->where('token_expires_at', '>=', Carbon::now())
            ->first();

        if (!$tracking) {
            return response()->view('approve.approve_expired', [
                'message' => 'Token หมดอายุหรือไม่ถูกต้อง',
            ]);
        }

          // ล้าง token เพื่อป้องกัน Re-Use
        // $tracking->login_token = null;
        // $tracking->save();

        // ค้นหา user ตาม empid
        $user = User::where('empid', $tracking->assign_id)->first();

        if (!$user) {
            // ✅ สร้าง user ใหม่อัตโนมัติ
            $DetailEmp = Valldataemp::where('CODEMPID', $tracking->empid)
                ->where('STAEMP', '!=', '9')
                ->first();

                if (!$DetailEmp) {
                    return response()->view('approve.approve_expired', [
                        'message' => 'ไม่พบข้อมูลพนักงานในระบบภายนอก'
                    ]);
                }
            $user = User::create([
                'empid'         => $tracking->empid,
                'fullname'      => $tracking->approvename ?? 'Auto-generated',
                'email'         => $DetailEmp->EMAIL ?? null,
                'bu'            => $DetailEmp->alias_name ?? null,
                'dept'          =>  $DetailEmp->DEPT ?? null,
                'status'        => 1,
                'deleted'       => 0,
                'password'      => bcrypt(Str::random(16)), // รหัสผ่านสุ่ม (ไม่ได้ใช้จริง)
                'created_by'    => 'system-auto'
            ]);
        }
 

        // ล็อกอิน user (ทั้งที่มีอยู่แล้วหรือเพิ่งสร้าง)
        Auth::login($user);
        session()->regenerate();

       
        return redirect()->route('approve.page', ['id' => $tracking->id]);
    }




}
