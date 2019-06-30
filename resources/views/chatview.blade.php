@extends('layouts.app')
@section('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



    <div class="chat active">
        <div class="panel-body">

                <input id="chatid" name="chatid" value="{{$id}}" type="hidden">
                <input id="chattype" name="chattype" value="{{$type}}" type="hidden">




        </div>
    <div class="chat-history">
        <div id="post_data"></div>

    </div>
    </div>

<script>
$(document).ready(function(){

 var _token = $('input[name="_token"]').val();
 var chatid=document.getElementById("chatid").value;
 var chattype=document.getElementById("chattype").value;
 load_data(0, _token,chatid,chattype,'post');

 function load_data(id='', _token,chatid,chattype)
 {
  $.ajax({
   url:"{{ route('loadmore') }}",
   method:"POST",
   data:{id:id, _token:_token, chatid:chatid, chattype:chattype},

   success:function(data)
   {
    $('#load_more_button').remove();
    $('#post_data').append(data);
   }
  })
 }

 $(document).on('click', '#load_more_button', function(){
  var id = $(this).data('id');
  var chatid=document.getElementById("chatid").value;
  var chattype=document.getElementById("chattype").value;

  $('#load_more_button').html('<b>Loading...</b>');
  load_data(id, _token, chatid, chattype);
 });

});
</script>
@endsection
