<?php
// config/jwt.php

return [
    /*
    |--------------------------------------------------------------------------
    | JWT Secret Key
    |--------------------------------------------------------------------------
    |
    | This value is used to sign your tokens. Make sure to keep it secret!
    |
    */
    'secret' => env('JWT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Token Time To Live (TTL)
    |--------------------------------------------------------------------------
    |
    | Here you can specify the amount of time (in minutes) that the token
    | will be valid for. Defaults to 1 hour.
    |
    */
    'ttl' => env('JWT_TTL', 60),

    /*
    |--------------------------------------------------------------------------
    | Refresh Time To Live
    |--------------------------------------------------------------------------
    |
    | Some tokens can be refreshed within a certain time window. Here
    | you can specify how long that window will remain open.
    |
    */
    'refresh_ttl' => env('JWT_REFRESH_TTL', 20160), // 14 days
];