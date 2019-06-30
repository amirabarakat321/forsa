@extends('layouts.app')
@section('content')
 <div class="inner_panal">
                    
                    <section class="profileView consultation  w-100 h-100 mb-5">

                        <div class="d-lg-flex justify-content-between">
                            <div class="order-2 my-5 text-center  text-lg-left">
                                <div class="userInfo text-center">
                                    <h3>استشارة </h3>
                                    <h4 class="mt-4">({{$data->catname}})</h4>
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
                                <div class="insession mr-4">
                                    <h3>في الجلسة</h3>
                                    <span>{{$data->service_price}}</span>
                                </div> <!-- end insession -->
                                <div class="insession ml-0">
                                    <h3>ساعة </h3>
                                    <span>{{$data->time}}</span>
                                </div> <!-- end insession -->
                            </div>
                            <div class="order-3 my-5 text-center  text-lg-left">
                                <ul class="profileAction ">
                                    <li>
                                        <a href="{{ url('chat/'.$data->id.'/cons')}}" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="المحادثات">
                                            <i class="fas fa-comments"></i>
                                        </a>
                                    </li>
                                    <!-- if the project is still active please add class active here else please add class inactive -->
                                    <li class="{{$data->liclass}}">
                                        <a href="#"  data-toggle="tooltip" title="{{ $data->statu}}" data-placement="bottom">
                                            <i class="fas fa-circle"></i>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a  data-toggle="tooltip" title="{{ $data->booking_date }}" data-placement="bottom" >
                                            <i class="fas fa-calendar-alt"></i>
                                        </a>
                                    </li>
                                    <li>

                                        <!-- To open the button please add class active here -->
                                        <button type="button" class="btn btn-sm btn-toggle {{$data->liclass}} status" data-toggle="button" aria-pressed="false">
                                            <a href="{{ url('consultations/status/'.$data->id) }}" style="display: none"></a>
                                            <div class="handle"></div>
                                        </button>
                                    </li>
                                </ul> <!-- end profileAction -->
                                <div class="text-center profileAction_a mainColor">

                                    <a href="{{ url('users/'.$data->provider_id) }}" class="owners mt-4">
                                        <i class="fas fa-user"></i>
                                        <span>مقدم الخدمة</span>
                                    </a>
                                    <a href="{{ url('users/'.$data->user_id) }}" class="owners ml-4">
                                        <i class="fas fa-user-tie"></i>
                                        <span>عميل</span>
                                    </a>
                                    <!-- end owners -->
                                </div> <!-- end profileAction_a -->
                            </div>
                        </div> <!-- end d-flex -->
                        <div class="my-5 about text-center">
                           <h3 class="mb-4">عن الاستشارة</h3>
                            <p class="mainColor">{{$data->description}}</p>
                        </div> <!-- end about -->
                    </section> <!-- end profileView -->
                 {{--<section>--}}
                     {{--<div id="messages"></div>--}}
                     {{--<input id="chat-input" type="text" placeholder="say anything" value="" autofocus/>--}}
                 {{--</section>--}}
                    
                </div> <!-- -->
@endsection
