<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageuserController extends Controller
{    
    public function loginadmin(Request $request) {
              $email =$request['email'];
              $password =$request['password'];
        if ( Auth::attempt( ['email' => $email, 'password' => $password, 'type' => "admin",'status'=>1] ) ) {
            // Authentication passed...
            return redirect()->intended( '/home' );
        }elseif ( Auth::attempt( ['email' => $email, 'password' => $password, 'type' => "supervisor",'status'=>1] ) ) {
            // Authentication passed...
            return redirect()->intended( '/home' );
        }else{
            return redirect()->intended( '/' );
        }
    }
}
