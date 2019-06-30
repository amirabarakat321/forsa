<?php

namespace App\Http\Controllers\Api;

use App\Chat;
use App\Consultation;
use App\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    use ApiReturn;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $conversation = Conversation::where(['chat_id' => \request()->input('chat_id')])
            ->orderBy('id','desc')
            ->limit(30)
            ->get();

        foreach ($conversation as $co){
            $co->message = json_decode($co->message);
        }

        return $this->apiResponse($conversation, '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chat = Chat::where('id', $request->input('chat_id'))->first();

        if($chat->type == 'consultation'){
            $service = Consultation::find($chat->service_id);
        }

        $conversation = new Conversation();
        $conversation->chat_id = $request->input('chat_id');

        if($request->has('attachment')){
            $path = Storage::putFile('chat_attachment', $request->file('attachment'));

            $url = "https://".$request->getHost()."/forsaTanya/storage/app/".$path;

            $conversation->message = json_encode(['message' => $request->input('message') , 'file' => $url], JSON_UNESCAPED_SLASHES);
            $conversation->attachment_type = $request->file('attachment')->getMimeType();
        }else{
            $conversation->message = json_encode(['message' => $request->input('message')], JSON_UNESCAPED_SLASHES);
        }

        $conversation->msg_from = $request->input('user_id');
        $conversation->msg_to = $service->user_id == $request->input('user_id') ? $service->provider_id : $service->user_id;
        $conversation->chat_type = $request->input('chat_type');
        $conversation->save();

        $conv = Conversation::find($conversation->id);

        $conv->message = json_decode($conversation->message );

        return $this->apiResponse($conv, 'تم الإرسال', 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $check = Chat::join('times', 'times.id', '=', 'chats.time_id')
            ->select('chats.id','chats.time_id','chats.status','chats.chat_date','theTime')
            ->where(['type' => \request()->input('service_type'), 'service_id' => \request()->input('service_id')]);

        if($check->count() > 0){
            $chat = $check->first();

            return $this->apiResponse($chat, '', 200);
        }

        return $this->apiResponse(null, '', 400);
    }

}
