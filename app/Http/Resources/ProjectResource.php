<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "title"=>$this->title,
//            "Creator"=>$date['Creator'],
            "Creator"=>$this->user->id,
            "tasks"=>TaskResource::collection($this->tasks),
            //"members"=>UserResource::collection($this->members),
            "members"=>$this->members,
            "created_at"=>$this->created_at
        ];
    }
}
