<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChildrenResource extends JsonResource
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
            'name' => $this->children_name,
            'image' => asset('storage/' . $this->children_photo),
            'bod' => $this->children_birth_of_date,
            'gender' => $this->children_gender,
            'older' => $this->children_older,
            'order' => $this->children_order,
            'school_history' => $this->children_school_history,
        ];
    }
}
