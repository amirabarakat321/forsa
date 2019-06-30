@extends('layouts.app')
@section('search')
    <form class="search__nav clearfix" method="post" action="{{route('usersearch')}}">
        @csrf
        <button class="search-btn" type="submit">
            <img src="{{ asset('images/icons/search_nav.svg') }}" alt="icon">
        </button> <!-- end search-btn -->
        <div class="form-group">
            <input class="form-control" name="name" type="search" placeholder="ابحث بالاسم هنا ...." >
            <input name="type" type="hidden" value="expert" >
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
    <section class="userNormal">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        الإسم
                    </th>
                    <th>
                        البريد الإلكتروني
                    </th>
                    <th>
                        رقم الجوال
                    </th>
                    <th>
                        التقيم/5
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
                {!! $clients !!}
                </tbody>
            </table>
            {!! $links !!}
        </div> <!-- end table-responsive -->
    </section> <!-- end userNormal -->
@endsection
