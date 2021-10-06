<?php

namespace App\Http\Resources;

use App\Http\Resources\School\LevelResource;
use App\Http\Resources\School\SchoolResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResource extends JsonResource
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
            'mentor_name' => $this->mentor_name,
            'mentor_title' => $this->mentor_title,
            'mentor_link_meet' => $this->mentor_link_meet,
            'mentor_phone' => $this->mentor_phone,
            'mentor_email' => $this->mentor_email,
            'mentor_experient' => $this->mentor_experient,
            'mentor_benefit' => $this->mentor_benefit,
            'mentor_description' => $this->mentor_description,
            'profile_image' => $this->user->profile_photo_url,
            'level' => new LevelResource($this->level),
            'school' => new SchoolResource($this->school),
            'schedules' => ExpertScheduleResource::collection($this->schedules)
        ];
    }
}
