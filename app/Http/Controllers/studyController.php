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

class studyController extends Controller
{
    public function __construct(){
        $this->middleware(['admin'])->except(['delete','studyview']);
        $this->middleware('delete', ['only' => [
            'delete',
        ]]);
        $this->middleware('reader', ['only' => [
            'studyview',
        ]]);
    }
    use SupervisorPrivilege;
    use NotificationApiReturn;
    public function index()
    {
        $this->notificationApiResponse('fhf');
        $studies = Study::orderBy('id', 'asc')->paginate(30);
        $study_type = DB::table('studies_types')->get();

        $output = '';
        //$data= StudyResource::collection(Study::get());
        $x = 1;
        foreach ($studies as $study) {

            $study->study_type = DB::table('studies_types')->select('type_title')->where('id', $study->study_type)->first()->type_title;
            $study->project_type = DB::table('projects_types')->select('type_title')->where('id', $study->project_type_id)->first()->type_title;
            $study->country = DB::table('cities')->select('name_ar')->where('id', $study->country_id)->first()->name_ar;
            $rate = DB::table('ratings')->where('service_type', "study")->where('service_id', $study->id)->first();
            if ($rate) {
                $totalrate = ($rate->rating2 + $rate->rating1 + $rate->rating3) / 3;
            } else {
                $totalrate = null;
            }
            if ($study->status == 0) {
                $class = "btn btn-sm btn-toggle";
                $aria = "false";
            } else {

                $class = "btn btn-sm btn-toggle active";
                $aria = "true";
            }

            $output .= ' <tr>
                    <td>' . $x . '</td>
                    <td>' . $study->study_type . '</td>
                    <td>' . $study->project_type . ' </td>
                    <td>
                        ' . $study->price . '
                    </td>
                    <td>
                        ' . $study->created_at . '
                    </td>
                    <td>
                        ' . $totalrate . '
                    </td>';
            ///check for edit privilege if supervisor
            if($this->editCheck()){


                $output .= '<td>
                        <!-- To open the button please add class active here -->
                        <button type="button" class="'.$class.'"  href="'.url("study/".$study->id."/status").'" 
                         aria-pressed="'.$aria.'" autocomplete="off">
                            <div class="handle"></div>
                        </button>
                    </td>
                    <td>
                       ';}else{

                $output .= '<td>
                        <!-- To open the button please add class active here -->
                        <button disabled type="button" class="'.$class.'"  href=""  aria-pressed="'.$aria.'" autocomplete="off">
                            <div class="handle"></div>
                        </button>
                    </td>
                    <td>';}
                ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR{
            /// view privilege
                if( $this->viewCheck()){
                    $output .='   <a  data-toggle="tooltip" title="عرض" data-placement="bottom" href="'.route("studyview",$study->id).'">
                            <i class="fas fa-eye"></i>
                        </a>';
                }
              if( $this->deleteCheck()){
                $output .= '<a  data-toggle="tooltip" class="deleteam" title="حذف" data-placement="bottom" href="'.url("study/".$study->id."/destroy").'" >
                            <i class="fas fa-trash"></i>
                        </a>
                        </td>
                        
                    </tr>';
              }else{
                $output .= '
                        </td>
                    </tr>';
               }

            $x++;
        }
        $siteMap = ['الرئيسية', 'الدراسات '];
        return view('studies.studies', ['siteMap' => $siteMap, 'studies' => $studies, 'output' => $output, 'types' => $study_type]);
    }

    public function editstatus($id){
        $study= Study::where('id',$id)->first();
        if($study->status == 0){
            $upd= Study::where('id',$id)
                ->update(['status' =>1]);
        }elseif($study->status !=0){
            $upd= Study::where('id',$id)
                ->update(['status' =>0]);
        }

        if($upd){
            return Response(['success'=>"true"]);
        }else{
            return Response(['success'=>"false"]);
        }
    }
    public function studyview($id){
     $study=  Study::find($id);
        $study->study_type = DB::table('studies_types')->select('type_title')->where('id', $study->study_type)->first()->type_title;
        $study->project_type = DB::table('projects_types')->select('type_title')->where('id', $study->project_type_id)->first()->type_title;
        $rate = DB::table('ratings')->where('service_type', "study")->where('service_id', $study->id)->first();
        $photos=DB::table('study_photos')->where('study_id',$id)->get();

        if( $rate ){
            $totalrate=($rate->rating2+$rate->rating1 +$rate->rating3)/3;
            $number=explode('.', (string) $totalrate);

            for($i=0;$i<(int)$number[0];$i++){
                $stars[$i]="fas fa-star";
            }
            if((int)$number[1][0]>=5){
                $stars[$i]="fas fa-star-half-alt fa-flip-horizontal";
            }else{
                $stars[$i]="far fa-star";
            }
            for($i++;$i<5;$i++) {
                $stars[$i] = "far fa-star";
            }
        }else{
            $totalrate=0;
            for($x=0;$x<5;$x++) {
                $stars[$x] = "far fa-star";
            }
        }

        if($study->status ==1)
        {
            $study->liclass="active";
           $study->statu="قائم";
        }if($study->status ==2)
        {

            $study->liclass="";
            $study->statu="مؤجل";
        }if($study->status ==0)
        {
            $study->liclass="";
            $study->statu="منتهي";
        }
        return view('studies.studyview')->with('study',$study)->with('stars',$stars)->with('photos',$photos)->with('totalrate',$totalrate);
    }
    public function delete($id){
        $del = Study::where('id', $id)->delete();
        if ($del) {
            return Response(['success' => true]);
        }
        return Response(['success' => false]);
    }

    public function  search(Request $request){
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
            $categ=DB::table('studies_types')->get();
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
        $types = DB::table('studies_types')->get();
        if(empty($request['saerchtesxt'])){
            $studies =DB::table('studies')
                ->whereIn('provider_id', $provider)
                ->whereIn('study_type', $cat)
                ->orderBy('id', 'desc')->paginate(30);
        }else{

            $studies =DB::table('studies')
                ->where('description', 'LIKE', "%{$request['saerchtesxt']}%")
                ->whereIn('provider_id', $provider)
                ->whereIn('study_type', $cat)
                ->orderBy('id', 'desc')->paginate(30);

        }

        $study_type = DB::table('studies_types')->get();
        $output = '';
        //$data= StudyResource::collection(Study::get());
        $x = 1;
        foreach ($studies as $study) {

            $study->study_type = DB::table('studies_types')->select('type_title')->where('id', $study->study_type)->first()->type_title;
            $study->project_type = DB::table('projects_types')->select('type_title')->where('id', $study->project_type_id)->first()->type_title;
            $study->country = DB::table('cities')->select('name_ar')->where('id', $study->country_id)->first()->name_ar;
            $rate = DB::table('ratings')->where('service_type', "study")->where('service_id', $study->id)->first();
            if ($rate) {
                $totalrate = ($rate->rating2 + $rate->rating1 + $rate->rating3) / 3;
            } else {
                $totalrate = null;
            }
            if ($study->status == 1) {
                $class = "btn btn-sm btn-toggle active";
                $aria = "true";
            } else {
                $class = "btn btn-sm btn-toggle";
                $aria = "false";
            }

            $output .= ' <tr>
                    <td>' . $x . '</td>
                    <td>' . $study->study_type . '</td>
                    <td>' . $study->project_type . ' </td>
                    <td>
                        ' . $study->price . '
                    </td>
                    <td>
                        ' . $study->created_at . '
                    </td>
                    <td>
                        ' . $totalrate . '
                    </td>
                  
                    <td>
                        <!-- To open the button please add class active here -->
                        <button type="button" class="'.$class.'"  href="'.url("study/".$study->id."/status").'"  aria-pressed="'.$aria.'" autocomplete="off">
                            <div class="handle"></div>
                        </button>
                    </td>
                    <td>
                        <a  data-toggle="tooltip" title="عرض" data-placement="bottom" href="'.url("study/".$study->id."/show").'">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a  data-toggle="tooltip" class="deleteam" title="حذف" data-placement="bottom" href="'.url("study/".$study->id."/destroy").'" >
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                ';
            $x++;
        }
        $siteMap = ['الرئيسية', 'الدراسات '];
        return view('studies.studies', ['siteMap' => $siteMap, 'studies' => $studies, 'output' => $output, 'types' => $study_type]);

    }
}
