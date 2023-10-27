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
                'id_victima' => 'required|min:8',
                'lugar' => 'required|min:3',
                'descripcion' => 'required|min:3',
                'file' => ''
            ]);

            try {
                $dni_id_victima = UsuarioNoRegistrado::where('dni', $request->id_victima)->first();

                if (!$dni_id_victima) {
                    $dni_id_victima = UsuarioVictima::where('dni', $request->id_victima)->first();

                    if (!$dni_id_victima) {
                        throw new Exception("No se encontró ningún usuario con el DNI proporcionado en ninguno de los modelos.");
                    }
                }
            }
            catch (Exception $e) {
                return redirect('/Denuncias')->withErrors(['error' => 'Error al registrar, verifique los datos. (DNI)']);
            }
    
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                
                Denuncia::create([
                    'id_comisaria' => $comisaria_id,
                    'id_victima' => $dni_id_victima->dni,
                    'lugar' => $request->lugar,
                    'descripcion' => $request->descripcion,
                    'prueba_media' => '/images/' . $imageName,
                ]);
    
                return redirect('/Denuncias');
            }
            else {
                Denuncia::create([
                    'id_comisaria' => $comisaria_id,
                    'id_victima' => $dni_id_victima->dni,
                    'lugar' => $request->lugar,
                    'descripcion' => $request->descripcion,
                    'prueba_media' => ''
                ]);
    
                return redirect('/Denuncias');
            }
        }
        catch (Exception $e) {
            return redirect('/Denuncias')->withErrors(['error' => 'Hubo un error al registrar la denuncia, verifique los datos (DNI).']);
        }
    }

    public function eliminar_denuncia ($id) {
        $denuncia = Denuncia::find($id);
        $denuncia->delete();

        return redirect('/Denuncias');
    }
}
