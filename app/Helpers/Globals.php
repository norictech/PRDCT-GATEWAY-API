<?php

namespace App\Helpers;

use App\Option;
use Illuminate\Http\Response;

class Globals {

    public static function api_response($error = false, $message = '', $http_status = 200) {
        return response()->json([
            'error' => $error,
            'message' => $message
        ], $http_status);
    }

    public static function get_option_value($option_key = NULL) {
        return Option::where('option_key', $option_key)->firstOrFail()->option_value;
    }

}
