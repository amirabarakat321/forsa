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
    <meta name="author" content="forceTouches.com">
    <!-- Site Title
    ========================== -->
    <title>فرصة تانية</title>

    <!-- Favicon
    ===========================-->
    <link rel="shortcut icon" type="image/x-icon" href="images/fav.png">

    <!-- Base & Vendors
    ========================== -->
    <!--        <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.css">-->
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap-ar.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/slick/slick.css') }}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

    <!-- Site Style
    ========================== -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/media.css') }}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4  col-lg-6 col-md-12 p-0 ">
                <div class="start-box">
                    <div class="login">
                        <h1>تسجيل دخول</h1>
                        <form method="post" accept-charset="utf8" action="{{ route('loginadmin') }}">
                            @csrf
                            <div class="input-container">
                                <input type="text" name="email" id="mail" required="required"/> <!-- Don't change type to  email -->
                                <label for="mail">البريد الالكتروني</label>
                                <div class="bar"></div>
                            </div>
                            <div class="input-container">
                                <input type="password" id="pass" name="password" required="required"/>
                                <label for="pass">كلمة المرور</label>
                                <div class="bar"></div>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                                <label class="custom-control-label" for="customCheck">تذكرني لاحقا</label>
                            </div>
                            <button type="submit" class="custom-btn mx-auto d-block font-weight-bold">دخول</button>

                        </form>
                    </div> <!-- end login -->
                </div> <!-- end start-box -->

            </div> <!-- end col -->
            <div class="col-xl-8 col-lg-6 align-self-center text-center">

            </div> <!-- end Col -->
        </div> <!-- end row -->
    </div> <!-- end Container-fluid -->
</div> <!-- end bg -->

<!--Script files
========================== -->
<script src="{{ asset('vendors/jquery/jquery.js') }}"></script>
<script src="{{ asset('vendors/slick/slick.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('vendors/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>
