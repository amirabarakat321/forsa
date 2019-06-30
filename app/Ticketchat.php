<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticketchat extends Model
{
    public $table = 'ticket_conversation';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'ticket_id','message_from','message_to','reply','attachment'
    ];
}
