<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'filename'=>$this->filename,
            'path'=>$this->path,
            'type'=>$this->type,
            'id'=>$this->id,
        ];
    }
}
