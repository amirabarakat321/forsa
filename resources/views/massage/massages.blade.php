@extends('layouts.app')

@section('content')
    <div class="inner_panal">
        <section class="Message">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            الرقم
                        </th>
                        <th>
                            الراسل
                        </th>
                        <th>
                            الهاتف
                        </th>
                        <th>
                            البريد الالكتروني
                        </th>

                        <th>
                           مقرؤه
                        </th>
                        <th>
                            الإجراءات
                        </th>
                        <th>
                         ارسال بريد
                         </th>
                    </tr>
                    </thead>
                    <tbody>
                    {!! $output!!}
                    </tbody>
                </table>
                {!! $messages->links() !!}
            </div> <!-- end table-responsive -->
        </section> <!-- end Message -->

    </div> <!-- end inner_panal -->
    <div class="modal fade" id="mail">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{route('sendmail')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>نص الرساله </label>
                            <input type="text" id="msg" name="msg" class="form-control" value="" required="">
                        </div>
                        <input type="hidden" id="useremail" name="email" value="">
                        <input type="hidden" id="username" name="name" value="">
                        <div class="control-model d-flex flex-row justify-content-between">
                            <button type="submit" class="custom-btn mt-3">حفظ</button>
                            <button type="button" class="custom-btn mt-3" data-dismiss="modal">إلغاء</button>
                        </div> <!-- end control-model -->
                    </form>
                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->
@endsection
