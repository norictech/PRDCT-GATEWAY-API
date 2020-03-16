<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\OauthToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $client_id = \DB::table('oauth_clients')->where('secret', env('APP_SECRET'))->get()->first()->id;

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
            'refresh_token' => $oauth_token->refresh_token,
            'expires_in' => $oauth_token->expires_in,
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
