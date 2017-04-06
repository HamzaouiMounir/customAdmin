<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => true,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAZb2f-bE:APA91bHAKHfD6QX7hlggMm45GYI1Uc4hcMHZNvt0V82Y3ou6NxwQLflZiC5kCMGq9X25aSHadKemxF734GIQruzVRHe6Zg7v3AzF2Fzkd9ywrERzrFysWeSl4qy5jdM5baVAMVtw4uWM'),
        'sender_id' => env('FCM_SENDER_ID', '436973074865'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
