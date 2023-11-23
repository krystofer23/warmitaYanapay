<?php

namespace App\Http\Controllers;

use App\Models\UsuarioComisaria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioComisariaController extends Controller
{
    public function editar_comisaria (Request $request, $id) 
    {
        try {
            $this->validate($request, [
                'nombre' => 'required',
                'direccion' => 'required',
                'correo' => 'required'
            ]);

            $usuario_comisaria = UsuarioComisaria::find($id);

            $usuario_comisaria->update([
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'correo' => $request->correo
            ]);

            return redirect('/Perfil')->withErrors(['error' => 'success']);
        }
        catch (Exception $e) {
            return redirect('/Perfil')->withErrors(['error' => 'Hubo un error al actualizar los datos.']);
        }
    }

    public function editar_clave (Request $request, $id) 
    {
        try {
            $this->validate($request, [
                'clave' => 'required',
            ]);

            $usuario_comisaria = UsuarioComisaria::find($id);

            $usuario_comisaria->update([
                'clave' => Hash::make($request->clave)
            ]);

            return redirect('/Perfil')->withErrors(['error' => 'success']);
        }
        catch (Exception $e) {
            return redirect('/Perfil')->withErrors(['error' => 'Hubo un error al actualizar los datos.']);
        }
    }

    public function eliminar_comisaria ($id) 
    {
        UsuarioComisaria::find($id)->delete();
        session_destroy();

        return redirect('/');
    }
}
