@extends('layouts.from.templatefrome')

@section('contentfrom')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="py-2 mb-4"> </h4> --}}
    <span class="h4 text-primary mb-0 app-brand-text fw-semibold">แบบฟอร์มรายงาน MAGIC FINGER</span>
    <!-- Default -->
    <div class="row">
        <!-- สภาพการณ์ที่พบ -->
        <div class="col-12 mb-4">
            <span class="h4 text-primary mb-0 app-brand-text fw-semibold">ส่วนที่ 1 : สำหรับพนักงานเป็นผู้รายงาน</span>

            <div class="bs-stepper wizard-numbered mt-2">
                <div class="bs-stepper-header">
                    <div class="step" data-target="#view-risk">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-number"><i class="mdi mdi-account-alert mdi-36px"></i></span>
                                <span class="d-flex flex-column gap-1 ms-2 text-primary">
                                    <span class="bs-stepper-title text-primary"> สภาพการณ์ที่พบ </span>
                                </span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#Life-saving">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-number"><i class="mdi mdi-home-search mdi-36px"></i></span>
                                <span class="d-flex flex-column gap-1 ms-2">
                                    <span class="text-primary bs-stepper-title">รายละเอียดเหตุการณ์ที่ท่านพบ</span>
                                    <span class="text-primary bs-stepper-subtitle">พร้อมรูปภาพประกอบ (ถ้ามี)</span>
                                </span>
                            </span>
                        </button>
                    </div>
                    <div class="line"></div>
                    <div class="step" data-target="#risk">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="mdi mdi-check"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-number"><i class="mdi mdi-asterisk-circle-outline mdi-36px"></i></span>
                                <span class="d-flex flex-column gap-1 ms-2">
                                    <span class="text-primary bs-stepper-title">ระดับความรุนแรง</span>
                                    <span class="text-primary bs-stepper-subtitle">Risk assessment</span>
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="multiStepsFormMagic" enctype="multipart/form-data" onSubmit="return false">
                        @csrf
                        <!-- ข้อมูลผู้รายงาน -->
                        <div id="view-risk" class="content">
                            <div class="content-header mb-3">
                                <span class="h4 text-primary mb-0 app-brand-text fw-semibold">ข้อมูลผู้รายงาน</span>
                            </div>
                            <div class="line"></div>
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="fullname" class="form-control"
                                            placeholder="ชื่อ - นามสกุล" value="{{ Auth::user()->fullname }}" name="multiStepsFullname" id="multiStepsFullname" disabled />
                                        <label for="multiStepsFullname">ชื่อ - นามสกุล</label>
                                        <input type="hidden" name="EmpID" value="{{  Auth::user()->empid  }}">
                                        <input type="hidden" name="EmpFullname" value="{{ Auth::user()->fullname  }}">
                                        <input type="hidden" name="EmpLoc" value="{{ Auth::user()->bu  }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="multiStepsPlant" class="form-control" placeholder="Plant" name="multiStepsPlant" value="{{ Auth::user()->bu }}" />
                                        <label for="multiStepsPlant">Plant</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <select id="sLocation_view"
                                            name="sLocation_view"
                                            class="form-control">
                                            <option value="">— เลือก Plant —</option>

                                            @foreach ($plants as $p)
                                            <option value="{{ $p->plant_code }}">
                                                {{ $p->plant_code }} 
                                            </option>
                                            @endforeach
                                        </select>
                                        <label for="sLocation_view">สถานที่ / โรงงาน</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="sLocation_dept_view" name="sLocation_dept_view" class="form-control" placeholder="sLocation_dept_view" />
                                        <label for="sLocation_dept_view">หน่วยงานที่พบ</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" id="sDateGet" name="sDateGet" class="form-control" placeholder="sDateGet" />
                                        <label for="sDateGet">วันเดือนปีที่พบ</label>
                                    </div>
                                </div>
                                <hr>
                                </hr>
                                <div class="col-md-6">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label text-sm-end">สภาพการณ์ที่พบ</label>
                                        <div class="col-sm-9">

                                            @foreach($cause as $cause)
                                            <div class="form-check mb-2">
                                                <input name="msCauseCheck" name="msCauseCheck" class="form-check-input" type="radio" value="{{ $cause->id }}" id="msCauseCheck" onclick="toggleInfo()" />
                                                <label class="form-check-label" for="msCauseCheck"> {{ $cause->cause }}</label>
                                            </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-prev" disabled>
                                        <i class="mdi mdi-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="mdi mdi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- สภาพการณ์ที่พบ -->
                        <!-- เหตุการณ์ที่พบ -->
                        <div id="Life-saving" class="content">
                            {{-- <h3>ประเภทของเหตุการณ์ที่พบ</h3> --}}

                            <div class="py-2 mb-3" id="LSR">
                                <span class="h4 text-primary mb-0 app-brand-text fw-semibold bs-stepper-title">ประเภทของเหตุการณ์ที่พบ</span>
                                {{-- <h3 class="">ประเภทของเหตุการณ์ที่พบ</h3> --}}
                                <span class="bs-stepper-subtitle">Life Saving Rules</span>

                                @foreach($event as $event)
                                <div class="form-check mb-2">
                                    <input name="msEventCheck" class="form-check-input" type="radio" id="msEventCheck" value="{{$event->id}}" />
                                    <label class="form-check-label" for="msEventCheck"> {{ $event->event }}</label>
                                </div>
                                @endforeach

                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <textarea class="form-control h-px-100" id="MsDetailOther" name="MsDetailOther"></textarea>
                                        <label for="MsDetailOther">อื่่นๆ</label>
                                    </div>
                                </div>
                                <hr>
                                </hr>
                            </div>

                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <textarea class="form-control h-px-100" id="MsDetail" name="MsDetail"></textarea>
                                        <label for="MsDetail">รายละเอียดเหตุการณ์ที่ท่านพบ</label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                                  <div class="form-floating form-floating-outline">
                                                      <input class="form-control" type="file" id="formValidationFile" name="formValidationFile" />
                                                      <label for="formValidationFile">รูปภาพประกอบ</label>
                                                  </div>
                                              </div> --}}

                                <div class="col-md-6">

                                    <h5 class="card-header text-primary">พร้อมรูปภาพประกอบ (ถ้ามี)</h5>
                                    <div class="card-body row">
                                        <div class="col-md-8">
                                            <div id="file-container">
                                                <div class="file-row mb-2 d-flex gap-2 align-items-center">
                                                    <input type="file" name="files[]" class="form-control w-75">
                                                    <button type="button" class="btn btn-danger btn-remove">ลบ</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4"><button type="button" id="add-file"
                                                class="btn btn-secondary mb-3">เพิ่มไฟล์</button>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="msCheck1" name="msCheck" value="1" />
                                                <label class="form-check-label" for="msCheck">แก้ไขแล้ว</label><br><br>
                                                <div class="col-12 form-floating form-floating-outline">
                                                    <input type="date" id="sDateGetEventCheck" class="form-control" placeholder="sDateGet" name="sDateGet" />
                                                    <label for="sDateGet">วันเดือนปี ที่แก้ไข</label>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="msCheck2" name="msCheck" value="0" />
                                                <label class="form-check-label" for="msCheck">ยังไม่ได้แก้ไข</label><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-outline-secondary btn-prev">
                                        <i class="mdi mdi-arrow-left me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-primary btn-next">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="mdi mdi-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links -->
                        <div id="risk" class="content">
                            <span class="h4 text-primary mb-0 app-brand-text fw-semibold">ระดับความรุนแรง</span>
                            <div class="row g-4">
                                <div class="row gy-3 mt-0">
                                    @foreach($ranks as $ranks)
                                    <div class="col-xl-3 col-md-5 col-sm-6 col-12">
                                        <div class="form-check custom-option custom-option-icon">
                                            <label class="form-check-label custom-option-content" for="rdRank">
                                                <input class="form-check-input" type="radio" id="rdRank" name="rdRank" value="{{$ranks->id}}" />
                                                <span class="custom-option-body">
                                                    <i class="mdi mdi-account-outline"></i>
                                                    <span class="custom-option-title"> {{ $ranks->rank }}</span>
                                                    <small class="mt-2"> {{ $ranks->rank_mening }} </small>
                                                </span> <small class="mt-2">{{ $ranks->rank_action }} </small>

                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                    <hr>
                                    </hr>
                                    <div class="row g-4">
                                        <div class="col-sm-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <textarea class="form-control h-px-100" id="MsSuggestion" name="MsSuggestion"></textarea>
                                                <label for="MsSuggestion">ข้อเสนอแนะในการแก้ไข</label>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-between">
                                            <button class="btn btn-outline-secondary btn-prev">
                                                <i class="mdi mdi-arrow-left me-sm-1 me-0"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                            </button>
                                            <button class="btn btn-primary btn-submit" type="submit"> Submit </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
            </div>
            <hr class="container-m-nx mb-5" />
        </div>

        </form>
    </div>
    @endsection
    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
</div>
@endif --}}

@section('jslogin')
@endsection


@section('csslogin')
<!-- Vendor -->
<link rel="stylesheet" href="{{ asset('template/assets/vendor/css/rtl/core.css') }}" />
<link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
<link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
<link rel="stylesheet" href="{{ asset('template//assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />


@endsection

@section('customjs')
  <script src="{{ asset('assets/js/pages-form-magic.js') }}"></script>
@endsection
