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
    'stripe' => [
        'model'  => App\Models\User::class,
        'key' => 'pk_test_51KgXDtLP4vuCnKzHhBe4g5gHno0hzbFQABV0ktAjU1txgs2By5fLf68bUt7nruyXJMcvkZMBNJD5s3om75l3iWPd00vapgbqX0',
        'secret' => 'sk_test_51KgXDtLP4vuCnKzH86jxCnQXv7GEZjoxiCbfYvS5KDl2HW3YCxGEr0TksPToET2pQeMHbSmt26bdtmriwbzmjGye00i6ae9ngW',
    ],

];
