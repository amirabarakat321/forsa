@extends('layouts.app')
@section('content')
<div class="inner_panal">
    <section class="projectSerivce">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($addcheck)
        <button class="custom-btn mb-4 d-block ml-auto" data-toggle="modal" data-target="#addService" >إضافة خدمة</button>
         @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            الرقم
                        </th>
                        <th>
                            اسم الخدمة
                        </th>
                        <th>
                            الإجراءات
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {!! $services !!}
                </tbody>
            </table>
        </div> <!-- end table-responsive -->
    </section> <!-- end projectSerivce -->
</div> <!-- end inner_panal -->

<div class="modal fade" id="addService">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" action="{{ route('addservice')  }}">
                    @csrf
                    <div class="form-group">
                        <label>اسم الخدمة</label>
                        <input type="text" name="service_title" class="form-control" required="">
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
        
@if($services != '')
<div class="modal fade" id="editService">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form action="{{route('editservice')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                    <div class="form-group">
                        <label>اسم الخدمة</label>
                        <input type="text" class="form-control"  id="tyname" value="" name="service_title" required="">
                   <!--
                    <small id="emailHelp" class="form-text">
                        من فضلك املئ حقل الادخال هذا
                    </small>
                           -->
                    </div>
                     <input type="hidden" id="tyid"  name="service_id"  value="">
                    <div class="control-model d-flex flex-row justify-content-between">
                        <button type="submit" class="custom-btn mt-3">حفظ</button>
                        <button type="button" class="custom-btn mt-3" data-dismiss="modal">إلغاء</button>
                    </div> <!-- end control-model -->
                </form>
            </div> <!-- end modal-body -->
        </div> <!-- end modal-content -->
    </div> <!-- end modal-dialog -->
</div> <!-- end modal -->

<script>
function edit(title ,id) {
  consol.log(arguments[0]);
}
</script>
@endif
@endsection
