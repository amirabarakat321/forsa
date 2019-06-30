<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{   public $table = 'users';
    public $guarded = [];

    protected $hidden = ['created_at','updated_at','password'];
}
