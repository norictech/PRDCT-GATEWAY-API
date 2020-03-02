<?php

function api_response($error = false, $message = '', $http_status = 200) {
    return response()->json([
        'error' => $error,
        'message' => $message
    ], $http_status);
}

function get_option_value($option_key = NULL) {
    return \App\Option::where('option_key', $option_key)->firstOrFail()->option_value;
}
