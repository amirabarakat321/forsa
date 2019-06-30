<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $siteMap = ['الرئيسية'];

        $msgs=    DB::table('messages')->count();
        $users=   DB::table('users')->whereNotIn('type', ['supervisor', 'admin'])->count();
        $studies= DB::table('studies')->count();
        $projects=DB::table('projects')->count();
        $consultations=DB::table('consultations')->count();
        $managers=     DB::table('users')->where('type', 'supervisor')->count();
        return view('home',['siteMap' => $siteMap ,'msgs' => $msgs ,'users' => $users ,'studies' => $studies
                           ,'projects' => $projects ,'consultations' => $consultations ,'managers' => $managers  ] );
    }

}
