<?php

namespace App\Http\Controllers;

use App\Models\UsuarioCreadoComisaria;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function RegistrarVictima (Request $request) 
    {
        try {
            $this->validate($request, [
                'dni' => 'required|min:8|max:8',

                'celular' => 'required|min:9|max:9',
                'direccion' => 'required',
                'correo' => 'required|email',
                'clave' => 'required|min:4'
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

            $usuario = UsuarioVictima::create([
                'dni' => $request->dni,
                'nombre' => json_decode($response)->data->nombres,
                'apellido' => json_decode($response)->data->apellido_paterno . ' ' . json_decode($response)->data->apellido_materno,
                'celular' => $request->celular,
                'direccion' => $request->direccion,
                'correo' => $request->correo,
                'clave' => Hash::make($request->clave)
            ]);

            UsuarioCreadoComisaria::create([
                'id_victima' => $usuario->id,
                'id_comisaria' => $_SESSION['id_usuario']
            ]);

            return redirect('/Usuarios')->withErrors(['error' => 'success']);
        }
        catch (Exception $e) {
            return redirect('/Usuarios')->withErrors(['error' => 'Hubo un error al registrar, verifica el DNI o los datos. ']);
        }
    }

    public function ActualizarUsuario (Request $request, $id) 
    {
        try {
            $this->validate($request, [
                'celular' => 'required|min:9|max:9',
                'direccion' => 'required',
                'correo' => 'required|email',
            ]);

            $usuario = UsuarioVictima::find($id);

            $usuario->update([
                'celular' => $request->celular,
                'direccion' => $request->direccion,
                'correo' => $request->correo
            ]);

            return redirect('/Usuarios');
        }
        catch (Exception $e) {
            return redirect('/Usuarios')->withErrors(['error' => 'Hubo un error al actualizar, verifique los datos.']);
        }
    }

    public function ActualizarClave (Request $request, $id) 
    {
        try {
            $this->validate($request, [
                'clave' => 'required|min:4'
            ]);

            $usuario = UsuarioVictima::find($id);

            $usuario->update([
                'clave' => Hash::make($request->clave)
            ]);

            return redirect('/Usuarios');
        }
        catch (Exception $e) {
            return redirect('/Usuarios')->withErrors(['error' => 'Hubo un error al actualizar, verifique la contraseña.']);
        }
    }

    public function EliminarUsuario ($id) 
    {
        UsuarioVictima::find($id)->delete();

        return redirect('/Usuarios');
    }
}
