<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" {{-- data-assets-path="template/assets/" --}} data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>SAFETY Report</title>

    <meta name="description" content="" />
    <meta name="assets-path" content="{{ asset('template/assets/') }}">


    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/materialdesignicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/css/rtl/theme-default.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('template/assets/css/demo.css') }}" /> --}}


    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/assets/css/loading.css') }}" />
    <!-- Page CSS -->
    @yield('csscustom')

    <!-- Helpers -->
    <script src="{{ asset('template/assets/vendor/js/helpers.js') }}"></script>
    {{-- <script src="{{ asset('template/assets/vendor/js/template-customizer.js') }}"></script> --}}
    <script src="{{ asset('template/assets/js/config.js') }}"></script>
    <style>
        .layout-page {
            padding-top: 0 !important;
            /* ลดช่องว่างบนของเนื้อหา */
        }

        /* ปรับให้เนื้อหาลงมาจาก Navbar มากขึ้น */
        .layout-navbar-fixed .layout-page .content-wrapper {
            padding-top: 20px !important;
        }

        /* จัดการความกว้างสูงสุดของฟอร์มรายงานไม่ให้กว้างเกินไปบนจอใหญ่ */
        .container-xxl {
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
        }

        .font-fc {
            font-family: 'FC Iconic', sans-serif !important;
        }

        /* ปรับแต่งส่วนหัวฟอร์มใน Content ให้ดูมีมิติ */
        .form-header-custom {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 2rem;
            border-radius: 0.5rem 0.5rem 0 0;
            text-align: center;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* 1. ปรับพื้นหลังของ Sidebar ทั้งหมดเป็นสีน้ำเงินเข้ม */
        #layout-menu.bg-menu-theme {
            background-color: #1e3a8a !important;
            /* BG Dark Blue */
            background-image: linear-gradient(180deg, #1e3a8a 0%, #111827 100%) !important;
        }

        /* 2. ปรับสีชื่อแบรนด์/โลโก้ด้านบนเมนู */
        .app-brand .system-name {
            color: #ffffff !important;
            font-weight: bold;
        }

        /* 3. ปรับสีตัวอักษรเมนูหลัก (Menu Links) */
        .menu-vertical .menu-item .menu-link {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* 4. ปรับสีตอนเอาเมาส์ไปชี้ (Hover) และเมนูที่กำลังใช้งาน (Active) */
        .menu-vertical .menu-item.active>.menu-link,
        .menu-vertical .menu-item .menu-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        /* 5. ปรับสีไอคอนข้างหน้าเมนู */
        .menu-vertical .menu-item .menu-icon {
            color: #60a5fa !important;
            /* สีฟ้าอ่อนเพื่อให้เด่นบนพื้นน้ำเงิน */
        }

        /* 6. ปรับสีหัวข้อเมนู (Menu Headers เช่น MASTER DATA) */
        .menu-vertical .menu-header {
            color: #93c5fd !important;
            /* สีฟ้าจางๆ */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* 7. เส้นคั่นเมนู */
        .menu-header::before {
            background-color: rgba(255, 255, 255, 0.2) !important;
        }

        /* ปรับแต่ง Scrollbar ของเมนูให้ดูเนียนตา */
        .ps__thumb-y {
            background-color: rgba(255, 255, 255, 0.3) !important;
        }
    </style>
</head>

<body>
    <!-- Loading Screen -->
    <!-- <div id="loading-screen">
        <div class="spinner"></div>
    </div> -->
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('layouts.slidebar')

            <div class="layout-page">
                @include('layouts.header')

                <div class="content-wrapper">

                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="font-fc">
                            @yield('content')
                        </div>

                    </div>
                    @include('layouts.footer')

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js -->
    {{-- <script src="template/assets/vendor/js/core.js"></script> --}}
    <script src="{{ asset('template/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('template/assets/vendor/libs/dropzone/dropzone.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    {{-- <script src="template/assets/vendor/libs/apex-charts/apexcharts.js"></script> --}}
    @yield('jsvendor')

    <!-- Main JS -->
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
    <!-- <script src="{{ URL::signedRoute('secure.js', ['filename' => 'js//app-loading-screen.js']) }}"></script> -->

    <!-- Page JS -->
    {{-- <script src="template/assets/js/dashboards-analytics.js"></script> --}}
    @yield('jscustom')
    @yield('custom-backend-js')
</body>

</html>
