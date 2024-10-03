<?php

namespace App\Http\Resources;


use \Illuminate\Http\Request;

class NoteResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request) : array
    {
        $this->micro = [
            'id' => $this->id,
            'text' => $this->text,
            'last_reply_at' => $this->created_at->diffForHumans(),

        ];
        $this->mini = [
            'is_mine' => $this->isMine(),
            'date' => $this->updated_at?->diffForHumans(),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s A'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s A'),
        ];

        $this->full = [
        ];
        $this->relations = [
            'user' => $this->relationLoaded('user') ? new UserResource($this->user) : null,
            'files' => $this->relationLoaded('files') ? FileResource::collection($this->files) : [],
        ];
        return $this->getResource();
    }
}
