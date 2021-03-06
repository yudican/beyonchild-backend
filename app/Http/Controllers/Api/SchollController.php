<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\GlobalApiController;
use App\Http\Resources\FacilityResource;
use App\Http\Resources\MentorResource;
use App\Http\Resources\School\LevelResource;
use App\Http\Resources\School\LocationResource;
use App\Http\Resources\School\SchoolResource;
use App\Models\EducationLevel;
use App\Models\Facility;
use App\Models\School;
use App\Models\SchoolLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchollController extends GlobalApiController
{
    public function schoolLevel()
    {
        $levels = EducationLevel::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => LevelResource::collection($levels)
        ];
        return response()->json($respon, 200);
    }

    public function schoolLocation()
    {
        $locations = SchoolLocation::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => LocationResource::collection($locations)
        ];
        return response()->json($respon, 200);
    }

    public function schoolFacility()
    {
        $facilities = Facility::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => FacilityResource::collection($facilities)
        ];
        return response()->json($respon, 200);
    }

    public function schools()
    {
        $schools = School::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => SchoolResource::collection($schools)
        ];
        return response()->json($respon, 200);
    }

    /**
     * Get school list by location and level
     * @method POST
     * @return Json
     * @param education_level_id $education_level_id
     */
    public function schoolByLevel($education_level_id = null)
    {
        if (!$education_level_id) return $this->_emptyState();

        $schools = School::where('education_level_id', $education_level_id)->get();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => SchoolResource::collection($schools)
        ];
        return response()->json($respon, 200);
    }

    /**
     * Get school list by location and level
     * @method POST
     * @return Json
     * @param school_location_id $school_location_id
     */
    public function schoolByLocation($school_location_id = null)
    {
        if (!$school_location_id) return $this->_emptyState();

        $schools = School::where('school_location_id', $school_location_id)->get();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => SchoolResource::collection($schools)
        ];
        return response()->json($respon, 200);
    }

    /**
     * Get school list by location and level
     * @method POST
     * @return Json
     */
    public function schoolByLocationAndLevel(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'school_location_id' => 'required',
            'education_level_id' => 'required',
        ]);

        if ($validate->fails()) {
            $respon = [
                'error' => true,
                'status_code' => 401,
                'message' => 'Silahkan isi semua form yang tersedia',
                'messages' => $validate->errors(),
            ];
            return response()->json($respon, 401);
        }

        $schools = School::where('school_location_id', $request->school_location_id)->where('education_level_id', $request->education_level_id)->get();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => SchoolResource::collection($schools)
        ];
        return response()->json($respon, 200);
    }

    public function schoolRecomendation(Request $request)
    {
        $school_min = School::orderBy('school_fee_monthly', 'ASC')->first();
        $school_max = School::orderBy('school_fee_monthly', 'DESC')->first();

        $price_min = $school_min ? $school_min->school_fee_monthly : 0;
        $price_max = $school_max ? $school_min->school_fee_monthly : $school_max->school_fee_monthly;

        $facility_id = $request->facility_id ?? [];
        $school_price_monthly = $request->school_price_monthly ?? [$price_min, $price_max];
        $schools = School::orWhereBetween('school_fee_monthly', $school_price_monthly)->orWhereHas('facilities', function ($query) use ($facility_id) {
            $query->whereIn('facility_id', $facility_id);
        })->orWhere('school_location_id', $request->school_location_id)->orWhere('education_level_id', $request->education_level_id)->get();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => SchoolResource::collection($schools)
        ];
        return response()->json($respon, 200);
    }

    public function schoolExperts($school_id)
    {
        $school = School::find($school_id);
        if (!$school) return $this->_emptyState();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => MentorResource::collection($school->mentors)
        ];
        return response()->json($respon, 200);
    }
}
