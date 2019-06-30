<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::paginate(30);

        $results = '';

        $x=0;
        foreach ($countries as $country) {
            $x++;
            $results .= '
                <tr>
                    <td>'.$x.'</td>
                    <td>'.$country->country.'</td>
                    <td>
                    <span data-toggle="modal" data-target="#editSpec">
                        <a data-toggle="tooltip" title="تعديل" class="update" data-placement="bottom" data-content="'.$country->country.'" href="'.route('countries.update', $country->id).'">
                            <i class="fas fa-edit"></i>
                        </a>
                    </span>
                    
                    <a data-toggle="tooltip" title="حذف" data-placement="bottom" href="'.route('countries.destroy', $country->id).'"  class="delete" >
                        <form action="'.route('users.destroy', $country->id).'" style="display: none;" id="delete_form">
                            <input type="hidden" name="data_id" value="'.$country->id.'">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="'.csrf_token().'">
                        </form>
                        <i class="fas fa-trash"></i>
                    </a>

                    </td>
                </tr>
            ';
        }

        $siteMap = ['الرئيسية', 'المدن'];

        return view('countries', ['countries' => $results, 'siteMap' => $siteMap, 'links' => $countries]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Country::create($request->all());

        return back()->with('status', 'تم إضافة التخصص بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Country::find($id)->update(['country' => $request->input('country')]);

        if($update){
            return back()->with('status', 'تم تعديل المدينة بنجاح');
        }
        return back()->with('error', 'فشل تعديل المدينة ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Country::destroy($id)){
            return response(['success' => true]);
        }else{
            return response(['success' => false]);
        }
    }
}
