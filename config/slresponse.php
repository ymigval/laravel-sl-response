<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Wrapping
    |--------------------------------------------------------------------------
    |
    | By default, your outermost result is wrapped in a 'result' key when the response
    | is converted to JSON. You can change or override this key.
    |
    */

    'wrapping' => env('SLRESPONSE_WRAPPING', 'result'),

    /*
    |--------------------------------------------------------------------------
    | Represent all exceptions as an API response
    |--------------------------------------------------------------------------
    |
    | To capture only exceptions with a specific status, set the value to false.
    |
    */

    'capture_all_exceptions' => env('SLRESPONSE_CAPTURE_ALL_EXCEPTIONS', true),
];
