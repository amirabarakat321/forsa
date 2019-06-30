<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyType extends Model
{
    public $table = 'studies_types';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'type_title','status','created_at','updated_at',
    ];
}
