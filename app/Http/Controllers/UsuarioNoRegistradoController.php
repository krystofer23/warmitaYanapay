<?php

namespace App\Http\Controllers;

use App\Models\UsuarioNoRegistrado;
use Exception;
use Illuminate\Http\Request;

class UsuarioNoRegistradoController extends Controller
{
    public function registro_usuario_no_registrado (Request $request)
    {
        try {
            $this->validate($request, [
                'dni'  => 'required',
                'nombre'  => 'required',
                'apellido'  => 'required',
                'celular'  => 'required',
                'lugar'  => 'required',
                'correo' => 'required' 
            ]);
            
            UsuarioNoRegistrado::create([
                'id_comisaria' => $_SESSION['id_usuario'],
                'dni' => $request->dni,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'celular' => $request->celular,
                'direccion' => $request->lugar,
                'correo' => $request->correo,
            ]);

            return redirect('/Usuarios');
        }
        catch (Exception $e) {
            return redirect('/Usuarios')->withErrors(['error' => 'Hubo un error al registrar el usuarios.']);
        }
    }

    public function editar_usuario_no_registrado (Request $request, $id) 
    {
        try {
            $this->validate($request, [
                'dni'  => 'required',
                'nombre'  => 'required',
                'apellido'  => 'required',
                'celular'  => 'required',
                'lugar'  => 'required',
                'correo' => 'required' 
            ]);

            $usuario_no_registrado = UsuarioNoRegistrado::find($id);

            $usuario_no_registrado->update([
                'dni' => $request->dni,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'celular' => $request->celular,
                'direccion' => $request->lugar,
                'correo' => $request->correo,
            ]);

            return redirect('/Usuarios');
        }
        catch (Exception $e) {
            return redirect('/Usuarios')->withErrors(['error' => 'Hubo un error al actualizar el usuarios.']);
        }
    }
}
