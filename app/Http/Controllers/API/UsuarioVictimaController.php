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
    public function store(Request $request)
    {
        try {
            
            $this->validate($request, [

                'dni' => 'required',
                'name' => 'required',
                'lastname' => 'required',
                'phone' => 'required',
                'direction' => 'required',
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $usuario = UsuarioVictima::create([

                'dni' => $request->dni,
                'nombre' => $request->name,
                'apellido' => $request->lastname,
                'celular' => $request->phone,
                'direccion' => $request->direction,
                'correo' => $request->email,
                'clave' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario creado con exito',
                'usuario' => $usuario

            ], Response::HTTP_CREATED);
        } 
        catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al crear el usuario',
                'error' => $error->getMessage()

            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $this->validate($request, [

                'dni' => 'required|min:8|max:8',
                'name' => 'required|min:3|max:255',
                'lastname' => 'required|min:3|max:255',
                'phone' => 'required|min:9|max:9',
                'direction' => 'required|min:3|max:255',
                'email' => 'required|email|min:8|max:255',
                'password' => 'required|min:4|max:255'
            ]);

            $usuario = UsuarioVictima::find($id);

            $usuario->update([

                'dni' => $request->dni,
                'nombre' => $request->name,
                'apellido' => $request->lastname,
                'celular' => $request->phone,
                'direccion' => $request->direction,
                'correo' => $request->email,
                'clave' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario actualizado con exito',
                'usuario' => $usuario

            ], Response::HTTP_OK);
        } 
        catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al actualizar el usuario',
                'error' => $error->getMessage()

            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        $usuario = UsuarioVictima::find($id);
        $usuario->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario eliminado con exito',
            'usuario' => $usuario
        ], Response::HTTP_OK);
    }
}
