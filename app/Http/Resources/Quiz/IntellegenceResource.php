<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Resources\Json\JsonResource;

class IntellegenceResource extends JsonResource
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
            'question_name' => $this->question_name,
            'question_score' => $this->question_score,
            'category' => new IntellegenceCategoryResource($this->smartCategory),
        ];
    }
}
