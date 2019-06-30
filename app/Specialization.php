<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $guarded = [];
    public $table = 'specializations';
    protected $hidden = ['created_at','updated_at'];
}
