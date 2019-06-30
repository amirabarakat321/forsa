@extends('layouts.app')
@section('search')
   

  <div class="inner_panal">

    <section class="consultation-filter">
        <div class="row">
            @if(count($errors))
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="col-lg-6 col-md-10 offset-lg-3 offset-md-1">
                <form action="{{route('filter')}}" method="post">
                   {{ csrf_field() }}
                    <div class="row">
                        {{--<div class="col-md-6">--}}
                            {{--<div class="form-group">--}}
                                 {{--<label>حدد فترة </label>--}}
                                {{--<select name="month" class="form-control">--}}
                                    {{--<option value="0">اختر المدة</option>--}}
                                    {{--<option value="1">--}}
                                           {{--آخر شهر--}}
                                    {{--</option>--}}
                                    {{--<option value="3">آخر 3 شهور</option>--}}
                                    {{--<option value="6">آخر 6 شهور</option>--}}
                                    {{--<option value="9">آخر 9 شهور</option>--}}
                                {{--</select> <!-- end form-control -->--}}
                            {{--</div> <!-- end form-group-->--}}
                        {{--</div> <!-- end col -->--}}
                        {{--<div class="col-md-6">--}}
                            <div class="form-group">
                                <label>حدد يوم</label>
                                <input name="day" type="date" class="form-control" />
                            </div> <!-- end form-group-->
                        {{--</div> <!-- end col -->--}}
                    </div>
                        <div  class="row">
                         <button type="submit" class="custom-btn">بحث</button>
                        </div>
                </form>
        
                <div class="timeFilter text-center">
                      
                @if(!empty($times) )
                  
                     @foreach($times as $time )
                    <div class="{{$time->clase}}">
                        <a href="{{route('consview',[ 'id'=>$time->id ,'date'=>$date])}}"></a>
                        <p class="yellow" data-toggle="tooltip" data-placement="bottom"
                           data-original-title="عدد الاستشارات ">{{$time->totalreserved}}</p>
                        <p class="red" data-toggle="tooltip" data-placement="bottom"
                           data-original-title="عدد الاستشارات ">{{$time->totalreserve}}</p>
                        <span>{{$time->theTime}}</span>
                    </div> <!-- end widget -->
                    @endforeach
                 
                @endif
                   
                </div> <!-- end timeFilter -->

            </div> <!-- end Col -->
        </div> <!-- end row -->
    </section> <!-- end consultation-filter -->
                    
  </div> <!-- end inner_panal -->

@endsection
