<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    public $table = 'projects_types';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'type_title','created_at',	'updated_at',
    ];

}
