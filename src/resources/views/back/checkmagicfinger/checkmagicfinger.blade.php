@extends('layouts.template')
@section('content')
    <div class="container card invoice-preview-card" >
        <div class="card-body py-2 px-3">
            <div class="row gx-3 gy-2 align-items-center">
                <div class="row align-items-center mb-4 gx-3">
                    <!-- ซ้าย: โลโก้ + หัวข้อ -->
                    <div class="col-sm-6 d-flex align-items-center gap-3">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <img src="{{ asset('assets/img/logo/BG_Logo.svg') }}" alt="Logo" width="80" height="80">
                            <h4 class="mb-0 fw-bold text-primary">แบบฟอร์มรายงาน Magic Finger</h4>
                        </div>
                    </div>
                    <!-- ขวา: เลขที่ใบงาน -->
                    <div class="col-sm-6 d-flex justify-content-end align-items-center mt-3 mt-md-0 gap-3">
                        <div style="mb-0 fw-bold text-primary text-end">
                            <h4 class="mb-0 fw-bold text-primary text-end"> ใบงานเลขที่ : {{ $Tracking->safety_code }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
            <div class="card mb-4">
                <!-- Account -->
                <div class="card-body pt-2 mt-1">
                    <form id="formAccountSettings" method="GET" onsubmit="return false"  class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                        <div class="row mt-2 gy-4">
                            <div class="col-md-6 fv-plugins-icon-container">
                                <h4 class="h4 text-primary mb-0 app-brand-text fw-bold">ส่วนที่ 1 สำหรับพนักงานเป็นผู้รายงาน</h4>
                                <div class="form-floating form-floating-outline">
                                    <h5 class="card-header text-primary">ผู้รายงาน : {{ $Tracking->assign_name }}</h5>
                                </div>
                                <div  class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="col-md-6 fv-plugins-icon-container">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" name="assign_name" id="assign_name"
                                        value=" {{ \Carbon\Carbon::parse($Tracking->report_date)->format('d/m/Y') }}">
                                    <label for="assign_name" class="text-primary"> วัน/เดือน/ปี ที่พบ: </label>
                                </div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input class="form-control" type="text" name="location_view" id="location_view"    value="{{ $Safety->location_view }}"> 
                                    <label for="location_view"  class="h6 col-3 text-primary mb-0 app-brand-text fw-bold">หน่วยงานที่พบ : </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control text-primary" id="location_dept_view"
                                        value="{{ $Safety->location_dept_view }}">
                                    <label for="organization" class="text-primary">แผนกที่พบ:</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-merge"> 
                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($Cause as $causeii)
                                            <div class="d-flex align-items-center gap-2">
                                                <input name="msCauseCheck" class="form-check-input" type="radio"
                                                    value="{{ $causeii->id }}" id="msCauseCheck_{{ $causeii->id }}"
                                                    onchange="toggleCause(this)"
                                                    {{ old('msCauseCheck', $selectedCauseId ?? '') == $causeii->id ? 'checked' : '' }}>
                                                <label for="msCauseCheck_{{ $causeii->id }}" class="form-check-label"  style="margin: 0; font-weight: 600; min-height: 24px;">
                                                    {{ $causeii->cause }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-floating form-floating-outline">
                                    <div class="d-flex flex-column gap-2">
                                        @foreach ($Event as $Events)
                                            <div class="d-flex align-items-center gap-2">
                                                <input name="msEvent" class="form-check-input" type="radio"   value="{{ $Events->id }}" id="msEvent_{{ $Events->id }}"  onchange="toggleOtherInput(this)"
                                                    {{ old('msEvent', $selectedEventId ?? '') == $Events->id ? 'checked' : '' }}>
                                                <label for="msEvent_{{ $Events->id }}" class="form-check-label"  style="margin: 0; font-weight: 600; min-height: 24px;">{{ $Events->event }}</label>
                                            </div>
                                        @endforeach
                                        <div id="otherEventInput" class="mt-3" style="display: none;">
                                            <label for="other_event_text" class="form-label">กรุณาระบุเพิ่มเติม</label>
                                            <input type="text" name="other_event_text" id="other_event_text"  class="form-control"  value="{{ old('other_event_text', $Safety->event_note ?? '') }}">
                                        </div>

                                    </div>
                                </div>

                                </div>
                            </div>
                            <div class="col-md-6"   id="eventSection" >
                               
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline">
                                    <div class="col-md-6 d-flex align-items-start flex-column">
                                        @if ($Safety->report_img_before)
                                            <label class="form-label fw-bold">รูปเดิม:</label>
                                            <img src="{{ asset('storage/' . $Safety->report_img_before) }}"
                                                alt="Report Image Before" class="img-fluid mt-2"    style="max-width: 75%; border: 1px solid #ccc; border-radius: 8px;">
                                        @else
                                            <p class="text-muted">Old Photo</p>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <div class="button-wrapper">
                                        <label for="upload" class="btn btn-primary me-2 mb-3 waves-effect waves-light"   tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input"   hidden="" accept="image/png, image/jpeg">
                                        </label>
                                        <button type="button"   class="btn btn-outline-danger account-image-reset mb-3 waves-effect">
                                            <i class="mdi mdi-reload d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button> 
                                        <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        
                            
                            <div class="col-md-6"> 
                            </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2 waves-effect waves-light">Save
                                changes</button>
                            <button type="reset" class="btn btn-outline-secondary waves-effect">Reset</button>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="col-sm-12 col-lg-12 p-2">
                <div class="card shadow-none border p-2 h-90 mb-3">

                    <div class="d-flex justify-content-between flex-wrap">





                        <div class="mb-4 mt-3">
                            <table class="table table-borderless w-100" style="table-layout: fixed;">
                                <tbody>
                                    {{-- Row 1: ผู้รายงาน + หน่วยงานที่พบ --}}
                                    <div class="card-body">

                                    </div>

 

                                </tbody>
                            </table>

                        </div>


                    </div>

                    <div class="my-6">

                        <div class="d-flex rounded position-relative pe-1">
                            <hr class="my-0">
                            <div class="row flex-grow-1">


                                <table class="table table-borderless w-100">
                                    <tbody>
                                        {{-- ชื่อ - นามสกุล --}}
                                        <tr class="align-top">
                                            <td class="pe-4 text-end align-middle" style="width: 30%;">

                                            </td>
                                            <td class="h5">

                                            </td>
                                        <tr>
                                            <td>
                                            </td>
                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>



                                <div class="row mb-4">


                                    {{-- ขวา: input สำหรับอัปโหลดไฟล์ใหม่ --}}
                                    <div class="col-md-6">
                                        <label for="report_img_before" class="form-label fw-bold">
                                            {{ $Safety->report_img_before ? 'เปลี่ยนรูปใหม่:' : 'อัปโหลดรูป:' }}
                                        </label>
                                        <input class="form-control" type="file" name="report_img_before"
                                            id="report_img_before" accept="image/*">
                                        <div class="form-text ">
                                            <label for="report_img_before" class="form-label text-black">
                                                ระบุรายละเอียด
                                            </label>
                                            <input type="text" class="form-control" id="report_detail"
                                                value="{{ $Safety->report_detail }}" placeholder="ระบุรายละเอียด"
                                                aria-label="report_detail">
                                        </div>

                                    </div>
                                </div>



                                <div class="card-body p-3 pt-2">

                                    <div class="d-flex justify-content-between align-items-center p-2">
                                        @if ($Safety->solve_status == 0)
                                            <span class="badge rounded-pill bg-label-warning ">
                                                ยังไม่แก้ไข
                                            @else
                                                <span class="badge rounded-pill bg-label-primary "> ผู้รายงานแก้ไขแล้ว
                                        @endif
                                        </span>
                                        <p class="d-flex align-items-center justify-content-center gap-1 mb-0">

                                            @if ($Safety->solve_date = null)
                                                <span class="text-warning">
                                                    <i class="mdi mdi-star me-1"></i>
                                                </span>
                                                <span class="fw-normal">
                                                    -
                                                @else
                                                    <span class="text-success">
                                                        <i class="mdi mdi-star me-1"></i> แก้ไขแล้ว วันที่
                                                    </span>
                                                    <span class="fw-normal">
                                                        {{ \Carbon\Carbon::parse($Safety->solve_date)->format('d/m/Y') }}
                                            @endif
                                            </span>
                                        </p>
                                    </div>
                                    <div class="progress rounded-pill mb-4" style="height: 8px">
                                        <div class="progress-bar @if ($Safety->solve_status == 0) 0                                 
                                                                    @else
                                                                    w-100 @endif"
                                            role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="0">
                                        </div>
                                    </div>
                                </div>
                                <span class="h4 p-3 pt-2 mb-0 app-brand-text fw-bold">ระดับความรุนเเรง</span>
                                <div class="col-sm-6 col-lg-3 mb-1">
                                    <div class="card {{ $Class_rank }}  h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2 pb-1">
                                                <div class="avatar me-2">
                                                    <span class="avatar-initial   rounded {{ $Class_rank_label }} ">
                                                        <i class="mdi mdi-source-fork mdi-20px"></i>
                                                    </span>
                                                </div>
                                                <h4 class="ms-1 mb-0 display-6">
                                                    {{ $Rank->rank }}</h4>
                                            </div>
                                            <p class="mb-0 text-heading">
                                                {{ $Rank->rank_mening }}</p>
                                            <p class="mb-0">
                                                <span class="me-1">{{ $Rank->rank_action }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3 pt-2">
                                    <span class="h4 mb-0 app-brand-text fw-bold">ข้อเสนอแนะในการแก้ไข:
                                    </span>
                                    <span class="h5 bg-label-primary">{{ $Safety->suggestion }} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="my-1" />
        <div class="card-body">
            <div class="card shadow-none border p-2 h-90 mb-3">
                <div class="mb-3" data-repeater-list="group-a">
                    <span class="h4 text-primary mb-0 app-brand-text fw-bold">ส่วนที่ 2 : สำหรับผู้จัดการฝ่าย /
                        ผู้ได้รับมอบหมาย</span>
                    <div class="row">

                        @if ($Tracking->assign_solve_img == null)
                        @else
                            <div class="rounded-2 text-center mb-3">
                                <img class="img-fluid" src="{{ asset('storage/' . $Tracking->assign_solve_img) }}">
                            </div>
                        @endif


                        <div class="card-body p-3 pt-2">
                            <span class="h4 mb-0 app-brand-text fw-bold">การดำเนินการแก้ไข</span>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if ($Tracking->assign_status == 0)
                                    <span class="badge rounded-pill bg-label-warning">ยังไม่แก้ไข
                                    @else
                                        <span class="badge rounded-pill bg-label-primary">ผู้ได้รับมอบหมาย
                                            ดำเนินการแก้ไขเรียบร้อยแล้ว
                                @endif
                                </span>
                                <p class="d-flex align-items-center justify-content-center gap-1 mb-0">
                                    @if (!$Tracking->assign_solve_date)
                                        <span class="text-warning">
                                            <i class="mdi mdi-star me-1"></i>แก้ไขแล้ววันที่
                                        </span>
                                        <span class="fw-normal">
                                            {{ \Carbon\Carbon::parse($Tracking->assign_success_date)->format('d/m/Y') }}
                                        @else
                                            <span class="text-warning">
                                                <i class="mdi mdi-star me-1"></i>กำหนดเสร็จ</span>
                                            <span class="fw-normal">
                                                {{ \Carbon\Carbon::parse($Tracking->assign_solve_date)->format('d/m/Y') }}
                                    @endif
                                    </span>
                                </p>
                            </div>
                            <div class="progress rounded-pill mb-1" style="height: 8px">
                                <div class="progress-bar @if ($Tracking->assign_status == 0) 0                                 
                                                                    @else
                                                                    w-100 @endif"
                                    role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="0">
                                </div>
                            </div>

                            <div class="card-body p-3 pt-2">
                                <span class="h4 mb-0 app-brand-text fw-bold">ระบุรายละเอียดแนวทางการแก้ไข:</span>
                                <span class="h5 bg-label-primary">{{ $Tracking->assign_solve_detail }}</span>


                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <hr class="my-1" />
        <div class="card-body">
            <div class="card shadow-none border p-2 h-90 mb-3">
                <div class="mb-3" data-repeater-list="group-a">
                    <span class="h4 text-primary mb-0 app-brand-text fw-bold">ส่วนที่ 3 : ทบทวนแก้ไขโดย SHE </span>
                    <div class="row">
                        @if ($Tracking->assign_solve_img == null)
                        @else
                            <div class="rounded-2 text-center mb-3">
                                <img class="img-fluid" src="{{ asset('storage/' . $Tracking->assign_solve_img) }}">
                            </div>
                        @endif
                        <div class="card-body p-3 pt-2">
                            <span class="h4 mb-0 app-brand-text fw-bold">การดำเนินการแก้ไข</span>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if ($Tracking->she_status == 0)
                                    <span class="badge rounded-pill bg-label-warning">ยังไม่แก้ไข
                                    @else
                                        <span class="badge rounded-pill bg-label-primary">SHE
                                            ดำเนินการแก้ไขเรียบร้อยแล้ว
                                @endif
                                </span>
                                <p class="d-flex align-items-center justify-content-center gap-1 mb-0">
                                    @if (!$Tracking->assign_solve_date)
                                        <span class="text-warning">
                                            <i class="mdi mdi-star me-1"></i>แก้ไขแล้ววันที่
                                        </span>
                                        <span class="fw-normal">
                                            {{ \Carbon\Carbon::parse($Tracking->she_success_date)->format('d/m/Y') }}
                                        @else
                                            <span class="text-warning">
                                                <i class="mdi mdi-star me-1"></i>กำหนดเสร็จ</span>
                                            <span class="fw-normal">
                                                {{ \Carbon\Carbon::parse($Tracking->she_solve_date)->format('d/m/Y') }}
                                    @endif
                                    </span>
                                </p>
                            </div>
                            <div class="progress rounded-pill mb-1" style="height: 8px">
                                <div class="progress-bar @if ($Tracking->she_status == 0) 0                                 
                                                                    @else
                                                                    w-100 @endif"
                                    role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="0">
                                </div>
                            </div>

                            <div class="card-body p-3 pt-2">
                                <span class="h4 mb-0 app-brand-text fw-bold">ระบุรายละเอียดแนวทางการแก้ไข:</span>
                                <span class="h5 bg-label-primary">{{ $Tracking->she_suggestion }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
@endsection

@section('jsvendor')
@endsection
