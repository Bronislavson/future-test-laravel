<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotebookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $notebook = $this->resource;
        return [
            'id' => $notebook->id,
            'full_name' => $notebook->full_name,
            'company' => $notebook->company,
            'email' => $notebook->email,
            'phone' => $notebook->phone,
            'date_of_birth' => $notebook->date_of_birth,
            'photos' => $notebook->images()->get()->map(function ($photo) {
                return [
                    'id' => $photo->id,
                    'img' => '/notebook_photos/' . basename($photo->photo_path),
                ];
            }),
        ];
    }
}
