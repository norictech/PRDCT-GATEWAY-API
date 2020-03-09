<?php

namespace App\Http\Controllers;

use App\Option;
use Illuminate\Http\Request;
use App\Http\Resources\OptionResource;
use Symfony\Component\HttpFoundation\Response;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OptionResource::collection(Option::advanced_filter());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = Option::create($request->all());
        $option->save();

        $stored_option = Option::find($option->id);

        return response()->json(new OptionResource($stored_option), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new OptionResource(Option::find($id));
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
        $option = Option::find($id)->update($data);

        $updated_option = Option::find($id);

        return response()->json(new OptionResource($updated_option), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Option::find($id)->delete();
        return response()->json($id);
    }

    public function mass_destroy(Request $request)
    {
        Option::whereIn('id', $request->all())->delete();
        return response()->json($request->all(), Response::HTTP_OK);
    }
}
