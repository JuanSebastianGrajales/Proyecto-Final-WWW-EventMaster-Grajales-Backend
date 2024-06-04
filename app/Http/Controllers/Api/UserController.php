<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class UserController extends Controller
{
    public function updateProfile(Request $request, $id)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        // Obtener el usuario autenticado
        $user = User::findOrFail($id);

        // Actualizar los datos del usuario
        try {
            $user->update($validatedData);

            // Generar un nuevo token con los datos actualizados
            $token = JWTAuth::fromUser($user);

            // Devolver la respuesta con el nuevo token
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            // Registrar el error y devolver una respuesta de error
            \Log::error('Error updating user profile: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update profile'], 500);
        }
    }
}
