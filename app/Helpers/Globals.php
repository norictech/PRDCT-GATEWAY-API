<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class Globals {

    public static function api_response($error = false, $message = '', $http_status = 200) {
        return response()->json([
            'error' => $error,
            'message' => $message
        ], $http_status);
    }

}
