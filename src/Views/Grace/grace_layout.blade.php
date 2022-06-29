<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>GRACE</title>
    <link href="{{ asset('grace/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div>
        <!--*******************
        Preloader start
    ********************-->
        <div id="preloader">
            <div class="loader">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                        stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
        <!--*******************
        Preloader end
    ********************-->


        <!--**********************************
        Main wrapper start
    ***********************************-->
        <div id="main-wrapper">

            <!--**********************************
            Nav header start
        ***********************************-->
            <div class="nav-header">
                <div class="brand-logo">
                    <a href="index.html">
                        <b class="logo-abbr"><img src="images/logo.png" alt=""> </b>
                        <span class="logo-compact"><img src="./images/logo-compact.png" alt=""></span>
                        <span class="brand-title">
                            <img src="images/logo-text.png" alt="">
                        </span>
                    </a>
                </div>
            </div>

            @include('grace.includes.header')

            @include('grace.includes.sidebar')

            <!--**********************************
            Content body start
        ***********************************-->
            <div class="content-body"></div>
            @yield('content')
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        @include('grace.includes.footer')

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('grace/js/common.min.js') }}"></script>
    <script src="{{ asset('grace/js/custom.min.js') }}"></script>
    <script src="{{ asset('grace/js/settings.js') }}"></script>
    <script src="{{ asset('grace/js/gleek.js') }}"></script>
    <script src="{{ asset('grace/js/styleSwitcher.js') }}}"></script>
    <script src="{{ asset('grace/js/circle-progress.min.js') }}"></script>
</body>

</html>
