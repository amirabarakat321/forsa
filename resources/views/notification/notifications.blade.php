@extends('layouts.app')

@section('content')
    <div class="inner_panal">
        <section class="notif">
            <div class="mb-4 text-center">
                <button class="custom-btn mx-2" data-toggle="modal" data-target="#addNotif" >إضافة إشعار</button>
                {{--<button class="custom-btn mx-2" data-toggle="modal" data-target="#addNotif" >تصدير كملف</button>--}}
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            الرقم
                        </th>
                        <th>
                            عنوان التنبيه
                        </th>
                        <th>
                            نوع المستخدمين
                        </th>
                        <th>
                            الإجراءات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                   {!! $output!!}

                    </tbody>
                </table>
                {!! $notifications->links() !!}
            </div> <!-- end table-responsive -->
        </section> <!-- end notif -->

    </div> <!-- end inner_panal -->



    <div class="modal fade" id="addNotif">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{route('addnotifi')}}" method="post" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>عنوان الإشعار</label>
                            <input type="text" name="title"  class="form-control" required="">
                            <!--
                                                        <small id="emailHelp" class="form-text">
                                                            من فضلك املئ حقل الادخال هذا
                                                        </small>
                            -->
                        </div>
                        <div class="form-group">
                            <label>نص الإشعار</label>
                            <textarea class="form-control" name="text" required=""></textarea>
                            <!--
                                                        <small id="emailHelp" class="form-text">
                                                            من فضلك املئ حقل الادخال هذا
                                                        </small>
                            -->
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label>إرسال رابط--}}
                                {{--<span>*</span>--}}
                            {{--</label>--}}
                            {{--<input type="url" class="form-control" name ='url' required="">--}}
                            {{--<!----}}
                                                        {{--<small id="emailHelp" class="form-text">--}}
                                                            {{--من فضلك املئ حقل الادخال هذا--}}
                                                        {{--</small>--}}
                            {{---->--}}
                        {{--</div>--}}

                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customer" name="client">
                            <label class="custom-control-label" for="customer"> عميل </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="amateur" name="amateur">
                            <label class="custom-control-label" for="amateur"> مجرب </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="expert" name="expert">
                            <label class="custom-control-label" for="expert"> خبير </label>
                        </div>
                        <div class="control-model d-flex flex-row justify-content-between">
                            <button type="submit" class="custom-btn mt-3">إرسال</button>
                            <button type="button" class="custom-btn mt-3" data-dismiss="modal">إلغاء</button>
                        </div> <!-- end control-model -->
                    </form>
                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->

    <div class="modal fade" id="viewNotif">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <p id="notifitext" class="mainColor text-center">

                    </p>
                    <div class="control-model d-flex flex-row justify-content-around">
                        <button type="button" class="custom-btn mt-3" data-dismiss="modal">إلغاء</button>
                    </div> <!-- end control-model -->
                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->
@endsection
