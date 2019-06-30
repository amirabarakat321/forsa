@extends('layouts.app')
@section('search')
    <form  action="{{route('searchSupervisor')}}" method="post" class="search__nav clearfix">
        @csrf
        <button class="search-btn" type="submit">
            <img src="{{ asset('images/icons/search_nav.svg') }}" alt="icon">
        </button> <!-- end search-btn -->
        <div class="form-group">
            <input class="form-control" name="adminname" type="search" placeholder="ابحث هنا بالاسم  ...." >
            <div class="filterWidget">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <h3 class="titleFilter">بحث بمثال</h3>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="example1">
                            <label class="custom-control-label" for="customCheck1">مثال رقم 1 </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck2" name="example1">
                            <label class="custom-control-label" for="customCheck2"> مثال رقم 2</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck3" name="example1">
                            <label class="custom-control-label" for="customCheck3"> مثال رقم 3</label>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <h3 class="titleFilter">بحث بمثال</h3>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck21" name="example1">
                            <label class="custom-control-label" for="customCheck21">مثال رقم 1 </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck22" name="example1">
                            <label class="custom-control-label" for="customCheck22"> مثال رقم 2</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck23" name="example1">
                            <label class="custom-control-label" for="customCheck23"> مثال رقم 3</label>
                        </div>
                    </div> <!-- end col -->

                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <h3 class="titleFilter">بحث بمثال</h3>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck31" name="example1">
                            <label class="custom-control-label" for="customCheck31">مثال رقم 1 </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck32" name="example1">
                            <label class="custom-control-label" for="customCheck32"> مثال رقم 2</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck33" name="example1">
                            <label class="custom-control-label" for="customCheck33"> مثال رقم 3</label>
                        </div>
                    </div> <!-- end col -->
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <h3 class="titleFilter">بحث بمثال</h3>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck41" name="example1">
                            <label class="custom-control-label" for="customCheck41">مثال رقم 1 </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck42" name="example1">
                            <label class="custom-control-label" for="customCheck42"> مثال رقم 2</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck43" name="example1">
                            <label class="custom-control-label" for="customCheck43"> مثال رقم 3</label>
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row -->
            </div> <!-- end filterWidget -->
        </div> <!-- end form-group -->
        {{--<div class="icon">--}}
            {{--<i class="fas fa-sliders-h"></i>--}}
        {{--</div>--}}
    </form> <!-- end search__nav -->
