<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
     */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env(key: 'RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'myfatoorah' => [
        'token' => env('MYFATOORAH_TOKEN'), // Add your token in .env file
        'initiate_payment_url' => env('MYFATOORAH_INITIATE_PAYMENT_URL'), // Add the URL in .env file
        'execute_payment_url' => env('MYFATOORAH_EXECUTE_PAYMENT_URL'), // Add the URL in .env file
        // 'send_payment_url' => env('MYFATOORAH_SEND_PAYMENT_URL'), // Add the URL in .env file
        'get_payment_status_url' => env('MYFATOORAH_GET_PAYMENT_STATUS_URL'), // Add the URL in .env file
        'update_payment_status_url' => env('MYFATOORAH_UPDATE_PAYMENT_STATUS_URL'), // Add the URL in .env file
        'send_payment_url' => env('MYFATOORAH_SEND_PAYMENT_URL'), // Add the URL in .env file
        'secret' => env('MYFATOORAH_WEBHOOK_SECRET_KEY'),
        'callback_url' => env('MYFATOORAH_CALLBACK_URL'),

    ],
    'mailgun' => [
        'transport' => 'mailgun',
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],
];
