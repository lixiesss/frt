<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FgdGroupResource extends JsonResource
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
            'name' => $this->name,
            'topic_id' => $this->topic_id,
            'session_id' => $this->session_id,
            'mentor_name' => $this->mentor_name,
            'topic' => new FgdTopicResource($this->whenLoaded('topic')),
            'session' => new FgdSessionResource($this->whenLoaded('session')),
            'applicants' => ApplicantResource::collection($this->whenLoaded('applicants')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
