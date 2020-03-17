<?php

use App\Option;

function api_response($error = false, $message = '', $http_status = 200) {
    return response()->json([
        'error' => $error,
        'message' => $message
    ], $http_status);
}

function get_option_value($option_key = NULL) {
    $option_value = Option::where('key', $option_key)->firstOrFail()->value;
    return $option_value;
}

function get_public_ip_address() {
    $public_ip_address = trim(shell_exec('dig +short myip.opendns.com @resolver1.opendns.com'));
    return $public_ip_address;
}

function get_max_token_each_user() {
    $max_token_each_user = 2;
    return $max_token_each_user;
}
