<?php
use Illuminate\Support\Facades\URL;
return [

  /*
  |--------------------------------------------------------------------------
  | Third Party Services
  |--------------------------------------------------------------------------
  |
  | This file is for storing the credentials for third party services such
  | as Stripe, Mailgun, SparkPost and others. This file provides a sane
  | default location for this type of information, allowing packages
  | to have a conventional place to find your various credentials.
  |
  */

  'mailgun' => [
    'domain' => env('MAILGUN_DOMAIN'),
    'secret' => env('MAILGUN_SECRET'),
    'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
  ],

  'ses' => [
    'key' => env('SES_KEY'),
    'secret' => env('SES_SECRET'),
    'region' => env('SES_REGION', 'us-east-1'),
  ],

  'sparkpost' => [
    'secret' => env('SPARKPOST_SECRET'),
  ],

  'stripe' => [
    'model' => App\Models\User::class,
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    'webhook' => [
      'secret' => env('STRIPE_WEBHOOK_SECRET'),
      'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
    ],
  ],

  'vkontakte' => [
    'client_id' => 7607907,
    'client_secret' => 'nphGP18552tewyPVRbe3',
    'redirect' => 'auth/vk'
  ],

  'google' => [
    'client_id'     => '400445959195-jjdvmtsmt45fas5g8rg3l8ib5tr75t37.apps.googleusercontent.com',
    'client_secret' => '_CjK3wtfRlSm-fHEsHD2PlIn',
    'redirect'      =>  'auth/google'
  ],

];
