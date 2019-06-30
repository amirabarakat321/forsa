<?php

namespace App\Http\Controllers;
use App\Http\Controllers\SupervisorPrivilege;

use App\Consultation;
use Illuminate\Http\Request;
use App\Http\Requests;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Jwt\AccessToken;
use DB;

class ConsultationsController extends Controller
{
    use SupervisorPrivilege;
    public function __construct()
    {
        $this->middleware(['admin'])->except(['show']);
        $this->middleware('reader', ['only' => [
            'show',

        ]]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ss="consultation";
        $consultations = DB::table('consultations')
            ->leftJoin('specializations', 'consultations.cat_id', '=', 'specializations.id')
            ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
            ->select('consultations.*', 'specializations.title as catname', 'users.service_price as providerprice')
            ->orderBy('consultations.id', 'desc')->paginate(30);

        $consultationscategories = DB::table('specializations')->get();


        $results = '';

        $status = [0 => 'انتظارالموافقه', 1 => 'جاري', 2 => 'منتهي',3=>'ملغي',4=>'رفض'];
       
        $x=0;
        foreach ($consultations as $consultation){
            $rate = DB::table('ratings')->where('service_type',"consultation")->where('service_id',$consultation->id)->first();
            if( $rate ){
                $totalrate=($rate->rating2+$rate->rating1 +$rate->rating3)/3;
            }else{
                $totalrate=null;
            }

            $x++;
            $results .= '<tr  >
                    <td>'.$x.'</td>
                    <td>'.$consultation->catname.'</td>
                    <td>'.$consultation->booking_date.'</td>
                    <td>'.$consultation->price.'</td>
                    <td>'.$totalrate.'</td>
                    <td>'.$status[$consultation->status].'</td>
                    <td>';
            ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR{
            if($this->viewCheck()){
                $results .=    '<a title="عرض" class="show" href="'.route('consultations.show', $consultation->id).'">
                        <i class="fas fa-eye"></i>
                    </a>
                    </td>
                </tr>';
                 }else{  $results .= '
                    </td>
                </tr>';}
        }

        $siteMap = ['الرئيسية', 'الإستشارات'];

        return view('consultations.consultations', ['siteMap' => $siteMap,'links' => $consultations, 'consultations' => $results, 'consultationscategories'=>$consultationscategories]);
    }

    /*
     * change status
     * */

    public function status($id){
        $consultation= Consultation::where('id',$id)->first();
        if($consultation->status == 1){
            $del= Consultation::where('id',$id)
                ->update(['status' =>3]);
        }else{
            $del= Consultation::where('id',$id)
                ->update(['status' =>1]);
        }

        if($del){
            return response(['success' => "true"]);
        }else{
            return response(['success' => "false"]);
        }
    }


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



    public function show($id)
    {
        $consultations = DB::table('consultations')
            ->leftJoin('specializations', 'consultations.cat_id', '=', 'specializations.id')
            ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
            ->leftJoin('times', 'times.id', '=', 'consultations.time_id' )
            ->select('consultations.*', 'specializations.title as catname', 'users.service_price' , 'times.theTime as time')
            ->where('consultations.id', $id)->first();
        if($consultations->status ==1)
        {
            $consultations->liclass="active";
            $consultations->tex="true";
            $consultations->statu="قائم";
        }if($consultations->status ==2)
          {
              $consultations->liclass="";
              $consultations->tex="false";
              $consultations->statu="منتهي";
       }if($consultations->status ==0)
        {
        $consultations->liclass="";
            $consultations->tex="false";
        $consultations->statu="انتظار الموافقه";
        }if($consultations->status ==3)
         {
        $consultations->liclass="";
             $consultations->tex="false";
        $consultations->statu="مؤجل ";
       }if($consultations->status ==4)
        {
        $consultations->liclass="";
            $consultations->tex="false";
        $consultations->statu="مرفوض ";
          }

        $rate = DB::table('ratings')->where('service_type', "consultation")->where('service_id', $consultations->id)->first();
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

        return view('consultations.consultationview',['data' => $consultations, 'stars' => $stars,'totalrate'=>$totalrate]);
    }

    public function generate_chat(AccessToken $accessToken, ChatGrant $chatGrant)
    {
        $appName = "TwilioChat";
        $deviceId = "fjeiofu4t5485784y8ghuireghiuerge";
        $identity = "forceTouches";

        $TWILIO_CHAT_SERVICE_SID = env("TWILIO_CHAT_SID");

        $endpointId = $appName . ":" . $identity . ":" . $deviceId;

        $accessToken->setIdentity($identity);

        $chatGrant->setServiceSid($TWILIO_CHAT_SERVICE_SID);
        $chatGrant->setEndpointId($endpointId);

        $accessToken->addGrant($chatGrant);

        $response = array(
            'identity' => $identity,
            'token' => $accessToken->toJWT()
        );

        return response()->json($response);
    }

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
        //
    }
}
