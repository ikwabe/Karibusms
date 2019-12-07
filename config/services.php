<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Mailgun, SparkPost and others. This file provides a sane default
      | location for this type of information, allowing packages to have
      | a conventional file to locate the various service credentials.
      |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'facebook' => [
        'client_id' => '278267052336362',
        'client_secret' => 'ed0a7391dee53fc9e0bab865d7c6f41e',
        'redirect' => 'http://www.karibusms.com/callback/facebook',
    ],
    'google' => [
        'client_id' => '688185075515-8n990kovtjtjvfcfbdt6m5320kh9m5un.apps.googleusercontent.com',
        'client_secret' => 'sVLLsAZ601nxNclxcxXVRbhd',
        'redirect' => 'http://www.karibusms.com/callback/google',
    ],
    'linkedin' => [
        'client_id' => '78xp0pvaclr5q5',
        'client_secret' => 'Z2JdBVhk6PjHIJ1y',
        'redirect' => 'http://www.karibusms.com/callback/linkedin',
    ],
    'github' => [
        'client_id' => '00e604eaffa0c8e7e522', // Your GitHub Client ID
        'client_secret' => 'a05f44475a40797e04666201fbaaa257ab6578eb', // Your GitHub Client Secret
        'redirect' => 'http://www.karibusms.com/callback/github',
    ],
];
