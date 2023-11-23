<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioNoRegistrado;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VerMasController extends Controller
{
    public function verMasDenuncia (Request $request, $id) 
    {
        $denuncia = Denuncia::find($id);
        $comisaria = UsuarioComisaria::where('id', $denuncia->id_comisaria)->first();

        $victima = UsuarioVictima::where('dni', $denuncia->id_victima)->first();

        if (!$victima) {
            $url = 'https://apiperu.dev/api/dni';

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer c59a841e3207922843de445f6e4b58dce01fed82aabbaa068163586d1ce3a486'
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['dni' => $denuncia->id_victima]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);

            curl_close($ch);

            $victima = new UsuarioVictima([
                'id' => 'nulo',
                'dni' => json_decode($response)->data->numero,
                'nombre' => json_decode($response)->data->nombres,
                'apellido' => json_decode($response)->data->apellido_paterno . ' ' . json_decode($response)->data->apellido_materno,
                'celular' => '',
                'direccion' => '',
                'correo' => '',
                'password' => ''
            ]);

            if (!$victima) {
                return redirect('verMasDenuncia')->withErrors(['error' => 'El DNI no se encontro por ningun lado.']);
            }
        }

        return view('./comisaria/verMasDenuncia', [
            'denuncia' => $denuncia,
            'victima' => $victima,
            'comisaria' => $comisaria,
            'volver' => strval($request->page)
        ]);
    }

    public function verMasUsuario (Request $request, $id) 
    {
        $usuario = UsuarioVictima::find($id);
        $denuncias = Collection::make(Denuncia::where('id_victima', $usuario->dni)->get())->map(function ($ele) {
            $comisaria = UsuarioComisaria::find($ele->id_comisaria);

            $data = [
                'id' => $ele->id,
                'created_at' => $ele->created_at,
                'id_comisaria' => $comisaria->nombre,
            ];

            return (object)$data;
        });

        return view('./comisaria/verMasUsuario', [
            'usuario' => $usuario,
            'denuncias' => $denuncias,
            'volver' => strval($request->page)
        ]);
    }

    // Update
    public function ActualizarDenuncia (Request $request, $id) {
        try {
            $denuncia = Denuncia::find($id);
            $denuncia->update([
                'descripcion' => $request->descripcion,
                'lugar' => $request->lugar
            ]);

            return redirect('verMasDenuncia/' . $id)->withErrors(['error' => 'success']);
        }
        catch (Exception $e) {
            return redirect('verMasDenuncia/' . $id)->withErrors(['error' => 'Error al actualizar la denuncia.']);
        }
    }

    public function ActualizarUsuario (Request $request, $id) {
        try {
            $usuario = UsuarioVictima::find($id);

            $usuario->update([
                'celular' => $request->celular,
                'direccion' => $request->direccion,
                'correo' => $request->correo
            ]);

            return redirect('verMasUsuario/' . $id)->withErrors(['error' => 'success']);
        }
        catch (Exception $e) {
            return redirect('verMasUsuario/' . $id)->withErrors(['error' => 'Error al actualizar el usuario.']);
        }
    }
}
