<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use GuzzleHttp\Client as Guzzle;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $client;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guzzle $client)
    {
        $this->middleware('guest');
        $this->client = $client;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'unique_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'unique_id' => $data['unique_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'group_id' => $data['group_id'],
        ]);
    }

    public function register(Request $request) {
        $request['unique_id'] = \Hash::make(md5(time()));
        $validator = $this->validator($request->all());

        if (empty($validator->messages()->toArray())) $validator->validate();
        else return api_response(true, $validator->messages(), 417);

        event(new Registered($user = $this->create($request->all())));
        $user_registered = $user->save($request->all());

        if ($user_registered) {
            $party_app = json_decode(\App\Helpers\Parties::all());
            foreach ($party_app as $key => $party) {
                $response[$party->app_url] = $this->client->request('POST', $party->app_url . 'register', [
                    'form_params' => $request->toArray()
                ]);
            }

            return api_response(true, 'Successfully registered!', 200);
        } else {
            return api_response(false, 'Something went wrong, please try again later!', 417);
        }
    }
}
