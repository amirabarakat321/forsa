<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\DB;

class ProjectsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $isFav = DB::table('favorites')->where(['user_id' => $this->user_id, 'favorite' => $this->id, 'favorite_type' => 'projects'])->count();
        $photo = DB::table('project_photos')->where('project_id', $this->id)->first();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'cat_id' => $this->cat_id,
            'service_id' => $this->service_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'country' => DB::table('countries')->select('country')->where('id', $this->country_id)->first()->country,
            'user_id' => $this->user_id,
            'price' => $this->price,
            'photo' => $photo,
            'status' => $this->status,
            'isFavorite' => $isFav > 0 ? 1 : 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
