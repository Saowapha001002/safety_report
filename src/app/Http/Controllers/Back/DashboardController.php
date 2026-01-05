<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
 
use Illuminate\Support\Str;
 use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; 
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function index()
    {
        // ดึงสถิติแยกตาม Plant (location_view) จากตาราง safety_report
        $dashboardData = DB::table('safety_report')
            ->select(
                'location_view', 
                DB::raw('count(*) as total'),
                DB::raw('sum(case when cause_id = 1 then 1 else 0 end) as unsafe_condition'),
                DB::raw('sum(case when cause_id = 2 then 1 else 0 end) as unsafe_action'),
                DB::raw('sum(case when event_id is not null then 1 else 0 end) as lsr_count'),
                DB::raw('sum(case when solve_status = 1 then 1 else 0 end) as solved_count')
            )
            ->where('deleted', 0)
            ->groupBy('location_view')
            ->orderBy('location_view', 'asc')
            ->get();

            $dashboardDataPie = DB::table('safety_report')
            ->select(
                'location_view',
                DB::raw('count(*) as total'),
                DB::raw('sum(case when solve_status = 1 then 1 else 0 end) as solved'),
                DB::raw('sum(case when solve_status != 1 then 1 else 0 end) as pending')
            )
            ->where('deleted', 0)
            ->groupBy('location_view')
            ->get();


        // ข้อมูลสำหรับ Pie Chart ภาพรวม (ประเภทอันตราย)
        $overallCause = DB::table('safety_report')
            ->select(
                DB::raw('sum(case when cause_id = 1 then 1 else 0 end) as condition_count'),
                DB::raw('sum(case when cause_id = 2 then 1 else 0 end) as action_count')
            )
            ->where('deleted', 0)
            ->first(); 

            // ข้อมูลสำหรับตารางและกราฟ Unsafe Condition
    $conditionStats = DB::table('safety_report')
        ->select(
            DB::raw('sum(case when solve_status = 1 then 1 else 0 end) as solved'),
            DB::raw('sum(case when solve_status != 1 then 1 else 0 end) as pending')
        )
        ->where('cause_id', 1) // 1 = Unsafe Condition
        ->where('deleted', 0)
        ->first();

    // ข้อมูลสำหรับตารางและกราฟ Unsafe Action
    $actionStats = DB::table('safety_report')
        ->select(
            DB::raw('sum(case when solve_status = 1 then 1 else 0 end) as solved'),
            DB::raw('sum(case when solve_status != 1 then 1 else 0 end) as pending')
        )
        ->where('cause_id', 2) // 2 = Unsafe Action
        ->where('deleted', 0)
        ->first();

    return view('back.dashboard.index', compact(
        'dashboardData', 
        'dashboardDataPie', 
        'overallCause', 
        'conditionStats', 
        'actionStats'
    ));
    
    }

    public function exportCsv()
{
    $headers = [
        "Content-type"        => "text/csv; charset=UTF-8",
        "Content-Disposition" => "attachment; filename=magic_finger_detailed_report_" . date('Ymd_His') . ".csv",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    // กำหนดหัวตารางให้ละเอียดขึ้น
    $columns = [
        'วันที่รายงาน', 'เลขที่ใบงาน', 'ชื่อผู้รายงาน', 'Plant', 'สถานที่พบ', 
        'ประเภทสภาพการณ์', 'Rank', 'สถานะการแก้ไข', 'วันที่แก้ไขสำเร็จ', 'ข้อเสนอแนะ'
    ];

    $callback = function() use($columns) {
        $file = fopen('php://output', 'w');
        // ใส่ BOM เพื่อให้ Excel เปิดแล้วไม่เป็นภาษาต่างดาว (รองรับภาษาไทย)
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($file, $columns);

        // ดึงข้อมูลรายรายการ Join กับ Tracking เพื่อเอาวันที่แก้ไข
        $data = DB::table('safety_report as r')
            ->leftJoin('safety_tracking as t', 'r.safety_code', '=', 't.safety_code')
            ->select(
                'r.report_date', 'r.safety_code', 'r.report_name', 'r.report_plant', 'r.location_view',
                'r.cause_id', 'r.rank_id', 'r.solve_status', 'r.solve_date', 'r.suggestion'
            )
            ->where('r.deleted', 0)
            ->orderBy('r.report_date', 'desc')
            ->get();

        foreach ($data as $row) {
            // แปลงค่า ID เป็นข้อความให้อ่านง่ายใน Excel
            $cause_text = ($row->cause_id == 1) ? 'Unsafe Condition' : 'Unsafe Action';
            $status_text = ($row->solve_status == 1) ? 'แก้ไขแล้ว' : 'ยังไม่ได้แก้ไข/รอการแก้ไข';
            
            $rank_text = '';
            if($row->rank_id == 1) $rank_text = 'Rank A';
            elseif($row->rank_id == 2) $rank_text = 'Rank B';
            elseif($row->rank_id == 3) $rank_text = 'Rank C';

            fputcsv($file, [
                $row->report_date ? Carbon::parse($row->report_date)->format('d/m/Y') : '-',
                $row->safety_code,
                $row->report_name,
                $row->report_plant,
                $row->location_view,
                $cause_text,
                $rank_text,
                $status_text,
                $row->solve_date ? Carbon::parse($row->solve_date)->format('d/m/Y') : '-',
                $row->suggestion
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}
