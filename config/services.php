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

    'facebook_poster' => [
        'page_id' => env('FACEBOOK_PAGE_ID', '105808608389244'),
        'access_token' => env('FACEBOOK_ACCESS_TOKEN', 'EAAM4W6G5U1gBANYpZB0FFABTZA3f1XtNx7GqCcI81WAzzOe36KRAet3vQuTKCly8xalkf8WViZCNsR40WC1GZCgJ9EmwwzJXmcIxkZBTbHw9QoahHr9IZCQn6AOXpZCx6Ou3ZAgbmGXySkilfI2VarHgZC6tFrno9y838YwPuEKnw7YUfo0XYHqp2WBQPf12bRLPKpgV1aM7NlrKzYkpmdpZBChlIYIjz0t0sZD'),
    ],

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

];
