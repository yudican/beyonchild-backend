<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventCategoryResource;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getEvent()
    {
        $events = Event::with('eventCategories')->paginate(10);
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => EventResource::collection($events)
        ];
        return response()->json($respon, 200);
    }

    public function getEventDetail($event_id)
    {
        $event = Event::with('eventCategories')->find($event_id);
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => new EventResource($event)
        ];
        return response()->json($respon, 200);
    }

    public function getEventCategory()
    {
        $event_categories = EventCategory::all();
        $respon = [
            'error' => false,
            'status_code' => 200,
            'message' => 'Data fetched successfuly.',
            'data' => EventCategoryResource::collection($event_categories)
        ];
        return response()->json($respon, 200);
    }
}
