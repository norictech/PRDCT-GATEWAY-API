<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\OauthToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Supports\TokenEncryptor;

class AuthController extends Controller
{
    public function token($id, Request $request) {
        $token_encryptor = new TokenEncryptor();
        try {
            $token = OauthToken::select('token', 'refresh_token', 'expires_in', 'updated_at')
                    ->where('user_id', $id)
                    ->where('token_type', 'Bearer')
                    ->where('client_ip', $request->ip())
                    ->where('user_agent', $_SERVER['HTTP_USER_AGENT'])
                    ->first();
        } catch (\Throwable $th) {
            throw_error($th);
        }

        $token_expire_time = Carbon::parse($token->updated_at)->addSecond($token->expires_in)->format('Y-m-d H:i:s');
        $is_token_expired = current_time() > $token_expire_time;

        if (!$is_token_expired) {
            return response()->json([
                'token' => $token->token,
                'refresh_token' => $token->refresh_token,
            ], Response::HTTP_OK);
        } else {
            throw_error('Token Expired!');
        }
    }

    public function tokenLifetimeCheck(Request $request) {
        try {
            $token = OauthToken::select('token', 'refresh_token', 'expires_in', 'updated_at')
                ->where('token', $request->token)
                ->where('token_type', 'Bearer')
                ->where('client_ip', $request->ip())
                ->where('user_agent', $_SERVER['HTTP_USER_AGENT'])
                ->first();
        } catch (\Throwable $th) {
            throw_error($th);
        }

        $token_expire_time = Carbon::parse($token->updated_at)->addSecond($token->expires_in)->format('Y-m-d H:i:s');
        $is_token_expired = current_time() > $token_expire_time;

        if (!$is_token_expired) {
            return response()->json([
                'error' => false,
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Token Expired'
            ], Response::HTTP_OK);
        }
    }
}
