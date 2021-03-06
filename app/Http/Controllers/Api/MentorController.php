<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalApiController;
use App\Http\Resources\ExpertScheduleResource;
use App\Http\Resources\MentorResource;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends GlobalApiController
{
    public function getMentor()
    {
        $mentors = Mentor::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => MentorResource::collection($mentors)
        ];
        return response()->json($respon, 200);
    }

    public function getMentorByEducationLevel($education_level_id)
    {
        if (!$education_level_id) return $this->_emptyState();
        $mentors = Mentor::where('education_level_id', $education_level_id)->get();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => MentorResource::collection($mentors)
        ];
        return response()->json($respon, 200);
    }

    // mentor detail
    public function getMentorDetail($mentor_id)
    {
        $mentor = Mentor::find($mentor_id);
        if (!$mentor) return $this->_emptyState();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => new MentorResource($mentor)
        ];
        return response()->json($respon, 200);
    }

    // mentor detail
    public function getMentorSchedule($mentor_schedule_id)
    {
        $mentor = Mentor::find($mentor_schedule_id);
        if (!$mentor) return $this->_emptyState();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => ExpertScheduleResource::collection($mentor->schedules)
        ];
        return response()->json($respon, 200);
    }
}
