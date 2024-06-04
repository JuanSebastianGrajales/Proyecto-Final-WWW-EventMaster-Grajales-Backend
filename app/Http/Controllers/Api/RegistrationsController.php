<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegistrationsController extends Controller
{
    public function index()
    {
        $registrations = Registrations::all();

        return response()->json($registrations);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'event_id' => 'required',
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

        $registration = Registrations::create([
            'event_id' => $request->event_id, 
            'user_id' => $request->user_id
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error al registrar el usuario en el evento',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'registration' => $registration,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function destroy($user_id, $event_id) 
    {
        // Buscar el registro basado en user_id y event_id
        $registration = Registrations::where('user_id', $user_id)
                                     ->where('event_id', $event_id)
                                     ->first();

        // Verificar si se encontró el registro
        if (!$registration) {
            $data = [
                'message' => 'El usuario no estaba registrado a este evento',
                'status' => 404 
            ];
            return response()->json($data, 404);
        }

        // Eliminar el registro
        $registration->delete();

        // Respuesta de éxito
        $data = [
            'message' => 'El usuario ya no asistirá al evento',
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
