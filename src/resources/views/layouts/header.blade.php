<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-blue-900 shadow-lg" id="layout-navbar" style="background-color: #1e3a8a !important;">
    
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="mdi mdi-menu mdi-24px text-white"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <span class="text-white font-fc text-xl font-bold tracking-wider">
                    SAFETY REPORTING SYSTEM
                </span>
            </div>
        </div>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <li class="nav-item lh-1 me-3">
                <span class="text-white-50 text-xs">ยินดีต้อนรับ, {{ Auth::user()->fullname ?? 'Guest' }}</span>
            </li>
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online border border-white rounded-circle p-1">
                        <img src="{{ asset('template/assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>
                </li>
        </ul>
    </div>
</nav>
