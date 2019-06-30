<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Facades\DB;

class ProjectCollection extends JsonResource
{

    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'title'  => $this->title ,
            'description' => $this->description ,
            'address' => $this->address,
            'price'  => $this->price,
            'cat_id'  => $this->cat_id ,
            'service_id'  => $this->service_id ,
            'lat'=> $this->lat,
            'lng' => $this->lng,
            'country' => DB::table('countries')->select('country')->where('id', $this->country_id)->first()->country,
            'user_id'  => $this->user_id,
            'status' => $this->status,
            'photos' => DB::table('project_photos')->where('project_id', $this->id)->get(),
            'isFavorite' => DB::table('favorites')->select(DB::raw("IF(count(*) > 0 ,1, 0) as isFavorite"))->where(['user_id' => $this->user_id, 'favorite' => $this->id, 'favorite_type' => 'projects'])->first()->isFavorite,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comments' => ProjectCommentCollection::collection(DB::table('project_comments')
                ->join('users', 'project_comments.user_id', '=', 'users.id')
                ->select('project_comments.*', 'users.avatar  as useravatar', 'users.id  as userid', 'users.name as username')->where(['project_id' => $this->id])->get()),
        ];

    }
}
