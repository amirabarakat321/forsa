@extends('layouts.app')
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


    <div class="chat-history">
                        <ul>
                            @csrf
                            <input name="_method" type="hidden" value="post">
                             <input type="hidden" id="chatid" value="{{$id}}">
                            <div id="post_data"></div>
                           
                        </ul>
                      </div>
                    
<script>
$(document).ready(function(){

 var _token = $('input[name="_token"]').val();
 var chatid=document.getElementById("chatid").value;
    load_data_ticket('', _token,chatid);

 function load_data_ticket(id="", _token,chatid)
 {
  $.ajax({
   url:"{{ route('ticketloadmore') }}",
   method:"POST",
   data:{id:id, _token:_token, chatid:chatid},
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

  $('#load_more_button').html('<b>Loading...</b>');
  load_data_ticket(id, _token, chatid);
 });

});
</script>
@endsection
