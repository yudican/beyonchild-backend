<?php

namespace App\Http\Resources\Quiz;

use Illuminate\Http\Resources\Json\JsonResource;

class SdqQuestionResource extends JsonResource
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
            'question_description' => $this->question_description,
            'options' => SdqOptionResource::collection($this->sdqQuestionOption)
        ];
    }
}
