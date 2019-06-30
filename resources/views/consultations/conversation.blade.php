@extends('layouts.app')
@section('content')
    <div class="inner_panal">
        <div class="chat-history">
            <ul>
                <li class="clearfix userChat1">
                    <div class="message-data align-right">
                        <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                        <span class="message-data-name">
                            <img src="images/users/user.png" alt="username" draggable="false">
                        </span>
                    </div>
                    <div class="message other-message float-right">
                        مرحباً بهاء ، كيف حالك؟ كيف يتم تنفيذ المشروع؟
                    </div>
                </li>

                <li class="clearfix userChat2">
                    <div class="message-data  text-right">
                        <span class="message-data-name">
                            <img src="images/users/user1.png" alt="username" draggable="false">
                        </span>
                        <!-- <span class="message-data-time">10:12 AM, Today</span> -->
                    </div>
                    <div class="message my-message float-left">
                        هل نلتقي اليوم؟ تم الانتهاء بالفعل من المشروع ولدي نتائج لإظهارها لك.
                    </div>
                </li>
            </ul>

        </div>
    </div> <!-- end inner_panal -->
@endsection
