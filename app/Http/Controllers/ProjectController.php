<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SupervisorPrivilege;
use App\Project;
use DB;
use App\ProjectType;
use App\ProjectService;
use App\User;
use Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin'])->except(['delete','projectview','addtype','addservice']);
        $this->middleware('delete', ['only' => [
            'delete',

        ]]);

        $this->middleware('reader', ['only' => [
            'projectview',

        ]]);
        $this->middleware('writer', ['only' => [
            'addtype','addservice'

        ]]);
    }

    use SupervisorPrivilege;
    public function index()
    {
        /// return all project  that it's cat is avaliable
        $projects= Project::leftjoin('projects_types', 'projects.cat_id', '=', 'projects_types.id')
                          ->join('projects_services', 'projects.service_id', '=', 'projects_services.id')
                          ->select('projects.*','projects_types.type_title as typename','projects_services.service_title as servicename')
                          ->paginate(20);
      return $this->retrevedata($projects);
    }

    public function retrevedata($projects)
    {
        $deletecheck =$this->deleteCheck();
        $editcheck =$this->editCheck();
        $viewcheck =$this->viewCheck();

        $projecttypes= DB::table('projects_types')->get();
        $output  ='';
        foreach ($projects as $project ) {

            if($project->status == 1) {
                $project->clas='btn btn-sm btn-toggle active';
                $project->sta='true';
            } else {
                $project->clas='btn btn-sm btn-toggle ';
                $project->sta='false';
            }
            $output .= '  <tr>
                            <td>'.$project->id.'</td>
                            <td>'.$project->title.'</td>
                            <td>'.$project->typename.'</td>
                            <td>'.$project->servicename.'</td>
                            <td>'.$project->address.'</td>

                            <td>';
            if($editcheck){
                $output .='<button type="button" class="'.$project->clas.'" href="'.url("projectstatus/".$project->id."/1").'"
                                        aria-pressed="'.$project->sta.'" autocomplete="off">
                                    <div class="handle"></div>
                                </button>';
            }else{
                $output .='<button disabled type="button" class="'.$project->clas.'" href="" aria-pressed="'.$project->sta.'" 
                                     autocomplete="off">
                                           <div class="handle"></div>
                                       </button>';
            }
            $output .=' </td>
                            <td>';
            if($viewcheck){
                $output .='  <a  data-toggle="tooltip" title="عرض" data-placement="bottom" href="'.route("showproject",$project->id).'">
                                    <i class="fas fa-eye"></i>
                                </a>';
            }
            if($deletecheck){
                $output .='<a   class="deleteam" data-toggle="tooltip" title="حذف" data-placement="bottom" href="'.url("/project/".$project->id."/1/destroy").'" >
                                    <i class="fas fa-trash"></i>
                                </a>';
            }


            $output .='   </td>
                        </tr>';


        }

        $siteMap = ['الرئيسية', 'المشاريع  '];
        return view('projects.viewprojects', ['siteMap' => $siteMap, 'projects' => $projects, 'output' => $output, 'projecttypes' => $projecttypes]);

    }


    public function projectview($id)
    {
        /// return all project  details
        $projects = DB::table('projects')->join('projects_types', 'projects.cat_id', '=', 'projects_types.id')
            ->join('users', 'projects.user_id', '=', 'users.id')->where('projects.id', $id)
            ->select('projects.*', 'projects_types.type_title as typename', 'users.name as username', 'users.id as userid')
            ->first();

        $photos=DB::table('project_photos')->where('project_id',$id)->get();

        $rate = DB::table('ratings')->where('service_type', "project")->where('service_id', $projects->id)->first();
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

        if($projects->status ==1)
        {
            $projects->sta="active";
            $projects->stat="قائم";
        }if($projects->status ==2)
    {
        $projects->sta="";
        $projects->stat="منتهي";
    }if($projects->status ==0)
    {
        $projects->sta="";
        $projects->stat="انتظار الموافقه";
    }if($projects->status ==3)
    {
        $projects->sta="";
        $projects->stat="مؤجل ";
    }if($projects->status ==4)
    {
        $projects->sta="";
        $projects->stat="مرفوض ";
    }

        return view('projects.projectdetials')->with('projects', $projects)->with('stars', $stars)->with('photos',$photos)->with('totalrate',$totalrate);
    }
    // delete from table project or service or type
    public function delete($id,$ty)
    {
        if($ty == 1){
            $del=  Project::where('id', $id)->delete();
        }elseif ($ty == 2) {
            $del=  ProjectType::where('id', $id)->delete();
        }elseif ($ty == 3) {
            $del=  ProjectService::where('id', $id)->delete();
        }

        if($del){
            return Response(['success'=>true]);
        }else{
            return Response(['success'=>false]);
        }
    }

