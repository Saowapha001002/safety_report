<?php


namespace App\Http\Controllers\Back;

use App\Models\Cause;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CauseController extends Controller
{
    public function index()
    {
        $cause = Cause::where('status','1')->get();
        return view('back.cause.index',compact('cause'));
    }

    public function list()
    {
        $cause = Cause::where('status','1')->get(); 
        return view('back.cause.list' ,compact('cause'));
    }
    public function create()
    {
        return view('back.cause.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cause' => 'required|string|max:255',           
        ],[
            'cause.required' => 'กรุณาระบุระดับความเสี่ยง',
            'cause.max' => 'ข้อมูลต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        ]);

        $cause = new Cause();
        $cause->cause = $request->cause; 
        $cause->status = '1';
        $cause->created_by = '1';
        $cause->save();
        return redirect()->route('cause.index')->with(['success' => 'success','message' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
    }

    public function edit($id)
    {
        $cause = Cause::find($id);
        return view('back.cause.edit',compact('cause'));
    }

    public function update(Request $request){
        $request->validate(['cause' => 'required|string|max:255',],
        [
            'cause.required' => 'กรุณาป้อนชื่อกิจกรรม',
            'cause.max' => 'ชื่อกิจกรรมต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        ]);

        $cause = Cause::find($request->id);
        $cause->cause = $request->cause; 
        $cause->status = '1';
        $cause->save();

        return redirect()->route('cause.index')->with(['success' => 'success','message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว']);
    }
}
