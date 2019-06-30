<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsultationsCategories extends Model
{
    public $table = 'specializations';
    public $guarded = [];
    protected $fillable = [
        'id' ,'title'	,	'status',	'created_at',	'updated_at',
    ];
}
