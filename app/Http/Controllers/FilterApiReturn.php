<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait FilterApiReturn {
    public function filterApiResponse (Request $request, $search_type){

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
                    'my_consultations' => " AND consultations.status = 0",
                    'my_prev_consultations' => " AND consultations.status = 1",
                    'clients_prev_consultations' => " AND consultations.status = 1",
                    'clients_consultations' => " AND consultations.status = 0",
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
                            ->select('*')
                            ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
//                           ->where('consultations.user_id', '=', $uid)
//                           ->where('consultations.status', '!=', 2)
                            ->whereRaw($q)
                            ->paginate(20);
                    }else{
                        $q = implode(' AND ', $search_array);

                        if($request->has('consultation_type')){
                            if(isset($consultation_types[$request->input('consultation_type')])){
                                $q .= $consultation_types[$request->input('consultation_type')];
                            }
                        }

                        $result = DB::table('consultations')
                            ->select('*')
                            ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
//                           ->where('consultations.user_id', '=', $uid)
                            ->whereRaw($q)
                            ->paginate(20);
                    }

                }else{
                    $q = '';

                    if($request->has('consultation_type')){
                        if(isset($consultation_types[$request->input('consultation_type')])){
                            $q .= $consultation_types[$request->input('consultation_type')];
                        }
                    }

                    $result = DB::table('consultations')
                        ->leftJoin('users', 'users.id', '=', 'consultations.provider_id')
//                       ->where('consultations.user_id', '=', $uid)
                        ->whereRaw($q)
                        ->select('*')
                        ->paginate(20);
                }

                // return query result
                return $this->apiResponse($result, '', 200);
            }

        }else{
            return $this->apiResponse(null, 'error', 400);
        }
    }
}
