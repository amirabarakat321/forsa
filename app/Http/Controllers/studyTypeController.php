<?php

namespace App\Http\Controllers;

use App\Http\Resources\study;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SupervisorPrivilege;
use DB;
use App\StudyType;


class studyTypeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['admin'])->except(['destroy']);
        $this->middleware('delete', ['only' => [
            'destroy',

        ]]);
    }

    use SupervisorPrivilege;
    public function index(){
        ///add privilege
        $addcheck =$this->addCheck();

        $cats = DB::table('studies_types')->paginate(20);
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
                    <td>'.$cat->type_title.'</td>';
                   if($this->editCheck()){
        $results .=' <td>
                        <!-- To open the button please add class active here -->
                        
                          <button type="button" class="'.$class.'"   href="'.url('studiestypes/status/'.$cat->id).'" 
                             aria-pressed="'.$aria.'" autocomplete="off">
                              <div class="handle"></div>
                           </button>
                        
                     
                        
                    </td>
                    <td>
                    <span data-toggle="modal" data-target="#editSpec">
                            <a data-toggle="tooltip" title="تعديل" class="updattype" data-placement="bottom" 
                            data-content="'.$cat->type_title.'" href="'.route('studiestypes.update', $cat->id).'">
                                <i class="fas fa-edit"></i>
                            </a>
                        </span>';}else{
                       $results .=' <td>
                           <button disabled type="button" class="'.$class.'"   href=""  aria-pressed="'.$aria.'" autocomplete="off">
                            <div class="handle"></div>
                        </button>
                      
                    </td>
                    <td>
                   ';
                   }
            if( $this->deleteCheck()){
                $results .= '<a data-toggle="tooltip" title="حذف" data-placement="bottom" href="'.route('studiestypes.destroy', $cat->id).'"  class="delete" >
                            <form action="'.route('studiestypes.destroy', $cat->id).'" style="display: none;" id="delete_form">
                                <input type="hidden" name="data_id" value="'.$cat->id.'">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                            </form>
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

        $siteMap = ['الرئيسية', 'الدراسات ', 'الأقسام'];
        return view('studies.type', ['cats' => $results, 'paginate' => $cats, 'siteMap' => $siteMap,'addcheck'=>$addcheck]);
    }

    public function store(Request $request){
        StudyType::create($request->all());

        return back()->with('status', 'تم الإضافة بنجاح');
    }

    public function update(Request $request, $id){
        StudyType::where('id' , $id)->update($request->except(['_token','_method']));

        return back()->with('status', 'تم التعديل  بنجاح');
    }

    /*
     * change type status
     * */

    public function status($id){
        $study= StudyType::where('id',$id)->first();
        if($study->status == 0){
            $upd= StudyType::where('id',$id)
                ->update(['status' =>1]);
        }elseif($study->status == 1){
            $upd= StudyType::where('id',$id)
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
        if(StudyType::destroy($id)){
            return response(['success' => true]);
        }

        return response(['success' => false]);
    }




}

