@extends('layouts.from.templatefrome')
<!-- Layout container -->

@section('contentfrom')

<div class="layout-page">
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        {{-- <div class="container-xxl flex-grow-1 container-p-y"> --}}
        <div class="row invoice-edit">
            <!-- Invoice Edit-->
            <div class="col-12 mb-lg-0 mb-4">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row mx-0">
                            <div class="col-md-7 mb-md-0 mb-4 ps-0">
                                <div class="d-flex svg-illustration align-items-center gap-2 mb-4">
                                    <span class="app-brand-logo demo">
                                        <span style="color: var(--bs-primary)">
                                            <img src="{{ asset('assets/img/logo/BG_Logo.svg') }}" alt="Logo"
                                                width="100" height="100">
                                        </span>
                                    </span>
                                    <span class="h4 mb-0 app-brand-text fw-semibold">แบบฟรอม์รายงาน Magic Finger</span>
                                </div>

                            </div>
                            <div class="col-md-5 pe-0 ps-0 ps-md-2">
                                <dl class="row mb-2 g-2">
                                    <dt class="col-sm-6 mb-2 d-md-flex align-items-center justify-content-end">
                                        <span class="h4 mb-0 app-brand-text fw-semibold">ใบงานเลขที่ </span>
                                    </dt>
                                    <dd class="col-sm-6">
                                        <div class="input-group input-group-merge disabled">
                                            <span class="input-group-text">#</span>
                                            <input type="text" class="form-control" disabled
                                                placeholder="ST202504290001" value="{{ $Tracking->safety_code }}" id="reportId" />
                                        </div>
                                    </dd>
                                    <dt class="col-sm-6 mb-2 d-md-flex align-items-center justify-content-end">
                                        <span class="fw-normal">วัน/เดือน/ปี ที่พบ</span>
                                    </dt>
                                    <dd class="col-sm-6">
                                        <input type="text" class="form-control invoice-date"
                                            value="{{ \Carbon\Carbon::parse($Tracking->report_date)->format('d/m/Y') }}" />
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body"><span class="h4 text-primary mb-0 app-brand-text fw-semibold">ส่วนที่ 1 สำหรับพนักงานเป็นผู้รายงาน</span>
                        <div class="d-flex justify-content-between flex-wrap">

                            <div class="my-6 me-6">
                                <h6 class="h5 mb-1">
                                    <span class="h4 mb-0 app-brand-text fw-semibold">ชื่อ - นามสกุล ผู้รายงาน : </span>
                                    {{ $Safety->report_empid }} {{ $Safety->report_name }}
                                </h6>
                            </div>
                            <div class="my-6">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="pe-6 h5 mb-1"><span class="h4 mb-0 app-brand-text fw-semibold">สถานที่พบ:</span></td>
                                            <td class="h5 mb-1">{{ $Safety->location_view }} </td>
                                        </tr>
                                        <tr>
                                            <td class="pe-6 h5 mb-1"><span class="h4 mb-0 app-brand-text fw-semibold">หน่วยงานที่พบ:</span></td>
                                            <td class="h5 mb-1">{{ $Safety->location_dept_view }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3" data-repeater-list="group-a">
                                <div class="repeater-wrapper pt-1 pt-md-4 mb-3" data-repeater-item="">
                                    <div class="d-flex rounded position-relative pe-1">
                                        <div class="">
                                            <div class="col-12 mb-md-0 mb-3">
                                                <span class="h4 mb-0 app-brand-text fw-semibold">ประเภทของสภาพการณ์ที่พบ: </span>
                                                <span class="h5 bg-label-primary">{{ $Cause->cause }} </span>
                                            </div>
                                            <div class="col-md-12 col-12 mb-md-0 mb-3">
                                                <span class="h4 mb-0 app-brand-text fw-semibold">ประเภทของเหตุการณ์ที่พบ:
                                                </span>
                                                <span class="h5 bg-label-primary">{{ !empty($Event->event) ? $Event->event : '-' }}
                                                    {{ !empty($Event->event_note) ? $Event->event_note : '' }} </span>
                                            </div>
                                            <div class="col-sm-12 col-lg-12">
                                                <div class="card shadow-none border p-2 h-90 mb-3">
                                                    <div class="rounded-2 text-center mb-3">
                                                        <a href="#">
                                                            <img class="img-fluid" src="{{ asset('storage/' . $Safety->report_img_before) }}" alt="tutor image 1"></a>
                                                    </div>
                                                    <div class="card-body p-3 pt-2">
                                                        <a href="#" class="h5">รายละเอียดเหตุการณ์ :</a>
                                                        <p class="mt-2">{{ $Safety->report_detail }}</p>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center mb-3">
                                                            @if ($Safety->solve_status == 0)
                                                            <span class="badge rounded-pill bg-label-warning">
                                                                ยังไม่แก้ไข
                                                                @else
                                                                <span
                                                                    class="badge rounded-pill bg-label-primary">
                                                                    แก้ไขแล้ว
                                                                    @endif
                                                                </span>
                                                                <p
                                                                    class="d-flex align-items-center justify-content-center gap-1 mb-0">
                                                                    <span class="text-warning"><i
                                                                            class="mdi mdi-star me-1"></i></span>
                                                                    <span class="fw-normal">
                                                                        @if ($Safety->solve_date = null)
                                                                        -
                                                                        @else
                                                                        {{ \Carbon\Carbon::parse($Safety->solve_date)->format('d/m/Y') }}
                                                                        @endif
                                                                    </span>
                                                                </p>
                                                        </div>
                                                        <div class="progress rounded-pill mb-4" style="height: 8px">
                                                            <div class="progress-bar @if ($Safety->solve_status == 0) 0                                 
                                                                    @else
                                                                    w-100 @endif"
                                                                role="progressbar" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="my-0" />
                                            <div class="card-body">
                                                <div class="row">
                                                    <span
                                                        class="h4 text-capitalize mb-3 text-nowrap">ระดับความรุนเเรง Rank</span>
                                                    <div class="col-sm-6 col-lg-3 mb-4">
                                                        <div class="card {{ $Class_rank }}  h-100">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center mb-2 pb-1">
                                                                    <div class="avatar me-2">
                                                                        <span
                                                                            class="avatar-initial   rounded {{ $Class_rank_label }} ">
                                                                            <i
                                                                                class="mdi mdi-source-fork mdi-20px"></i>
                                                                        </span>
                                                                    </div>
                                                                    <h4 class="ms-1 mb-0 display-6">
                                                                        {{ $Rank->rank }}
                                                                    </h4>
                                                                </div>
                                                                <p class="mb-0 text-heading">
                                                                    {{ $Rank->rank_mening }}
                                                                </p>
                                                                <p class="mb-0">
                                                                    <span
                                                                        class="me-1">{{ $Rank->rank_action }}</span>
                                                                    {{-- <small class="text-muted">(และมีแผนใน 3  วัน)</small> --}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <hr class="my-0" />
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 mb-md-0 mb-3">
                                                        <span class="h4 mb-0 app-brand-text fw-semibold">ข้อเสนอแนะในการแก้ไข: </span>
                                                        <span class="h5 bg-label-primary">{{ $Safety->suggestion  }} </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-1" />
                                <div class="card-body">
                                    <div class="row">
                                        <span class="h4 text-capitalize mb-3 text-nowrap">ส่วนที่ 2 : สำหรับผู้จัดการฝ่าย / ผู้ได้รับมอบหมาย </span>
                                        <form id="multiStepsFormApprove" enctype="multipart/form-data" onsubmit="return false">
                                            @csrf

                                            {{-- hidden ใช้ยิงกลับไปหา safety/track --}}
                                            <input type="hidden" name="safety_id" id="safety_id" value="{{ $Safety->id }}">
                                            <input type="hidden" name="safety_code" id="safety_code" value="{{ $Safety->safety_code }}">

                                            {{-- ✅ เลือกสถานะการแก้ไข --}}
                                            <div class="row mb-3">
                                                <div class="col-md-6">

                                                    {{-- แก้ไขเรียบร้อยแล้ว + แนบรูปได้ --}}
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input"   type="radio"     id="msCheck_done"    name="msCheck"    value="1" />
                                                        <label class="form-check-label fw-bold" for="msCheck_done">
                                                            ดำเนินการแก้ไขเรียบร้อยแล้ว พร้อมรูปภาพประกอบ (ถ้ามี)
                                                        </label>
                                                    </div>

                                                    {{-- ✅ แนบรูปหลักฐานการแก้ไข (ใช้เมื่อเลือก msCheck = 1) --}}
                                                    <div class="card-body row mb-3" id="approve-upload-wrapper">
                                                        <div class="col-md-8">
                                                            <div id="file-container">
                                                                <div class="file-row mb-2 d-flex gap-2 align-items-center">
                                                                    <input type="file" name="files[]" class="form-control w-75">
                                                                    {{-- ปุ่มลบไฟล์ต่อแถว ถ้าจะใช้ค่อยเปิด JS มาทำ --}}
                                                                    {{-- <button type="button" class="btn btn-danger btn-remove">ลบ</button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <button type="button"
                                                                id="add-file-approve"
                                                                class="btn btn-secondary mb-3">
                                                                เพิ่มไฟล์
                                                            </button>
                                                        </div>
                                                    </div>


                                                    {{-- ยังไม่ได้แก้ไข / อยู่ระหว่างดำเนินการ --}}
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input"     type="radio"   id="msCheck_pending"          name="msCheck"    value="2" />
                                                        <label class="form-check-label" for="msCheck_pending">
                                                            ยังไม่ได้แก้ไข / อยู่ระหว่างดำเนินการ
                                                        </label>
                                                    </div>

                                                    {{-- วันที่แก้ไขแล้ว / วันที่กำหนดให้เสร็จ --}}
                                                    <div class="col-12 form-floating form-floating-outline mt-3">
                                                        <input type="date"    id="sDateEdit"   class="form-control"    name="sDateEdit"    placeholder="sDateEdit" />
                                                        <label for="sDateEdit">วันเดือนปี ที่แก้ไขแล้ว / กำหนดแล้วเสร็จ</label>
                                                    </div>
                                                </div>
                                            </div>



                                            {{-- ✅ รายละเอียดแนวทางการแก้ไข / ข้อเสนอแนะเพิ่มเติม --}}
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="mb-3">
                                                            <label for="note" class="form-label fw-medium">
                                                                ระบุรายละเอียดแนวทางการแก้ไข:
                                                            </label>
                                                            <textarea class="form-control"  rows="3"   id="note" name="note"
                                                                placeholder="อธิบายวิธีการแก้ไข หรือมาตรการเพิ่มเติม"></textarea>
                                                        </div>
                                                    </div>

                                                    <button class="btn btn-primary d-grid w-100 mb-3 btn-submit-approve" type="submit"  id="btn-submit-approve">
                                                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                                                            <i class="mdi mdi-send-outline scaleX-n1-rtl me-2"></i>
                                                            Close Job / ส่งต่อ SHE-Plant
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- / Content -->
                        <!-- Footer -->
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl">
                                <div
                                    class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
                                    <div class="text-body mb-2 mb-md-0">©
                                        <script>
                                            document.write(new Date().getFullYear());
                                        </script> , made with
                                        <span class="text-danger">
                                            <i class="tf-icons mdi mdi-heart"></i></span> by
                                        <a href="#" target="_blank" class="footer-link fw-medium">Application Development BG Group</a>
                                    </div>
                                </div>
                            </div>
                        </footer>
                        <!-- / Footer -->
                        <div class="content-backdrop fade"></div>
                    </div>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>


            @endsection

@section('customjs')
<script src="{{ asset('assets/js/pages-form-approve.js') }}"></script>
@endsection
