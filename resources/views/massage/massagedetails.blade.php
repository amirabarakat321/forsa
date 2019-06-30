@extends('layouts.app')
@section('content')
    <div class="inner_panal">

        <section class="profileView consultation  w-100 h-100 mb-5">

            <div class="d-lg-flex justify-content-between">
                <div class="order-2 my-5 text-center  text-lg-left">
                    <div class="userInfo text-center">
                        <h3>رساله من  </h3>
                        <h4 class="mt-4">({{$message->messagefrom}})</h4>

                    </div> <!-- end userInfo -->
                </div>

                <div class="order-3 my-5 text-center  text-lg-left">
                    <ul class="profileAction ">
                        <!-- if the project is still active please add class active here else please add class inactive -->

                        <li>
                            <a href="{{ route('users.show', $message->user_id) }}" class="owners ml-4">
                                <i class="fas fa-user-tie"></i>
                                <span>المرسل </span>
                            </a>
                        </li>
                        <li>
                            <a  data-toggle="tooltip"  title="حذف" data-placement="bottom"  href="{{url("inbox/".$message->id."/delete")}}"   >
                                <i class="fas fa-trash"></i>
                            </a>
                        </li>
                    </ul> <!-- end profileAction -->


                </div>
            </div> <!-- end d-flex -->
            <div class="my-5 about text-center">
                <h3 class="mb-4">{{$message->subject}}</h3>
                <p class="mainColor">{{$message->message}}</p>
            </div> <!-- end about -->
        </section> <!-- end profileView -->

    </div> <!-- end inner_panal -->
@endsection
