<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\NotificationApiReturn;
use App\User;
use Illuminate\Http\Request;
use DB;


class notificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin'])->except(['delete','view','save']);
        $this->middleware('delete', ['only' => [
            'delete',
        ]]);

        $this->middleware('reader', ['only' => [
            'view',
        ]]);
        $this->middleware('writer', ['only' => [
            'save',

        ]]);
    }
    use NotificationApiReturn;

    public function index(){
       $notifications = DB::table('notification')->orderBy('id', 'des')->paginate(3);
        $output = '';
        $x = 1;
        foreach ($notifications as $study) {
            $type= json_decode($study->user_type ,true);
            $output .= '<tr>
                        <td>'.$x.'</td>
                        <td>'. $study->title.'   </td>
                        
                        <td>';

                  for ( $i=1; $i<sizeof($type);$i++) {
                      $output .= $type[$i].' - ';
                      }
                  $output .=$type[0].'
                     </td>
                        <td>
                         
                            
                                 <a  data-toggle="modal" data-target="#viewNotif"  title="عرض" class="notifiView" data-content="'.$study->text.'" data-placement="bottom" href="javascript:void(0);">
                                    <i class="fas fa-eye"></i>
                                 </a>
                      
                            <a  data-toggle="tooltip" class="deleteam" title="حذف"  
                                 href="'.url("notifications/".$study->id."/delete").'" >
                                <i class="fas fa-trash"></i>
                            </a>
                            
                        </td>
                       
                    </tr>';
            $x++;
        }
        $siteMap = ['الرئيسية', 'الاشعارات '];
        return view('notification.notifications', ['siteMap' => $siteMap, 'output' => $output ,'notifications'=>$notifications]);
    }

    public function save(Request $request){
        $data =$request->all();
        $var = array();
        $tokens = [];

        if(array_key_exists("client",$data)){
              $var[]="client";
              $clients = User::where('type' , 'client')->get();

              foreach ($clients as $client){
                  $Tokens = json_decode($client->tokens);
                   if($Tokens){
                       for ($x = 0; $x < count($Tokens->devices); $x++) {
                           array_push($tokens, $Tokens->devices[$x]->token);
                       }
                   }

              }

        }

        if(array_key_exists("amateur",$data)){
            $var[]="amateur";
            $amateurs = User::where('type' , 'amateur')->get();
            foreach ($amateurs as $amateur){
                $Tokens = json_decode($amateur->tokens);
                   if($Tokens) {
                       for ($x = 0; $x < count($Tokens->devices); $x++) {
                           array_push($tokens, $Tokens->devices[$x]->token);
                       }
                   }
            }
        }
        if(array_key_exists("expert",$data)){
            $var[]="expert";

            $experts = User::where('type' , 'expert')->get();
            foreach ($experts as $expert){
                $Tokens = json_decode($expert->tokens);
                 if($Tokens) {
                     for ($x = 0; $x < count($Tokens->devices); $x++) {
                         array_push($tokens, $Tokens->devices[$x]->token);
                     }
                 }

            }
        }
        $varr=json_encode($var);

        DB::table('notification')->insert([
            [ 'title'     =>$request['title'] ,
              'text'      =>$request['text'] ,
              'user_type' =>$varr ,
                ],
        ]);


        $this->notificationApiResponse($request['title'], $request['text'], $tokens);

        return redirect('notifications');
    }

    public function view($id){
        $message= DB::table('messages')->find($id);
        $message->messagefrom = DB::table('users')->select('name')->where('id', $message->user_id)->first()->name;
        return view('massage.massagedetails')->with('message',$message);
    }
    public function show(){
    //
     }

    public function delete($id){
        $del = DB::table('notification')->where('id', $id)->delete();
        if ($del) {
            return Response(['success' => true]);
        }
        return Response(['success' => false]);
    }



}
