<?php

namespace App\Http\Controllers;

use App\Access;
use Illuminate\Http\Request;
use App\Http\Resources\AccessResource;
use Symfony\Component\HttpFoundation\Response;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AccessResource::collection(Access::advanced_filter());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $access = Access::create($request->all());
        $access->save();

        $stored_access = Access::find($access->id);

        return response()->json(new AccessResource($stored_access), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Access  $access
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AccessResource(Access::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Access  $access
     * @return \Illuminate\Http\Response
     */
    public function edit(Access $access)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Access  $access
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Access::where('role_id', $id)->delete();

        return response()->json($id, Response::HTTP_OK);
    }

    public function mass_destory(Request $request) {
        Access::whereIn('role_id', $request->all())->delete();
        return response()->json($request->all(), Response::HTTP_OK);
    }
}
