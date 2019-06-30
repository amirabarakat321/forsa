@extends('layouts.app')

@section('content')
    <div class="inner_panal">
        @if( isset($photos))
        <div class="sliderProfile">
            <div class="slider">
                @foreach($photos as $photo)
                <div class="item" style="background-image :url({{$photo->photo}}) ">
                </div>
              @endforeach
            </div><!-- end slider -->
            <div class="sliderControl">
                <div class="arrow next">
                    <i class="fas fa-chevron-right"></i>
                </div> <!-- end arrow -->
                <div class="arrow prev">
                    <i class="fas fa-chevron-left"></i>
                </div> <!-- end arrow -->
            </div> <!-- end sliderControl -->
        </div> <!-- end sliderProfile -->
        @endif
        <section class="profileView statuies  w-100 h-100 mb-5">

            <div class="d-lg-flex justify-content-between">
                <div class="order-2 my-5 text-center  text-lg-left">
                    <div class="userInfo text-center">
                        <h3>{{ $study->title}} </h3>
                        <h4 class="mt-4">({{ $study->project_type}})</h4>
                    </div> <!-- end userInfo -->
                </div>
                <div class="order-1 my-5 text-center  text-lg-left">
                    <ul class="rating" data-toggle="tooltip" title="{{$totalrate}}" data-placement="bottom">
                        <li>
                            <i class="{{$stars[0]}}"></i>
                        </li>
                        <li>
                            <i class="{{$stars[1]}}"></i>
                        </li>
                        <li>
                            <i class="{{$stars[2]}}"></i>
                        </li>
                        <li>
                            <i class="{{$stars[3]}}"></i>
                        </li>
                        <li>
                            <i class="{{$stars[4]}}"></i>
                        </li>
                    </ul> <!-- end rating -->
                    <div class="insession">
                        <h3>السعر </h3>
                        <span>{{ $study->price}}</span>
                    </div> <!-- end insession -->
                </div>
                <div class="order-3 my-5 text-center  text-lg-left">
                    <ul class="profileAction">
                        <!-- if the project is still active please add class active here else please add class inactive -->
                        <li class="{{$study->liclass}}">
                            <a href="#"  data-toggle="tooltip" title="{{ $study->statu}}" data-placement="bottom">
                                <i class="fas fa-circle"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#"  data-toggle="tooltip" title="{{$study->address}}" data-placement="bottom">
                                <i class="fas fa-map-marker-alt"></i>
                            </a>
                        </li>
                        <li>
                            <a  href="#" data-toggle="tooltip" title="{{ $study->created_at}}" data-placement="bottom" >
                                <i class="fas fa-calendar-alt"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('study/'.$study->id.'/destroy')}}" class="delete" data-toggle="tooltip" title="حذف" data-placement="bottom">
                                <i class="fas fa-trash"></i>
                            </a>
                        </li>
                    </ul> <!-- end profileAction -->
                    <div class="text-center profileAction_a mainColor">
                        <h3>دراسة جدوي</h3>
                        <h4>( {{ $study->study_type}})</h4>
                        <a href="" class="owners mt-4">
                            <i class="fas fa-user"></i>
                            <span>مقدم الخدمة</span>
                        </a>
                        <a href="" class="owners ml-4">
                            <i class="fas fa-user-tie"></i>
                            <span>عميل</span>
                        </a>
                        <!-- end owners -->
                    </div> <!-- end profileAction_a -->

                </div>
            </div> <!-- end d-flex -->
            <div class="my-5 about text-center">
                <h3 class="mb-4">في الدراسة</h3>
                <p class="mainColor">{{$study->description}}</p>
            </div> <!-- end about -->
        </section> <!-- end profileView -->

    </div> <!-- end inner_panal -->
@endsection
