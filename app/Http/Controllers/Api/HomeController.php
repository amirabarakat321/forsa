<?php

namespace App\Http\Controllers\Api;

use App\Consultation;
use App\Favorite;
use App\Project;
use App\Rating;
use App\Specialization;
use App\Study;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use ApiReturn;

    /*
     * Main statistics
     * */


    public function index(Request $request){
        $uid = $request->input('user_id');

        $user_projects = Project::where('user_id', $uid)->count();
        $user_studies = Study::where('user_id', $uid)->count();

        $projects = Project::count();
        $studies = Study::count();

        $experts = User::where(['type' => 'expert', 'status' => 1])->count();
        $matures = User::where(['type' => 'amateur', 'status' => 1])->count();

        return $this->apiResponse([
            'user_projects' => $user_projects,
            'user_studies' => $user_studies,
            'projects' => $projects,
            'studies' => $studies,
            'experts' => $experts,
            'amateur' => $matures
        ],'', 200);
    }


    /*
     * Filter and search
     * */

    public function filter(Request $request)
    {
        $uid = $request->input('user_id');

        $search_type = $request->input('search_type');

        $types = [
            'users' => [
                'user_type' => $request->input('user_type'),
                'specialization' => $request->input('specialization'),
                'service_price_start' => $request->input('service_price_start'),
                'service_price_max' => $request->input('service_price_max'),
                'visibility' => $request->input('visibility')
            ],
            'consultations' => [
                'provider_type' => $request->input('provider_type'),
                'cat_id' => $request->input('cat_id'),
                'date' => $request->input('date')
            ],
        ];

       if(isset($types[$search_type])){
           $search_array = [];

           /**
            * users search
            */
           if($search_type == 'users'){
               if($request->has('specialization') OR $request->has('user_type') OR $request->has('service_price_start') OR $request->has('service_price_max') OR $request->has('visibility')){
                   $types['users']['service_price_start'] != null ? array_push($search_array, 'service_price >= '.$types['users']['service_price_start']) : '';
                   $types['users']['service_price_max'] != null ?  array_push($search_array, 'service_price <= '.$types['users']['service_price_max']) : '';
                   $types['users']['visibility'] != null ?  array_push($search_array, 'visibility = '.$types['users']['visibility']) : '';
                   $types['users']['user_type'] != null ? array_push($search_array, "type = '".$types['users']['user_type']."'") : '';
                   $types['users']['specialization'] != null ? array_push($search_array, 'FIND_IN_SET('.$types['users']['specialization'].', specializations) != 0') : '';

                   $q = 'status = 1 AND '.implode(' AND ', $search_array);

                   $result = DB::table('users')->select('*')->whereRaw($q)->paginate(20);

               }else{
                   $result = DB::table('users')->where('status', 1)->select('*')->paginate(20);
               }

               foreach ($result as $user){
                   $user->specializations = Specialization::whereIn('id', explode(',',$user->specializations))->get();

                   $user->studies = Study::where(['user_id' => $user->id])->count();
                   $user->projects = Project::where(['user_id' => $user->id])->count();
                   $user->consultations = Consultation::where(['user_id' => $user->id])->count();

                   if($request->has('user_id')){
                       $uid = $request->input('user_id');
                       $check_fav = Favorite::where(['user_id' => $uid, 'favorite' => $user->id])->count();

                       $check_fav > 0 ? $user->isFav = 1 : $user->isFav = 0;
                   }else{
                       $user->isFav = 0;
                   }

                   // rating
                   $getRating = Rating::where(['user_id' => $user->id]);

                   if($getRating->count() > 0){
                       $ratingsSum = $getRating->get();
                       $ratingsArray = [];
                       foreach ($ratingsSum as $rate){
                           $rate->userInfo = User::select("id","avatar","name")->find($rate->rating_from);
                           array_push($ratingsArray, $rate->rating);
                       }

                       $user->rating = array_sum($ratingsArray) / $getRating->count();
                   }else{
                       $user->rating = 0;
                   }
               }

               // return query result
               return $this->apiResponse($result, '', 200);

           }

           /**
            * **************************************************
            * End Search Users
            * consultations search
            * my_prev_consultations
            * my_consultations
            * clients_prev_consultations
            * clients_consultations
            * ***************************************************
            */

           if($search_type == 'consultations'){

               $consultation_types = [
                   'my_consultations' => " AND consultations.user_id = $uid AND consultations.status = 0",
                   'my_prev_consultations' => " AND consultations.user_id = $uid AND consultations.status = 1",
                   'clients_prev_consultations' => " AND consultations.provider_id = $uid AND consultations.status = 1",
                   'clients_consultations' => " AND consultations.provider_id = $uid AND consultations.status = 0",
               ];

               if($request->has('provider_type') OR $request->has('consultation_type') OR $request->has('cat_id') OR $request->has('date')){
                   $types['consultations']['cat_id'] != null ? array_push($search_array, 'consultations.cat_id = '.$types['consultations']['cat_id']) : '';
                   $types['consultations']['date'] != null ? array_push($search_array, "consultations.booking_date = '".$types['consultations']['date']."'") : '';

                   if($types['consultations']['provider_type'] != null){
                       $ptype = $types['consultations']['provider_type'];
                       // query
                       $q = "users.type = '$ptype' AND ".implode(' AND ', $search_array);

                       if($request->has('consultation_type')){
                           if(isset($consultation_types[$request->input('consultation_type')])){
                               $q .= $consultation_types[$request->input('consultation_type')];
                           }
                       }

                       $result = DB::table('consultations')
                           ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
                           ->leftJoin('consultations_categories', 'consultations_categories.id', '=', 'consultations.cat_id')
                           ->leftJoin('times', 'times.id', '=', 'consultations.time_id')
                           ->select('consultations.*', 'times.theTime')
                           ->whereRaw($q)
                           ->orderBy('consultations.id', 'desc')
                           ->paginate(20);
                   }else{
                       $q = implode(' AND ', $search_array);

                       if($request->has('consultation_type')){
                           if(isset($consultation_types[$request->input('consultation_type')])){
                               $q .= $consultation_types[$request->input('consultation_type')];
                           }
                       }

                       $result = DB::table('consultations')
                           ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
                           ->leftJoin('consultations_categories', 'consultations_categories.id', '=', 'consultations.cat_id')
                           ->leftJoin('times', 'times.id', '=', 'consultations.time_id')
                           ->select('consultations.*', 'times.theTime')
                           ->whereRaw($q)
                           ->orderBy('consultations.id', 'desc')
                           ->paginate(20);
                   }

               }else{
                   $q = '';

                   if($request->has('consultation_type')){
                       if(isset($consultation_types[$request->input('consultation_type')])){
                           $q .= $consultation_types[$request->input('consultation_type')];
                       }
                   }

                   if($q != ''){
                       $result = DB::table('consultations')
                           ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
                           ->leftJoin('consultations_categories', 'consultations_categories.id', '=', 'consultations.cat_id')
                           ->leftJoin('times', 'times.id', '=', 'consultations.time_id')
                           ->select('consultations.*', 'times.theTime')
                           ->whereRaw($q)
                           ->orderBy('consultations.id', 'desc')
                           ->paginate(20);
                   }else{
                       $result = DB::table('consultations')
                           ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
                           ->leftJoin('consultations_categories', 'consultations_categories.id', '=', 'consultations.cat_id')
                           ->leftJoin('times', 'times.id', '=', 'consultations.time_id')
                           ->select('consultations.*', 'times.theTime')
                           ->orderBy('consultations.id', 'desc')
                           ->paginate(20);
                   }

               }

               foreach ($result as $user){
                   $user->client = User::find($user->user_id);
                   $user->provider = User::find($user->provider_id);
               }

               // return query result
               return $this->apiResponse($result, '', 200);
           }

       }else{
           return $this->apiResponse(null, 'error', 400);
       }
    }
}
