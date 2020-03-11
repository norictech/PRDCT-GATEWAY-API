<?php

namespace App\Http\Resources;

use App\Http\Resources\PackageResource;
use App\Package;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'version' => $this->version,
            'patch_date' => $this->patch_date,
            'description' => $this->description,
            'is_maintenance' => $this->is_maintenance,
            'timestamps' => [
                'created_at' => $this->created_at->format('D, d/m/Y H:i:s'),
                'updated_at' => $this->updated_at->format('D, d/m/Y H:i:s')
            ],
            'packages' => PackageResource::collection(
                Package::join('application_has_packages', 'application_has_packages.package_id', '=', 'packages.id', 'left')
                         ->where('application_has_packages.application_id', $this->id)
                         ->get()
            )
        ];
    }
}
