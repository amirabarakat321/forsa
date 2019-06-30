<?php

namespace App\Http\Controllers\Api;

use App\Favorite;
use App\Rating;
use App\Specialization;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoritesController extends Controller
{
    use ApiReturn;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uid = $request->input('user_id');
        $ftype = $request->input('favorite_type');

        // Favorite users
        if($ftype == 'users'){
            $favorites = Favorite::join('users', 'users.id', '=', 'favorites.favorite')->where('user_id', $uid)->paginate(20);

            foreach ($favorites as $favorite){
                $favorite->specializations = Specialization::whereIn('id', explode(',',$favorite->specializations))->get();

                // rating
                $getRating = Rating::where(['user_id' => $favorite->favorite]);

                if($getRating->count() > 0){
                    $ratingsSum = $getRating->get();
                    $ratingsArray = [];
                    foreach ($ratingsSum as $rate){
                        $rate->userInfo = User::select("id","avatar","name")->find($rate->rating_from);
                        array_push($ratingsArray, $rate->rating);
                    }

                    $favorite->rating = array_sum($ratingsArray) / $getRating->count();
                }else{
                    $favorite->rating = 0;
                }
            }

        }

        // favorite projects
        if($ftype == 'projects'){

        }

        // favorite studies
        if($ftype == 'studies'){

        }

        // result
        return $this->apiResponse($favorites, '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = $request->input('user_id');
        $fid = $request->input('favorite_id');
        $ftype = $request->input('favorite_type');

        $check = Favorite::where(['user_id' => $uid, 'favorite' => $fid]);

        if($check->count() > 0){
            $check->delete();
            return $this->apiResponse(null, 'تم الحذف من المفضلة', 201);
        }

        $favorite = new Favorite();
        $favorite->user_id = $uid;
        $favorite->favorite = $fid;
        $favorite->favorite_type = $ftype;
        $favorite->save();

        return $this->apiResponse(null, 'تم الإضافة للمفضلة', 201);

    }
}
