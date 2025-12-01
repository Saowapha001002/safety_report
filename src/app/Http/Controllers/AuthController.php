<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use App\Models\Valldataemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 
 
class AuthController extends Controller
{
    // Show login form
    public function index()
    {
        return view('auth.login');
    }
 
    // Process login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'empid' => 'required',
            'password' => 'required',
        ],[
            'empid.required' => 'กรุณากรอกรหัสพนักงาน',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
        ]);
 
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/main'); // Redirect after login
        }
 
        return back()->withErrors(['empid' => 'รหัสพนักงาน หรือ รหัสผ่านไม่ถูกต้อง']);
    }
 
    // Show register form
    public function showRegisterForm()
    {
        return view('auth.create');
    }
 
    public function CheckEmpID(Request $request)
    {
        $request->validate([
            'empid' => 'required|unique:users',
            'idcard' => 'required',
        ],[
            'empid.unique' => 'คุณสร้างบัญชีผู้ใช้ไปแล้วกรุณา Login',
        ]);
 
 
 
        $empid = $request->empid;
        $idcard = $request->idcard;
 
        $employees = Valldataemp::where('CODEMPID', $empid)
            ->where('NUMOFFID', $idcard)
            ->where('STAEMP', '!=', '9')
            ->first('CODEMPID');
 
        if ($employees) {
            return response()->json(['status' => 200, 'message' => 'พบข้อมูลพนักงาน', 'employees' => $employees], 200);
        } else {
            return response()->json(['status' => 404, 'message' => 'ไม่พบข้อมูล'], 200);
        }
    }
 
    // Process registration
    public function register(Request $request)
    {
        $request->validate([
            'empid' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);
 
 
        $empid = $request->empid;
        $password = $request->password;
 
        $DetailEmp = Valldataemp::where('CODEMPID', $empid)
            ->where('STAEMP', '!=', '9')
            ->first();
 
        if ($DetailEmp) {
            User::create([
                'empid' => $DetailEmp->CODEMPID,
                'fullname' => $DetailEmp->NAMFIRSTT . ' ' . $DetailEmp->NAMLASTT,
                'email' => $DetailEmp->EMAIL,
                'bu' => $DetailEmp->alias_name,
                'dept' => $DetailEmp->DEPT,
                // 'status' => $DetailEmp->STAEMP,
                'password' => Hash::make($password),
                'created_by' => $DetailEmp->CODEMPID,
            ]);
 
            try {
                return response()->json(['status' => 200, 'message' => 'สร้างบัญชีผู้ใช้เรียบร้อย'], 200);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['status' => 404, 'message' => 'ไม่สามารถสร้างบัญชีผู้ใช้ได้'], 200);
            }
        } else {
            return response()->json(['status' => 404, 'message' => 'ไม่พบข้อมูล'], 200);
        }
    }
 
    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
 
 