<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectCommentCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
          return[
            'id' => $this->id,
            'project_id'=>$this->project_id, 
            'user_id'=> $this->user_id,
            'comment'=> $this->comment,
            'useravatar'=> $this->useravatar,
            'username'=> $this->username,
            'price'=> $this->price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
   public $preserveKeys = true;

}
