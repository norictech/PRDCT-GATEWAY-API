<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Resources\RoleResource;
use Symfony\Component\HttpFoundation\Response;
use App\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RoleResource::collection(Role::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create($request->all());
        $role->save();

        return response()->json([
            'data' => new RoleResource(Role::find($role->id))
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new RoleResource(Role::find($id));
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
        $role = Role::find($id)->update($request->all());
        return response()->json([
            'data' => new RoleResource(Role::find($id))
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Role::find($id)->delete();
        return response()->json($id);
    }

    public function mass_destroy(Request $request) {
        Role::whereIn('id', $request->all())->delete();

        return response()->json($request->all(), Response::HTTP_OK);
    }

    public function members($id) {
        $members = User::where('role_id', $id)->get();
        return response()->json([
            'data' => $members
        ], Response::HTTP_OK);
    }
}
