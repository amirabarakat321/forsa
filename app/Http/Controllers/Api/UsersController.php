<?php

namespace App\Http\Controllers\Api;

use App\Calendar;
use App\Consultation;
use App\Documentation;
use App\Favorite;
use App\PasswordReset;
use App\Phone;
use App\Portfolio;
use App\Portfolio_file;
use App\Project;
use App\Rating;
use App\Specialization;
use App\Study;
use App\User;
use App\UserSetting;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    use ApiReturn;
    use NotificationApiReturn;
    use SmsApiReturn;

    /*
     * user check phone before register
     * */
    public function active_phone(Request $request){
        $phone = $request->input('phone');

        $check = User::where(['phone' => $phone])->count();

        if($check > 0){
            return $this->apiResponse(null, trans('custom.register-before'),400);
        }

        $chk_phone = Phone::where(['phone' => $phone]);

        if($chk_phone->count() > 0){
            $chk_phone->delete();
        }

        $code = str_random(4);

        $make_request = new Phone();
        $make_request->phone = $phone;
        $make_request->code = $code;
        $make_request->save();

        $this->smsApiResponse($phone,'Your Code is '.$code);

        return $this->apiResponse(null, trans('custom.success-code-sent-to-phone'),201);

    }

    public function check_phone(Request $request)
    {
        $chk = Phone::where(['phone' => $request->input('phone'), 'code' => $request->input('code')]);

        if($chk->count() > 0){
            $chk->update(['status' => 1]);
            return $this->apiResponse(null, trans('custom.success-register'), 201);
        }

        return $this->apiResponse(null, trans('custom.wrong-number'), 401);

    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * Login user
     */
    public function index(Request $request)
    {
        $email = $request->input('user');
        $token = $request->input('token');

        if(is_numeric($email)){
            $get = User::where(['phone' => $email, 'status' => 1]);
        }else{
            $get = User::where(['email' => $email, 'status' => 1]);
        }

        // check if user exist
        if($get->count() > 0){
            // get user data
            $result = $get->first();
            // check password
            $password = Hash::check($request->input('password'), $result->password);

            if($password != false){
                $result->specializations = Specialization::whereIn('id', explode(',',$result->specializations))->get();
                $id = $result->id;

                $result->studies = Study::where(['user_id' => $id])->count();
                $result->projects = Project::where(['user_id' => $id])->count();
                $result->consultations = Consultation::where(['user_id' => $id])->count();

                // rating
                $getRating = Rating::where(['user_id' => $id]);

                if($getRating->count() > 0){
                    $ratingsSum = $getRating->get();
                    $ratingsArray = [];
                    foreach ($ratingsSum as $rate){
                        $rate->userInfo = User::select("id","avatar","name")->find($rate->rating_from);
                        array_push($ratingsArray, $rate->rating);
                    }

                    $result->rating = array_sum($ratingsArray) / $getRating->count();
                }else{
                    $result->rating = 0;
                }

                $tokens = $result->tokens != null ? json_decode($result->tokens) : '';

                if ($tokens != null) {
                    $TokensArray = [];

                    for ($x = 0; $x < count($tokens->devices); $x++) {
                        array_push($TokensArray, $tokens->devices[$x]->token);
                    }

                    foreach ($tokens as $device) {
                        if (!in_array($token, $TokensArray)) {
                            $newToken = [
                                'deviceType' => $request->input('deviceType'),
                                'token' => $token
                            ];

                            array_push($device, $newToken);

                            $get->update(['tokens' => json_encode(['devices' => $device])]);
                        }
                    }
                }else{
                    $newToken['devices'] = [
                        [
                            'deviceType' => $request->input('deviceType'),
                            'token' => $token,
                        ],
                    ];

                    $get->update(['tokens' => json_encode($newToken)]);
                }

                return $this->apiResponse($result, trans('custom.success-login'), 201);

            }else{

                return $this->apiResponse(null, trans('custom.failed-login'), 401);
            }

        }else{
            return $this->apiResponse(null, trans('custom.failed-login'), 401);
        }
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:6',
            'email' => 'required|unique:users|email',
            'password' => 'required|confirmed:password_confirmation|min:6|max:20',
            'password_confirmation' => 'required',
            'phone' => 'required:numeral|unique:users'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(
                null,$validator->errors()->first(),401
            );
        }

        $tokens['devices'] = [
            [
                'deviceType' => $request->input('deviceType'),
                'token' => $request->input('token'),
            ],
        ];

        $request['tokens'] = json_encode($tokens);

        $request['password'] = Hash::make($request->input('password'));

        $user = User::create($request->except(['deviceType', 'token', 'password_confirmation']));

        if($request->has('avatar')){
            $path = Storage::putFile('users', $request->file('avatar'));
            $url = 'https://'.$request->getHost().'/forsaTanya/storage/app/'.$path;
            User::where(['id' => $user->id])->update(['avatar' => $url]);
        }

        $result = User::find($user->id);
        $result->specializations = Specialization::whereIn('id', explode(',',$result->specializations))->get();
        $id = $result->id;

        $result->studies = Study::where(['user_id' => $id])->count();
        $result->projects = Project::where(['user_id' => $id])->count();
        $result->consultations = Consultation::where(['user_id' => $id])->count();

        // rating
        $getRating = Rating::where(['user_id' => $id]);

        if($getRating->count() > 0){
            $ratingsSum = $getRating->get();
            $ratingsArray = [];
            foreach ($ratingsSum as $rate){
                $rate->userInfo = User::select("id","avatar","name")->find($rate->rating_from);
                array_push($ratingsArray, $rate->rating);
            }

            $result->rating = array_sum($ratingsArray) / $getRating->count();
        }else{
            $result->rating = 0;
        }

        return $this->apiResponse(
            $result, trans('custom.success-register'), 201
        );

    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * upload user work and portfolio
     * */

    public function add_portfolio(Request $request){
        $title = $request->input('title');
        $files = $request->file('file');
        $uid = $request->input('user_id');

        $portfolio = new Portfolio();
        $portfolio->user_id = $uid;
        $portfolio->title = $title;
        $portfolio->save();

        foreach ($files as $file){
            $extension =  $file->clientExtension();
            $path = Storage::putFile('portfolio', $file);
            $url = 'https://'.$request->getHttpHost().'/forsaTanya/storage/app/'.$path;

            $pfiles = new Portfolio_file();
            $pfiles->portfolio_id = $portfolio->id;
            $pfiles->file = $url;
            $pfiles->ext = $extension;
            $pfiles->save();
        }

        $portfolio->files = Portfolio_file::where(['portfolio_id' => $portfolio->id])->get();

        return $this->apiResponse($portfolio, trans('custom.success-add'), 201);

    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * **************************************
     * ************************************
     * Show Portfolio
     * */

    public function portfolio($id){
        /*
        * user portfolio
        * */
        $portfolio_check = Portfolio::where('user_id', $id);

        if($portfolio_check->count() > 0){
            $portfolios = $portfolio_check->get();
            foreach ($portfolios as $portfolio){
                $portfolio->files = Portfolio_file::where('portfolio_id', $portfolio->id)->get();
            }

            return $this->apiResponse($portfolios, '', 200);
        }

        $portfolio = null;


        return $this->apiResponse($portfolio, '', 400);

    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * upload user documentations
     * */

    public function add_documentations(Request $request){
        $title = $request->input('title');
        $files = $request->file('file');
        $uid = $request->input('user_id');

        foreach ($files as $file){
            $extension =  $file->clientExtension();
            $path = Storage::putFile('documentations', $file);
            $url = 'https://'.$request->getHttpHost().'/forsaTanya/storage/app/'.$path;

            $pfiles = new Documentation();
            $pfiles->user_id = $uid;
            $pfiles->title = $title;
            $pfiles->file = $url;
            $pfiles->ext = $extension;
            $pfiles->save();
        }

        $documentation = Documentation::where(['user_id' => $uid])->get();

        return $this->apiResponse($documentation, trans('custom.success-add'), 201);

    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // get user profile
        $profile = User::find($id);

        $profile->specializations = Specialization::whereIn('id', explode(',',$profile->specializations))->get();

        $profile->studies = Study::where(['user_id' => $id])->count();
        $profile->projects = Project::where(['user_id' => $id])->count();
        $profile->consultations = Consultation::where(['user_id' => $id])->count();

        if($request->has('user_id')){
            $uid = $request->input('user_id');
            $check_fav = Favorite::where(['user_id' => $uid, 'favorite' => $id])->count();

            $check_fav > 0 ? $profile->isFav = 1 : $profile->isFav = 0;
        }else{
            $profile->isFav = 0;
        }

        // rating
        $getRating = Rating::where(['user_id' => $id]);

        if($getRating->count() > 0){
            $ratingsSum = $getRating->get();
            $ratingsArray = [];
            foreach ($ratingsSum as $rate){
                $rate->userInfo = User::select("id","avatar","name")->find($rate->rating_from);
                array_push($ratingsArray, $rate->rating);
            }

            $profile->rating = array_sum($ratingsArray) / $getRating->count();
        }else{
            $profile->rating = 0;
        }

        // return response
        return $this->apiResponse($profile, '', 200);
    }


    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     *
     * Show All Users By type
     * type => expert, mature
     */

    public function getUsers(Request $request){
        $users = User::where(['type' => $request->input('type')])->paginate(20);

        foreach ($users as $user){
            if($request->has('user_id')){
                $uid = $request->input('user_id');
                $check_fav = Favorite::where(['user_id' => $uid, 'favorite' => $user->id])->count();

                $check_fav > 0 ? $user->isFav = 1 : $user->isFav = 0;
            }else{
                $user->isFav = 0;
            }

            $user->specializations = Specialization::whereIn('id', explode(',',$user->specializations))->get();
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

        return $this->apiResponse($users, '', 200);
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     *
     * Show All work days
     */

    public function work_days(Request $request){

        $days = Calendar::where('user_id', $request->input('user_id'))
            ->select('work_date','work_time')
            ->where('work_date', '>=', date('Y-m-d'))
            ->get();

        foreach ($days as $day){

            $times = json_decode($day->work_time);

            $day->times = DB::table('times')->whereIn('id', $times)->get();
        }

        return $this->apiResponse($days, '', 200);
    }
    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|min:6',
            'email' => 'email|unique:users,email,'.$id,
            'password' => 'confirmed:password_confirmation',
            'phone' => 'numeric|unique:users,phone,'.$id,
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(
                null,$validator->errors()->first(),401
            );
        }

        if($request->has('avatar')){
            $path = Storage::putFile('users', $request->file('avatar'));
            $url = 'https://'.$request->getHost().'/forsaTanya/storage/app/'.$path;

            User::where(['id' => $id])->update(['avatar' => $url]);
        }

        if($request->input('password') != null){
            $request['password'] = Hash::make($request->input('password'));
        }

        $update = User::where(['id' => $id])
            ->update($request->except(['deviceType', 'token', 'password_confirmation','avatar']));

        if($update == true){
            $user = User::find($id);
            $user->specializations = Specialization::whereIn('id', explode(',',$user->specializations))->get();

            $user->studies = Study::where(['user_id' => $id])->count();
            $user->projects = Project::where(['user_id' => $id])->count();
            $user->consultations = Consultation::where(['user_id' => $id])->count();

            // rating
            $getRating = Rating::where(['user_id' => $id]);

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

            return $this->apiResponse($user, trans('custom.success-edit'), 201);
        }

        return $this->apiResponse(null, 'failed update', 400);
    }

    /*
     * Rating user
     * */

    public function rating(Request $request){
        $uid = $request->input('user_id');

        Rating::create($request->all());

        return $this->apiResponse(User::find($uid), trans('custom.success-rating'), 201);
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * get specializations
     * */

    public function specializations()
    {
        $sp = Specialization::get();

        return $this->apiResponse($sp, '', 200);
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * make setting for user
     * */

    public function settings(Request $request)
    {
        $chk = UserSetting::where(['user_id' => $request->input('user_id')]);

        $getRating = Rating::where(['user_id' => $request->input('user_id')]);

        if($chk->count() > 0){
            UserSetting::where(['user_id' => $request->input('user_id')])->update($request->all());
            $user = User::find($chk->first()->user_id);
            $setting = $chk->first();
            $user->settings = $setting;

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $user->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $user->rating = 0;
            }

            return $this->apiResponse($user, trans('custom.success-edit'), 201);
        }else{
            $setting = UserSetting::create($request->all());
            $user = User::find($request->input('user_id'));
            $user->settings = $setting;

            if($getRating->count() > 0){
                $ratingsSum = $getRating->get();
                $ratingsArray = [];
                foreach ($ratingsSum as $rate){
                    array_push($ratingsArray, $rate->rating);
                }

                $user->rating = array_sum($ratingsArray) / $getRating->count();
            }else{
                $user->rating = 0;
            }

            return $this->apiResponse($user, trans('custom.success-add'), 201);

        }
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * Comments and rating
     * */

    public function comments($id){
        // rating
        $getRating = Rating::join('users', 'users.id', '=', 'ratings.rating_from')
            ->select('ratings.id','ratings.comment','ratings.rating','ratings.type','ratings.status','ratings.user_id','ratings.rating_from','users.name','users.avatar')
            ->where(['user_id' => $id]);

        if($getRating->count() > 0){
            $comments = $getRating->paginate(20);
            return $this->apiResponse($comments,'',200);
        }

        $comments = null;

        return $this->apiResponse($comments,'',400);
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
         * user Documents
         * */

    public function documents($id){
        /*
         * user Documents
         * */
        $documents_check = Documentation::where('user_id', $id);

        if($documents_check->count() > 0){
            $documents = $documents_check->get();
            return $this->apiResponse($documents,'',200);
        }

        $documents = null;

        return $this->apiResponse($documents,'',400);
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * Password RESET
     * */

    public function forgetPassword(Request $request)
    {
        $email = $request->input('email');
        if(User::where(['email' => $email])->count() > 0){
            PasswordReset::where(['email' => $email])->delete();
            $pr = new PasswordReset();
            $pr->email = $email;
            $pr->token =  str_random(6);
            $pr->save();

            return $this->apiResponse(['code' => $pr->token], trans('custom.success-code-sent-to-email'), 201);
        }

        return $this->apiResponse(null, trans('custom.failed-email'), 400);

    }
    public function update_password(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'confirmed:password_confirmation',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(
                null,$validator->errors()->first(),401
            );
        }

        $user_id = $request->input('email');
        $password = $request->input('password');

        User::where(['email' => $user_id])->update(['password' => Hash::make($password)]);

        return $this->apiResponse(['user' => User::where('email', $user_id)->first()], trans('custom.success-update-password'), 201);
    }

    /***************************************************************************
     * *************************************************************************
     * ************************************************************************
     * user logout
     * */

    public function logout(Request $request){
        $uid = $request->input('user_id');
        $token = $request->input('token');

        $tokens = json_decode(User::find($uid)->tokens);

        if ($tokens->devices != '') {
            $TokensArray = [];
            $x=0;
            foreach ($tokens as $device) {
                if ($device[$x]->token != $token) {

                    array_push($TokensArray, $device[$x]);

                    $x++;
                }
            }

            if(!empty($TokensArray)){
                User::where(['id' => $uid])->update(['tokens' => json_encode(['devices' => $TokensArray])]);
            }else{
                User::where(['id' => $uid])->update(['tokens' => null]);
            }

            return $this->apiResponse(null, 'success logout', 200);
        }
    }

}
