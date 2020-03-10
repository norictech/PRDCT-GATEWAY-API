<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use Symfony\Component\HttpFoundation\Response;

class GroupController extends Controller
{
    public function index()
    {
        return GroupResource::collection(Group::advanced_filter());
    }

    public function store(Request $request)
    {
        $group = Group::create($request->all());
        $group->save();

        $stored_group = Group::find($group->id);

        return response()->json(new GroupResource($stored_group), Response::HTTP_OK);
    }

    public function show($id)
    {
        return new GroupResource(Group::find($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $group = Group::find($id)->update($data);

        $updated_group = Group::find($id);

        return response()->json(new GroupResource($updated_group), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $deleted = Group::find($id)->delete();
        return response()->json($id);
    }

    public function mass_destroy(Request $request)
    {
        Group::whereIn('id', $request->all())->delete();
        return response()->json($request->all(), Response::HTTP_OK);
    }
}
