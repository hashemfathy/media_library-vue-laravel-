<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->whenLoaded('attachedMedia')[0]['attachedmediable_type']);
        return [
            'url' => $this->getFullUrl(),
            'data' => [
                'id' => $this->id,
                'model_type' => $this->model_type,
                'model_id' => $this->model_id,
                'collection_name' => $this->collection_name,
                'name' => $this->name,
                'file_name' => $this->file_name,
                'mime_type' => $this->mime_type,
                'size' => $this->size,
                'custom_properties' => $this->custom_properties,
                'created_at' => $this->created_at,
                'order_column' => $this->order_column,
            ],
            'relations' => [
                'users' => $this->whenLoaded('users'),
            ]
        ];
    }
}
