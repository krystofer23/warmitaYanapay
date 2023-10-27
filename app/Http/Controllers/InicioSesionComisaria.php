<?php

namespace App\Http\Controllers;

use App\Models\Llaves;
use App\Models\UsuarioComisaria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InicioSesionComisaria extends Controller
{
    public function inicio_sesion_route () 
    {
        return view('inicioSesion');
    }

    public function inicio_sesion_post (Request $request) 
    {
        $credenciales = $request->validate([
            'correo' => 'required|email',
            'clave' => 'required',
        ]);

        $user = UsuarioComisaria::where('correo', $credenciales['correo'])->first();

        if (!$user || !Hash::check($credenciales['clave'], $user->clave)) {
            session_destroy();

            return redirect('/InicioSesion')->withErrors(['error' => 'Credenciales inválidas. Por favor, verifica tu correo y contraseña e intenta de nuevo.']);
        }
        else {
            $_SESSION['usuario'] = $user->nombre;
            $_SESSION['id_usuario'] = $user->id;

            return redirect('/');
        }
    }

    public function cerrar_sesion (Request $request)
    {
        session_destroy();
        return redirect('/');
    }

    public function registro_comisaria_route () 
    {
        return view('registro');
    }

    public function registro_comisaria_post (Request $request)
    {
        try {
            $this->validate($request, [
                'nombre' => 'required|min:2',
                'direccion' => 'required|min:2',
                'correo' => 'required|min:2',
                'clave' => 'required|min:2', 
                'llave' => 'required|min:2'
            ]);

            $llaves = Llaves::all();

            foreach ($llaves as $key) {
                if (!Hash::check($request->llave, $key->llave_acceso)) {
                    return redirect('/RegistroComisaria')->withErrors(['error' => 'La llave ingresada es incorrecta.']);
                }
                else {
                    UsuarioComisaria::create([
                        'nombre' => $request->nombre,
                        'direccion' => $request->direccion,
                        'correo' => $request->correo,
                        'clave' => Hash::make($request->clave),
                    ]);

                    return redirect('/InicioSesion');
                }
            }
        }
        catch (Exception $e) {
            return redirect('/RegistroComisaria')->withErrors(['error' => 'Hubo un error al registrarse.']);
        }
    }
}
