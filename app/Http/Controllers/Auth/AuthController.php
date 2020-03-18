<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\OauthToken;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function token($id, Request $request) {
        $token = OauthToken::select('token')
                            ->where('user_id', $id)
                            ->where('token_type', 'Bearer')
                            ->where('client_ip', $request->ip())
                            ->where('user_agent', $_SERVER['HTTP_USER_AGENT'])
                            ->first();
        if ($token) {
            return response()->json([
                'error' => false,
                'token' => $token->token
            ]);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Token Expired!'
            ]);
        }
    }
}
