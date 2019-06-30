<!DOCTYPE html>
<html dir="rtl">
<head>
    <!-- Meta Tags
    ========================== -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content=" ">
    <meta name="author" content="Feidi">
    <meta name="contact" content="info@example.com">
    <meta name="contactNetworkAddress" CONTENT="abdo23970@gmail.com">
    <meta name="contactPhoneNumber" CONTENT="01092144285">

    <!-- Site Title
    ========================== -->
    <title>فرصة تانية</title>

    <!-- Favicon
    ===========================-->
    <link rel="shortcut icon" type="image/x-icon" href="images/fav.png">

    <!-- Base & vendors
    ========================== -->
    <!--        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">-->
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap-ar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/slick/slick.css') }}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

    <!-- Site Style
    ========================== -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">
    {{--<link rel="stylesheet" href="{{ asset('chat/index.css') }}">--}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="">

<div class="container-fluid page-body-wrapper d-flex flex-row">
    <aside class="side-nav d-flex flex-column">
        <div class="control-side active">
            <span></span>
            <span></span>
        </div>
        <div class="brand">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/Logo.png') }}" alt="logo">
            </a>
        </div> <!-- end brand -->

        <ul class="nav-list" id="accordionNav">
            <li>

                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/icons/home_i.svg') }}" alt="icon">
                    الرئيسية
                </a>
            </li>

            <li  class="has-submenu collapsed " data-toggle="collapse" href="#collapseMessage" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{  asset('images/icons/message_i.svg') }}" alt="icon">
                    الرسائل
                </a>
                <div id="collapseMessage" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                        <li >
                            <a href="{{ url('inbox') }}"class="">الرسائل الجديده</a>
                        </li>
                        <li>
                            <a href="{{ url('inbox/readMessage') }}" class="">الرسائل المقرؤة</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li >
                <a href="{{ url('notifications') }}">
                    <img src="{{ asset('images/icons/notification.svg') }}" alt="icon">
                    الإشعارات
                </a>
            </li>
            <li  class="has-submenu collapsed " data-toggle="collapse" href="#collapseUsers" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{ asset('images/icons/users_i.svg') }}" alt="icon">
                    المستخدمين
                </a>
                <div id="collapseUsers" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                        <li >
                            <a href="{{ url('users/clients') }}" class="">عميل</a>
                        </li>
                        <li>
                            <a href="{{ url('users/amateurs') }}" class="">مجرب</a>
                        </li>
                        <li>
                            <a href="{{ url('users/experts') }}" class="">خبير</a>
                        </li>
                        <li>
                            <a href="{{ url('specializations') }}" class="">التخصصات</a>
                        </li>
                    </ul>
                </div>
            </li>
            {{--<li>--}}
                {{--<a href="{{ url('countries') }}">--}}
                    {{--<img src="{{ asset('images/icons/search_nav.svg') }}" alt="icon">--}}
                    {{--المدن--}}
                {{--</a>--}}
            {{--</li>--}}
            <li class="has-submenu collapsed " data-toggle="collapse" href="#collapseProject" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{ asset('images/icons/project_i.svg') }}" alt="icon">
                    المشاريع
                </a>
                <div id="collapseProject" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                        <li>
                            <a href="{{ route('projectindex') }}" class=""> عرض</a>
                        </li>
                        <li>
                            <a href="{{ route('servicesindex') }}" class="">الخدمات</a>
                        </li>
                        <li>
                            <a href="{{ route('typesindex') }}" class="">الأقسام</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="has-submenu collapsed " data-toggle="collapse" href="#collapseStudies" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{ asset('images/icons/studies_i.svg') }}" alt="icon">
                    الدراسات
                </a>
                <div id="collapseStudies" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                        <li >
                            <a href="{{ url('/studies') }}" class=""> عرض</a>
                        </li>
                        <li>
                            <a href="{{ url('/studiestypes') }}" class="">الأنواع</a>
                        </li>
                        {{--<li>
                            <a href="{{ url('studies/categories') }}" class="">الأقسام</a>
                        </li>--}}

                    </ul>
                </div>
            </li>
            <li class="has-submenu collapsed " data-toggle="collapse" href="#collapseInfo" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{ asset('images/icons/info_i.svg') }}" alt="icon">
                    الاستشارات
                </a>
                <div id="collapseInfo" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                        <li>
                            <a href="{{route('consultations.index') }}" class=""> عرض</a>
                        </li>

                        <li>
                            <a href="{{ route('consultations_categories.index') }}" class=""> الأقسام</a>
                        </li>
                        <li>
                            <a href="{{route('filterview') }}" class="">بحث</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li >
                <a href="{{url('/setting')}}">
                    <img src="{{asset('images/icons/payment.svg')}}" alt="icon">
                    نسبة الموقع
                </a>
            </li>
            <li class="has-submenu collapsed " data-toggle="collapse" href="#collapseTicket" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{ asset('images/icons/question-mark.svg') }}" alt="icon">
                    التذاكر
                </a>
                <div id="collapseTicket" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                        {{--<li>--}}
                        {{--<a href="{{ url('Supervisor') }}" class="">مديرين</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ url('ticket') }}" class=""> عرض</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="has-submenu collapsed " data-toggle="collapse" href="#collapseWallet" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{ asset('images/icons/money.svg') }}" alt="icon">
                    الرصيد
                </a>
                <div id="collapseWallet" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                        {{--<li>--}}
                        {{--<a href="{{ url('Supervisor') }}" class="">مديرين</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ url('wallet') }}" class=""> اضافه رصيد </a>
                            <a href="{{ url('wallet/withdraw') }}" class=""> سحب رصيد </a>
                        </li>

                    </ul>
                </div>
            </li>
