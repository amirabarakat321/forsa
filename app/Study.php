<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Study extends Model
{
    public $table = 'studies';
    public $timestamps = true;
    protected $fillable = [
       'id','title'  , 'description' , 'address', 'price'  , 'private', 'user_id' , 'provider_id' , 'study_type' ,
       'project_type_id', 'country_id' ,
        ];
}
