<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->role_name,
            'status' => $this->status ? 'Active' : 'Inactive',
            'description' => $this->description,
            'timestamps' => [
                'created_at' => $this->created_at,
                'update_at' => $this->updated_at
            ],
        ];
    }
}
