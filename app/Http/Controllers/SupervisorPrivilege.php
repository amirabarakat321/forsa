<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;


trait SupervisorPrivilege {
    public function viewCheck (){
        ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR
        if (auth::user()->type=="supervisor"){
            $privil=json_decode(auth::user()->privilege, true);
            IF( $privil['view'] ==0)
            {
                return(0);

            }else{
                return(1);
            }
        }else{
            return(1);
        }
    }
    public function addCheck (){
    ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR
    if (auth::user()->type=="supervisor"){

        $privil=json_decode(auth::user()->privilege, true);

        IF( $privil['add'] ==0)
        {
            return(0);

        }else{
            return(1);
        }
    }else{
        return(1);
    }
  }
    public function deleteCheck (){
        ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR
        if (auth::user()->type=="supervisor"){

            $privil=json_decode(auth::user()->privilege, true);
            IF( $privil['delete'] ==0) {
                return (0);
            }else{
                return(1);
            }
        }else{
            return(1);
        }
    }
    public function editCheck (){
      ////CHECK THE PRIVILEGE IF THE AUTH IS SUPERVISOR
      if (auth::user()->type=="supervisor"){

         $privil=json_decode(auth::user()->privilege, true);
         IF( $privil['edit'] ==0) {
            return (0);
         }else{
            return(1);
        }
     }else{
          return(1);
      }
  }





}
