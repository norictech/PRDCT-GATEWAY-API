<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\OauthToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Supports\TokenEncryptor;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $token_encryptor = new TokenEncryptor();
        $client_id = DB::table('oauth_clients')->where('secret', env('APP_SECRET'))->get()->first()->id;

        $credentials = [
            'grant_type' => 'password',
            'client_id' => $client_id,
            'client_secret' => env('APP_SECRET'),
            'username' => $request->username,
            'password' => $request->password,
            'scope' => '*',
        ];

        $request->request->add($credentials);
        $oauth_request = Request::create('/oauth/token', 'post');

        $oauth_token = json_decode(\Route::dispatch($oauth_request)->getContent());

        // format oauth_token data
        // $oauth_token->access_token = $token_encryptor->secure_token($oauth_token->access_token, nonce($request));
        // $oauth_token->refresh_token = $token_encryptor->secure_token($oauth_token->refresh_token, nonce($request));

        /**
         * Store active token to oauth_tokens table
         */
        $user_id = User::where('email', $request->username)->first()->id;
        $tokenAvailable = OauthToken::where('user_id', $user_id)
                                      ->where('client_ip', $request->ip())
                                      ->where('user_agent', $_SERVER['HTTP_USER_AGENT'])
                                      ->count();

        $active_token_data = [
            'user_id' => $user_id,
            'token_type' => $oauth_token->token_type,
            'token' => $oauth_token->access_token,
            'expires_in' => $oauth_token->expires_in,
            'refresh_token' => $oauth_token->refresh_token,
            'refresh_token_expires_in' => env('PERSONAL_REFRESH_TOKEN_LIFETIME') * 86400,
            'client_ip' => $request->ip(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        ];

        if ($tokenAvailable) OauthToken::where('user_id', $user_id)
                                         ->where('client_ip', $request->ip())
                                         ->where('user_agent', $_SERVER['HTTP_USER_AGENT'])
                                         ->update($active_token_data);
        else OauthToken::create($active_token_data)->save();

        $oauth_token->user_id = $user_id;

        return response()->json($oauth_token, Response::HTTP_OK);
    }
}
