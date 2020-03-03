<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessResource extends JsonResource
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
            'role_id' => $this->role_id,
            'menu' => $this->menu,
            'timestamps' => [
                'created_at' => $this->created_at->format('D, d/m/Y H:i:s'),
                'updated_at' => $this->updated_at->format('D, d/m/Y H:i:s')
            ],
        ];
    }
}
