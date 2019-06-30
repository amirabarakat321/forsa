<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model
{
    public $table = 'projects_services';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'service_title','created_at',	'updated_at',
    ];

}