@extends('layouts.app')
@section('content')
    <section class="consultationDepartment">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($addcheck)
        <button class="custom-btn mb-4 d-block ml-auto" data-toggle="modal" data-target="#addDepart">إضافة قسم</button>
            @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                        #
                        </th>
                        <th>
                            اسم القسم
                        </th>
                        <th>
                            الحالة
                        </th>
                        <th>
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {!! $cats !!}
                </tbody>
            </table>
            {!! $paginate !!}
        </div> <!-- end table-responsive -->
    </section> <!-- end userNormal -->

    <div class="modal fade" id="addDepart">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="{{ route('consultations_categories.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>اسم القسم </label>
                            <input type="text" class="form-control" required="" name="title">
                        </div>

                        <div class="control-model d-flex flex-row justify-content-between">
                            <button type="submit" class="custom-btn mt-3">إضافة</button>
                            <button type="button" class="custom-btn mt-3" data-dismiss="modal">إلغاء</button>
                        </div> <!-- end control-model -->

                    </form>
                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->

    <div class="modal fade" id="editSpec">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="" class="editSpec">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>اسم القسم </label>
                            <input type="text" class="form-control" required="" name="title" value="">
                        </div>

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
