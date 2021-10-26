<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InterestTalentResource;
use App\Models\InterestTalent;
use Illuminate\Http\Request;

class InterestTalentController extends Controller
{
    public function index()
    {
        $talents = InterestTalent::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => InterestTalentResource::collection($talents)
        ];
        return response()->json($respon, 200);
    }
}
