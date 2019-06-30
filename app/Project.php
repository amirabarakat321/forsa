<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $table = 'projects';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'title'	,'description'	,'address','price'	,'cat_id'	,'service_id'	,'lat',	'lng',	'country_id',	'user_id',	'status',	'created_at',	'updated_at',
    ];

}
