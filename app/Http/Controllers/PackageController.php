<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use App\Http\Resources\PackageResource;
use Symfony\Component\HttpFoundation\Response;

class PackageController extends Controller
{
    public function index()
    {
        return PackageResource::collection(Package::advanced_filter());
    }

    public function store(Request $request)
    {
        $package = Package::create($request->all());
        $package->save();

        $stored_package = Package::find($package->id);

        return response()->json(new PackageResource($stored_package), Response::HTTP_OK);
    }

    public function show($id)
    {
        return new PackageResource(Package::find($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $package = Package::find($id)->update($data);

        $updated_package = Package::find($id);

        return response()->json(new PackageResource($updated_package), Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $deleted = Package::find($id)->delete();
        return response()->json($id);
    }

    public function mass_destroy(Request $request)
    {
        Package::whereIn('id', $request->all())->delete();
        return response()->json($request->all(), Response::HTTP_OK);
    }
}
