<?php

namespace App\Http\Controllers;

use App\Models\Llaves;
use App\Models\UsuarioComisaria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class InicioSesionComisaria extends Controller
{
    public function inicio_sesion_route () 
    {
        return view('inicioSesion');
    }

    public function inicio_sesion_post (Request $request) 
    {
        try {
            $credenciales = $request->validate([
                'correo' => 'required|email',
                'clave' => 'required',
            ]);
    
            $user = UsuarioComisaria::where('correo', $credenciales['correo'])->first();
    
            if (Auth::attempt(['email' => $credenciales['correo'], 'password' => $credenciales['clave']])) {
                $_SESSION['usuario'] = 'Administrador';
                $_SESSION['id_usuario'] = '1';

                return redirect('/HomeA');
            }
            else if (!$user || !Hash::check($credenciales['clave'], $user->clave)) {
                session_destroy();
    
                return redirect('/InicioSesion')->withErrors(['error' => 'Credenciales inválidas. Por favor, verifica tu correo y contraseña e intenta de nuevo.']);
            }
            else {
                if ($user->estado == '1') {
                    $_SESSION['usuario'] = $user->nombre;
                    $_SESSION['id_usuario'] = $user->id;
        
                    return redirect('/');
                } 
                else {
                    session_destroy();
        
                    return redirect('/InicioSesion')->withErrors(['error' => 'Cuenta inexistente. Por favor, verifica tu correo y contraseña e intenta de nuevo.']);
                }
            }
        }
        catch (Exception $e) {
            return redirect('/InicioSesion')->withErrors(['error' => 'Credenciales inválidas. Por favor, verifica tu correo y contraseña e intenta de nuevo.']);
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

            $llaves = Llaves::get();

            foreach ($llaves as $key) {
                $llave_access = Crypt::decryptString($key->llave_acceso);

                if ($llave_access == $request->llave) {
                    if ($key->status == '1') {
                        UsuarioComisaria::create([
                            'nombre' => $request->nombre,
                            'direccion' => $request->direccion,
                            'correo' => $request->correo,
                            'clave' => Hash::make($request->clave),
                        ]);

                        $llave = Llaves::find($key->id);

                        $llave->update([
                            'status' => '0'
                        ]);
    
                        return redirect('/InicioSesion');
                    }
                    else {
                        return redirect('/RegistroComisaria')->withErrors(['error' => 'La llave ingresada ya esta usada.']);
                    }
                }
            }

            return redirect('/RegistroComisaria')->withErrors(['error' => 'La llave ingresada es incorrecta.' . $llave_access . $request->llave]);
        }
        catch (Exception $e) {
            return redirect('/RegistroComisaria')->withErrors(['error' => 'Hubo un error al registrarse.']);
        }
    }
}
