<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SupervisorPrivilege;

use App\Ticketchat;
use App\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\AccessToken;
use DB;

class TicketsController extends Controller
{
    use SupervisorPrivilege;
    public function __construct()
    {
        $this->middleware(['admin'])->except(['delete','showchat']);
        $this->middleware('delete', ['only' => [
            'delete',

        ]]);
        $this->middleware('reader', ['only' => [
            'showchat',
        ]]);
    }
    use SupervisorPrivilege;
    public function index()
    {
        $tickets = DB::table('tickets')
            ->leftJoin('users', 'users.id', '=', 'tickets.user_id')
            ->select('tickets.*', 'users.name as username', 'users.email as useremail', 'users.phone as userphone')
            ->orderBy('tickets.id', 'desc')->paginate(30);


        $results = '';
        $x=0;
        foreach ($tickets as $ticket){
            $x++;
            $results .= '<tr >
                    <td>'.$x.'</td>
                    <td>'.$ticket->username.'</td>
                    <td>'.$ticket->useremail.'</td>
                    <td>'.$ticket->userphone.'</td>
                    <td>'.$ticket->title.'</td>
                    <td>'.$ticket->message.'</td>
                    <td>';
            ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR{
            if($this->viewCheck()){
                $results .=    ' <a href="'.url("ticketchat/".$ticket->id).'" data-toggle="tooltip" title=""
                                    data-placement="bottom" data-original-title="المحادثات">
                                            <i class="fas fa-comments"></i>
                                        </a>';}

            if($this->deleteCheck()){
                $results .=  ' <a  data-toggle="tooltip" class="deleteam" title="حذف" data-placement="bottom"  
                                 href="'.url("ticket/".$ticket->id."/delete").'">
                                <i class="fas fa-trash"></i>
                            </a>';}
                $results.='</td>
                </tr>';

        }

        $siteMap = ['الرئيسية', 'التذاكر'];

        return view('tickets.tickets', ['siteMap' => $siteMap,'links' => $tickets, 'results' => $results]);
    }


    public function delete($id)
    {
        $del=  DB::table('tickets')->where('id', $id)->delete();

        if($del){
            return Response(['success'=>true]);
        }else{
            return Response(['success'=>false]);
        }
    }

    public function showchat($id)
    {

        return view('tickets.ticketchat', ['id' => $id]);

    }


    function load_dataticket(Request $request)
    {

        if($request->ajax())
        {
            if($request->id > 0)
            {
                $data = Ticketchat::where('ticket_id', (int)$request->chatid)
                    ->where('id', '<', $request->id)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();

            }
            else
            {
                $data = Ticketchat::where('ticket_id', (int)$request->chatid)
                    ->orderBy('id', 'DESC')
                    ->limit(5)
                    ->get();
            }
            $output = '';
            $last_id = '';

            if(!$data->isEmpty())
            {
                foreach($data as $con)
                {

                    if ($con->message_from == 0) {
                        $user =  DB::table('users')->where('type', 'admin')->first();
                        $liclass = "clearfix userChat1";
                        $divclass = "message-data  text-right";
                        $messclass = "message other-message float-right";
                    }else {
                        $user = DB::table('users')->where('id', $con->message_from)->first();
                        $liclass = "clearfix userChat2";
                        $divclass = " message-data align-right";
                        $messclass = "message my-message float-left";
                    }


                    if ($con->reply != null && $con->attachment == null ) {
                        $output .= ' <li class="' . $liclass . '">
                                    <div class="' . $divclass . '">
                                  <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                   <span class="message-data-name">
                                    <img src="' . $user->avatar . '" alt="username" draggable="false">
                                  </span>
                                  </div>
                                  <div class="' . $messclass . '">
                                   ' . $con->reply . '

                               </div>
                              </li>
                      ';
                    }
                    if ($con->reply != null && $con->attachment != null ) {


                        // file
                        $output .= '<li class="' . $liclass . '">
                                         <div class="' . $divclass . '">
                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                           <span class="message-data-name">
                                            <img src="' . $user->avatar . '" alt="username" draggable="false">
                                           </span>
                                          </div>
                                          <div class="' . $messclass . '">
                                            ' . $con->reply . '
                                            
                                            <a href="' . route("chatdownload", ['id' => $con->id]) . '">اسم الملف .pdf
                                            <i class="fas fa-cloud-download-alt mx-3"></i>
                                            </a>
                                          </div>
                                         </li>
                                         ';
                    }
                    if ($con->reply == null && $con->attachment != null ) {
                        // file
                        $output .= '<li class="' . $liclass . '">
                                         <div class="' . $divclass . '">
                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                           <span class="message-data-name">
                                            <img src="' . $user->avatar . '" alt="username" draggable="false">
                                           </span>
                                          </div>
                                          <div class="' . $messclass . '">
                                            <a href="' . route("chatdownload", ['id' => $con->id]) . '">اسم الملف .pdf
                                            <i class="fas fa-cloud-download-alt mx-3"></i>
                                            </a>
                                          </div>
                                         </li>
                                         ';
                    }

                    $last_id = $con->id;
                }
                $output .= '
                <div id="load_more">
                <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                </div>
                   ';
            } else
            {
                $output .= '
                   <div id="load_more">
                      <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
                       </div>
                          ';
            }
            echo $output;
        }
    }



}
