<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class supervisorPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }
    public function update()
    {
        if(Auth::User()->type == "supervisor")
        {
            $privil=json_decode(auth::user()->privilege, true);
            IF( $privil['edit'] ==0)
            {
                return false;


            }else{
                return true;
            }
        }elseif (Auth::User()->type == "admin")
                     return true;

    }
}
