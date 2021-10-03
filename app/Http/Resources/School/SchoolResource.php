<?php

namespace App\Http\Resources\School;

use App\Http\Resources\CurriculumnResource;
use App\Http\Resources\ExtracurricularResource;
use App\Http\Resources\FacilityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
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
            'school_name' => $this->school_name,
            'school_image' => asset('storage/' . $this->school_image),
            'school_curiculumn' => $this->school_curiculumn,
            'school_description' => $this->school_description,
            'school_teacher_count' => $this->school_teacher_count,
            'school_address' => $this->school_address,
            'school_map_address' => $this->school_map_address,
            'school_phone_number' => $this->school_phone_number,
            'school_email' => $this->school_email,
            'school_fee_monthly' => $this->school_fee_monthly,
            'school_accreditation' => $this->school_accreditation,
            'school_day_start' => $this->school_day_start,
            'school_day_end' => $this->school_day_end,
            'school_day_open' => $this->school_day_open,
            'school_day_close' => $this->school_day_close,
            'level' => new LevelResource($this->level),
            'location' => new LocationResource($this->location),
            'facilities' => FacilityResource::collection($this->facilities),
            'curiculumns' => CurriculumnResource::collection($this->curriculumns),
            'extracurriculars' => ExtracurricularResource::collection($this->extracuriculars),
        ];
    }
}
