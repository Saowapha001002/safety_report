<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Rank;

class RankController extends Controller
{

    
    public function index()
    {
        $rank = Rank::where('status','1')->get();
        return view('back.rank.index',compact('rank'));
        // return view('back.rank.index',compact('rank'));
    }

    public function list()
    {
        $rank = Rank::where('status','1')->get(); 
        return view('back.rank.list' ,compact('rank'));
    }
    public function create()
    {
        return view('back.rank.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'rank' => 'required|string|max:255',
            'rank_mening' => 'required|string|max:500',
            'rank_action' => 'required|string|max:1000',
        ],[
            'rank.required' => 'กรุณาระบุระดับความเสี่ยง',
            'rank.max' => 'ข้อมูลต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        ]);

        $rank = new Rank();
        $rank->rank = $request->rank;
        $rank->rank_mening = $request->rank_mening;
        $rank->rank_action = $request->rank_action;
        $rank->status = '1';
        $rank->created_by = '1';
        $rank->save();

        return redirect()->route('rank.index')->with(['success' => 'success','message' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
    }

    public function edit($id)
    {
        $rank = Rank::find($id);
        return view('back.rank.edit',compact('rank'));
    }

    public function update(Request $request){
        $request->validate(['rank' => 'required|string|max:255',],
        [
            'rank.required' => 'กรุณาป้อนชื่อกิจกรรม',
            'rank.max' => 'ชื่อกิจกรรมต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        ]);

        $rank = Rank::find($request->id);
        $rank->rank = $request->rank;
        $rank->rank_mening = $request->rank_mening;
        $rank->rank_action = $request->rank_action;
        $rank->status = '1';
        $rank->save();

        return redirect()->route('rank.index')->with(['success' => 'success','message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว']);
    }


}