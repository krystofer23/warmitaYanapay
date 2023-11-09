<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UsuarioVictimaController extends Controller
{
    public function store (Request $request) 
    {
        try {
            $this->validate($request, [
                'dni' => 'required|min:8|max:8',

                'phone' => 'required|min:9|max:9',
                'direction' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:4'
            ]);

            $url = 'https://apiperu.dev/api/dni';

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer c59a841e3207922843de445f6e4b58dce01fed82aabbaa068163586d1ce3a486'
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['dni' => $request->dni]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);

            curl_close($ch);

            UsuarioVictima::create([
                'dni' => $request->dni,
                'nombre' => json_decode($response)->data->nombres,
                'apellido' => json_decode($response)->data->apellido_paterno . ' ' . json_decode($response)->data->apellido_materno,
                'celular' => $request->phone,
                'direccion' => $request->direction,
                'correo' => $request->email,
                'clave' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario creado con exito.'
            ], Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al buscar o el dni es incorrecto.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update (Request $request) 
    {
        try {
            $this->validate($request, [
                'id' => 'required',

                'phone' => 'required|min:9|max:9',
                'direction' => 'required',
                'email' => 'required|email'
            ]);

            $usuario = UsuarioVictima::find($request->id);

            $usuario->update([
                'celular' => $request->phone,
                'direccion' => $request->direction,
                'correo' => $request->email,
            ]);

            return response()->json([
                'status' => 'success',
                'user' => $usuario
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al actualizar el usuario.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function updatePassword (Request $request) 
    {
        try {
            $this->validate($request, [
                'id' => 'required',
                'password' => 'required|min:4',
            ]);

            $usuario_comisaria = UsuarioVictima::find($request->id);

            $usuario_comisaria->update([
                'clave' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Contraseña actualizado con exito.'
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al actualizar la contraseña.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy (Request $request) 
    {
        try {
            $this->validate($request, [
                'id' => 'required',
            ]);

            UsuarioVictima::find($request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario eliminado con exito.'
            ], Response::HTTP_OK);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al eliminar el usuario.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
