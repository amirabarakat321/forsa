<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kreait\Firebase;
use App\User;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Pagination\LengthAwarePaginator;

use Kreait\Firebase\Database;

class FirebaseController extends Controller

{

//

    public function index()
    {

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/test-bf688-firebase-adminsdk-k0u0a-452dfbd658.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://test-bf688.firebaseio.com/')
            ->create();

        $database = $firebase->getDatabase();

        $newPost = $database
            ->getReference('MyMessages/consult-34');

//$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-

//$newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-

//$newPost->getChild('title')->set('Changed post title');

//$newPost->getValue(); // Fetches the data from the realtime database

$output='';
        $arr = $newPost->getValue();

dd($arr);
if($arr) {
            foreach ($arr as $ar) {
                for ($i = 0; $i < 1; $i++) {
                    $asd = array();
                    foreach ($ar as $a) {
                        $asd[] = $a;
                    }
                    $checkid = $asd[1];
                }
                unset($asd);
            }


            foreach ($arr as $ar) {
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
                                            <a href="' . route("chatdownload", ['id' => $con->id]) . '">اسم الملف .pdf
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
                                                <source src=".$asd[1]." type="video/mp4">
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
                                                      <source src=".$asd[1]." type="audio/mp3">
                                                    </audio>
                                                 
                                               </div>
                                              </li> 
                                   ';
                }

                ////
                unset($asd);
            }
        }else{
            $output="لا يوجد محادثه";
        }

         return view('chatview')->with('output',$output);
    }


    public function consultchat($id)
    {

       // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/forsatanya-8ae4d-c46892e3d920.json');
//        $firebase = (new Factory)
//            ->withServiceAccount($serviceAccount)
//            ->withDatabaseUri('https://forsatanya-8ae4d.firebaseio.com/')
//            ->create();
        $fire='consult-'.$id;
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/test-bf688-firebase-adminsdk-k0u0a-452dfbd658.json');

        $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->withDatabaseUri('https://test-bf688.firebaseio.com/')
        ->create();

        $database = $firebase->getDatabase();

        $newPost = $database
            ->getReference('MyMessages/'.$fire);

//$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-

//$newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-

//$newPost->getChild('title')->set('Changed post title');

//$newPost->getValue(); // Fetches the data from the realtime database

        $output='';
        $arr = $newPost->getValue();
        dd($arr);
        $arry = array();

if($arr) {
    //get id of one of the speakers
    foreach ($arr as $ar) {
        for ($i = 0; $i < 1; $i++) {
            $asd = array();
            foreach ($ar as $a) {
                $asd[] = $a;
            }
            $checkid = $asd[1];
        }
        unset($asd);
    }
    $items = array();
    $items  =$arr;


    // Get current page form url e.x. &page=1
    $currentPage = LengthAwarePaginator::resolveCurrentPage();

    // Create a new Laravel collection from the array data
    $itemCollection = collect($items);

    // Define how many items we want to be visible in each page
    $perPage = 1;

    // Slice the collection to get the items to display in current page
    $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

    // Create our paginator and pass it to the view
    $paginatedItems= new LengthAwarePaginator($currentPageItems , count($itemCollection), $perPage);

    // set url path for generted links
    $paginatedItems->setPath(url('chatconsul/'.$id));




    foreach ($paginatedItems as $ar) {
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
                                            <a href="' . route("chatdownload", ['id' => $con->id]) . '">اسم الملف .pdf
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
                                                <source src=".$asd[1]." type="video/mp4">
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
                                                      <source src=".$asd[1]." type="audio/mp3">
                                                    </audio>
                                                 
                                               </div>
                                              </li> 
                                   ';
        }

        ////
        unset($asd);

    }
}else{
    $output="لا يوجد محادثه";
}
        return view('chatview',['items' => $paginatedItems, 'output' => $output]);

    }
}
?>
