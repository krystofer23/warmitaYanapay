<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class InicioSesionController extends Controller
{
    public function login (Request $request)
    {
        try {
            $credenciales = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            $user = UsuarioVictima::where('correo', $credenciales['email'])->first();
    
            if (!$user || !Hash::check($credenciales['password'], $user->clave)) {
                return response()->json([
                    'status' => 'error_l',
                    'message' => 'Las credenciales no son correctas',
    
                ], Response::HTTP_BAD_REQUEST);
            }
            else {
                return response()->json([
                    'status' => 'success_l',
                    'user' => $user
    
                ], Response::HTTP_OK);
            }
        }
        catch (Exception $error) {

            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error en el inicio de sesión',
                'error' => $error->getMessage()

            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
