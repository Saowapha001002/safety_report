@extends('layouts.template')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-4">
        <!-- Congratulations card -->
        <div class="col-md-12 col-lg-12">
            @session('success')
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endsession
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead class="table-dark">
                        <tr>
                            <th>SAFETY CODE</th>       
                            <th>รหัสผู้รายงาน</th>
                            <th>ชื่อผู้รายงาน</th>
                            <th>สังกัดผู้รายงาน</th>
                            <th>วันที่ รายงาน</th>
                            <th>สถานที่พบ</th>
                            <th>สถานะเอกสาร</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($safeties as $safety)
                        <tr>
                            <td>{{ $safety->safety_code }}</td>
                            <td>{{ $safety->report_empid }}</td>
                            <td>{{ $safety->report_name }}</td>
                            <td>{{ $safety->report_plant }}</td>
                            <td>{{ $safety->report_date }}</td>
                            <td>{{ $safety->location_view }}</td>
                            <td>{{ $safety->status_text }}</td>
                             <td>
                                <a href="{{ route('checkmagicfinger.page', $safety->id) }}" class="btn btn-primary">ตรวจสอบ</a>
                            </td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                 
            </div>
        </div>
    </div>
</div>

@endsection

@section('jsvendor')

@endsection