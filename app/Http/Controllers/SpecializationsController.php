<?php

namespace App\Http\Controllers;

use App\Specialization;
use Illuminate\Http\Request;

class SpecializationsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin'])->except(['destroy']);
        $this->middleware('delete', ['only' => [
            'destroy',

        ]]);

    }

    public function index()
    {
        $specializations = Specialization::paginate(30);
        $results = '';

        $x=0;
        foreach ($specializations as $specialization){
            $x++;
            $results .= '<tr>
                    <td>'.$x.'</td>
                    <td>'.$specialization->title.'</td>
                    <td>
                    <span data-toggle="modal" data-target="#editSpec">
                        <a data-toggle="tooltip" title="تعديل" class="update" data-placement="bottom" data-content="'.$specialization->title.'" href="'.route('specializations.update', $specialization->id).'">
                            <i class="fas fa-edit"></i>
                        </a>
                    </span>
                    
                   
                    <a  data-toggle="tooltip" title="حذف" data-placement="bottom" href="'.url('specializations/delete/'.$specialization->id).'"  class="delete" >
                        <form action="'.url('specializations/delete/'.$specialization->id).'" style="display: none;" id="delete_form">
                            <input type="hidden" name="data_id" value="'.$specialization->id.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                        </form>
                        <i class="fas fa-trash"></i>
                    </a>
                    </td>
                </tr>';
        }

        $siteMap = ['الرئيسية', 'التخصصات'];

        return view('users.usersSpecializations', ['specializations' => $results, 'siteMap' => $siteMap, 'links' => $specializations]);
    }

    public function store(Request $request)
    {
        Specialization::create($request->all());

        return back()->with('status', 'تم إضافة التخصص بنجاح');
    }

    public function update(Request $request, $id)
    {
        $update = Specialization::find($id)->update(['title' => $request->input('title')]);

        if($update){
            return back()->with('status', 'تم تعديل التخصص بنجاح');
        }
        return back()->with('error', 'فشل تعديل التخصص ');
    }

    public function destroy($id){
        if(Specialization::destroy($id)){
            return response(['success' => true]);
        }
            return response(['success' => false]);

    }
}
