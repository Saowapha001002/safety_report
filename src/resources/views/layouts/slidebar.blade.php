{{-- <aside id="layout-menu"   class="layout-menu menu-vertical menu bg-menu-theme menu-fixed menu-light menu-accordion menu-shadow"> --}}
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text" data-i18n="AdminApprove">Admin</span>
        </li>
        <li class="menu-item  @if (Route::is('checkmagicfinger')) active @endif">
            <a href="{{ route('checkmagicfinger') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-file-check"></i>
                <div data-i18n="Admin Checking">Admin Checking</div>
            </a>
        </li>
        <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text" data-i18n="Master Data">Master Data</span>
        </li>
        <li class="menu-item  @if (Route::is('cause.index')) active @endif">
            <a href="{{ route('cause.index') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-file-check"></i>
                <div data-i18n="สภาพการณ์">สภาพการณ์</div>
            </a>
        </li>
        {{-- Normal Approve --}}
        <li class="menu-item  @if (Route::is('event.index')) active @endif">
            {{-- <a href="javascript:void(0);" class="menu-link menu-toggle"> --}}
            <a href="{{ route('event.index') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-file-check"></i>
                <div data-i18n="เหตุการณ์">เหตุการณ์</div>

            </a>
        </li>
        <li class="menu-item  @if (Route::is('rank.index')) active @endif">
            <a href="{{ route('rank.index') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-file-check"></i>
                <div data-i18n="ความเสี่ยง">ความเสี่ยง</div>
            </a>
        </li>
    </ul>

</aside>
