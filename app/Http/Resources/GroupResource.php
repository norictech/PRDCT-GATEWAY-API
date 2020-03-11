<?php

namespace App\Http\Resources;

use App\Application;
use App\Group;
use App\Http\Resources\ApplicationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'description' => $this->description,
            'timestamps' => [
                'created_at' => $this->created_at->format('D, d/m/Y H:i:s'),
                'updated_at' => $this->updated_at->format('D, d/m/Y H:i:s')
            ],
            'users' => UserResource::collection($this->users),
            'applications' => ApplicationResource::collection(
                Application::join('group_has_applications', 'group_has_applications.application_id', '=', 'applications.id', 'left')
                             ->where('group_has_applications.group_id', $this->id)
                             ->get()
            ),
        ];
    }
}
