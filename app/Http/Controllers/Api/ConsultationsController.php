<?php

namespace App\Http\Controllers\Api;

use App\Calendar;
use App\Chat;
use App\Consultation;
use App\Favorite;
use App\Rating;
use App\Specialization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;

class ConsultationsController extends Controller
{
    use ApiReturn;
    use NotificationApiReturn;

    public $current_date;
    public $current_time;

    public function __construct()
    {
        $this->current_time = date('H:i:s');
        $this->current_date = date('Y-m-d');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function my_consultations(Request $request)
    {
        $uid = $request->input('user_id');

        $consultations = Consultation::leftJoin('specializations', 'specializations.id', '=', 'consultations.cat_id')
            ->select('consultations.*', 'specializations.title')
            ->where('consultations.user_id' , $uid)
            ->where('consultations.status', '!=' , 2)
            ->where('consultations.status', '!=' , 3)
            ->paginate(20);
        $x=0;
        foreach ($consultations as $consultation) {
            // check consultation time
            $consultation->time = DB::table('times')->where('id', $consultation->time_id)->first()->theTime;
            $time = strtotime($consultation->time);
            $endTime = date("H:i:s", strtotime('+30 minutes', $time));

            $time1 = new \DateTime($this->current_time);
            $time2 = new \DateTime($endTime);

            $diff = $time1->diff($time2);

            if($consultation->booking_date <= $this->current_date && $this->current_time >= $endTime && $diff->format('%i') >= 30 ){
                Consultation::where(['id' => $consultation->id])->update(['status' => 2]);
                unset($consultations[$x]);
            }

            // time stamp
            $date = new \DateTime($consultation->booking_date.' '.$consultation->theTime);
            $consultation->timeStamp = $date->getTimestamp();
            //user data
            $consultation->userData = User::select('id','name','email','phone','avatar','experience_years','service_price','visibility','authenticate')->where('id', $consultation->provider_id)->first();

            // check is favorite
            $check_fav = Favorite::where(['user_id' => $uid, 'favorite' => $consultation->userData->id])->count();

            $check_fav > 0 ? $consultation->userData->isFav = 1 : $consultation->userData->isFav = 0;

            // rating
            $getRating = Rating::where(['user_id' => $consultation->provider_id]);

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $consultation->userData->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $consultation->userData->rating = 0;
            }
            $x++;
        }

        return $this->apiResponse($consultations, '', 200);
    }

    public function my_prev_consultations(Request $request)
    {
        $uid = $request->input('user_id');

        $consultations = Consultation::leftJoin('specializations', 'specializations.id', '=', 'consultations.cat_id')
            ->select('consultations.*', 'specializations.title')
            ->where(['consultations.user_id' => $uid, 'consultations.status' => 2])
            ->paginate(20);

        foreach ($consultations as $consultation) {
            $consultation->time = DB::table('times')->where('id', $consultation->time_id)->first()->theTime;
            // time stamp
            $date = new \DateTime($consultation->booking_date.' '.$consultation->theTime);
            $consultation->timeStamp = $date->getTimestamp();

            // user data
            $consultation->userData = User::select('id','name','email','phone','avatar','experience_years','service_price','visibility','authenticate')->where('id', $consultation->provider_id)->first();
            
            // check is favorite
            $check_fav = Favorite::where(['user_id' => $uid, 'favorite' => $consultation->userData->id])->count();

            $check_fav > 0 ? $consultation->userData->isFav = 1 : $consultation->userData->isFav = 0;

            // rating
            $getRating = Rating::where(['user_id' => $consultation->provider_id]);

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $consultation->userData->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $consultation->userData->rating = 0;
            }
        }

