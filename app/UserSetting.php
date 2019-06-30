<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    public $table = 'users_settings';

    public $guarded = [];
}