@if(Auth::check()&& Auth::user()->type=="admin")
            <li class="has-submenu collapsed " data-toggle="collapse" href="#collapseAdmin" aria-expanded="true">
                <a href="javascript:void(0);">
                    <img src="{{ asset('images/icons/mangers_i.svg') }}" alt="icon">
                    المديرين
                </a>
                <div id="collapseAdmin" class="collapse submenu" data-parent="#accordionNav">
                    <ul>
                       {{--<li>--}}
                            {{--<a href="{{ url('Supervisor') }}" class="">مديرين</a>--}}
                        {{--</li>--}}
                        <li>
                            <a href="{{ url('Supervisor') }}" class=""> مشرفين</a>
                        </li>

                    </ul>
                </div>
            </li>
@endif
            {{--<li class="has-submenu collapsed " data-toggle="collapse" href="#collapseProblem" aria-expanded="true">--}}
                {{--<a href="#">--}}
                    {{--<img src="{{ asset('images/icons/question-mark.svg') }}" alt="icon">--}}
                    {{--الشكاوي  و  المقترحات--}}
                {{--</a>--}}
                {{--<div id="collapseProblem" class="collapse submenu" data-parent="#accordionNav">--}}
                    {{--<ul>--}}
                        {{--<li>--}}
                            {{--<a href="{{ url('messages/problems') }}" class="">الشكاوي</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="{{ url('messages/notes') }}" class=""> المقترحات</a>--}}
                        {{--</li>--}}

                    {{--</ul>--}}
                {{--</div>--}}
            {{--</li>--}}
            <li>
                <a  data-toggle="modal"  data-target="#signout" >

                    <img src="{{ asset('images/icons/logout_i.svg') }}" alt="icon">
                    تسجيل خروج
                </a>
            </li>
        </ul> <!-- end nav-list -->

    </aside> <!-- end side-nav -->
    <div class="main-panel">
        @yield('search')
        <div class="inner_panal">
            <ul class="breadcrumb">
               @if(isset($siteMap))
                   @php
                       $c = count($siteMap);
                       $x=0;
                   @endphp
                   @foreach($siteMap as $smap)
                       <li class="breadcrumb-item {{ $x == $c -1 ? 'active' : '' }}">{{$smap}}</li>
                        @php
                            $x++;
                        @endphp
                   @endforeach
               @endif
            </ul>
            @yield('content')
        </div>
    </div>
</div>  <!-- end page-body-wrapper -->

{{-- Image Modal --}}
<div class="modal fade" id="img">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <img src="" alt="image">
            <div class="modal-body">

                <button type="button" class="custom-btn d-block m-auto" data-dismiss="modal">إلغاء</button>
            </div>
        </div> <!-- end modal-content -->
    </div> <!-- end modal-dialog -->
</div> <!-- end modal -->
{{-- Address modal --}}
<div class="modal fade" id="getTooltipData">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <h3 class="text-center text-black-50 tooltipData">
                        من فضلك املئ حقل الادخال هذا
                    </h3>
                </div>
                <div class="control-model d-flex flex-row justify-content-between">
                    <button type="button" class="custom-btn m-0" data-dismiss="modal">إلغاء</button>
                </div> <!-- end control-model -->
            </div> <!-- end modal-body -->
        </div> <!-- end modal-content -->
    </div> <!-- end modal-dialog -->
</div> <!-- end modal -->
{{--  end address modal --}}
<!-- Sign out-->
<!-- The Modal -->
<div class="modal fade" id="signout">
    <div class="modal-dialog modal-dialog-centered">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        <div class="modal-content">
            <div class="modal-body">
                <p class="mainColor text-center">
                    هل تريد تسجيل خروجك بالفعل ؟
                </p>
                <div class="control-model d-flex flex-row justify-content-around">
                    <button type="submit" class="custom-btn">نعم</button>
                    <button type="button" class="custom-btn" data-dismiss="modal">الغأء</button>
                </div> <!-- end control-model -->
            </div> <!-- end modal-body -->
        </div> <!-- end modal-content -->
        </form>
    </div> <!-- end modal-dialog -->
</div> <!-- end modal -->
<!-- /Sign out-->


<!--Script files
========================== -->
{{--<script src="https://media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>--}}
{{--<script src="https://media.twiliocdn.com/sdk/js/chat/v3.0/twilio-chat.min.js"></script>--}}
<script src="{{ asset('vendors/jquery/jquery.js') }}"></script>
{{--<script src="{{ asset('chat/index.js') }}"></script>--}}

<script src="{{ asset('vendors/slick/slick.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('vendors/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/customAm.js') }}"></script>
</body>
</html>
