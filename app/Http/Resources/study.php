<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Project;
class study extends JsonResource
{
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'title'  => $this->title ,
            'description' => $this->description ,
            'address' => $this->address,
            'price'  => $this->price,
            'private'  => $this->private,
            'user_id'  => $this->user_id,
            'provider_id'  => $this->provider_id,
            'study_type'  => DB::table('studies_types')->select('type_title')->where('id', $this->studies_types)->first()->type_title,
            'project_type'=> DB::table('projects_types')->select('type_title')->where('id', $this->project_type_id)->first()->type_title,
            'country' => DB::table('countries')->select('country')->where('id', $this->country_id)->first()->country,
            ];
        //
    }
}
