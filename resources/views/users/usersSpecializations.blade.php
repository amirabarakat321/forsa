@extends('layouts.app')
@section('content')
    <section class="userSpec">
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <button class="custom-btn mb-4 d-block ml-auto" data-toggle="modal" data-target="#addSpec">إضافة تخصص</button>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        اسم التخصص
                    </th>
                    <th>
                        الإجراءات
                    </th>
                </tr>
                </thead>
                <tbody>
                {!! $specializations !!}
                </tbody>
            </table>
            {!! $links->links() !!}
        </div> <!-- end table-responsive -->
    </section> <!-- end userSpec -->
    <div class="modal fade" id="editSpec">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="" class="editSpec">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>اسم التخصص</label>
                            <input type="text" name="title" class="form-control" required="" value="">
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
    <div class="modal fade" id="addSpec">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="{{ route('specializations.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>اسم التخصص</label>
                            <input type="text" name="title" class="form-control" required="">
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
@endsection
