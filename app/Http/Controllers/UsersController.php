<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\Http\Controllers\Api\NotificationApiReturn;
use App\Portfolio;
use App\Portfolio_file;
use App\Project;
use App\Rating;
use App\Study;
use App\User;
use DB;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    use NotificationApiReturn;

    public function __construct(){
        $this->middleware(['justadmin']);

    }

    public function index()
    {
        echo "fff";
    }
    /*
     * get all clients
     * */

    public function clientsretrive($clients)
    {
        $results = '';

        $x=0;
        foreach ($clients as $client){
            $x++;
            $status = $client->status == true ? 'active' : '';
            if($client->status == 1) {
                $client->clas='btn btn-sm btn-toggle active';
                $client->sta='true';
            } else {
                $client->clas='btn btn-sm btn-toggle ';
                $client->sta='false';
            }
            $results .= '<tr>
                    <td>'.$x.'</td>
                    <td> '.$client->name.' </td>
                    <td>
                        '.$client->email.'
                    </td>
                    <td>
                        <bdi>'.$client->phone.'</bdi>
                    </td>
                    <td>
                        <!-- To open the button please add class active here -->
                        <button type="button" class="'.$client->clas.'" aria-pressed="'. $client->sta.'" href="'.url('users/status/'.$client->id).'">
                            <a  style="display: none"></a>
                            <div class="handle"></div>
                        </button>
                    </td>
                    <td>
                        <a  data-toggle="tooltip" title="عرض" data-placement="bottom" href="'.url('users/'.$client->id).'">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a data-toggle="tooltip" title="حذف" data-placement="bottom" href="'.route('users.destroy', $client->id).'"  class="delete" >
                            <form action="'.route('users.destroy', $client->id).'" style="display: none;" id="delete_form">
                                <input type="hidden" name="data_id" value="'.$client->id.'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                            </form>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>';
        }

        $siteMap = ['الرئيسية', 'المستخدمين', 'العملاء'];

        return view('users.clients', ['clients' => $results, 'siteMap' => $siteMap, 'links' => $clients]);
    }
    public function clients()
    {
        $clients = User::where(['type' => 'client'])->paginate(30);
        return $this->clientsretrive($clients);
    }

    /*
     * end of get all clients
     * get all experimenters
     * */
    public function amateursretrive($amateurs)
    {
        $results = '';

        $x=0;
        foreach ($amateurs as $client){
            $x++;

            //get user rating

            $getRating = Rating::where(['user_id' => $client->id]);

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $client->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $client->rating = 0;
            }

            /*
             * end get rating
             * */
            if($client->status == 1) {
                $client->clas='btn btn-sm btn-toggle active';
                $client->sta='true';
            } else {
                $client->clas='btn btn-sm btn-toggle ';
                $client->sta='false';
            }
            $status = $client->status == true ? 'active' : '';
            $results .= '<tr>
                    <td>'.$x.'</td>
                    <td> '.$client->name.' </td>
                    <td>
                        '.$client->email.'
                    </td>
                    <td>
                        <bdi>'.$client->phone.'</bdi>
                    </td>
                    <td>
                        '.$client->rating.'
                    </td>
                    <td>
                        <!-- To open the button please add class active here -->
                          <button type="button" class="'.$client->clas.'" aria-pressed="'. $client->sta.'" href="'.url('users/status/'.$client->id).'">
                            <a  style="display: none"></a>
                            <div class="handle"></div>
                        </button>
                    </td>
                    <td>
                        <a  data-toggle="tooltip" title="عرض" data-placement="bottom" href="'.url('users/'.$client->id).'">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a data-toggle="tooltip" title="حذف" data-placement="bottom" href="'.route('users.destroy', $client->id).'"  class="delete" >
                            <form action="'.route('users.destroy', $client->id).'" style="display: none;" id="delete_form">
                                <input type="hidden" name="data_id" value="'.$client->id.'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                            </form>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>';
        }

        $siteMap = ['الرئيسية', 'المستخدمين', 'المجربين'];

        return view('users.experimenters', ['clients' => $results, 'siteMap' => $siteMap, 'links' => $amateurs]);
    }
    public function amateurs()
    {
        $amateurs = User::where(['type' => 'amateur'])->paginate(30);
         return $this->amateursretrive($amateurs);

    }
        /*
         * end of get all experimenters
         *  get all experts
         * */

    public function expertsretrive($experts)
    {

        $results = '';

        $x=0;
        foreach ($experts as $client){
            $x++;

            //get user rating

            $getRating = Rating::where(['user_id' => $client->id]);

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $client->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $client->rating = 0;
            }

            /*
             * end get rating
             * */
            if($client->status == 1) {
                $client->clas='btn btn-sm btn-toggle active';
                $client->sta='true';
            } else {
                $client->clas='btn btn-sm btn-toggle ';
                $client->sta='false';
            }
            $status = $client->status == true ? 'active' : '';
            $results .= '<tr>
                    <td>'.$x.'</td>
                    <td> '.$client->name.' </td>
                    <td>
                        '.$client->email.'
                    </td>
                    <td>
                        <bdi>'.$client->phone.'</bdi>
                    </td>
                    <td>
                        '.$client->rating.'
                    </td>
                    <td>
                        <!-- To open the button please add class active here -->
                        <button type="button" class="'.$client->clas.'" aria-pressed="'. $client->sta.'" href="'.url('users/status/'.$client->id).'">
                            <a  style="display: none"></a>
                            <div class="handle"></div>
                        </button>
                    </td>
                    <td>
                        <a  data-toggle="tooltip" title="عرض" data-placement="bottom" href="'.url('users/'.$client->id).'">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a data-toggle="tooltip" title="حذف" data-placement="bottom" href="'.route('users.destroy', $client->id).'"  class="delete" >
                            <form action="'.route('users.destroy', $client->id).'" style="display: none;" id="delete_form">
                                <input type="hidden" name="data_id" value="'.$client->id.'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                            </form>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>';
        }

        $siteMap = ['الرئيسية', 'المستخدمين', 'الخبراء'];

        return view('users.experts', ['clients' => $results, 'siteMap' => $siteMap, 'links' => $experts->links()]);
    }
    public function experts()
    {
        $experts = User::where(['type' => 'expert'])->paginate(30);
        return $this->expertsretrive($experts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(User::where('id', $id)->count() > 0){
            $profile = User::find($id);

            if($profile->type == 'amateur' OR $profile->type == 'expert') {
                // get user portfolio
                $portfolios = Portfolio::where(['user_id' => $id]);
                $portfolioResult = '';
                $documenations =  DB::table('documentations')->where('user_id',$id)->get();

                if($portfolios->count() > 0){
                    foreach ($portfolios->get() as $portfolio){
                        // portfolio files
                        $portfolio_files = Portfolio_file::where(['portfolio_id' => $portfolio->id])->first();
                        if($portfolio_files) {
                            if ($portfolio_files->ext == 'pdf'):

                                $file = '<h3>' . $portfolio->title . '</h3>
                                   <br>   
                            <a class="doc" href="' . $portfolio_files->file . '" ></a>';
                            else:
                                $file = '<h3>' . $portfolio->title . '</h3>
                                 <br>
                            <img src="' . $portfolio_files->file . '" alt="image" data-toggle="modal"  data-target="#img">';
                            endif;
                        }
                        $portfolioResult .= '
                            <div class="col-lg-4">
                                <div class="imgContainer">
                                       '.$file.'
                                </div> <!-- end imgContainer -->
                            </div> <!-- edn col -->
                        ';
                    }
                }

                // get user projects
                $projects = Project::where(['user_id' => $id]);
                $projectsResult = '';

                if($projects->count() > 0 ){
                    foreach ($projects as $project):
                        $projectsResult .= '
                            <div class="col-lg-4">
                                <div class="project my-3">
                                    <a href="'.url('projects/'.$project->id).'"></a>
                                    <div class="imgContainer">
                                        <img src="images/bg-body.png" alt="image">
                                    </div> <!-- end imgContainer -->
                                    <p class="text-center my-2">'.$project->title.'</p>
                                </div> <!-- end project -->
                            </div> <!-- edn col -->
                        ';
                    endforeach;
                }

                // get user rating
                $getRating = Rating::where(['user_id' => $profile->id]);
                $profile->studies = Study::where(['user_id' => $id])->count();
                $profile->projects = Project::where(['user_id' => $id])->count();
                $profile->consultations = Consultation::where(['user_id' => $id])->count();

                if ($getRating->count() > 0) {
                    $ratingsSum = $getRating->get();
                    $ratingsArray = [];
                    foreach ($ratingsSum as $rate) {
                        array_push($ratingsArray, $rate->rating);
                    }

                    $profile->rating = array_sum($ratingsArray) / $getRating->count();
                } else {
                    $profile->rating = 0;
                }
                /*
                 * end of get rating
                 * */
            }

            $siteMap = ['الرئيسية', 'المستخدمين', ' الملف الشخصي '.'('.$profile->name.')'];
            $specializations = ['client' => 'عميل', 'expert' => 'خبير', 'amateur' => 'مجرب'];

            // return views
            if($profile->type == 'client'){
                return view('users.Profile', ['profile' => $profile,  'siteMap' => $siteMap, 'specializations' => $specializations]);
            }

            if($profile->type == 'expert'){
                return view('users.Profile', ['documentations'=>$documenations,'profile' => $profile, 'portfolio' => $portfolioResult, 'projects' => $projectsResult, 'siteMap' => $siteMap, 'specializations' => $specializations]);
            }

            if($profile->type == 'amateur'){
                return view('users.Profile', ['documentations'=>$documenations,'profile' => $profile, 'portfolio' => $portfolioResult ,'projects' => $projectsResult, 'siteMap' => $siteMap, 'specializations' => $specializations]);
            }
        }else{
            return abort(404);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::destroy($id)){
            return response(['success' => true]);
        }

        return response(['success' => false]);
    }

    /*
     * change user status
     * */

    public function status($id){

        $user= User::where('id',$id)->first();
        if($user->status == 0){
            $ss="bbb";
            $upd= User::where('id',$id)
                ->update(['status' =>1]);
        }elseif($user->status == 1){
            $ss="ban";
            $upd= User::where('id',$id)
                ->update(['status' =>0]);
        }

        if($upd){
            return Response(['message'=>$ss,'success'=>"true",]);
        }else{
            return Response(['success'=>"false"]);
        }
    }

    /*
     * authenticate user (upgrade)
     * types (gold, authenticated, certified)
     * */

    public function upgradeUser(Request $request, $id){
        $type = $request->input('upgradeMark');

        User::where(['id' => $id])->update(['authenticate' => $type]);

        return back();
    }

    // send Notification

    public function sendNotifi(Request $request, $id){
        $title = $request->input('title');
        $message = $request->input('message');

        $user = User::find($id);

        $Tokens = $user->tokens != null ? json_decode($user->tokens) : null;

        $clientTokensArray = [];

        if($Tokens != null) {
            for ($x = 0; $x < count($Tokens->devices); $x++) {
                array_push($clientTokensArray, $Tokens->devices[$x]->token);
            }
        }

        $this->notificationApiResponse($title, $message, $clientTokensArray,null);

        return back()->with('status', 'تم إرسال الإشعار بنجاح');
    }

    public function search( Request $request)
    {

        $requestData = $request->all();

        if($requestData['name']==null){
            $users=User::Where('type','=',$requestData['type'])->paginate(30);

        }else{
            $users=User::where('type',$requestData['type'])->where('name', 'LIKE', "%{$requestData['name']}%")->paginate(30);
        }
        if($requestData['type']=="expert") {
            return $this->expertsretrive($users);
        }
        if($requestData['type']=="client") {
            return $this->clientsretrive($users);
        }
        if($requestData['type']=="amateur") {
            return $this->amateursretrive($users);
        }

    }

}
