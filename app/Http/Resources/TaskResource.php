<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class TaskResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'due_at' => optional($this->due_at)->toATOMString(),
            'deleted_at' => optional($this->deleted_at)->toATOMString(),
            'author' => new UserResource($this->author),
        ];
    }
}
