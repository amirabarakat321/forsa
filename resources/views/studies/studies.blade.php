@extends('layouts.app')
@section('search')
    <form  action="{{ route('searchstudy')}}"  method="post" class="search__nav clearfix">
        {{ csrf_field() }}
        <button class="search-btn" type="submit">
            <img src="{{ asset('images/icons/search_nav.svg') }}" alt="icon">
        </button> <!-- end search-btn -->
        <div class="form-group">
            <input class="form-control" name="saerchtesxt" type="search" placeholder="ابحث بالمحتوي هنا" >
            <div class="filterWidget">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <h3 class="titleFilter">مقدم الخدمه </h3>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" value="expert" name="expert">
                            <label class="custom-control-label" for="customCheck1">خبير </label>
                        </div>
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck2" value="amateur" name="amateur">
                            <label class="custom-control-label" for="customCheck2">مجرب</label>
                        </div>
                        
                    </div> <!-- end col -->
                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <h3 class="titleFilter">نوع الدراسه </h3>
                        @foreach($types as $cat)
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="{{$cat->id}}" value="{{$cat->id}}"name="{{$cat->type_title}}">
                            <label class="custom-control-label" for="{{$cat->id}}">{{$cat->type_title}}</label>
                        </div>
                       @endforeach
                    </div> <!-- end col -->

                    
                </div> <!-- end row -->
            </div> <!-- end filterWidget -->
        </div> <!-- end form-group -->
        <div class="icon">
            <i class="fas fa-sliders-h"></i>
        </div>
    </form> <!-- end search__nav -->
@endsection
@section('content')
    <section class="studies">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>
                        الرقم
                    </th>
                    <th>
                        نوع الدراسة
                    </th>
                    <th>
                        نوع المشروع
                    </th>

                    <th>
                        السعر
                    </th>
                    <th>
                        التاريخ
                    </th>
                    <th>
                        التقييم
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

                {!! $output !!}
                </tbody>
            </table>
            {!! $studies->links() !!}
        </div> <!-- end table-responsive -->
    </section> <!-- end userExpert -->
@endsection
