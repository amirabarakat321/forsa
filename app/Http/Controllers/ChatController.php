<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase;
use App\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Pagination\LengthAwarePaginator;

use Kreait\Firebase\Database;



class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin'])->except(['show']);
        $this->middleware('reader', ['only' => [
            'show',

        ]]);

    }
    public function show($id, $type)
    {
        return view('chatview', ['id' => $id, 'type' => $type]);

    }


   function load_data(Request $request)
    {

  if($request->ajax())
  {
      $fire='consult-'.(int)$request->chatid;
      $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/test-bf688-firebase-adminsdk-k0u0a-452dfbd658.json');

      $firebase = (new Factory)
          ->withServiceAccount($serviceAccount)
          ->withDatabaseUri('https://test-bf688.firebaseio.com/')
          ->create();

      $database = $firebase->getDatabase();

      $newPost = $database
          ->getReference('MyMessages/'.$fire);

      $arr = $newPost->getValue();
            $arry = array();
            foreach ($arr as $ar) {
                $obj = (object)$ar;
                $arry[]=$obj;
            }
      //get id of one of the speakers
         $check=$arry[0];
         $asd=array();
              foreach ($check as $a) {
                  $asd[] = $a;
              }
              $checkid = $asd[1];
              unset($asd);




            $data =array();


      $x=(int)$request->id+1;
                $i=(int)$request->id;
                if ((int)$request->id > 0) {
                    $last_id =(int)$request->id;
                    for($i;$i<=$x ;++$i) {
                        if (array_key_exists($i, $arry)) {
                            $data[] = $arry[$i];
                        }
                    }
                    }else{
                    $last_id =0;
                       for($i=0;$i<=1;++$i) {
                           if (array_key_exists($i, $arry)) {
                               $data[] = $arry[$i];
                           }
                       }
               }

            $output = '';

            if($data!= NULL){


                foreach ($data as $ar) {
                    $asd = array();
                    foreach ($ar as $a) {
                        $asd[] = $a;
                    }
                    ////

                    $user = User::where('id', $asd[1])->first();
                    if ($asd[1] == $checkid) {
                        $liclass = "clearfix userChat1";
                        $divclass = "message-data  text-right";
                        $messclass = "message other-message float-right";

                    } else {
                        $liclass = "clearfix userChat2";
                        $divclass = " message-data align-right";
                        $messclass = "message my-message float-left";
                    }
                    if ($asd[5] == 'text') {

                        $output .= ' <li class="' . $liclass . '">
                                    <div class="' . $divclass . '">
                                  <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                   <span class="message-data-name">
                                    <img src="' . $user->avatar . '" alt="username" draggable="false">
                                  </span>
                                  </div>
                                  <div class="' . $messclass . '">
                                   ' . $asd[0] . '

                               </div>
                              </li>
                      ';
                    }
                    if ($asd[5] == 'image') {
                        // image
                        $output .= '
                                  <li class="' . $liclass . '">
                                    <div class="' . $divclass . '">
                                    <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                     <span class="message-data-name">
                                     <img src="' . $user->avatar . '" alt="username" draggable="false">
                                    
                                     </span>
                                   </div>
                                   <div class="' . $messclass . '">
                                     <img src="' . $asd[0] . '" alt="username" draggable="false">
                                   </div>
                                  </li>
                                   ';
                    }
                    if ($asd[5] == 'pdf') {
                        // file
                        $output .= '<li class="' . $liclass . '">
                                         <div class="' . $divclass . '">
                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                           <span class="message-data-name">
                                            <img src="' . $user->avatar . '" alt="username" draggable="false">
                                           </span>
                                          </div>
                                          <div class="' . $messclass . '">
                                            <a href="' . route("chatdownload", ['id' => $asd[0]]) . '">اسم الملف .pdf
                                            <i class="fas fa-cloud-download-alt mx-3"></i>
                                            </a>
                                          </div>
                                         </li>
                                         ';
                    }
                    if ($asd[5] == 'video') {
                        // vedio
                        $output .= '<li class="' . $liclass . '">
                                        <div class="' . $divclass . '">
                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                          <span class="message-data-name">
                                            <img src="' . $user->avatar . '" alt="username" draggable="false">
                                            
                                          </span>
                                        </div>
                                        <div class="' . $messclass . '">
                                            <video controls>
                                                <source src=".$asd[0]." type="video/mp4">
                                            </video>
                                       </div>
                                      </li>
                                   ';
                    }
                    if ($asd[5] == 'audio') {
                        // audio
                        $output .= '  <li class="' . $liclass . '">
                                                <div class="' . $divclass . '">
                                                  <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
                                                  <span class="message-data-name">
                                                    <img src="' . $user->avatar . '" alt="username" draggable="false">
                                                    
                                                  </span>
                                                </div>
                                                <div class="' . $messclass . '">
                                                   <audio controls>
                                                      <source src=".$asd[0]." type="audio/mp3">
                                                    </audio>
                                                 
                                               </div>
                                              </li> 
                                   ';
                    }
                   ++$last_id;
                    unset($asd);

                }
                $output .= '
                <div id="load_more">
                <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                </div>
                   ';

            } else {
              $output .= '
                   <div id="load_more">
                      <button type="button" name="load_more_button" class="btn btn-info form-control">No Data Found</button>
                       </div>
                          ';}
      unset($data);
      echo $output;

            //....old version on DB not firebase...

            //            $chat = Chat::where(['service_id' => (int)$request->chatid ,'type' => $request->chattype])->first();
//           if($chat) {
//               if ($request->id > 0) {
//                   $data = Conversation::where('chat_id', $chat->id)
//                       ->where('id', '<', $request->id)
//                       ->orderBy('id', 'DESC')
//                       ->limit(5)
//                       ->get();
//               } else {
//                   $data = Conversation::where('chat_id', $chat->id)
//                       ->orderBy('id', 'DESC')
//                       ->limit(5)
//                       ->get();
//               }
//           }
//
//            if($data!= NULL)
//            {
//
//                foreach($data as $con)
//                {
//                    $con->message = json_decode($con->message, true);
//                    $user = User::where('id', $con->msg_from)->first();
//                    $con->avatar = $user->avatar;
//                    if ($con->msg_from == Auth::user()->id) {
//                        $liclass = "clearfix userChat1";
//                        $divclass = "message-data  text-right";
//                        $messclass = "message other-message float-right";
//
//                    } else {
//                        $liclass = "clearfix userChat2";
//                        $divclass = " message-data align-right";
//                        $messclass = "message my-message float-left";
//                    }
//                    if ($con->message['message'] != null && !array_key_exists('file', $con->message)) {
//
//                        $output .= ' <li class="' . $liclass . '">
//                                    <div class="' . $divclass . '">
//                                  <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                   <span class="message-data-name">
//                                    <img src="' . $con->avatar . '" alt="username" draggable="false">
//                                  </span>
//                                  </div>
//                                  <div class="' . $messclass . '">
//                                   ' . $con->message['message'] . '
//
//                               </div>
//                              </li>
//                      ';
//                    }
//                    if ($con->message['message'] == null && array_key_exists('file', $con->message)) {
//                        if ($con->chat_type == 2) {
//                            // image
//                            $output .= '
//                                  <li class="' . $liclass . '">
//                                    <div class="' . $divclass . '">
//                                    <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                     <span class="message-data-name">
//                                     <img src="' . $con->avatar . '" alt="username" draggable="false">
//
//                                     </span>
//                                   </div>
//                                   <div class="' . $messclass . '">
//                                     <img src="' . $con->message['file'] . '" alt="username" draggable="false">
//                                   </div>
//                                  </li>
//                                   ';
//                        }
//                        if ($con->chat_type == 3) {
//                            // file
//                            $output .= '<li class="' . $liclass . '">
//                                         <div class="' . $divclass . '">
//                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                           <span class="message-data-name">
//                                            <img src="' . $con->avatar . '" alt="username" draggable="false">
//                                           </span>
//                                          </div>
//                                          <div class="' . $messclass . '">
//                                            <a href="' . route("chatdownload", ['id' => $con->id]) . '">اسم الملف .pdf
//                                            <i class="fas fa-cloud-download-alt mx-3"></i>
//                                            </a>
//                                          </div>
//                                         </li>
//                                         ';
//                        }
//                        if ($con->chat_type == 4) {
//                            // vedio
//                            $output .= '<li class="' . $liclass . '">
//                                        <div class="' . $divclass . '">
//                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                          <span class="message-data-name">
//                                            <img src="' . $con->avatar . '" alt="username" draggable="false">
//
//                                          </span>
//                                        </div>
//                                        <div class="' . $messclass . '">
//                                            <video controls>
//                                                <source src="' . \Request::root() . '/images/video/1.mp4" type="video/mp4">
//                                            </video>
//                                       </div>
//                                      </li>
//                                   ';
//                        }
//                        if ($con->chat_type == 5) {
//                            // audio
//                            $output .= '  <li class="' . $liclass . '">
//                                                <div class="' . $divclass . '">
//                                                  <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                                  <span class="message-data-name">
//                                                    <img src="' . $con->avatar . '" alt="username" draggable="false">
//
//                                                  </span>
//                                                </div>
//                                                <div class="' . $messclass . '">
//                                                   <audio controls>
//                                                      <source src="' . \Request::root() . '/images/audio/1.mp3" type="audio/mp3">
//                                                    </audio>
//
//                                               </div>
//                                              </li>
//                                   ';
//                        }
//
//                    }
//                    if ($con->message['message'] != null && array_key_exists('file', $con->message)) {
//
//                        if ($con->chat_type == 2) {
//                            // image
//                            $output .= '
//                                  <li class="' . $liclass . '">
//                                    <div class="' . $divclass . '">
//                                    <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                     <span class="message-data-name">
//                                     <img src="' . $con->avatar . '" alt="username" draggable="false">
//
//                                     </span>
//                                   </div>
//                                   <div class="' . $messclass . '">
//                                   ' . $con->message['message'] . '
//                                     <img src="' . $con->message['file'] . '" alt="username" draggable="false">
//                                   </div>
//                                  </li>
//                                   ';
//                        }
//                        if ($con->chat_type == 3) {
//                            // file
//                            $output .= '<li class="' . $liclass . '">
//                                         <div class="' . $divclass . '">
//                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                           <span class="message-data-name">
//                                            <img src="' . $con->avatar . '" alt="username" draggable="false">
//                                           </span>
//                                          </div>
//                                          <div class="' . $messclass . '">
//                                          ' . $con->message['message'] . '
//                                            <a href="' . route("chatdownload", ['id' => $con->id]) . '">اسم الملف .pdf
//                                            <i class="fas fa-cloud-download-alt mx-3"></i>
//                                            </a>
//                                          </div>
//                                         </li>
//                                         ';
//                        }
//                        if ($con->chat_type == 4) {
//                            // vedio
//                            $output .= '<li class="' . $liclass . '">
//                                        <div class="' . $divclass . '">
//                                          <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                          <span class="message-data-name">
//                                            <img src="' . $con->avatar . '" alt="username" draggable="false">
//
//                                          </span>
//                                        </div>
//                                        <div class="' . $messclass . '">
//                                        ' . $con->message['message'] . '
//                                            <video controls>
//                                                <source src="' . \Request::root() . '/images/video/1.mp4" type="video/mp4">
//                                            </video>
//                                       </div>
//                                      </li>
//                                   ';
//                        }
//                        if ($con->chat_type == 5) {
//                            // audio
//                            $output .= '  <li class="' . $liclass . '">
//                                                <div class="' . $divclass . '">
//                                                  <!-- <span class="message-data-time" >10:10 AM, Today</span> &nbsp; &nbsp; -->
//                                                  <span class="message-data-name">
//                                                    <img src="' . $con->avatar . '" alt="username" draggable="false">
//
//                                                  </span>
//                                                </div>
//                                                <div class="' . $messclass . '">
//                                                ' . $con->message['message'] . '
//                                                   <audio controls>
//                                                      <source src="' . \Request::root() . '/images/audio/1.mp3" type="audio/mp3">
//                                                    </audio>
//
//                                               </div>
//                                              </li>
//                                   ';
//                        }
//
//
//                    }
//
//                    $last_id = $con->id;
//                }
//                $output .= '
//                <div id="load_more">
//                <button type="button" name="load_more_button" class="btn btn-success form-control" data-id="'.$last_id.'" id="load_more_button">Load More</button>
//                </div>
//                   ';
//            }


       }
   }



    public function download($url)
    {
        //dd('njhihiu');
        return response()->download($url);
    }





}
