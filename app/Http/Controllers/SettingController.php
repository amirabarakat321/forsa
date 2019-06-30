<?php

namespace App\Http\Controllers;
use Validator;
use DB;
use Redirect;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function __construct()
     {
      $this->middleware(['justadmin']);
     }
    public function index() {
        $st= DB::table('setting')->where('id',1)->first();
        $total= DB::table('setting')->sum('money');
        return view('admin.setting')->with(['rate'=>$st->rate ,'total'=>$total]);
    }
    public function edit(Request $request) {
        $validator = Validator::make($request->all(), [
            'rate' => 'required',
        ],[
            'rate.required' => 'يجب ادخال النسبه',
        ],[]);

        if($validator->fails()){
            return Redirect::back()->withErrors( $validator->errors());
        }
         DB::table('setting')->where('id',1)->update(['rate' =>$request['rate']]);
      return $this->index();
  }
}
