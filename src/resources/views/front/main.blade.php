<!DOCTYPE html>

<html
  lang="en"
  class="light-style layout-navbar-fixed layout-wide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="front-pages-no-customizer">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Safety Report</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link   href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"  rel="stylesheet" />

    <link rel="stylesheet" href="../../assets/vendor/fonts/materialdesignicons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/pages/front-page.css" />
    <!-- Vendors CSS -->

    <link rel="stylesheet" href="../../assets/vendor/libs/nouislider/nouislider.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/swiper/swiper.css" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="../../assets/vendor/css/pages/front-page-landing.css" />

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script> 
    <script src="../../assets/js/front-config.js"></script>
  </head>

  <body>
    <script src="../../assets/vendor/js/dropdown-hover.js"></script>
    <script src="../../assets/vendor/js/mega-dropdown.js"></script>

    <!-- Navbar: Start -->
    <nav class="layout-navbar container shadow-none py-0">
      <div class="navbar navbar-expand-lg landing-navbar border-top-0 px-3 px-md-4">
        <!-- Menu logo wrapper: Start -->
        <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-4">
          <!-- Mobile menu toggle: Start-->
          {{-- <button
            class="navbar-toggler border-0 px-0 me-2"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="tf-icons mdi mdi-menu mdi-24px align-middle"></i>
          </button> --}}

            <span class="app-brand-logo demo me-1">
              <span style="color: var(--bs-primary)">
                <img src="{{ asset('assets/img/logo/BG_Logo.svg') }}" alt="Logo" width="100" height="100">
              </span>
          </span>
          <!-- Mobile menu toggle: End-->
          <a href="landing-page.html" class="app-brand-link">
            
            <span class="app-brand-text demo menu-text fw-semibold ms-2 ps-1">SAFETY REPORT</span>
          </a>
        </div>
        <!-- Menu logo wrapper: End -->
        <!-- Menu wrapper: Start -->
        <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
          <button
            class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="tf-icons mdi mdi-close"></i>
          </button>
        
        </div>
        <div class="landing-menu-overlay d-lg-none"></div>
        <!-- Menu wrapper: End -->
        <!-- Toolbar: Start -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- navbar button: Start -->
          {{-- <li>
            <a href="../vertical-menu-template/auth-login-cover.html"
              class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4"
              target="_blank"  ><span class="tf-icons mdi mdi-account me-md-1"></span
              ><span class="d-none d-md-block">Login/Register</span></a>
          </li> --}}


          

            @if(auth()->check() && auth()->user()->role === 1 || auth()->user()->role === 2)
                
            <li>
              <a  href="#" class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4"
                target="_blank"   onclick="window.location.href = '{{ route('checkmagicfinger') }}' ">
                <span class="tf-icons mdi mdi-check"></span >Check Report 
              </a>

          </li>

            @endif

          <!-- navbar button: End -->
        </ul>
        <!-- Toolbar: End -->
      </div>
    </nav>
    <!-- Navbar: End -->

    <!-- Sections:Start -->

    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"> </span>
      
      </h4>

    <div class="container">
    <div data-bs-spy="scroll" class="scrollspy-example">
      
   
      <!-- Contact Us: Start -->
      <section id="landingContact" class="section-py bg-body landing-contact">
        <div class="container bg-icon-left">
          <h1 class="text-center fw-semibold d-flex justify-content-center align-items-center mb-4">
            <img  src="../../assets/img/front-pages/icons/section-tilte-icon.png"   alt="section title icon"     class="me-2" />
            <span class="text-uppercase">รายงานด้านความปลอดภัย</span>
          </h1>
           
          <div class="card-body">
            {{-- <small class="text-light fw-medium">Block level buttons</small> --}}
            <div class="row mt-3">
              <div class="d-grid gap-2 col-lg-6 mx-auto">                
                <button class="btn btn-xl btn-primary waves-effect waves-light" type="button"  onclick="window.location.href = '{{ route('magic') }}' ">MAGIC FINGER</button>
                <button class="btn btn-xl btn-primary waves-effect waves-light" type="button">Take 5</button>
              </div>
            </div>
          </div>

          <div class="row gy-4">
            <div class="col-lg-5">
              <div class="card h-100">
                
              </div>
            </div>
            <div class="col-lg-7">
              <div class="card">
                 
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- Contact Us: End -->
    </div>

    <!-- / Sections:End -->
</div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/nouislider/nouislider.js"></script>
    <script src="../../assets/vendor/libs/swiper/swiper.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/front-main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/front-page-landing.js"></script>
  </body>
</html>
