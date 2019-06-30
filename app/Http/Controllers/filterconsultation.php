<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Validator;
use DB;

class filterconsultation extends Controller
{
  public function  index(){
   	$times = [];
        return view('consultations.consultationfilter')->with('times',$times);
      }


  public function  searchcons(Request $request){
    $provider=[]; 
    $cat=$request->input();
  
    unset($cat['_token']); 
    unset($cat['saerchtesxt']);
    if (array_key_exists('expert', $request->input())) {
       $provider[]=$request['expert'];
       unset($cat['expert']);
    } 
    if (array_key_exists('amateur', $request->input())) {
       $provider[]=$request['amateur'];
       unset($cat['amateur']);
     }

     if(empty($cat)){ 
           $categ=DB::table('specializations')->get();
           foreach ($categ as $cate ) {
             $cat[]= $cate->id;
           }
            
          }
     if(empty($provider)){
            $users=DB::table('users')
                    ->where('type', 'expert')
                    ->orWhere('type', 'amateur')
                    ->get();
           foreach ($users as $user ) {
               $provider[]= $user->id;
             }
          }else{
             $users=DB::table('users')
                    ->whereIn('type',$provider )
                    ->get();
            foreach ($users as $user ) {
               $provider[]= $user->id;
             }
          }
     $consultationscategories = DB::table('specializations')->get();
     if(empty($request['saerchtesxt'])){
     $consultations =DB::table('consultations')
                     ->leftJoin('specializations', 'consultations.cat_id', '=', 'specializations.id')
                      ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
                      ->select('consultations.*', 'specializations.title as catname', 'users.service_price')
                       ->whereIn('provider_id', $provider)
                       ->whereIn('cat_id', $cat)
                       ->orderBy('id', 'desc')->paginate(30);
                     }else{
                     
                      $consultations =DB::table('consultations')
                           ->leftJoin('specializations', 'consultations.cat_id', '=', 'specializations.id')
                            ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
                            ->select('consultations.*', 'specializations.title as catname', 'users.service_price')
                            ->where('description', 'LIKE', "%{$request['saerchtesxt']}%")
                             ->whereIn('provider_id', $provider)
                             ->whereIn('cat_id', $cat)
                             ->orderBy('id', 'desc')->paginate(30);
                     }

        $results = '';
        $status = [0 => 'ملغي', 1 => 'جاري', 2 => 'منتهي'];
       
        $x=0;
        foreach ($consultations as $consultation){
            $x++;
            if($consultation->user_id == $consultation->provider_id)
            {
               $color  ="#af0000";
            }else{
                 $color  ="#e57a00";
            }
            $results .= '<tr>
                    <td bgcolor='.$color.'>'.$x.'</td>
                    <td>'.$consultation->catname.'</td>
                    <td>'.$consultation->booking_date.'</td>
                    <td>'.$consultation->service_price.'</td>
                    <td>5</td>
                    <td>'.$status[$consultation->status].'</td>
                    <td  >
                    <a title="عرض" class="show" href="'.route('consultations.show', $consultation->id).'">
                        <i class="fas fa-eye"></i>
                    </a>
                    </td>
                </tr>';
        }

        $siteMap = ['الرئيسية', 'الإستشارات'];

        return view('consultations.consultations', ['siteMap' => $siteMap,'links' => $consultations, 'consultations' => $results, 'consultationscategories'=>$consultationscategories]);              
            
       
      }