        return $this->apiResponse($consultations, '', 200);
    }

    public function clients_consultations(Request $request)
    {
        $uid = $request->input('user_id');

        $consultations = Consultation::leftJoin('specializations', 'specializations.id', '=', 'consultations.cat_id')
            ->select('consultations.*', 'specializations.title')
            ->where('consultations.provider_id' , $uid)
            ->where('consultations.status', '!=' , 2)
            ->where('consultations.status', '!=' , 3)
            ->paginate(20);
        $x=0;
        foreach ($consultations as $consultation) {
            // check consultation time
            $consultation->time = DB::table('times')->where('id', $consultation->time_id)->first()->theTime;
            $time = strtotime($consultation->time);
            $endTime = date("H:i:s", strtotime('+30 minutes', $time));

            $time1 = new \DateTime($this->current_time);
            $time2 = new \DateTime($endTime);

            $diff = $time1->diff($time2);

            $minutes = ($diff->days * 24 * 60) +
                ($diff->h * 60) + $diff->i;

            if($consultation->booking_date <= $this->current_date && $this->current_time >= $endTime && $minutes >= 30 ){
                Consultation::where(['id' => $consultation->id])->update(['status' => 2]);
                unset($consultations[$x]);
            }

            // time stamp
            $date = new \DateTime($consultation->booking_date.' '.$consultation->theTime);
            $consultation->timeStamp = $date->getTimestamp();

            //user data
            $consultation->userData = User::select('id','name','email','phone','avatar','experience_years','service_price','visibility','authenticate')->where('id', $consultation->user_id)->first();

            // check is favorite
            $check_fav = Favorite::where(['user_id' => $uid, 'favorite' => $consultation->userData->id])->count();

            $check_fav > 0 ? $consultation->userData->isFav = 1 : $consultation->userData->isFav = 0;

            // rating
            $getRating = Rating::where(['user_id' => $consultation->provider_id]);

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $consultation->userData->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $consultation->userData->rating = 0;
            }
            $x++;
        }

        return $this->apiResponse($consultations, '', 200);
    }

    public function clients_prev_consultations(Request $request)
    {
        $uid = $request->input('user_id');

        $consultations = Consultation::leftJoin('specializations', 'specializations.id', '=', 'consultations.cat_id')
            ->select('consultations.*', 'specializations.title')
            ->where('consultations.provider_id' , $uid)
            ->where('consultations.status', 2)
            ->paginate(20);

        foreach ($consultations as $consultation) {
            $consultation->time = DB::table('times')->where('id', $consultation->time_id)->first()->theTime;

            // time stamp
            $date = new \DateTime($consultation->booking_date.' '.$consultation->theTime);
            $consultation->timeStamp = $date->getTimestamp();

            // user data
            $consultation->userData = User::select('id','name','email','phone','avatar','experience_years','service_price','visibility','authenticate')->where('id', $consultation->user_id)->first();

            // check is favorite
            $check_fav = Favorite::where(['user_id' => $uid, 'favorite' => $consultation->userData->id])->count();

            $check_fav > 0 ? $consultation->userData->isFav = 1 : $consultation->userData->isFav = 0;

            // rating
            $getRating = Rating::where(['user_id' => $consultation->provider_id]);

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $consultation->userData->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $consultation->userData->rating = 0;
            }
        }

        return $this->apiResponse($consultations, '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * make consultation
     */
    public function store(Request $request)
    {
        $uid = $request->input('user_id');
        $pid = $request->input('provider_id');

        if($request->has('status') && $request->input('status') == 4){
            $price = 0;
            $tid = $request->input('time_id');
        }else{
            $price = User::find($pid)->service_price;
            $tid = $request->input('time_id');
        }

        $cid = $request->input('cat_id');
        $booking_date = $request->input('booking_date') != null ? $request->input('booking_date') : date('Y-m-d');
        $description = $request->input('description');

        $consultation = new Consultation();
        $consultation->cat_id = $cid;
        $consultation->user_id = $uid;
        $consultation->provider_id = $pid;
        $consultation->time_id = $tid;
        $consultation->description = $description;
        $consultation->price = $price + (($price * 10) / 100);
        $consultation->booking_date = $booking_date;

        if($request->has('status') && $request->input('status') == 4){
            $consultation->status = 4;
        }

        $consultation->save();

        $chat = new Chat();
        $chat->service_id = $consultation->id;
        $chat->type = 'consultation';
        $chat->time_id = $tid;
        $chat->chat_date = $booking_date;
        $chat->save();

        $result = Consultation::leftJoin('specializations', 'specializations.id', '=', 'consultations.cat_id')
            ->leftJoin('times', 'times.id', '=', 'consultations.time_id')
            ->select('consultations.*', 'times.theTime')
            ->where('consultations.id', '=', $consultation->id)
            ->first();

        $result->client = User::find($uid);
        $result->provider = User::find($pid);

        $providerTokens = json_decode($result->provider->tokens);

        $providerTokensArray = [];
        for ($x=0; $x < count($providerTokens->devices); $x++) {
            array_push($providerTokensArray, $providerTokens->devices[$x]->token);
        }

        $this->notificationApiResponse('لديك حجز إستشارة جديدة', $result->client->name.'لديك حجز إستشارة جديدة من العميل ', $providerTokensArray);

        return $this->apiResponse($result, 'تم الحجز بنجاح', 201);

    }

//    public function bookingNow(Request $request){
//        $uid = $request->input('user_id');
//        $pid = $request->input('provider_id');
//
//        $booking_date = date('Y-m-d');
//
//        $check_calendar = Calendar::select("id","work_time")
//            ->where(['user_id' => $pid, 'work_date' => $booking_date]);
//
//        if($check_calendar->count() > 0) {
//            $calendar = $check_calendar->first();
//
//            $work_times = DB::table('times')
//                ->select('times.id','times.theTime')
//                ->whereIn('times.id', json_decode($calendar->work_time))
//                ->orderBy('times.id', 'asc')
//                ->get();
//
//            $results = [];
//
//            $time1 = new \DateTime($this->current_time);
//
//            foreach ($work_times as $work_time){
//                // check consultation time
//                $time = strtotime($work_time->theTime);
//
//                $endTime = date("H:i:s", strtotime('+30 minutes', $time));
//
//                $time2 = new \DateTime($endTime);
//
//                $diff = $time1->diff($time2);
//
//                $minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
//
//                if($minutes <= 30){
//                    array_push($results, $work_time);
//                }
//            }
//
//            dd($results);
//
//            $provider = User::find($pid);
//            $price = $provider->service_price;
//
//            $cid = Specialization::find(explode(',', $provider->specialization)[0])->id;
//            $tid = $request->input('time_id');
//
//            $consultation = new Consultation();
//            $consultation->cat_id = $cid;
//            $consultation->user_id = $uid;
//            $consultation->provider_id = $pid;
//            $consultation->time_id = $tid;
//            $consultation->price = $price + (($price * 10) / 100);
//            $consultation->booking_date = $booking_date;
//            $consultation->save();
//
//            $chat = new Chat();
//            $chat->service_id = $consultation->id;
//            $chat->type = 'consultation';
//            $chat->time_id = $tid;
//            $chat->chat_date = $booking_date;
//            $chat->save();
//
//            $result = Consultation::leftJoin('consultations_categories', 'consultations_categories.id', '=', 'consultations.cat_id')
//                ->leftJoin('times', 'times.id', '=', 'consultations.time_id')
//                ->select('consultations.*', 'times.theTime')
//                ->where('consultations.id', '=', $consultation->id)
//                ->first();
//
//            $result->client = User::find($uid);
//            $result->provider = User::find($pid);
//
//            $providerTokens = json_decode($result->provider->tokens);
//
//            $providerTokensArray = [];
//            for ($x=0; $x < count($providerTokens->devices); $x++) {
//                array_push($providerTokensArray, $providerTokens->devices[$x]->token);
//            }
//
//            $this->notificationApiResponse('لديك حجز إستشارة جديدة', $result->client->name.'لديك حجز إستشارة جديدة من العميل ', $providerTokensArray);
//
//            return $this->apiResponse($result, 'تم الحجز بنجاح', 201);
//        }else{
//            return $this->apiResponse(null, 'لا يوجد مواعيد', 400);
//        }
//    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consultation = Consultation::leftJoin('consultations_categories', 'consultations_categories.id', '=', 'consultations.cat_id')
            ->leftJoin('times', 'times.id', '=', 'consultations.time_id')
            ->select('consultations.*', 'times.theTime','consultations_categories.name')
            ->where('consultations.id', '=', $id)->first();

        // check consultation time
        $time = strtotime($consultation->theTime);
        $endTime = date("H:i:s", strtotime('+30 minutes', $time));

        if($endTime <= $this->current_time && $consultation->booking_date <= $this->current_date){
            Consultation::where(['id' => $consultation->id])->update(['status' => 2]);
        }

        $date = new \DateTime($consultation->booking_date.' '.$consultation->theTime);
        $consultation->timeStamp = $date->getTimestamp();

        $consultation->client = User::find($consultation->user_id);
        $consultation->provider = User::find($consultation->provider_id);

        return $this->apiResponse($consultation, '', 200);

    }

    /*
     * *****************************************
     * *****************************************
     * Update consultation status
     * */

    public function updateStatus(Request $request ,$id){
        $uid = $request->input('user_id');
        $status = $request->input('status');

        $check = Consultation::whereRaw("id = '$id' AND (provider_id = $uid OR user_id = $uid)");

        if($check->count() > 0){
            $result = $check->first();

            $result_check = Consultation::where(
                ['time_id' => $result->time_id, 'booking_date' => $result->booking_date, 'provider_id' => $result->provider_id]
            )->where('id', '!=', $id);

            if($result_check->count() > 0){
                if($status == 1 && $result_check->first()->status == 1){
                    return $this->apiResponse(null, 'لديك إستشارة محجوزه بالفعل',400);
                }else{
                    $user = User::find($result->user_id);

                    $userTokens = json_decode($user->tokens);

                    $userTokensArray = [];

                    for ($x=0; $x < count($userTokens->devices); $x++) {
                        array_push($userTokensArray, $userTokens->devices[$x]->token);
                    }

                    $this->notificationApiResponse('تم رفض طلبك', 'تم رفض طلبك', $userTokensArray);

                    $result_check->delete();
                }
            }

            $check->update(['status' => $status]);

            return $this->apiResponse(null, 'تم بنجاح',201);
        }

        return $this->apiResponse(null, 'فشل ',400);
    }

}
