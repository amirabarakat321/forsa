<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectComment extends Model
{
    public $table = 'project_comments';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'project_id','user_id','comment'
    ];

}