<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use App\User;
class AdminController extends Controller
{    
    public function __construct(){
        $this->middleware(['justadmin']);

       } 

    public function index() {
        $admins = DB::table('users')
            ->where('type', "supervisor")
            ->paginate(30);

        foreach ($admins as $adm ) {
            if($adm->status == 1) {
                $adm->clas='btn btn-sm btn-toggle active';
                $adm->sta='true';
            } elseif ($adm->status == 0) {
                $adm->clas='btn btn-sm btn-toggle ';
                $adm->sta='false';
            }
        }

        return view('admin.adminview')->with('admins',$admins);
    }

public function addadmin(Request $request) {

  
    $data = $this->validate(request(),[
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:100|unique:users,email',
                        'password' => 'min:6|required',

     ],[
                      'name.required'   => 'ادخل الاسم الاول' ,
                      'name.max'        => 'الاسم الاول كبير ',
                      'password.required'    => 'ادخل الرقم السري ',
                      'password.min'    => 'الرقم السري يجب ان يكون اكبر من 6 حروف',
                      'email.email'  => 'اكتب الابريد الالكتروني بطريقه صحيحه ',
                      'email.required'  => 'يجب ادخال البريد  الالكتروني ',
                      'email.unique'  => 'هذا البريد الالكتروني مستخدم ',
     ],[ ]);
    $requestData = $request->all();
    $pass= Hash::make($requestData['password']);
        if ($data){
         DB::table('users')->insert([
                   'email' =>$requestData['email'],
                   'name'  =>$requestData['name'],
                   'type' =>"supervisor", 
                   'status' =>1,
                   'password' =>$pass,
                            ]);
               return back()->with('success', 'تم الإضافة بنجاح');

        }      
    }
    
     public function editstatue($id) {
        
            $user= User::where('id',$id)->first();
            if($user->status == 0){
                $del= User::where('id',$id)
                    ->update(['status' =>1]);
            }elseif($user->status == 1){
                $del= User::where('id',$id)
                    ->update(['status' =>0]);
            }
       
        if($del){
            return Response(['success'=>"true"]);
        }else{
            return Response(['success'=>"false"]);
        }
    }

  public function delete($id)
    {
            $del=  User::where('id', $id)->delete();
        if($del){
            return Response(['success'=>true]);
        }else{
            return Response(['success'=>false]);
        }
    }

    public function edit( Request $request)
    { 

       $admin=DB::table('users')->where('id',(int)$request['id'])->first();
      if($request['password'] == null){
       if($request['email'] == $admin->email){

             $data = $this->validate(request(),[
                        'name' => 'required|max:255',

                ],[
                      'name.required'   => 'ادخل الاسم الاول' ,
                      'name.max'        => 'الاسم الاول كبير ',
                     
               ],[ ]);

       }elseif($request['email'] != $admin->email){
         $data = $this->validate(request(),[
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:100|unique:users,email',

                    ],[
                      'name.required'   => 'ادخل الاسم الاول' ,
                      'name.max'        => 'الاسم الاول كبير ',
                      
                      'password.min'    => 'الرقم السري يجب ان يكون اكبر من 6 حروف',
                      'email.email'  => 'اكتب الابريد الالكتروني بطريقه صحيحه ',
                      'email.required'  => 'يجب ادخال البريد  الالكتروني ',
                      'email.unique'  => 'هذا البريد الالكتروني مستخدم ',
                     ],[ ]);
       }

      }elseif ($request['password'] != null) {
        if($request['email'] == $admin->email){

             $data = $this->validate(request(),[
                        'name' => 'required|max:255',
                        'password' => 'min:6|required',


                ],[
                      'name.required'   => 'ادخل الاسم الاول' ,
                      'name.max'        => 'الاسم الاول كبير ',
                      'password.required'    => 'ادخل الرقم السري ',
                      'password.min'    => 'الرقم السري يجب ان يكون اكبر من 6 حروف',
                     
               ],[ ]);

       }elseif($request['email'] != $admin->email){
         $data = $this->validate(request(),[
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:100|unique:users,email',
                        'password' => 'min:6|required',


                    ],[
                      'name.required'   => 'ادخل الاسم الاول' ,
                      'name.max'        => 'الاسم الاول كبير ',
                      'password.required'    => 'ادخل الرقم السري ',
                      'password.min'    => 'الرقم السري يجب ان يكون اكبر من 6 حروف',
                      'email.email'  => 'اكتب الابريد الالكتروني بطريقه صحيحه ',
                      'email.required'  => 'يجب ادخال البريد  الالكتروني ',
                      'email.unique'  => 'هذا البريد الالكتروني مستخدم ',
                     ],[ ]);
       }
      }
    $requestData = $request->all();
     if($requestData['password']==null){
     
     $admin=DB::table('users')->where('id',(int)$requestData['id'])->first();
     $pass =$admin->password;
                 }else{
                  $pass= Hash::make($requestData['password']);
                 }
   
        if ($data){
         DB::table('users')->where('id',$requestData['id'])
                           ->update([
                             'email' =>$requestData['email'],
                             'name'  =>$requestData['name'],
                             'password' =>$pass,
                               ]);
               return back()->with('success', 'تم التعديل بنجاح');

        }      
    }
 public function search( Request $request)
    {
      
    $requestData = $request->all();

     if($requestData['adminname']==null){
     
     $admins=DB::table('users')->Where('type','=',"supervisor")->paginate(30);
   
                 }else{
                  $admins=DB::table('users')->whereIn('type',["supervisor"])->where('name', 'LIKE', "%{$requestData['adminname']}%")->paginate(30);
                 }
   
        foreach ($admins as $adm ) {
            if($adm->status == 1) {
                $adm->clas='btn btn-sm btn-toggle active';
                $adm->sta='true';
            } elseif ($adm->status == 0) {
                $adm->clas='btn btn-sm btn-toggle ';
                $adm->sta='false';
            }
        }

        return view('admin.adminview')->with('admins',$admins);
        
    }

}
