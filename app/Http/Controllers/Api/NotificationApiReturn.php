<?php
namespace App\Http\Controllers\Api;

use Edujugon\PushNotification\PushNotification;

trait NotificationApiReturn {
    public function notificationApiResponse ($title = null , $message = null,$token = null, array $data = null){

        $push = new PushNotification('fcm');

        $push->setMessage([
            'notification' => [
                'title'=> $title,
                'body'=> $message,
                'sound' => 'default'
            ]
            //'data' => ""
        ])
            ->setApiKey('AAAAAXaL8Ks:APA91bGeDpNt2WnOtgRppVhb1682EimEmPwi3QSTUuro3ltAU4cXT1eFgOB7ulAroH5L3JovhKuLHdks3AwOD7k0bzpWHv5-dTBVBlpjw4YL4WP00NZsZg6vZ5LDJdE4lBEhXUMijQbR')
            ->setDevicesToken($token);

        $push->send();
    }
}
