@extends('layouts.app')
@section('content')
    <div class="inner_panal">
        <section class="projectDepartment">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($addcheck)
            <button class="custom-btn mb-4 d-block ml-auto" data-toggle="modal" data-target="#addDepart">إضافة قسم</button>
                @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            الرقم
                        </th>
                        <th>
                            اسم القسم
                        </th>
                        <th>
                            الإجراءات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cats as $cat)
                        <tr>
                            <td>{{$cat->id}}</td>
                            <td>{{$cat->type_title}}</td>
                            <td>
                            @if($editcheck)
                            <span data-toggle="modal" data-target="#editDepart">
                                <a  data-toggle="tooltip" title="تعديل"  class="updattype" data-content="{{$cat->type_title}}-{{$cat->id}}}" data-placement="bottom" href="{{route('edittype')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </span>
                                @endif
                                @if($deletecheck)
                                <a data-toggle="tooltip" title="حذف" data-placement="bottom" href="{{url("/project/".$cat->id."/2/destroy")}}"  class="deleteam" >
                                    <form action="{{ route('delType', $cat->id) }}" style="display: none;" id="delete_form">
                                        <input type="hidden" name="data_id" value="{{ $cat->id }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                    <i class="fas fa-trash"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div> <!-- end table-responsive -->

        </section> <!-- end projectDepartment -->

    </div> <!-- end inner_panal -->
    <div class="modal fade" id="addDepart">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form  action="{{route('addtype')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>اسم القسم</label>
                            <input type="text" class="form-control" name="type_title" required="">

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

    <div class="modal fade" id="editDepart">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{route('edittype')}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>اسم القسم</label>
                            <input type="text" id="tyname" name="type_title" class="form-control" value="" required="">
                        </div>
                        <input type="hidden" id="tyid" name="type_id" value="">
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
