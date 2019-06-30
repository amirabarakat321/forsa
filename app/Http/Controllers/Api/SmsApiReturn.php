<?php
namespace App\Http\Controllers\Api;
use Twilio\Rest\Client;
trait SmsApiReturn {
    public function smsApiResponse ($to = null , $body = null){
        $sid = "AC152a15291224d150736d50b8ffefe236";
        $token = "cfce0b53be22df5f613674c129690e66";
        $sms = new Client($sid, $token);
        $sms->messages->create(
            "'".$to."'",
            array(
                'from' => '+12028834383',
                'body' => $body
            )
        );
    }
}
