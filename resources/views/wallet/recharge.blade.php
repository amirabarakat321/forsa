@extends('layouts.app')
@section('search')
    <form  action="{{route('balancesearch')}}"  method="post" class="search__nav clearfix">
        {{ csrf_field() }}
        <button class="search-btn" type="submit">
            <img src="{{ asset('images/icons/search_nav.svg') }}" alt="icon">
        </button> <!-- end search-btn -->
        <div class="form-group">
            <input class="form-control" name="saerchtesxt" type="search" placeholder="ابحث باسم المستخدم او البنك  هنا" >
            <input  name="ty" type="hidden"  value="{{$ty}}" >
            {{--<div class="filterWidget">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-xl-3 col-lg-6 col-md-12">--}}
                        {{--<h3 class="titleFilter">مقدم الخدمه </h3>--}}
                        {{--<div class="custom-control custom-checkbox mb-2">--}}
                            {{--<input type="checkbox" class="custom-control-input" id="customCheck1" value="expert" name="expert">--}}
                            {{--<label class="custom-control-label" for="customCheck1">خبير </label>--}}
                        {{--</div>--}}
                        {{--<div class="custom-control custom-checkbox mb-2">--}}
                            {{--<input type="checkbox" class="custom-control-input" id="customCheck2" value="amateur" name="amateur">--}}
                            {{--<label class="custom-control-label" for="customCheck2">مجرب</label>--}}
                        {{--</div>--}}

                    {{--</div> <!-- end col -->--}}
                    {{--<div class="col-xl-3 col-lg-6 col-md-12">--}}
                        {{--<h3 class="titleFilter">نوع الاستشاره </h3>--}}
                        {{--@foreach($consultationscategories as $cat)--}}
                            {{--<div class="custom-control custom-checkbox mb-2">--}}
                                {{--<input type="checkbox" class="custom-control-input" id="{{$cat->id}}" value="{{$cat->id}}"name="{{$cat->title}}">--}}
                                {{--<label class="custom-control-label" for="{{$cat->id}}">{{$cat->title}}</label>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                    {{--</div> <!-- end col -->--}}


                {{--</div> <!-- end row -->--}}
            {{--</div> <!-- end filterWidget -->--}}
        </div> <!-- end form-group -->
        {{--<div class="icon">--}}
            {{--<i class="fas fa-sliders-h"></i>--}}
        {{--</div>--}}
    </form> <!-- end search__nav -->
@endsection
@section('content')

        <div class="inner_panal">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
                @if(count($errors))
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="color: red">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            اسم المستخدم
                        </th>

                        <th>
                            اسم البنك
                        </th>
                        <th>
                            فرع البنك
                        </th>
                        <th>
                            رقم الحساب
                        </th>
                        <th>
                            رقم ايبان
                        </th>
                        <th>
                            المبلغ المحول
                        </th>

                        <th>
                            الإجراءات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {!! $output !!}
                    </tbody>
                </table>
                {!! $link->links() !!}
            </div> <!-- end table-responsive -->
        </div> <!-- end inner_panal -->


    <!-- Sign out-->
    <!-- The Modal -->

    <div class="modal fade" id="sendMoney">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="{{route('balancerecharge')}}"  class="editSpec">
                      @csrf
                        <div class="form-group">
                            <label> عدد النقاط</label>
                            <input value="" name="id" type="hidden" id="add_balance_id">
                            <input type="text" name="amount" disabled value="" id="balance_amount" class="form-control" required="" placeholder="">

                        </div>
                        <div class="control-model d-flex flex-row justify-content-around">
                            <button type="submit" class="custom-btn mt-2">إرسال</button>
                            <button type="button" class="custom-btn mt-2" data-dismiss="modal">الغأء</button>
                        </div> <!-- end control-model -->
                    </form>

                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->

    <div class="modal fade" id="mark">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center mb-4 mainColor">اختار العلامة</p>
                    <form class="text-center " action="{{route('editwallet')}}" method="post">
                          @csrf
                        <input value="" name="id" type="hidden" id="balance_id">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="blue" name="status[]" value="0">
                            <label class="custom-control-label" for="blue">
                                <i class="fas fa-check-circle animate blue" style="font-size:22px"></i>
                            </label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="green" name="status[]" value="1">
                            <label class="custom-control-label" for="green">
                                <i class="fas fa-check-circle animate green" style="font-size:22px"></i>
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
        <div class="modal fade" id="changeBalanceview">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" action="{{route('balancewithdraw')}}"  class="editSpec">
                            @csrf
                            <div class="form-group">

                                <div class="custom-control custom-radio custom-control-inline mb-2">
                                    <input type="radio"  class="custom-control-input" id="Bview" name="status" value="1">
                                    <label class="custom-control-label" for="Bview">ارسال اشعار انه تم الاطلاع ع  الطلب وجاري عملية التحويل </label>
                                </div>

                                <input value="" name="id" type="hidden" id="delete_balance_id_view">
                                <input type="text" name="amount" disabled value="" id="delete_balance_amount_view" class="form-control" required="" placeholder="">

                            </div>
                            <div class="control-model d-flex flex-row justify-content-around">
                                <button type="submit" class="custom-btn mt-2">إرسال</button>
                                <button type="button" class="custom-btn mt-2" data-dismiss="modal">الغأء</button>
                            </div> <!-- end control-model -->
                        </form>

                    </div> <!-- end modal-body -->
                </div> <!-- end modal-content -->
            </div> <!-- end modal-dialog -->
        </div> <!-- end modal -->
        <div class="modal fade" id="changeBalancedone">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="post" action="{{route('balancewithdraw')}}"  class="editSpec">
                            @csrf
                            <div class="form-group">


                                <div class="custom-control custom-radio custom-control-inline mt-2">
                                    <input type="radio" class="custom-control-input" id="Bdone" name="status" value="2">
                                    <label class="custom-control-label" for="Bdone"> ارسال اشعار انه تمت عملية التحويل </label>
                                </div>

                                <input value="" name="id" type="hidden" id="delete_balance_id_done">
                                <input type="text" name="amount" disabled value="" id="delete_balance_amount_done" class="form-control" required="" placeholder="">

                            </div>
                            <div class="control-model d-flex flex-row justify-content-around">
                                <button type="submit" class="custom-btn mt-2">إرسال</button>
                                <button type="button" class="custom-btn mt-2" data-dismiss="modal">الغأء</button>
                            </div> <!-- end control-model -->
                        </form>

                    </div> <!-- end modal-body -->
                </div> <!-- end modal-content -->
            </div> <!-- end modal-dialog -->
        </div> <!-- end modal -->
        <div class="modal fade" id="bankDetails">
            <div class="modal-dialog modal-dialog-centered modal-lg" >
                <div class="modal-content">
                    <div class="modal-body">
                        <form >
                            <div  id="printForm">
                                <div class="row">
                                    <div class="col-6">
                                        <h5>اسم البنك</h5>
                                        <h4 id="bankname"></h4>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <h5> رقم الحساب</h5>
                                        <h4 id="accnu"></h4>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <h5> رقم الابيان</h5>
                                        <h4 id="iban_nu"></h4>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <h5>العمليه</h5>
                                        <h4 id="processtype"></h4>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <h5>المبلغ الكلي</h5>
                                        <h4 id="tatalbalance"></h4>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <h5>نسبه الموقع</h5>
                                        <h4 id="sitecommission"></h4>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <h5>المبلغ المستخدم بعد الخصم</h5>
                                        <h4 id="uesrbalance"></h4>
                                    </div> <!-- end col -->
                                    <div class="col-6">
                                        <h5>مبلغ الموقع </h5>
                                        <h4 id="sitebalance"> </h4>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <div class="control-model d-flex flex-row justify-content-around">
                                <button type="button" class="custom-btn" onclick="printcontent('printForm')">طباعة</button>
                                <button type="button" class="custom-btn" data-dismiss="modal">الغأء</button>
                            </div> <!-- end control-model -->
                        </form>


                    </div> <!-- end modal-body -->
                </div> <!-- end modal-content -->
            </div> <!-- end modal-dialog -->
        </div> <!-- end modal -->
@endsection