@endsection
@section('content')
    <div class="inner_panal"> 
        <section class="admins">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
             @endif 
             @if(count($errors))
                <ul>
                @foreach($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
                @endforeach
                </ul>
             @endif
            @if($ifsearch)
            <button class="custom-btn mb-4 d-block ml-auto" data-toggle="modal" data-target="#addAdmin">إضافة مشرف</button>
                @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                الرقم
                            </th>
                            <th>
                                 الاسم
                            </th>
<!--
                            <th>
                                 القسم
                            </th>
                            <th>
                                الصلاحية
                            </th>
 -->
                            <th>
                                الحالة
                            </th>
                            <th>
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td>{{$admin->id}}</td>
                            <td>{{$admin->name}}</td>
                           <!--
                            <td>قسم الرسايل</td>
                            <td>
                                عرض - تعديل
                            </td>
                            -->
                            <td>
                                <!-- To open the button please add class active here -->
                                <button type="button" class="{{$admin->clas}}"  aria-pressed="{{$admin->sta}}" href="/Supervisor/{{$admin->id}}/statue" autocomplete="off">
                                    <div class="handle"></div>
                                </button>
                            </td>
                         
                        

                            <td>
                                <span data-toggle="modal" data-target="#editAdmin">
                                    <a  data-toggle="tooltip"  title="تعديل"  class="updateadmin" data-placement="bottom"
                                        data-content="{{$admin->name}}-{{$admin->email}}-{{$admin->id}}-{{$admin->privilege['view']}}-{{$admin->privilege['delete']}}-{{$admin->privilege['edit']}}-{{$admin->privilege['add']}}"
                                         href="{{route('editSupervisor')}}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </span>
                                <a  data-toggle="tooltip" title="حذف" data-placement="bottom" href="{{url('/Supervisor/'.$admin->id.'/delete')}}" class="deleteam">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                       
                    </tbody>
                </table>
            </div> <!-- end table-responsive -->
        </section> <!-- end admins -->        
    </div> <!-- end inner_panal -->


        <!-- Sign out-->
        <!-- The Modal -->
        <div class="modal fade" id="signout">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="mainColor text-center">
                            هل تريد تسجيل خروجك بالفعل ؟
                        </p>
                        <div class="control-model d-flex flex-row justify-content-around">
                            <button type="button" class="custom-btn">نعم</button>
                            <button type="button" class="custom-btn" data-dismiss="modal">إلغاء</button>
                        </div> <!-- end control-model -->
                    </div> <!-- end modal-body -->
                </div> <!-- end modal-content -->
            </div> <!-- end modal-dialog -->
        </div> <!-- end modal -->
        <!-- /Sign out-->
        <div class="modal fade" id="addAdmin">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="{{route('addSupervisor')}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>اسم المدير </label>
                                <input type="text" id="adname" name="name" class="form-control" required="">
                                  <!--
                                <small id="emailHelp" class="form-text">
                                    من فضلك املئ حقل الادخال هذا
                                </small>
                                    -->
                            </div>
                            <div class="form-group">
                                <label>البريد الالكتروني </label>
                                <input type="email" name="email" class="form-control" required="">
                                <!--
                            <small id="emailHelp" class="form-text">
                                من فضلك املئ حقل الادخال هذا
                            </small>
                              -->
                            </div>
                            <div class="form-group">
                                <label>الرقم السري </label>
                                <input type="password" name="password"
                            class="form-control" required="">
                                 <!--
                            <small id="emailHelp" class="form-text">
                                من فضلك املئ حقل الادخال هذا
                            </small>
                             -->
                            </div>
                               <!--
                            <label class="d-block"> الاقسام </label>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="proj" name="example1">
                                <label class="custom-control-label" for="proj"> قسم المشاريع </label>
                            </div>
                             <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="mess" name="example1">
                                <label class="custom-control-label" for="mess"> قسم الرسائل </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="studiesD" name="example1">
                                <label class="custom-control-label" for="studiesD"> قسم الدراسات </label>
                            </div>
                             <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="notifD" name="example1">
                                <label class="custom-control-label" for="notifD"> قسم الاشعارات </label>
                            </div>-->
                            <label class="d-block"> الصلاحية </label>
                            <div class="custom-control custom-checkbox mb-2">
                                <input  type="checkbox" class="custom-control-input" id="view" name="view" value="1">
                                <label class="custom-control-label" for="view"> عرض </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="eidt" name="edit" value="1">
                                <label class="custom-control-label" for="eidt"> تعديل </label>
                            </div>

                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="add" name="add" value="1">
                                <label class="custom-control-label" for="add"> اضافة </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="delete" name="delete" value="1">
                                <label class="custom-control-label" for="delete"> حذف </label>
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

        <div class="modal fade" id="editAdmin">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <form  action="" method="post" name="myform">
                            @csrf
                             <input type="hidden" name="id" value="" id="addminid" class="form-control">
                             <div class="form-group">
                                <label>اسم المدير </label>
                                <input type="text" name="name" id="addminname" value="" class="form-control" required="">

<!--
                            <small id="emailHelp" class="form-text">
                                من فضلك املئ حقل الادخال هذا
                            </small>
-->
                            </div>
                            <div class="form-group">
                                <label>البريد الالكتروني </label>
                                <input type="email" name="email" value="" id="addminemail" class="form-control" required="">
<!--
                            <small id="emailHelp" class="form-text">
                                من فضلك املئ حقل الادخال هذا
                            </small>
-->
                            </div>
                            <div class="form-group">
                                <label>رقم سري جديد </label>
                                <input type="password" name="password" value="" id="addminpass" autocomplete="off"   class="form-control" >
<!--
                            <small id="emailHelp" class="form-text">
                                من فضلك املئ حقل الادخال هذا
                            </small>
-->
                            </div>
<!--
                            <label class="d-block"> الاقسام </label>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="proj" name="example1">
                                <label class="custom-control-label" for="proj"> قسم المشاريع </label>
                            </div>
                             <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="mess" name="example1">
                                <label class="custom-control-label" for="mess"> قسم الرسائل </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="studiesD" name="example1">
                                <label class="custom-control-label" for="studiesD"> قسم الدراسات </label>
                            </div>
                             <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="notifD" name="example1">
                                <label class="custom-control-label" for="notifD"> قسم الاشعارات </label>
                            </div>-->
                            <label class="d-block"> الصلاحية </label>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="viewEd" name="view" value="1">
                                <label class="custom-control-label" for="viewEd"> عرض </label>
                            </div>
                             <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="editEd" name="edit" value="1">
                                <label class="custom-control-label" for="editEd"> تعديل </label>
                            </div>
                            
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="addEd" name="add" value="1">
                                <label class="custom-control-label" for="addEd"> اضافة </label>
                            </div>
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" id="deleteEd" name="delete" value="1">
                                <label class="custom-control-label" for="deleteEd"> حذف </label>
                            </div>

                            
                            <div class="control-model d-flex flex-row justify-content-between">
                                <button type="submit" class="custom-btn mt-3">تعديل</button>
                                <button type="button" class="custom-btn mt-3" data-dismiss="modal">إلغاء</button>
                            </div> <!-- end control-model -->
                            
                        </form>
                    </div> <!-- end modal-body -->
                </div> <!-- end modal-content -->
            </div> <!-- end modal-dialog -->
        </div> <!-- end modal -->
@endsection
