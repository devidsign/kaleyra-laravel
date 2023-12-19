<?php

return [
    'url' => env('BANDYER_URL','https://sandbox.bandyer.com/rest/'),
    'key' => env('BANDYER_API_KEY','ak_live_5fba53cc6606928728090432'),
    'default_role' => 'basic',
    'room' => [
        'config' => [
            'recording' => 'none',
            'duration' => '',
            'call_type' => 'audio_video',
            'live' => true,
        ]
    ],
    'user' => [
        'tools' => [
            "chat"  => false,
            "screen_sharing" => false,
            "file_upload" =>false,
            "snapshot" => false,
            "live_edit" => false,
            "live_pointer" => false,
            "present_to_everyone" => false,
            "sign" => false,
            "whiteboard" => false,
        ]
    ]
];
