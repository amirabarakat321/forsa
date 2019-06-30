@extends('layouts.app')
@section('content')
    <section class="profileView users w-100 h-100 mb-5">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        <div class="d-lg-flex justify-content-between">
            <div class="order-2 my-5 text-center  text-lg-left">
                <div class="userInfo text-center">
                    <div class="userImg">
                        <img src="{{ $profile->avatar != null ? $profile->name : asset('images/avatar.png') }}" alt="user image">
                    </div> <!-- end userImg -->
                    <h3>{{ $profile->name }} <span>( {{ $profile->type == 'client' ? 'عميل' : 'خبير' }} )</span></h3>
                    <ul class="userAction">
                        <li>
                            <a href="#" data-toggle="tooltip" title="{{ $specializations[$profile->type] }}"  data-placement="bottom">
                                <i class="fas fa-question-circle"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="tooltip" title="{{ $profile->email }}" data-content="{{ $profile->email }}" data-placement="bottom">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" data-toggle="tooltip" title="{{ $profile->phone }}" data-content="{{ $profile->phone }}" data-placement="bottom">
                                <i class="fas fa-phone fa-flip-horizontal"></i>
                            </a>
                        </li>
                        @if($profile->type == 'amateur' OR $profile->type == 'expert')
                        <li data-toggle="modal" data-target="#mark">
                            <a href="javascript:void(0);" data-toggle="tooltip" title="تغير العلامة" data-placement="bottom">
                                @if($profile->authenticate == 'certified')
                                    <i class="fas fa-check-circle animate green"></i>
                                @elseif($profile->authenticate == 'authenticated')
                                    <i class="fas fa-check-circle animate blue"></i>
                                @elseif($profile->authenticate == 'gold')
                                    <i class="fas fa-check-circle animate gold"></i>
                                @else
                                    <i class="fas fa-check-circle animate gray"></i>
                                @endif
                            </a>
                        </li>
                        @else
                            <li>
                                <i class="fas fa-check-circle animate green"></i>
                            </li>
                        @endif
                    </ul> <!-- end userAction -->
                </div> <!-- end userInfo -->
            </div>
            <div class="order-1 my-5 text-center  text-lg-left">
                @if($profile->type == 'amateur' OR $profile->type == 'expert')
                    <ul class="rating" data-toggle="tooltip" data-value= "{{ $profile->rating }}" title="{{ $profile->rating }}" data-placement="bottom">

                    </ul> <!-- end rating -->
                    <div class="insession">
                        <h3>في الجلسة</h3>
                        <span>{{ $profile->service_price }} ريال</span>
                    </div> <!-- end insession -->
                @endif
            </div>
            <div class="order-3 my-5 text-center  text-lg-left">
                <ul class="profileAction">
                  
                    <li>
                        <a href="#"  data-toggle="tooltip" title="{{ $profile->address }}" data-content="{{ $profile->address }}" data-placement="bottom">
                            <i class="fas fa-map-marker-alt"></i>
                        </a>
                    </li>
                    <li data-toggle="modal"  data-target="#notif">
                        <a  href="#" data-toggle="tooltip" title="إرسال تنبيه" data-placement="bottom" >
                            <i class="fas fa-bell"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('users/status/'.$profile->id) }}" class="ban" data-toggle="tooltip" title="{{ $profile->status == true ? 'حظر' : 'إلغاء الحظر' }}" data-placement="bottom">
                            <i class="{{ $profile->status == true ? 'fas fa-ban' : 'fas fa-play' }}"></i>
                        </a>
                    </li>
                </ul> <!-- end profileAction -->
                <div class="text-center profileAction_a mainColor">
                    <h4>الرصيد</h4>
                    <h5>{{ $profile->balance != null ? $profile->balance : 0 }} ريال</h5>
                </div>
            </div>
        </div> <!-- end d-flex -->
        @if($profile->type == 'amateur' OR $profile->type == 'expert')
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home">ملقات التوثيق</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu1">معرض الأعمال</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu2">معرض المشاريع</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu3">السيرة الذاتية</a>
            </li>
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" data-toggle="tab" href="#menu4">التقييمات</a>--}}
            {{--</li>--}}
        </ul>

        <div class="tab-content">
            <div id="home" class=" tab-pane active ">
                <div class="row mt-5">
                    @if(count($documentations) >0)
                        @foreach($documentations as $docum)
                    <div class="col-xl-4 col-lg-6 col-md-12 offset-xl-2">
                        <div class="docWidget">
                            <h3>{{$docum->title}}</h3>

                            <a href="{{ $docum->file }}" target="_blank">
                                <img src="{{ $docum->file }}" class="img-thumbnail"/>
                            </a>
                        </div> <!-- end docWidget -->
                    </div>
                        @endforeach
                        @endif

                </div> <!-- end row -->

            </div>

            <div id="menu1" class=" tab-pane fade">
                <div class="row mt-5 userWorks">
                    {!! $portfolio !!}
                </div> <!-- edn row -->
            </div>

            <div id="menu2" class=" tab-pane fade">
                <div class="row  mt-5 userWorks">
                    {!! $projects !!}
                </div> <!-- edn row -->

            </div>
            <div id="menu3" class=" tab-pane fade">
                {{ $profile->bio }}
            </div>
            {{--<div id="menu4" class=" tab-pane fade">--}}
                {{--<div class="rating-card">--}}
                    {{--<div class="clearfix">--}}
                        {{--<div class="card-img">--}}
                            {{--<img src="images/users/user.png" alt="username">--}}
                        {{--</div> <!-- end card-img -->--}}
                        {{--<div class="content">--}}
                            {{--هناك حقيقة مثبته منذ زمن طويل ان المحتوي المقرؤ سيلهي القارء عن الشكلالخارجي للمحتصميم  وسينبهر بيه هناك حقيقة مثبته منذ زمن طويل ان المحتوي المقرؤ سيلهي القارء عن الشكلالخارجي للمحتصميم  وسينبهر بيه--}}
                        {{--</div> <!-- end content -->--}}
                    {{--</div>--}}

                    {{--<div class="d-lg-flex">--}}
                        {{--<ul class="rating " data-toggle="tooltip" data-placement="bottom">--}}
                            {{--<p class="text-center">تقييم الجودة</p>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star-half-alt fa-flip-horizontal"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="far fa-star"></i>--}}
                            {{--</li>--}}
                        {{--</ul> <!-- end rating -->--}}
                        {{--<ul class="rating " data-toggle="tooltip" data-placement="bottom">--}}
                            {{--<p class="text-center">تقييم السرعة</p>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}

                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                        {{--</ul> <!-- end rating -->--}}
                        {{--<ul class="rating " data-toggle="tooltip" data-placement="bottom">--}}
                            {{--<p class="text-center">تقييم المصادقة</p>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}

                            {{--<li>--}}
                                {{--<i class="fas fa-star-half-alt fa-flip-horizontal"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="far fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="far fa-star"></i>--}}
                            {{--</li>--}}
                        {{--</ul> <!-- end rating -->--}}

                    {{--</div>--}}
                {{--</div> <!-- end rating-card -->--}}
                {{--<button class="custom-btn d-block delete ml-auto mt-2 mr-0">حذف</button>--}}
                {{--<div class="rating-card">--}}
                    {{--<div class="clearfix">--}}
                        {{--<div class="card-img">--}}
                            {{--<img src="images/users/user.png" alt="username">--}}
                        {{--</div> <!-- end card-img -->--}}
                        {{--<div class="content">--}}
                            {{--هناك حقيقة مثبته منذ زمن طويل ان المحتوي المقرؤ سيلهي القارء عن الشكلالخارجي للمحتصميم  وسينبهر بيه هناك حقيقة مثبته منذ زمن طويل ان المحتوي المقرؤ سيلهي القارء عن الشكلالخارجي للمحتصميم  وسينبهر بيه--}}
                        {{--</div> <!-- end content -->--}}
                    {{--</div>--}}

                    {{--<div class="d-lg-flex">--}}
                        {{--<ul class="rating " data-toggle="tooltip" data-placement="bottom">--}}
                            {{--<p class="text-center">تقييم الجودة</p>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star-half-alt fa-flip-horizontal"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="far fa-star"></i>--}}
                            {{--</li>--}}
                        {{--</ul> <!-- end rating -->--}}
                        {{--<ul class="rating " data-toggle="tooltip" data-placement="bottom">--}}
                            {{--<p class="text-center">تقييم السرعة</p>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}

                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                        {{--</ul> <!-- end rating -->--}}
                        {{--<ul class="rating " data-toggle="tooltip" data-placement="bottom">--}}
                            {{--<p class="text-center">تقييم المصادقة</p>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="fas fa-star"></i>--}}
                            {{--</li>--}}

                            {{--<li>--}}
                                {{--<i class="fas fa-star-half-alt fa-flip-horizontal"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="far fa-star"></i>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<i class="far fa-star"></i>--}}
                            {{--</li>--}}
                        {{--</ul> <!-- end rating -->--}}

                    {{--</div>--}}
                {{--</div> <!-- end rating-card -->--}}
                {{--<button class="custom-btn d-block delete ml-auto mt-2 mr-0">حذف</button>--}}
            {{--</div>--}}
        </div>

        <div class="statisticsProfile mainColor">
            <div class="row">
                <div class="col mx-4">
                    <div class="widget text-center">
                        <div class="w_icon">
                            <i class="fas fa-info-circle"></i>
                        </div> <!-- edn w_icon -->
                        <h3>عدد الاستشارات</h3>
                        <small>{{ $profile->consultations }} استشارات</small>
                    </div> <!-- end widget -->
                </div> <!-- end col -->
                <div class="col mx-4">
                    <div class="widget text-center">
                        <div class="w_icon">

                            <i class="fas fa-file-signature"></i>
                        </div> <!-- edn w_icon -->
                        <h3>عدد الدراسات </h3>
                        <small>{{ $profile->studies }} دراسات</small>
                    </div> <!-- end widget -->
                </div> <!-- end col -->
                <div class="col mx-4">
                    <div class="widget text-center">
                        <div class="w_icon">
                            <i class="fas fa-building"></i>
                        </div> <!-- edn w_icon -->
                        <h3>عدد المشاريع </h3>
                        <small>{{ $profile->projects }} مشروع</small>
                    </div> <!-- end widget -->
                </div> <!-- end col -->
                @if($profile->type == 'amateur' OR $profile->type == 'expert')
                <div class="col mx-4">
                    <div class="widget text-center">
                        <div class="w_icon">
                            <i class="fas fa-star"></i>
                        </div> <!-- edn w_icon -->
                        <h3>سنين الخبرة</h3>
                        <small>{{ $profile->experience_years }} سنوات</small>
                    </div> <!-- end widget -->
                </div> <!-- end col -->
                @endif
            </div> <!-- end row -->
        </div> <!-- end statisticsProfile -->
        @endif
    </section>
    <div class="modal fade" id="mark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center mb-4 mainColor">اختار العلامة</p>
                    <form class="text-center" action="{{ url('upgradeMark/'.$profile->id) }}" id="userUpgradeMark" method="post">
                        @csrf
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="blue" name="upgradeMark" value="authenticated">
                            <label class="custom-control-label" for="blue">
                                <i class="fas fa-check-circle animate blue" style="font-size:22px"></i>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="green" name="upgradeMark" value="certified">
                            <label class="custom-control-label" for="green">
                                <i class="fas fa-check-circle animate green" style="font-size:22px"></i>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="gold" name="upgradeMark" value="gold">
                            <label class="custom-control-label" for="gold">
                                <i class="fas fa-check-circle animate gold" style="font-size:22px"></i>
                            </label>
                        </div>
                        <div class="control-model d-flex flex-row justify-content-between mt-4">
                            <button type="submit" class="custom-btn m-0 confirm">إرسال</button>
                            <button type="button" class="custom-btn m-0" data-dismiss="modal">إلغاء</button>
                        </div> <!-- end control-model -->
                    </form>
                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->

    <div class="modal fade" id="notif">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="{{ url('sendNotifi/'.$profile->id) }}">
                        @csrf
                        <div class="form-group">
                            <label>إرسال إشعار</label>
                            <input class="form-control" type="text" name="title" required placeholder="عنوان الرسالة">
                            <br/>
                            <textarea class="form-control" name="message" required="" placeholder="نص الرسالة"></textarea>
                        </div>
                        <div class="control-model d-flex flex-row justify-content-between">
                            <button type="submit" class="custom-btn m-0">إرسال</button>
                            <button type="button" class="custom-btn m-0" data-dismiss="modal">إلغاء</button>
                        </div> <!-- end control-model -->
                    </form>
                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->

@endsection
