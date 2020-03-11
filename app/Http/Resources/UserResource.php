<?php

namespace App\Http\Resources;

use App\Role;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'timestamps' => [
                'created_at' => $this->created_at->format('D, d/m/Y H:i:s'),
                'updated_at' => $this->updated_at->format('D, d/m/Y H:i:s'),
            ],
            'role' => [
                'id' => $this->role->id,
                'role_name' => $this->role->role_name,
            ]
        ];
    }
}
