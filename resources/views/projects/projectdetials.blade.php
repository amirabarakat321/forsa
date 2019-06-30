@extends('layouts.app')
@section('content')
<div class="inner_panal">
    @if(isset($photos))
        <div class="sliderProfile">
            <div class="slider">
                @foreach($photos as $photo)
                    <div class="item" style="background-image: url({{$photo->photo}})">
                    </div>
                @endforeach

            </div><!-- end slider -->
            <div class="sliderControl">
                <div class="arrow next">
                    <i class="fas fa-chevron-right"></i>
                </div> <!-- end arrow -->
                <div class="arrow prev">
                    <i class="fas fa-chevron-left"></i>
                </div> <!-- end arrow -->
            </div> <!-- end sliderControl -->
        </div> <!-- end sliderProfile -->
    @endif
	<section class="profileView projects  w-100 h-100">
	    
	    <div class="d-lg-flex justify-content-between">
	        <div class="order-2 my-5 text-center  text-lg-left">
	            <div class="userInfo text-center">
	                <h3>{{$projects->address}}</h3>
	                <a href="{{ route('profile',$projects->userid)}}">{{$projects->username}}</a>
	                <h4 class="mt-4">({{$projects->typename}})</h4>
	            </div> <!-- end userInfo -->
	        </div>
	        <div class="order-1 my-5 text-center  text-lg-left">
	            <ul class="rating" data-toggle="tooltip" title="{{$totalrate}}" data-placement="bottom">
	                <li>
                        <i class="{{$stars[0]}}"></i>
                    </li>
                    <li>
                        <i class="{{$stars[1]}}"></i>
                    </li>
                    <li>
                        <i class="{{$stars[2]}}"></i>
                    </li>
                    <li>
                        <i class="{{$stars[3]}}"></i>
                    </li>
                    <li>
	                    <i class="{{$stars[4]}}"></i>
	                </li>
	            </ul> <!-- end rating -->
	            <div class="insession">
	                <h3>السعر</h3>
	                <span>{{$projects->price}}</span>
	            </div> <!-- end insession -->
	        </div>
	        <div class="order-3 my-5 text-center  text-lg-left">
	            <ul class="profileAction">
	                <!-- if the project is still active please add class active here else please add class inactive -->
	                <li class={{$projects->sta}}>
	                    <a href="#"  data-toggle="tooltip" title={{$projects->stat}} data-placement="bottom">
	                        <i class="fas fa-circle"></i>
	                    </a>
	                </li>
	                <li>
	                    <a href="#"  data-toggle="tooltip" title="{{$projects->address}}" data-placement="bottom">
	                        <i class="fas fa-map-marker-alt"></i>
	                    </a>
	                </li>
	                <li class="deletedetailam">
	                    <a href="{{url('http://127.0.0.1:8000/project/delete/'.$projects->id)}}"  data-toggle="tooltip" title="حذف" data-placement="bottom">
	                        <i class="fas fa-trash"></i>
	                    </a>
	                </li>
	            </ul> <!-- end profileAction -->
	            <div class="text-center profileAction_a mainColor">
	                <h3>بيع مشروع</h3>
	            </div> <!-- end profileAction_a -->
	        </div>
	    </div> <!-- end d-flex -->
	    <div class="my-5 about text-center">
	       <h3 class="mb-4">نبذة عن المشروع</h3> 
	        <p class="mainColor">{{$projects->description}}</p>
	    </div> <!-- end about -->
	</section> <!-- end profileView -->

</div> <!-- end inner_panal -->

@endsection