  public function  filter(Request $request){
//if($request['month'] != 0){
//    $data =Validator::make($request->all(), [
//        'month' => 'required_without:day',
//         ]);
//
//       }
//      if ($data->fails()) {
//          return \Redirect::back()
//              ->withErrors($data) ;// send back all errors to the login form
//      } elseif ($request['month'] != "0") {
//       / $times = DB::table('consultations')
//            ->join('times', 'consultations.time_id', '=', 'times.id',)
//            ->select('times.theTime', 'times.id', DB::raw('count(times.id) as total'))
//            ->where('consultations.booking_date', '>', (new \Carbon\Carbon)->submonths((int)$request['month']))
//            ->groupBy('theTime')
//            ->groupBy('id')
//            ->get();
//        $date = $request['month'];
//
//
//    }//            DB::table('consultations')
////            ->leftJoin ('times', 'consultations.time_id', '=', 'times.id')
////            ->select('times.theTime', 'times.id', DB::raw('count(times.id) as total'))
////            ->where('consultations.booking_date', $request['day'])
////            ->groupBy('theTime')
////            ->groupBy('id')
////            ->get();
      $date=' ';
    if ($request['day'] != null) {
        $times =DB::table('times')->orderBy('id', 'asc')->get();

        $date = strtotime($request['day']);
        foreach ($times as $time){

            $time->totalreserved=  DB::table('consultations')
                             ->where('consultations.booking_date', $request['day'])
                             ->where('time_id', $time->id)
                             ->whereColumn('user_id', '!=','provider_id')->count();
            $time->totalreserve=   DB::table('consultations')
                             ->where('consultations.booking_date', $request['day'])
                             ->where('time_id', $time->id)
                             ->whereColumn('user_id', '=','provider_id')->count();

        if($time->totalreserved == 0 && $time->totalreserve ==0){
              $time->clase='widget text-center gray';
            }
        if($time->totalreserved == 0 && $time->totalreserve != 0){
            $time->clase='widget text-center red';
        }
        if($time->totalreserved != 0 && $time->totalreserve == 0){
             $time->clase='widget text-center yellow';
         }
         if($time->totalreserved != 0 && $time->totalreserve !=0){
             $time->clase='widget text-center widget_v2';
         }
        }
    }  elseif ( $request['day'] == null) {
        $times = [];
    }
    return view('consultations.consultationfilter')->with('times', $times)->with('date', $date);

      }
      public function  consultationview($id,$date ){
     
              
        if( strlen($date) >2){
           $consultations = DB::table('consultations')
            ->leftJoin('specializations', 'consultations.cat_id', '=', 'specializations.id')
            ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
            ->select('consultations.*', 'specializations.title as catname', 'users.service_price')
            ->where('consultations.booking_date', date('Y-m-d',$date))
             ->where('consultations.time_id', $id)
            ->orderBy('id', 'desc')->paginate(30);
           
        }else{
            $consultations =DB::table('consultations')
              ->leftJoin('specializations', 'consultations.cat_id', '=', 'specializations.id')
              ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
              ->select('consultations.*', 'specializations.title as catname', 'users.service_price')
            ->where('consultations.booking_date', '>', (new \Carbon\Carbon)->submonths((int)$date))
            ->where('consultations.time_id', $id)
            ->orderBy('id', 'desc')->paginate(30);
        }

         $results = '';
        $status = [0 => 'ملغي', 1 => 'جاري', 2 => 'منتهي'];
       
        $x=0;
        foreach ($consultations as $consultation){
            $x++;
            if($consultation->user_id == $consultation->provider_id)
            {
               $color  ="#af0000";
            }else{
                 $color  ="#e57a00";
            }
            $results .= '<tr>
                    <td bgcolor='.$color.'>'.$x.'</td>
                    <td>'.$consultation->catname.'</td>
                    <td>'.$consultation->booking_date.'</td>
                    <td>'.$consultation->service_price.'</td>
                    <td>5</td>
                    <td>'.$status[$consultation->status].'</td>
                    <td  >
                    <a title="عرض" class="show" href="'.route('consultations.show', $consultation->id).'">
                        <i class="fas fa-eye"></i>
                    </a>
                    </td>
                </tr>';
        }

        $siteMap = ['الرئيسية', 'الإستشارات'];
        $consultationscategories = DB::table('specializations')->get();
        return view('consultations.consultations', ['siteMap' => $siteMap,'links' => $consultations, 'consultations' => $results,'consultationscategories'=>$consultationscategories]);
        }
        

  } 
