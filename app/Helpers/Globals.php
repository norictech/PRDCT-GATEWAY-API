<?php

use App\Option;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

function current_time($format = 'Y-m-d H:i:s') {
    return Carbon::now()->format($format);
}

function throw_error($message = '') {
    echo json_encode([
        'error' => true,
        'message' => $message
    ], Response::HTTP_OK);
}

function nonce($request) {
    return $request->ip() . $_SERVER['HTTP_USER_AGENT'];
}
