<?php
namespace App\Http\Controllers\Api;

trait ApiReturn {
    public function apiResponse ($data = null , $error = null , $code = 200){

        $code_status = array(200,201,202);

        $array = [
            'data' => $data,
            'status' => in_array($code,$code_status) ? true : false,
            'message' => $error
        ];

        return response($array,$code);
    }
}
