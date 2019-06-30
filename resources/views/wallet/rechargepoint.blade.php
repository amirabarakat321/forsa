@extends('layouts.app')
@section('content')

        <div class="inner_panal">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
                @if(count($errors))
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="color: red">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            اسم المستخدم
                        </th>
                        <th>
                            كود العمليه
                        </th>
                        <th>
                           طريقه الدفع
                        </th>
                        <th>
                            الصورة
                        </th>
                        <th>
                            المبلغ المحول
                        </th>

                        <th>
                            الإجراءات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        @foreach($transactions as $tran)
                        <td>{{$tran->username}}</td>
                        <td>
                            {{$tran->operation_code}}
                        </td>
                        <td> {{$tran->pay_type}} </td>
                        <td>
                            <div class="userWorks">

                                <img src="{{$tran->photo}}"   height="42" width="42"   data-toggle="modal" data-target="#img">
                            </div>


                        </td>
                        <td>{{$tran->amount}}</td>
                        <td>
                            <span data-toggle="modal"  data-target="">
                                <a href="javascript:void(0);" data-toggle="tooltip" title="" data-placement="bottom">
                                    <i class="{{$tran->color}}"></i>
                                </a>
                            </span>
                            <span data-toggle="modal" data-target="{{$tran->change}}">
                                <a  data-toggle="tooltip" title="{{$tran->title}}" class="rechargebalance"  data-content="{{$tran->amount}}-{{$tran->id}}"  data-placement="bottom" href="javascript:void(0);"  >
                                    <i class="fas fa-redo"></i>
                                </a>
                            </span>
                        </td>
                    </tr>

                    @endforeach
                    </tbody>
                </table>
                {{$transactions->links()}}
            </div> <!-- end table-responsive -->
        </div> <!-- end inner_panal -->


    <!-- Sign out-->
    <!-- The Modal -->

    <div class="modal fade" id="sendMoney">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" action="{{route('balancerecharge')}}"  class="editSpec">
                      @csrf
                        <div class="form-group">
                            <label> عدد النقاط</label>
                            <input value="" name="id" type="hidden" id="add_balance_id">
                            <input type="text" name="amount" disabled value="" id="balance_amount" class="form-control" required="" placeholder="">

                        </div>
                        <div class="control-model d-flex flex-row justify-content-around">
                            <button type="submit" class="custom-btn mt-2">إرسال</button>
                            <button type="button" class="custom-btn mt-2" data-dismiss="modal">الغأء</button>
                        </div> <!-- end control-model -->
                    </form>

                </div> <!-- end modal-body -->
            </div> <!-- end modal-content -->
        </div> <!-- end modal-dialog -->
    </div> <!-- end modal -->

        <div class="modal fade" id="img" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered  modal-lg">
                <div class="modal-content">
                    <div class="mt-5">
                        <img src="" alt="image" class="mx-auto">
                    </div>
                    <div class="modal-body">
                        <button type="button" class="custom-btn d-block m-auto" data-dismiss="modal">إلغاء</button>
                    </div>
                </div> <!-- end modal-content -->
            </div> <!-- end modal-dialog -->
        </div>


@endsection
