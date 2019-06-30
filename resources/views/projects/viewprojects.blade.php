@extends('layouts.app')
@section('search')
    <form  action="{{route('searchproject')}}"  method="post" class="search__nav clearfix">
        {{ csrf_field() }}
        <button class="search-btn" type="submit">
            <img src="{{ asset('images/icons/search_nav.svg') }}" alt="icon">
        </button> <!-- end search-btn -->
        <div class="form-group">
            <input class="form-control" name="saerchtesxt" type="search" placeholder="ابحث بالمحتوي هنا" >
            <div class="filterWidget">
                <div class="row">

                    <div class="col-xl-3 col-lg-6 col-md-12">
                        <h3 class="titleFilter">نوع المشروع </h3>
                        @foreach($projecttypes as $cat)
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
        <section class="Projects">
              @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
             @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                الرقم
                            </th>
                            <th>
                                اسم المشروع
                            </th>
                            <th>
                                القسم
                            </th>
                            <th>
                                نوع الخدمة
                            </th>
                            <th>
                                الموقع
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
                {!! $projects->links() !!}
            </div> <!-- end table-responsive -->
        </section> <!-- end Projects -->
@endsection
