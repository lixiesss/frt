<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FgdTestResource extends JsonResource
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
            'question' => $this->question,
            'type' => $this->type?->value,
            'type_label' => $this->type?->label(),
            'topic_id' => $this->topic_id,
            'topic' => new FgdTopicResource($this->whenLoaded('topic')),
            'applicants' => ApplicantResource::collection($this->whenLoaded('applicants')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
