<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;
use App\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;


class WalletController extends Controller
{
    use SupervisorPrivilege;
    public function __construct()
    {
        $this->middleware(['justadmin']);
    }

        public function index()
    {
        $wallets = DB::table('cash_transactions')->where('pay_type','cash')->paginate(30);
        foreach ($wallets as $wallet){
            $user = DB::table('users')->where('id',$wallet->user_id)->first();
            $wallet->username=$user->name;
            if($wallet->status == 0 ){
                $wallet->color="fas fa-check-circle animate blue";
                $wallet->change="#sendMoney";
                $wallet->title="تحويل لنقط";

            }else{
                $wallet->color="fas fa-check-circle animate green";
                $wallet->change="";
                $wallet->title="تم التحويل";
            }


        }

        return view('wallet.rechargepoint')->with('transactions',$wallets)->with('ty',1);
    }
    public function indexwithdraw()
    {
    $wallets = DB::table('withdraw')->orderBy('id', 'des')->paginate(30);
    return $this->retrivedata($wallets,0);
    }
    public function retrivedata( $wallets,$ty)
    {
        $editcheck =$this->editCheck();
        $output = '';
        $x = 1;
        $st= DB::table('setting')->where('id',1)->first();

        foreach ($wallets as $wallet){

            $user =  DB::table('users')->where('id',$wallet->user_id)->first();

                $baltype="سحب";
                $sitecomission=$st->rate;

                if($wallet->status == 2 ){
                    $color="green";
                    $change="";
                    $cla="";
                    $wallet->balance = $wallet->amount;


                }elseif($wallet->status == 0){
                    $wallet->balance = $user->balance;

                    $color="blue";
                    $change="#changeBalanceview";
                    $cla="deletebalance";
                }elseif($wallet->status == 1){
                    $color="gold";
                    $change="#changeBalancedone";
                    $cla ="deletebalance";
                    $wallet->balance = $wallet->amount;

                }
            $output.='   <tr>
                        <td>'. $wallet->username.'</td>
                        <td>'.$wallet->bank_name .'</td>
                        <td>'. $wallet->bank_branch.'</td>
                        <td>'. $wallet->bank_account.'</td>
                        <td>'. $wallet->iban_number.'</td>
                        <td>'. $wallet->balance .'</td>
                        <td>';

            if($editcheck){

                $output.='<span data-toggle="modal"  data-target="">
                               <a href="javascript:void(0);"  class="updatebalance" data-content="'.$wallet->id.'" data-toggle="tooltip"  data-placement="bottom">
                                    <i class="fas fa-check-circle animate '.$color.'"></i>
                                                <!--                                                <i class="fas fa-check-circle animate blue"></i>-->
                                                <!--                                                <i class="fas fa-check-circle animate gold"></i>-->
                                 </a>
                             </span> 
                              <span data-toggle="modal" data-target="'.$change.'">
                                            <a  data-toggle="tooltip" title="رد المبلغ" class="'.$cla.'" data-content="'. $wallet->balance.'-'.$wallet->id.'-'.$wallet->status.'" data-placement="bottom" href="javascript:void(0);"  >
                                                <i class="fas fa-paper-plane"></i>
                                            </a>
                                        </span>
                     <span data-toggle="modal" data-target="#bankDetails">
                                            <a  data-toggle="tooltip" title="عرض التفاصيل"
                                             data-content="'.$wallet->bank_name.'-'.$wallet->bank_account.'-'.$baltype.'-'. $wallet->balance.'-'.$sitecomission.'-'.$wallet->amount.'-'.$wallet->site_commission.'-'.$wallet->iban_number.'" class="balancedetials"
                                            data-placement="bottom" href="javascript:void(0);"  >
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </span>      
                           ';

            }

            $output.='  </td>
                    </tr>
     ';
        }

        return view('wallet.recharge')->with('output',$output)->with('link',$wallets)->with('ty',$ty);

    }

    public function edit(Request $request)
    {


        if(isset($request['status'])) {
            $ballance =  DB::table('withdraw')->where('id',$request['id'])->first();
            if ($ballance->status == 0) {
                $del = DB::table('withdraw')->where('id',$request['id'])
                    ->update(['status' => 1]);
            } else {
                $del = DB::table('withdraw')->where('id',$request['id'])
                    ->update(['status' => 0]);
            }

            if ($del) {
                return back()->with('status', 'تم التعديل  بنجاح');
            } else {
                return back();
            }
        }else{
            return back()->with('status','لم يتم تغير الحاله بنجاح');
        }
    }
    // for client account in our site
    public function balancerecharge(Request $request)
      {

          $ballance =  DB::table('cash_transactions')->where('id',$request['id'])->first();
        $user =  DB::table('users')->where('id',$ballance->user_id)->first();

        $newbalance =$user->balance+$ballance->amount;
        DB::table('cash_transactions')->where('id',$request['id'])
                             ->update(['status' => 1]);
        DB::table('users')->where('id',$user->id)
            ->update(['balance' =>$newbalance  ]);

        return back()->with('status','تمت اضافه الرصيد بنجاح ');

      }
      //for consultants from there account in our site to there bank account
    public function balancewithdraw(Request $request)
    {
        $data = $this->validate(request(),[
            'status' => 'required',
        ],[
            'status.required'   => 'يجب التاكيد علي الحاله ' ,

        ],[ ]);

        if ($data) {
            $st= DB::table('setting')->where('id',1)->first();
            $ballance = DB::table('withdraw')->where('id', $request['id'])->first();
            $user = DB::table('users')->where('id', $ballance->user_id)->first();
            DB::table('withdraw')->where('id', $request['id'])
                ->update(['status' => $request['status']]);
            if ($request['status'] == 1) {
                //site commission
                $total = $user->balance;
                $site=$total*$st->rate/100;
                $newbalance =$total-$site;
                DB::table('withdraw')->where('id', $request['id'])
                    ->update(['amount' => $newbalance,
                              'total' => $total,
                              'site_commission' => $site,]);

            }
            if ($request['status'] == 2) {
                $newbalance =$user->balance - $ballance->total ;
                DB::table('users')->where('id', $user->id)
                    ->update(['balance' => $newbalance]);

                DB::table('setting')->insert([
                                'user_id'=> $ballance->user_id,
                                'rate'=>  $st->rate,
                                'money'=>$ballance->site_commission
                ]);

                return back()->with('status','تم تحويل الرصيد بنجاح  بنجاح وخصم'.$ballance->site_commission.'نسبه الموقع');

                }
            return back()->with('status', 'تمت عمليه التحويل وفي انتظار اتمام العمليه ');

          }

    }
    public function walletsearch(Request $request)
    {

        if(empty($request['saerchtesxt'])){
            if($request['ty'] == 0){
                $wallets = DB::table('withdraw')->orderBy('id', 'des')->paginate(30);
            }
        }else{
            if($request['ty'] == 0){
                $wallets =  DB::table('withdraw')->where('username', 'LIKE', "%{$request['saerchtesxt']}%")
                    ->orwhere('bank_name', 'LIKE', "%{$request['saerchtesxt']}%")
                    ->paginate(30);
            }
        }
        return   $this->retrivedata($wallets,$request['ty'] );

    }



}
