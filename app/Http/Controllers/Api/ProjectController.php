<?php

namespace App\Http\Controllers\Api;

use App\Project;
use App\projectComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectsCollection;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    use ApiReturn;

    // retrieve project depended on  service_id
    public function show()
    {
        $ty = \request()->input('service_id');

        $projects = Project::where(['status' => 1])->where(['service_id' => $ty ])->paginate(20);

        foreach ($projects as $project){
            $photo = DB::table('project_photos')->where('project_id', $project->id);

            $project->isFav = DB::table('favorites')->where(['user_id' => $project->user_id, 'favorite' => $project->id, 'favorite_type' => 'projects'])->count() > 0 ? 1 : 0;
            $project->photo = $photo->count() > 0 ? $photo->first()->photo : null;
        }

        return $this->apiResponse($projects, '', 200);
    }

    /// retrieve one project with his comments
    public function showproject($id )
    {
        $project = Project::where(['status' => 1])->where(['id' => $id])->get();

//        $comments =projectComment::join('users', 'project_comments.user_id', '=', 'users.id')
//            ->select('project_comments.*', 'users.avatar  as useravatar', 'users.id  as userid')
//            ->where(['project_id' =>$id ])->get();

        $data= ProjectCollection::collection($project);

        return $this->apiResponse($data, '', 200);
    }
    //// retrieve projects of usre 
    public function myproject($id)
    {
        $projects = Project::where(['user_id' =>$id])->paginate(10);

        foreach ($projects as $project){
            $photo = DB::table('project_photos')->where('project_id', $project->id);
            $project->photo = $photo->count() > 0 ? $photo->first()->photo : null;
        }

        return $this->apiResponse($projects, '', 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:6',
            'description' =>  'required|string|min:6',
            'address' =>  'required|string|min:6',
            'cat_id' => 'required|integer',
            'country_id' => 'integer',
            'price' => 'required|integer',
            'user_id' => 'required|integer',
            'service_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(
                null,$validator->errors()->first(),401
            );
        }

        $project = Project::create($request->except('photo'));

        // if photos exist put them in images[]
        if($files=$request->file('photo')){
            $images=array();
            foreach($files as $file){
                $path = Storage::putFile('projects', $file);
                $url = 'http://'.$request->getHost().'/forsaTanya/storage/app/'.$path;
                $images[]=$url;
            }
            foreach($images as $img){
                DB::table('project_photos')->insert([
                    ['project_id' => $project->id , 'photo' =>$img ]]);
            }
        }

        return $this->apiResponse(null, trans('custom.success-add-project'),201);

    }


    public function destroy($ty)
    {
        $projects = Project::where('id', $ty)->delete();

        return $this->apiResponse(null, trans('custom.success-delete-project'),201);
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|min:6',
            'description' =>  'string|min:6',
            'address' =>  'string|min:6',
            'cat_id' => 'integer',
            'price' => 'integer',
            'user_id' => 'integer',
            'country_id' => 'integer',
            'service_id' => 'integer'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(
                null,$validator->errors()->first(),401
            );
        }

        Project::where(['id' => $id, 'user_id' => $request->input('user_id')])
            ->update($request->except('photo'));

        // if photos exist delete old photos  then put the new  in images[] 
        if($files=$request->file('photo')){
            DB::table('project_photos')->where('project_id' , $id)->delete();

            $images=array();

            foreach($files as $file){
                $path = Storage::putFile('projects', $file);
                $url = 'http://'.$request->getHost().'/forsaTanya/storage/app/'.$path;
                $images[]=$url;
            }

            foreach($images as $img){
                DB::table('project_photos')->insert([
                    ['project_id' => $id , 'photo' =>$img ]]);
            }
        }

        return $this->apiResponse(null, trans('custom.success-update-project'),201);
    }

    ///// comments  ////
    public function destroyComment($id)
    {
        if(projectComment::where(['id' => $id, 'user_id' => \request()->input('user_id')])->delete()){
            return $this->apiResponse(null, trans('custom.success-delete'),201);
        }

        return $this->apiResponse(null, trans('custom.failed-delete'),201);
    }

    public function storeComment(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'comment' =>  'required|string|min:6',
            'user_id' => 'required|integer',
            'project_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(
                null,$validator->errors()->first(),401
            );
        }

        $comment = projectComment::create($request->all());

        return $this->apiResponse($comment, trans('custom.success-add-comment'),201);

    }


    public function projects_types()
    {
        $projects_types =DB::table('projects_types')->get();

        return $this->apiResponse($projects_types, '', 200);
    }

    public function projects_services()
    {
        $projects_types =DB::table('projects_services')->get();

        return $this->apiResponse($projects_types, '', 200);
    }

//    public function filter(Request $request)
//    {
//        $project= new  Project;
//        $project =  $project->newQuery();
//        ///filter with price
//        if($request->exists('price')){
//            $price = explode(";",$request->input('price'));
//            ///dd($price);
//            $project->whereBetween('price', [(int)$price[0], (int)$price[1]]);
//        }
//
//        ///filter with type
//        if($request->exists('type')){
//            $type = explode(";",$request->input('type'));
//            $typ;
//            $i=0;
//            foreach ($type as $ty) {
//                $typ[$i]=(int)$ty;
//                ++$i;}
//            $project->whereIn('cat_id',$typ);
//        }
//
//        //filter with city
//        if($request->exists('city')){
//            $city = explode(";",$request->input('city'));
//            $cit;
//            $i=0;
//            foreach ($city as $ci) {
//                $cit[$i]=(int)$ci;
//                ++$i;
//            }
//            $project->wherein('city_id',$cit);}
//        $project->where('service_id','=',$request->input('service'));
//
//        return $this->apiResponse($project->get(), '', 200);
//
//    }

}
