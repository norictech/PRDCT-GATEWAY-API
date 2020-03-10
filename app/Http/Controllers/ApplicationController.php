<?php

namespace App\Http\Controllers;

use App\Application;
use Illuminate\Http\Request;
use App\Http\Resources\ApplicationResource;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends Controller
{
    public function index()
    {
        return ApplicationResource::collection(Application::advanced_filter());
    }

    public function store(Request $request)
    {
        $group = Application::create($request->all());
        $group->save();

        $stored_group = Application::find($group->id);

        return response()->json(new ApplicationResource($stored_group), Response::HTTP_OK);
    }

    public function show($id)
    {
        return new ApplicationResource(Application::find($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $group = Application::find($id)->update($data);

        $updated_group = Application::find($id);

        return response()->json(new ApplicationResource($updated_group), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $deleted = Application::find($id)->delete();
        return response()->json($id);
    }

    public function mass_destroy(Request $request)
    {
        Application::whereIn('id', $request->all())->delete();
        return response()->json($request->all(), Response::HTTP_OK);
    }
}
