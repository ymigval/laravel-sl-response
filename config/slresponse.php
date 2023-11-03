<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Wrapping
    |--------------------------------------------------------------------------
    |
    | By default, your outermost result is wrapped in a result key when the response
    | is converted to JSON. You can change or override this key.
    |
    */

    'wrapping' => env('SLRESPONSE_WRAPPING', 'result'),
];
