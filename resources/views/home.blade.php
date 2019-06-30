@extends('layouts.app')

@section('content')
    <section class="home">

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
                @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                @endif
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-6 col">
                <div class="boxCard">
                    <div class="b_content">
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="numStat text-right">
                            <p>رسالة</p>
                            <p>{{$msgs }}</p>
                        </div> <!-- end numStat -->
                    </div> <!-- end b_content -->
                </div> <!-- end boxCard -->
            </div> <!-- end col -->
            <div class="col-xl-4 col-lg-6 col">
                <div class="boxCard">
                    <div class="b_content">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="numStat text-right">
                            <p>مستخدم</p>
                            <p>{{$users}}</p>
                        </div> <!-- end numStat -->
                    </div> <!-- end b_content -->
                </div> <!-- end boxCard -->
            </div> <!-- end col -->
            <div class="col-xl-4 col-lg-6 col">
                <div class="boxCard">
                    <div class="b_content">
                        <div class="icon">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div class="numStat text-right">
                            <p>دراسة</p>
                            <p>{{$studies}}</p>
                        </div> <!-- end numStat -->
                    </div> <!-- end b_content -->
                </div> <!-- end boxCard -->
            </div> <!-- end col -->
            <div class="col-xl-4 col-lg-6 col">
                <div class="boxCard">
                    <div class="b_content">
                        <div class="icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="numStat text-right">
                            <p>مشروع</p>
                            <p>{{$projects}}</p>
                        </div> <!-- end numStat -->
                    </div> <!-- end b_content -->
                </div> <!-- end boxCard -->
            </div> <!-- end col -->
            <div class="col-xl-4 col-lg-6 col">
                <div class="boxCard">
                    <div class="b_content">
                        <div class="icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="numStat text-right">
                            <p>استشارة</p>
                            <p>{{$consultations}}</p>
                        </div> <!-- end numStat -->
                    </div> <!-- end b_content -->
                </div> <!-- end boxCard -->
            </div> <!-- end col -->
            <div class="col-xl-4 col-lg-6 col">
                <div class="boxCard">
                    <div class="b_content">
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="numStat text-right">
                            <p>مشرفين  </p>
                            <p>{{$managers }}</p>
                        </div> <!-- end numStat -->
                    </div> <!-- end b_content -->
                </div> <!-- end boxCard -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </section> <!-- end home -->

@endsection
