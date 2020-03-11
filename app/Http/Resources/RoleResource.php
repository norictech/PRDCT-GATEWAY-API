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
            'id' => $this->id,
            'name' => $this->role_name,
            'status' => $this->status ? 'Active' : 'Inactive',
            'description' => $this->description,
            'timestamps' => [
                'created_at' => $this->created_at->format('D, d/m/Y H:i:s'),
                'updated_at' => $this->updated_at->format('D, d/m/Y H:i:s')
            ],
            'users' => UserResource::collection($this->users),
            'accesses' => AccessResource::collection($this->accesses)
        ];
    }
}
