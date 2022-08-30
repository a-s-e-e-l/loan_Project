<!DOCTYPE html>
@php
    App::setLocale(Session::get("locale") != null ? Session::get("locale") : "en");
@endphp
<html dir="{{ ( Session::get("locale")== "ar" ? 'rtl' : 'ltr') }}">

<head>
    @include('layout.head')
</head>
<body>
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    @include('layout.header')
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    @include('layout.sidebar')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-5 align-self-center">
{{--                    <h4 class="page-title">@yield("title")</h4>--}}
{{--                    <div class="d-flex align-items-center">--}}
{{--                    </div>--}}
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex no-block justify-content-end align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/dashboard') }}">@yield("title")</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">@yield("title-side")</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            @yield("content")
        </div>
        {{--        <footer class="footer text-center">--}}
        {{--            All Rights Reserved by AdminBite admin.--}}
        {{--        </footer>--}}
    </div>
</div>
@include('layout.footer-script')
</body>
</html>
