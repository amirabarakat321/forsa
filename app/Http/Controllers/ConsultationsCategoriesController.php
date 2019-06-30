<?php

namespace App\Http\Controllers;

use App\ConsultationsCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SupervisorPrivilege;


class ConsultationsCategoriesController extends Controller
{
    use SupervisorPrivilege;
    public function __construct()
    {
        $this->middleware(['admin'])->except(['destroy']);
        $this->middleware('delete', ['only' => [
            'destroy',

        ]]);

    }
    /*
     * show all categories
     * */
    public function index(){
        ///add privilege
        $addcheck =$this->addCheck();
        $cats = DB::table('specializations')->paginate(20);
        $results = '';

        $x=0;
        foreach ($cats as $cat){
            if ($cat->status == 1) {
                $class = "btn btn-sm btn-toggle active";
                $aria = "true";
            } else {
                $class = "btn btn-sm btn-toggle";
                $aria = "false";
            }
            $x++;
            $status = $cat->status == true ? 'active' : '';
            $results .= '
                <tr>
                    <td>'.$x.'</td>
                    <td>'.$cat->title.'</td>
                   ';
            if($this->editCheck()){
            $results.=' <td>
                        <!-- To open the button please add class active here -->
                        <button type="button" class="'.$class.'"   aria-pressed="'.$aria.'"
                        href="'.url('consultations_categories/status/'.$cat->id).'">
                            <div class="handle"></div>
                        </button>
                        
                    </td>
                    <td>
                    <span data-toggle="modal" data-target="#editSpec">
                            <a data-toggle="tooltip" title="تعديل" class="update" data-placement="bottom" data-content="'.$cat->title.'" href="'.route('consultations_categories.update', $cat->id).'">
                                <i class="fas fa-edit"></i>
                            </a>
                        </span>';
                    }else{
                $results .=' <td>
                        <button disabled type="button" class="btn btn-sm btn-toggle '.$status.' status" data-toggle="button" aria-pressed="false">
                            <a href="" style="display: none"></a>
                            <div class="handle"></div>
                        </button>
                    </td>
                    <td>
                   ';}
            if( $this->deleteCheck()){
                $results .= ' <a  data-toggle="tooltip" class="deleteam" title="حذف" data-placement="bottom"
                 href="'.url("/consultations_categories_destroy/".$cat->id).'" >
                            <i class="fas fa-trash"></i>
                        </a>
               
                           
                        </td>
                        
                    </tr>';
            }else{
                $results .= '
                        </td>
                    </tr>';
            }
        }

        $siteMap = ['الرئيسية', 'الإستشارات', 'الأقسام'];
        return view('consultations.categories', ['cats' => $results, 'paginate' => $cats, 'siteMap' => $siteMap,'addcheck'=> $addcheck]);
    }

    public function store(Request $request){

        ConsultationsCategories::create($request->all());

        return back()->with('status', 'تم الإضافة بنجاح');
    }

    public function update(Request $request, $id){
        ConsultationsCategories::where('id' , $id)->update($request->except(['_token','_method']));

        return back()->with('status', 'تم التعديل  بنجاح');
    }

    /*
     * change user status
     * */

    public function status($id){
        $cons= ConsultationsCategories::where('id',$id)->first();
        if($cons->status == 0){
            $upd= ConsultationsCategories::where('id',$id)
                ->update(['status' =>1]);
        }elseif($cons->status == 1){
            $upd= ConsultationsCategories::where('id',$id)
                ->update(['status' =>0]);
        }
        if($upd){
            return Response(['success'=>"true"]);
        }else{
            return Response(['success'=>"false"]);
        }


    }

    // delete category

    public function destroy($id){
        if(ConsultationsCategories::destroy($id)){
            return response(['success' => true]);
        }

        return response(['success' => false]);
    }
}
