<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'=>$this->name,
            'id'=>$this->id,
            'address'=>$this->address,
            'store'=>$this->store,
            'phone_number'=>$this->phone_number, 
            'attachment'=>new AttachmentResource($this->whenLoaded('attachment')), 
            'product'=>ProductResource::collection($this->whenLoaded('product')), 
        ];
    }
}
