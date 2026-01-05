@extends('layouts.template')
@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-4xl mx-auto shadow-xl rounded-lg overflow-hidden border border-gray-200">
    <div class="bg-white p-6 border-b-4 border-blue-600 flex items-center justify-between">
        <img src="{{ asset('assets/img/logo/BG_Logo.svg') }}" alt="Logo" class="h-16">
        <div class="text-right">
            <h1 class="text-2xl font-black text-blue-900 mb-0">MAGIC FINGER REPORT</h1>
            <span class="text-gray-500 text-sm">เลขที่ใบงาน: {{ $Tracking->safety_code }}</span>
        </div>
    </div>

    <form action="{{ route('checkmagicfinger.update', $Safety->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-gray-200 p-2 text-center font-bold border-b border-gray-300">
            ส่วนที่ 1 : สำหรับพนักงานเป็นผู้เขียนรายงาน ( ใบงานเลขที่ : {{ $Tracking->safety_code }})
        </div>

        <div class="grid grid-cols-2 border-b border-gray-300">
            <div class="p-2 border-r border-gray-300 flex items-center">
                <span class="mr-2 whitespace-nowrap">ชื่อ - นามสกุล ผู้รายงาน</span>
                <input type="text" name="reporter_name" value="{{ $Safety->report_name }}" class="w-full border-b border-dotted border-black outline-none bg-transparent">
            </div>
            <div class="p-2 flex items-center bg-blue-50">
                <span class="mr-2 whitespace-nowrap">สถานที่พบ/ บริเวณที่พบ</span>
                <select id="sLocation_view" name="sLocation_view" class="form-control">
                    <option value="">— เลือก Plant —</option>
                    @foreach ($plants as $p)
                    <option value="{{ $p->plant_code }}" @selected(old('sLocation_view', $Safety->location_view) == $p->plant_code)>
                        {{ $p->plant_code }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-2 border-b border-gray-300">
            <div class="p-2 border-r border-gray-300 flex items-center">
                <span class="mr-2 whitespace-nowrap">Plant</span>
                <input type="text" name="location_dept_view" value="{{ $Safety->location_dept_view }}" class="w-full border-b border-dotted border-black outline-none bg-transparent">
            </div>
            <div class="p-2 flex items-center bg-blue-50">
                <span class="mr-2 whitespace-nowrap">วัน/เดือน/ปี ที่พบ</span>
                <input type="date" name="report_date" value="{{ $Tracking->report_date ? \Carbon\Carbon::parse($Tracking->report_date)->format('Y-m-d') : '' }}" 
                class="w-full border-b border-dotted border-black outline-none bg-transparent text-blue-800">
            </div>
        </div>
        <div class="p-2 bg-blue-200 text-center font-bold text-sm border-b border-gray-300">
            ทำเครื่องหมาย ✓ หน้าประเภทของสภาพการณ์ที่พบ
        </div>
        <div class="p-3 space-y-2 border-b border-gray-300">
            @foreach ($Cause as $causeii)
            <div class="flex items-center gap-2">
                <input name="msCauseCheck" type="radio" value="{{ $causeii->id }}"
                    id="msCauseCheck_{{ $causeii->id }}"
                    onchange="toggleCause(this)"
                    @checked(old('msCauseCheck', $Safety->cause_id ?? '') == $causeii->id)>
                <label for="msCauseCheck_{{ $causeii->id }}" class="font-semibold cursor-pointer">
                    {{ $causeii->cause }}
                </label>
            </div>
            @endforeach
        </div>

        <div id="msEventSection" class="p-4 bg-gray-50 border-b border-gray-300"
            style="{{ old('msCauseCheck', $Safety->cause_id ?? '') == 2 ? '' : 'display: none;' }}">
            <p class="text-center font-bold text-sm mb-2 text-blue-800 italic">
                ประเภทของเหตุการณ์ที่พบ (Life Saving Rules) ***
            </p>
            <div class="grid grid-cols-2 gap-3 text-sm px-4">
                @foreach ($Event as $Events)
                <div class="flex items-center gap-2">
                    <input name="event_id" type="radio" value="{{ $Events->id }}"
                        id="msEvent_{{ $Events->id }}"
                        onchange="toggleOtherInput(this)"
                        @checked(old('event_id', $Safety->event_id ?? '') == $Events->id)>
                    <label for="msEvent_{{ $Events->id }}" class="font-semibold cursor-pointer">{{ $Events->event }}</label>
                </div>
                @endforeach
            </div>

            <div id="otherEventInput" class="mt-3 px-4"
                style="{{ old('event_id', $Safety->event_id ?? '') == 6 ? '' : 'display: none;' }}">
                <label class="text-xs font-bold text-red-600">กรุณาระบุเพิ่มเติม:</label>
                <input type="text" name="event_note" class="w-full border-b border-gray-400 outline-none bg-transparent"
                    value="{{ old('event_note', $Safety->event_note ?? '') }}">
            </div>
        </div>

        <div class="p-4 bg-gray-50 border-b border-gray-300 space-y-4">
            <div>
                <div class="text-blue-800 font-bold text-xs mb-1 uppercase tracking-wider">รายละเอียดเหตุการณ์</div>
                <textarea name="report_detail" class="w-full h-20 p-2 text-sm border border-gray-300 rounded outline-none bg-white shadow-sm focus:border-blue-500 transition-all">{{ $Safety->report_detail }}</textarea>
            </div>

            @if($Safety->report_img_before)
            <div class="bg-white p-2 border rounded shadow-sm inline-block">
                <p class="text-[10px] text-gray-500 italic mb-1">รูปภาพที่รายงาน:</p>
                <img class="rounded border" src="{{ asset('storage/' . $Safety->report_img_before) }}" style="max-width: 150px; height: auto;">
            </div>
            @endif


            @if($Safety->report_img_after)
            <div class="bg-white p-2 border rounded shadow-sm inline-block">
                <p class="text-[10px] text-gray-500 italic mb-1">รูปภาพที่แก้ไขแล้ว:</p>
                <img class="rounded border" src="{{ asset('storage/' . $Safety->report_img_after) }}" style="max-width: 150px; height: auto;">
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div class="flex flex-col space-y-2">
                    <label class="flex items-center cursor-pointer group">
                        <input type="radio" name="solve_status" value="1" class="w-4 h-4 text-blue-600" @checked($Safety->solve_status == 1)>
                        <span class="ml-2 font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">แก้ไขแล้ว / วันที่แก้ไข</span>
                        @if($Safety->solve_date)
                        <span class="ml-2 text-green-700 text-xs font-bold bg-green-50 px-2 py-0.5 rounded border border-green-200">
                            ({{ \Carbon\Carbon::parse($Safety->solve_date)->format('d/m/Y') }})
                        </span>
                        @endif
                    </label>
                    <div class="pl-6">
                        <p class="text-[10px] text-gray-500 mb-1 font-bold">แนบรูปหลังการแก้ไข (ถ้ามี):</p>
                        <input type="file" name="manager_img_after" class="text-xs file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    </div>
                </div>
                <div class="flex flex-col space-y-2">
                    <label class="flex items-center cursor-pointer group">
                        <input type="radio" name="solve_status" value="0" class="w-4 h-4 text-blue-600" @checked($Safety->solve_status == 0 )>
                        <span class="ml-2 font-semibold text-gray-700 group-hover:text-blue-600 transition-colors">ยังไม่ได้แก้ไข / รอการแก้ไข</span>
                    </label>                    
                </div>
            </div>
        </div>

        <div class="bg-yellow-100 p-2 text-center font-bold border-b border-gray-300 mt-4">
            ส่วนที่ 2 : สำหรับผู้จัดการฝ่าย/ ผู้ที่ได้รับมอบหมาย
        </div>
        <div class="p-4 bg-yellow-50 border-b border-gray-300 space-y-4">
            <div class="flex items-center space-x-4">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="assign_status" value="1" class="mr-2" @checked($Tracking->assign_status == 1)>
                    <span class="font-semibold">ดำเนินการแก้ไขเรียบร้อยแล้ว</span>
                    @if($Tracking->solve_date)
                    <span class="ml-2 text-blue-600">({{ \Carbon\Carbon::parse($Tracking->solve_date)->format('d/m/Y') }})</span>
                    @endif
                </label>
                <input type="file" name="assign_solve_img" class="text-xs">
            </div>

            <div class="flex items-center space-x-2">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="assign_status" value="2" class="mr-2" @checked($Tracking->assign_status == 2)>
                    <span class="font-semibold">รอการแก้ไข กำหนดเสร็จ:</span>
                </label>
                <input type="date" name="assign_solve_date"
                    value="{{ $Tracking->assign_solve_date ? \Carbon\Carbon::parse($Tracking->assign_solve_date)->format('Y-m-d') : '' }}"
                    class="border-b border-black outline-none bg-transparent">
            </div>

            @if($Safety->report_img_after)
            <div class="mt-2">
                <p class="text-[10px] text-gray-500 italic">รูปหลังการแก้ไข:</p>
                <img class="rounded border" src="{{ asset('storage/' . $Safety->report_img_after) }}" style="max-width: 150px;">
            </div>
            @endif

            <div class="bg-yellow-200/50 p-1 font-bold text-xs mt-2">ระบุรายละเอียดแนวทางการแก้ไข</div>
            <textarea name="manager_suggestion" class="w-full h-20 p-2 text-sm border rounded outline-none bg-white shadow-sm">{{ $Tracking->assign_solve_detail }}</textarea>
        </div>

        <div class="bg-gray-200 p-2 text-center font-bold border-b border-gray-300">
            ส่วนที่ 3 : ทบทวนการแก้ไขโดย SHE
        </div>
        <div class="p-4 bg-gray-50 border-b border-gray-300 space-y-4">
            <div class="flex items-center space-x-4">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="she_status" value="1" class="mr-2" @checked($Tracking->she_status == 1)>
                    <span class="font-semibold">ดำเนินการตรวจสอบแล้ว</span>
                    @if($Tracking->she_success_date)
                    <span class="ml-2 text-green-700">({{ \Carbon\Carbon::parse($Tracking->she_success_date)->format('d/m/Y') }})</span>
                    @endif
                </label>
                <input type="file" name="she_img" class="text-xs">
                
                 @if($Safety->she_solve_img)
                <div class="mt-2">
                    <p class="text-[10px] text-gray-500 italic">รูปหลังการแก้ไข:</p>
                    <img class="rounded border" src="{{ asset('storage/' . $Safety->she_solve_img) }}" style="max-width: 150px;">
                </div>
            @endif

            </div>

            <div class="flex items-center space-x-2">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" name="she_status" value="0" class="mr-2" @checked($Tracking->she_status == 0)>
                    <span class="font-semibold">รอการแก้ไข (SHE กำหนด):</span>
                </label>
                <input type="date" name="she_solve_date"  value="{{ $Tracking->she_solve_date ? \Carbon\Carbon::parse($Tracking->she_solve_date)->format('Y-m-d') : '' }}"   class="border-b border-black outline-none bg-transparent">
            </div>

            <div class="bg-gray-300/50 p-1 font-bold text-xs mt-2">ข้อเสนอแนะโดย SHE</div>
            <textarea name="she_suggestion" class="w-full h-20 p-2 text-sm border rounded outline-none bg-white shadow-sm">{{ $Tracking->she_suggestion }}</textarea>
        </div>

        <div class="p-4 text-center">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700 font-bold">
                บันทึกข้อมูล
            </button>
        </div>
    </form>
</div>

@endsection

@section('custom-backend-js')
<script src="{{ asset('assets/js/pages-checkmagicfinger.js') }}"></script>
