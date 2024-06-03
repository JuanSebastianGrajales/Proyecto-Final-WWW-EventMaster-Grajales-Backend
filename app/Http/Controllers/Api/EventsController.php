<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    public function index()
    {
        $events = Events::all();

        return response()->json($events);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'event_date' => 'required',
            'event_time' => 'required',
            'location' => 'required',
            'is_public' => 'required',
            'category_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $event = Events::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'is_public' => $request->is_public,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al crear el evento',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'event' => $event,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function updatePartial(Request $request, $id)
    {
        $event = Events::find($id);

        if (!$event) {
            $data = [
                'message' => 'Evento no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => '',
            'description' => '',
            'event_date' => '',
            'event_time' => '',
            'location' => '',
            'is_public' => '',
            'category_id' => ''
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }


        if ($request->has('title')) {
            $event->title = $request->title;
        }

        if ($request->has('description')) {
            $event->description = $request->description;
        }

        if ($request->has('event_date')) {
            $event->event_date = $request->event_date;
        }

        if ($request->has('event_time')) {
            $event->event_time = $request->event_time;
        }

        if ($request->has('location')) {
            $event->location = $request->location;
        }

        if ($request->has('is_public')) {
            $event->is_public = $request->is_public;
        }

        if ($request->has('category_id')) {
            $event->category_id = $request->category_id;
        }

        $event->save();

        $data = [
            'message' => 'Evento actualizado',
            'event' => $event,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
