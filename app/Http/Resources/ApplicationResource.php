<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'freelancer' => [
                'id' => $this->freelancer->id,
                'name' => $this->freelancer->name,
            ],
            'job' => [
                'id' => $this->job->id,
                'title' => $this->job->title,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
