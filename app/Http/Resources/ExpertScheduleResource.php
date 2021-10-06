<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpertScheduleResource extends JsonResource
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
            'schedule_title' => $this->schedule_title,
            'schedule_date' => $this->schedule_date,
            'schedule_time_start' => $this->schedule_time_start,
            'schedule_time_end' => $this->schedule_time_end,
        ];
    }
}
