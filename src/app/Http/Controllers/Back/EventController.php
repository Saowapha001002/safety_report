<?php

namespace App\Http\Controllers\Back;

use App\Models\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventController extends Controller
{
     
    public function index()
    {
        $event = Event::where('status','1')->get();
        return view('back.event.index',compact('event'));
    }

    public function list()
    {
        $event = Event::where('status','1')->get(); 
        return view('back.event.list' ,compact('event'));
    }
    public function create()
    {
        return view('back.event.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'event' => 'required|string|max:255',
            'event_note' => 'required|string|max:500',
            
        ],[
            'event.required' => 'กรุณาระบุระดับความเสี่ยง',
            'event.max' => 'ข้อมูลต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        ]);

        $event = new Event();
        $event->event = $request->event;
        $event->event_note = $request->event_note;
        $event->status = '1';
        $event->created_by = '1';
        $event->save();
        return redirect()->route('event.index')->with(['success' => 'success','message' => 'บันทึกข้อมูลเรียบร้อยแล้ว']);
    }

    public function edit($id)
    {
        $event = Event::find($id);
        return view('event.edit',compact('event'));
    }

    public function update(Request $request){
        $request->validate(['event' => 'required|string|max:255',],
        [
            'event.required' => 'กรุณาป้อนชื่อกิจกรรม',
            'event.max' => 'ชื่อกิจกรรมต้องมีความยาวไม่เกิน 255 ตัวอักษร',
        ]);

        $event = Event::find($request->id);
        $event->event = $request->event;
        $event->event_note = $request->event_note;    
        $event->status = '1';
        $event->save();

        return redirect()->route('event.index')->with(['success' => 'success','message' => 'แก้ไขข้อมูลเรียบร้อยแล้ว']);
    }
}
