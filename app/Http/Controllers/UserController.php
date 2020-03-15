<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\OauthToken;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return UserResource::collection(User::advanced_filter());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['unique_id'] = \Hash::make(Carbon::now());
        $user = User::create($request->all());
        $user->save();

        $stored_user = User::find($user->id);

        return response()->json(new UserResource($stored_user), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id)->update($data);

        $updated_user = User::find($id);

        return response()->json(new UserResource($updated_user), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::destroy($id);
        return response()->json($id, Response::HTTP_OK);
    }

    public function mass_destroy(Request $request)
    {
        User::whereIn('id', $request->all())->delete();
        return response()->json($request->all(), Response::HTTP_OK);
    }

    public function me(Request $request) {
        return new UserResource($request->user());
    }

    public function get_active_token($id) {
        $token_data = OauthToken::where('user_id', $id)->get();

        return response()->json($token_data);
    }
}