//    // delete from details page
//    public function deleteproject($id)
//    {
//        $del=Project::where('id', $id)->delete();
//
//        if($del){
//            return Response(['success'=>true]);
//        }else{
//            return Response(['success'=>false]);
//        }
//    }

    public function editstatue($id ,$ty)
    {
        if ($ty == 1) {
            $project= Project::where('id',$id)->first();
            if($project->status == 1){
                $del= Project::where('id',$id)
                    ->update(['status' =>3]);
            }else{
                $del= Project::where('id',$id)
                    ->update(['status' =>1]);
            }
        }elseif ($ty == 2) {
            $type= ProjectType::where('id',$id)->first();
            if($type->status == 0){
                $del= ProjectType::where('id',$id)
                    ->update(['status' =>1]);
            }elseif($type->status==1){
                $del= ProjectType::where('id',$id)
                    ->update(['status' =>0]);
            }
        }elseif($ty == 3) {
            $service= ProjectService::where('id',$id)->first();
            if($service->status == 0){
                $del= ProjectService::where('id',$id)
                    ->update(['status' =>1]);
            }elseif($service->status == 1){
                $del= ProjectService::where('id',$id)
                    ->update(['status' =>0]);
            }
        }

        if($del){
            return Response(['success'=>"true"]);
        }else{
            return Response(['success'=>"false"]);
        }
    }

    ///handel projects_types table
    ///
    public function typesindex()
    {
          ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR{

          ////delte privilige for supervisor{
             $deletecheck= $this->deleteCheck();
          //{
          ////edit privilige for supervisor{
            $editCheck= $this->editCheck();
            //{
         /// add privilege
        $addcheck =$this->addCheck();


        /// return all project  that it's cat is avaliable
        $cats= DB::table('projects_types')->get();

        return view('projects.projecttype')->with('cats',$cats)
                                           ->with('deletecheck',$deletecheck)
                                           ->with('editcheck',$editCheck)
                                           ->with('addcheck',$addcheck);
    }

    public function addtype(Request $request)
    {
        $pro = new ProjectType();
        $pro->type_title = $request->input('type_title') ;
        $pro->status = 1 ;
        $pro->save();

        return back()->with('success', 'تم الإضافة بنجاح');
    }

    public function edittype(Request $request)
    {
        ProjectType::where('id',(int)$request->input('type_id'))
            ->update(['type_title' => $request->input('type_title')]);

        return back()->with('success', 'تم التعديل بنجاح');
    }
//
//    public function delType($id)
//    {
//        if (ProjectType::destroy($id))
//            return response(['success' => true]);
//        else
//            return response(['success' => false]);
//    }

    // handel  projects_services table

    public function servicesindex()
    {
        ///add privilege
        $addcheck =$this->addCheck();
        /// return all project  that it's cat is avaliable
        $results = '';
        $services= DB::table('projects_services')->get();
        if (count($services) > 0){
            $x=0;
            foreach ($services as $service ) {
                $x++;
                if($service->status == 1) {
                    $service->clas='btn btn-sm btn-toggle active';
                    $service->sta='true';
                } elseif ($service->status == 0) {
                    $service->clas='btn btn-sm btn-toggle ';
                    $service->sta='false';
                }



                $results .='<tr>
                        <td> '.$x.'</td>
                        <td>'.$service->service_title.'</td> 
                        <td>';
                if($this->editCheck()){
                    $results .= ' <span data-toggle="modal" data-target="#editService">
                                <a  data-toggle="tooltip" class="updattype" data-content="'.$service->service_title.'-'.$service->id.'
                                    title="تعديل" data-placement="bottom" href="">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </span>';
                            }
                if( $this->deleteCheck()){
                    $results .= '<a data-toggle="tooltip" title="حذف" data-placement="bottom" class="deleteam" href="'.url("/project/".$service->id."/3/destroy").'"   >
                                <form action="'.route('delService', $service->id).'" style="display: none;" id="delete_form">
                                    <input type="hidden" name="data_id" value="'.$service->id.'">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="'.csrf_token().'">
                                </form>
                                <i class="fas fa-trash"></i>
                            </a>
                           
                        </td>
                        
                    </tr>';
                }else{
                    $results .= '
                        </td>
                    </tr>';
                }



            }
        }

        return view('projects.projectservices')->with('services',$results)->with('addcheck',$addcheck);
    }

    public function addservice(Request $request)
    {
        $pro = new ProjectService();
        $pro->service_title = $request->input('service_title') ;
        $pro->status = 1 ;
        $pro->save();
        return back()->with('success', 'تم الإضافة بنجاح');
    }

    public function editservice(Request $request)
    {
        ProjectService::where('id',(int)$request->input('service_id'))
            ->update(['service_title' => $request->input('service_title')]);

        return back()->with('success', 'تم التعديل بنجاح');
    }

//    public function delService($id)
//    {
//        if (ProjectService::destroy($id))
//            return response(['success' => true]);
//        else
//            return response(['success' => false]);
//    }

    public function  searchproject(Request $request){
        $cat=$request->input();
        unset($cat['_token']);
        unset($cat['saerchtesxt']);

        if(empty($cat)){
            $categ=DB::table('projects_types')->get();
            foreach ($categ as $cate ) {
                $cat[]= $cate->id;
            }

        }

        if(empty($request['saerchtesxt'])){

            //dd($projects);
            $projects =DB::table('projects')->leftjoin('projects_types', 'projects.cat_id', '=', 'projects_types.id')
                ->join('projects_services', 'projects.service_id', '=', 'projects_services.id')
                ->select('projects.*','projects_types.type_title as typename','projects_services.service_title as servicename')
                ->whereIn('cat_id', $cat)
                ->orderBy('id', 'desc')->paginate(30);
        }else{

            $projects =DB::table('projects')->leftjoin('projects_types', 'projects.cat_id', '=', 'projects_types.id')
                ->join('projects_services', 'projects.service_id', '=', 'projects_services.id')
                ->select('projects.*','projects_types.type_title as typename','projects_services.service_title as servicename')
                ->where('description', 'LIKE', "%{$request['saerchtesxt']}%")
                ->orwhere('title', 'LIKE', "%{$request['saerchtesxt']}%")
                ->whereIn('cat_id', $cat)
                ->orderBy('id', 'desc')->paginate(30);
        }

        return $this->retrevedata($projects);

    }

}
