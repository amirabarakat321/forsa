<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Api\NotificationApiReturn;
use App\Study;
use App\Project;
use App\Http\Resources\Study as StudyResource ;
use App\Http\Resources\ProjectCollection;
use App\Http\Controllers\SupervisorPrivilege;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Mail\SendMailable;
use Illuminate\Support\Facades\Mail;

class massageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin'])->except(['delete','deletemessage','view']);
        $this->middleware('delete', ['only' => [
            'delete','deletemessage',
        ]]);

        $this->middleware('reader', ['only' => [
            'view',

        ]]);
    }
    public function retriveview($messages){
        $output = '';
        $x = 1;
        foreach ($messages as $study) {

            $study->messagefrom = DB::table('users')->select('name')->where('id', $study->user_id)->first()->name;

            if ($study->status == 1) {
                $class = "btn btn-sm btn-toggle active";
                $aria = "true";
            } else {
                $class = "btn btn-sm btn-toggle";
                $aria = "false";
            }

            $output .= '<tr>
                        <td>'.$x.'</td>
                        <td>'. $study->messagefrom.'   </td>
                        <td>'. $study->phone.'   </td>
                        <td>'. $study->email.'   </td>
                        <td>
                            <!-- To open the button please add class active here -->
                            <button type="button" class="'.$class.'" href="'.url("inbox/".$study->id."/status").'"  aria-pressed="'.$aria.'" autocomplete="off">
                                <div class="handle"></div>
                            </button>
                        </td>
                        <td>
                            <a  data-toggle="tooltip" title="عرض" data-placement="bottom" href="'.route("messageview",$study->id).'">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a  data-toggle="tooltip" class="deleteam" title="حذف" data-placement="bottom"  
                                 href="'.url("inbox/".$study->id."/destroy").'"   class="delete">
                                <i class="fas fa-trash"></i>
                            </a>
                            
                        </td>
                        <td>  <span data-toggle="modal" data-target="#mail">
                                <a  data-toggle="tooltip" title="رد "  class="sendMail" data-content="'.$study->email.'-'.$study->messagefrom.'" data-placement="bottom" href="{{route(\'edittype\')}}">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </span></td>
                    </tr>';

            $x++;
        }
        $siteMap = ['الرئيسية', 'الرسائل '];
        return view('massage.massages', ['siteMap' => $siteMap, 'messages' => $messages, 'output' => $output]);
    }
    /// unread messages
    public function index(){
       $messages = DB::table('messages')->where('status',0)->orderBy('id', 'des')->paginate(30);
        return( $this->retriveview($messages));
    }
    //read messages
    public function readmessage(){
        $messages = DB::table('messages')->where('status',1)->orderBy('id', 'des')->paginate(30);
        return( $this->retriveview($messages));
    }
    public function editstatus($id){
        $message =DB::table('messages')->where('id',$id)->first();
        if($message->status == 0){
            $upd= DB::table('messages')->where('id',$id)
                ->update(['status' =>1]);
        }elseif($message->status == 1){
            $upd=DB::table('messages')->where('id',$id)
                ->update(['status' =>0]);
        }

        if($upd){
            return Response(['success'=>"true"]);
        }else{
            return Response(['success'=>"false"]);
        }
    }
    public function view($id){
       $message= DB::table('messages')->find($id);
        $message->messagefrom = DB::table('users')->select('name')->where('id', $message->user_id)->first()->name;
        return view('massage.massagedetails')->with('message',$message);
    }
    public function delete($id){
        $del = DB::table('messages')->where('id', $id)->delete();
        if ($del) {
            return Response(['success' => true]);
        }
        return Response(['success' => false]);
    }
    public function deletemessage($id){
        $sta= DB::table('messages')->select('status')->where('id', $id)->first()->status;
        $del = DB::table('messages')->where('id', $id)->delete();
          if($sta == 0){
              return $this->index();
          }else{
              return $this->readmessage();

          }

}

    public function mail(Request $request)
    {
        $name = $request->name;
        $msg=   $request->msg;
        Mail::to($request->email)->send(new SendMailable($name,$msg));

        return redirect()->back();
    }
}
