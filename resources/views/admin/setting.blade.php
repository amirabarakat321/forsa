@extends('layouts.app')
@section('content')

    @if(count($errors))
        <ul>
            @foreach($errors->all() as $error)
                <li style="color: red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
        <div class="inner_panal">
            <section class="payment mt-4">
                <form action="{{route('editsetting')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col text-center">
                            <div class="form-group">
                                <label>نسبة الموقع</label>
                                <input class="form-control" name="rate" type="number" placeholder="مثال : {{$rate}}%">
                            </div> <!-- end form-group -->
                        </div> <!-- end col -->

                        <div class="col-12 text-center">
                            <h4>رصيد  الموقع الكلي:
                               {{$total}}
                                ريال
                            </h4>
                        </div> <!-- end Col -->
                        <div class="col text-center">
                            <button type="submit" class="custom-btn">حفظ</button>
                        </div> <!-- end Col -->
                    </div> <!-- end row -->
                </form>
            </section> <!-- end payment -->
        </div> <!-- end inner_panal -->

@endsection
