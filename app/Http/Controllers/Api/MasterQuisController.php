<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\GlobalApiController;
use App\Http\Resources\Quiz\IntellegenceCategoryResource;
use App\Http\Resources\Quiz\IntellegenceResource;
use App\Http\Resources\Quiz\SdqQuestionResource;
use App\Models\IntelligenceQuestion;
use App\Models\SdqQuestion;
use App\Models\SmartCategory;

class MasterQuisController extends GlobalApiController
{
    public function multipleIntelegenceCategory()
    {
        $intellegences = SmartCategory::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => IntellegenceCategoryResource::collection($intellegences)
        ];
        return response()->json($respon, 200);
    }

    public function multipleIntelegenceQuestion($category_id = null)
    {
        if (!$category_id) return $this->_emptyState();

        $intellegences = IntelligenceQuestion::where('smart_category_id', $category_id)->get();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => IntellegenceResource::collection($intellegences)
        ];
        return response()->json($respon, 200);
    }

    public function sdqQuestion()
    {
        $intellegences = SdqQuestion::with('sdqQuestionOption')->get();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => SdqQuestionResource::collection($intellegences)
        ];
        return response()->json($respon, 200);
    }
}
