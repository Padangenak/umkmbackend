<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Models\Category;
use App\Http\Resources\UserResource;
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dump($this);
        return [
            'product'=>$this->product,
            'price'=>$this->price,
            'user'=>new UserResource($this->whenLoaded('user')),
            'discon'=>$this->discon,
            'description'=>$this->description,
            'category'=>new CategoryResource($this->whenLoaded('category')),
            'attachment'=>new AttachmentResource($this->whenLoaded('attachment')),
            'variant'=>VariantResource::collection($this->whenLoaded('variant')),
            'count'=>$this->count,
            'id'=>$this->id,
            'active'=>$this->active,
        ];
    }
}
