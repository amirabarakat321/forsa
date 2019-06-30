<?php

namespace App\Http\Controllers\Api;

use App\Calendar;
use App\Consultation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TimesController extends Controller
{
    use ApiReturn;

    public $current_time;
    public $current_date;

    public function __construct()
    {
        $this->current_time = date('H:i:s');
        $this->current_date = date('Y-m-d');
    }


    /**
     * Display a alisting of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $times = DB::table('times')->get();

        return $this->apiResponse($times, '', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent());
        $day = $data->work_day;
        $uid = $data->user_id;
        $work_times = $data->work_times;
        $CD = date('Y-m-d');

        // get user old calendar
        $old_calendar = Calendar::where(['user_id' => $uid, 'work_date' => $day]);

        if($old_calendar->count() > 0){
            $old_calendar->update(['work_time' => json_encode($work_times)]);
        }else{
            $calendar = new Calendar();
            $calendar->user_id = $uid;
            $calendar->work_date = $day;
            $calendar->work_time = json_encode($work_times);
            $calendar->save();
        }

        return $this->apiResponse(null, trans('custom.success-add-calendar'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $date = $request->input('date');
        $uid = $request->input('user_id');

        $check_calendar = Calendar::select("id","work_time")
            ->where(['user_id' => $uid, 'work_date' => $date]);

        if($check_calendar->count() > 0){
            $calendar = $check_calendar->first();

            if($date > $this->current_date OR $date < $this->current_date){
                $work_times = DB::table('times')
                    ->whereIn('times.id', json_decode($calendar->work_time))
                    ->orderBy('times.id', 'asc')
                    ->select('times.id','times.theTime')
                    ->get();
            }else{
                $work_times = DB::table('times')
                    ->whereIn('times.id', json_decode($calendar->work_time))
                    ->where('times.theTime', '>=', $this->current_time)
                    ->orderBy('times.id', 'asc')
                    ->select('times.id','times.theTime')
                    ->get();
            }


            foreach ($work_times as $work_time){
                $consultationCheck = Consultation::whereRaw("time_id = '$work_time->id' AND booking_date = '$date' ");

                if($consultationCheck->count() > 0){
                    $work_time->timeStatus = $consultationCheck->first()->status == 1 ? 1 : 0;
                }else{
                    $work_time->timeStatus = 0;
                }

//                // check consultation time
//                $time = strtotime($work_time->theTime);
//
//                $endTime = date("H:i:s", strtotime('+30 minutes', $time));
//
//                $time1 = new \DateTime($this->current_time);
//
//                $time2 = new \DateTime($endTime);
//
//                $diff = $time1->diff($time2);
//
//                $minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;


                if($consultationCheck->count() > 0){
                    $work_time->consultation_id = $consultationCheck->first()->id;
                }else{
                    $work_time->consultation_id = null;
                }
            }

            $calendar->work_times = $work_times;
        }else{
            $calendar = null;
        }

        return $this->apiResponse($calendar, '', 200);
    }

    /*
     * get work calendar
     * */
    public function WorkCalendar(Request $request)
    {
        $type = $request->input('type');
        $uid = $request->input('user_id');

        $current_date = date('Y-m-d');

        /*
         * if custom
         * */

        if($type == 0){
            $date_from = $request->input('date_from');
            $date_to = $request->input('date_to');

            $calendar = Calendar::select("id","work_date")
                ->where(['user_id' => $uid])
                ->where('work_date', '>=', $date_from)
                ->where('work_date', '<=', $date_to)
                ->get();
        }

        if($type == 1){
            $last_week = date('Y-m-d', strtotime('-7 days'));

            $calendar = Calendar::select("id","work_date")
                ->where(['user_id' => $uid])
                ->where('work_date', '>=', $last_week)
                ->where('work_date', '<=', $current_date)
                ->get();
        }

        if($type == 2){
            $last_month = date('Y-m-d', strtotime('-1 month'));

            $calendar = Calendar::select("id","work_date")
                ->where(['user_id' => $uid])
                ->where('work_date', '>=', $last_month)
                ->where('work_date', '<=', $current_date)
                ->get();
        }

        if($type == 3){
            $last_3_months = date('Y-m-d', strtotime('-3 month'));

            $calendar = Calendar::select("id","work_date")
                ->where(['user_id' => $uid])
                ->where('work_date', '>=', $last_3_months)
                ->where('work_date', '<=', $current_date)
                ->get();
        }

        return $this->apiResponse($calendar, '', 200);
    }

}
