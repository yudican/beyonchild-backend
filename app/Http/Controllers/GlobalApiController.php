<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GlobalApiController extends Controller
{
    public function _emptyState()
    {
        $respon = [
            'error' => true,
            'status_code' => 400,
            'message' => 'Data not found!',
            'data' => []
        ];
        return response()->json($respon, 400);
    }
}
