<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalApiController;
use App\Http\Resources\ChildrenResource;
use App\Models\Children;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChildrenController extends GlobalApiController
{
    public function getChildren()
    {
        $children = auth()->user()->childrens;
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => ChildrenResource::collection($children)
        ];
        return response()->json($respon, 200);
    }

    public function addChildren(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'children_name' => 'required',
            'children_photo' => 'required|image',
            'children_birth_of_date' => 'required',
            'children_gender' => 'required',
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

        if (!$request->hasFile('children_photo')) {
            return response()->json([
                'error' => true,
                'message' => 'File not found',
                'status_code' => 400,
            ], 400);
        }
        $file = $request->file('children_photo');
        if (!$file->isValid()) {
            return response()->json([
                'error' => true,
                'message' => 'Image file not valid',
                'status_code' => 400,
            ], 400);
        }

        try {
            DB::beginTransaction();
            $photo = $request->children_photo->store('children', 'public');
            $children = Children::create([
                'children_name' => $request->children_name,
                'children_photo' => $photo,
                'children_birth_of_date' => $request->children_birth_of_date,
                'children_gender' => $request->children_gender,
                'children_older' => $request->children_older,
                'children_order' => $request->children_order,
                'children_school_history' => $request->children_school_history,
                'parent_id' => auth()->user()->id
            ]);

            if (count($request->talents) > 0) {
                $children->talents()->attach($request->talents);
            }

            DB::commit();
            $respon = [
                'error' => false,
                'status_code' => 200,
                'message' => 'Data added successfuly.',
                'data' => new ChildrenResource($children)
            ];
            return response()->json($respon, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $respon = [
                'error' => true,
                'status_code' => 400,
                'message' => 'Data added failed.',
                'data' => []
            ];
            return response()->json($respon, 400);
        }
    }

    public function updateChildren(Request $request, $id)
    {
        if (!$id) return $this->_emptyState();
        $validate = Validator::make($request->all(), [
            'children_name' => 'required',
            'children_birth_of_date' => 'required',
            'children_gender' => 'required',
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

        if ($request->children_photo) {
            if (!$request->hasFile('children_photo')) {
                return response()->json([
                    'error' => true,
                    'message' => 'File not found',
                    'status_code' => 400,
                ], 400);
            }
            $file = $request->file('children_photo');
            if (!$file->isValid()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Image file not valid',
                    'status_code' => 400,
                ], 400);
            }
        }

        try {
            DB::beginTransaction();

            $data = [
                'children_name' => $request->children_name,
                'children_birth_of_date' => $request->children_birth_of_date,
                'children_gender' => $request->children_gender,
                'children_older' => $request->children_older,
                'children_order' => $request->children_order,
                'children_school_history' => $request->children_school_history,
            ];

            $children = Children::find($id);
            if ($request->children_photo) {
                $photo = $request->children_photo->store('children', 'public');
                $data = ['children_photo' => $photo];
                if (Storage::exists('public/children/' . $children->children_photo)) {
                    Storage::delete('public/children/' . $children->children_photo);
                }
            }

            $children->update($data);

            if (count($request->talents) > 0) {
                $children->talents()->sync($request->talents);
            }

            DB::commit();
            $respon = [
                'error' => false,
                'status_code' => 200,
                'message' => 'Data updated successfuly.',
                'data' => new ChildrenResource($children)
            ];
            return response()->json($respon, 200);
        } catch (\Throwable $th) {
            DB::rollback();
            $respon = [
                'error' => true,
                'status_code' => 400,
                'message' => 'Data updated failed.' . $th->getMessage(),
                'data' => []
            ];
            return response()->json($respon, 400);
        }
    }
}
