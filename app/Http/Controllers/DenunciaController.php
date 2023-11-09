<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\UsuarioNoRegistrado;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Http\Request;

class DenunciaController extends Controller
{
    public function registro_denuncia_post (Request $request)
    {
        try {
            $comisaria_id = $_SESSION['id_usuario'];

            $this->validate($request, [
                'id_victima' => 'required|min:8', // dni
                'lugar' => 'required|min:3',
                'descripcion' => 'required|min:3',
                'file' => ''
            ]);

            $url = 'https://apiperu.dev/api/dni';

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer c59a841e3207922843de445f6e4b58dce01fed82aabbaa068163586d1ce3a486'
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['dni' => $request->id_victima]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);

            curl_close($ch);
    
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move('images', $imageName);
                
                Denuncia::create([
                    'id_comisaria' => $comisaria_id,
                    'id_victima' => json_decode($response)->data->numero,
                    'lugar' => $request->lugar,
                    'descripcion' => $request->descripcion,
                    'prueba_media' => '/images/' . $imageName,
                ]);
    
                return redirect('/Denuncias');
            }
            else {
                Denuncia::create([
                    'id_comisaria' => $comisaria_id,
                    'id_victima' => json_decode($response)->data->numero,
                    'lugar' => $request->lugar,
                    'descripcion' => $request->descripcion,
                    'prueba_media' => ''
                ]);
    
                return redirect('/Denuncias');
            }
        }
        catch (Exception $e) {
            return redirect('/Denuncias')->withErrors(['error' => 'Hubo un error al registrar la denuncia, verifique los datos (DNI). ']);
        }
    }

    public function eliminar_denuncia ($id) {
        $denuncia = Denuncia::find($id);
        $denuncia->delete();

        return redirect('/Denuncias');
    }
}
