<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Denuncia;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioNoRegistrado;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ComisariaController extends Controller
{
    public function home()
    {
        try {
            if (isset($_SESSION['usuario'])) {

                $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();

                $v_alertas = Alerta::count();
                $v_denuncias = Denuncia::where('id_comisaria', $usuario_comisaria->id)->count();
                $v_usuarios = UsuarioNoRegistrado::where('id_comisaria', $usuario_comisaria->id)->count();

                return view('./comisaria/home', [
                    'usuario_comisaria' => $usuario_comisaria,

                    'alertas_n' => $v_alertas,
                    'denuncias_n' => $v_denuncias,
                    'usuarios_n' => $v_usuarios,
                ]);
                
            } else {
                return redirect('/InicioSesion');
            }
        }
        catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function alertas()
    {
        try {
            if (isset($_SESSION['usuario'])) {

                $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();
                $usuarios_victima = UsuarioVictima::get();
                $alertas = Alerta::get();

                return view('./comisaria/alertas', [
                    'usuario_comisaria' => $usuario_comisaria,
                    'alertas' => $alertas,
                    'victimas' => $usuarios_victima
                ]);
                
            } else {
                return redirect('/InicioSesion');
            }
        }
        catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function denuncias()
    {
        try {
            $denuncia = Denuncia::get();

            $dni_registrado = UsuarioVictima::get();
            $dni_no_registrado = UsuarioNoRegistrado::where('id_comisaria', $_SESSION['id_usuario'])->get();

            $denuncias = Collection::make($denuncia)->map(function ($ele) {
                $comisaria = UsuarioComisaria::find($ele->id_comisaria);
                $data = [
                    'id' => $ele->id,
                    'id_comisaria' => $comisaria->nombre,
                    'dni' => $ele->id_victima,
                    'lugar' => $ele->lugar,
                    'descripcion' => $ele->descripcion,
                    'prueba_media' => $ele->prueba_media,
                    'created_at' => $ele->created_at,
                ];

                return (object)$data;
            });

            $usuarios_no_registrados = UsuarioNoRegistrado::where('id_comisaria', $_SESSION['id_usuario'])->get();

            if (isset($_SESSION['usuario'])) {

                $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();

                return view('./comisaria/denuncias', [
                    'denuncias' => $denuncias,
                    'dni_1' => $dni_registrado,
                    'dni_2' => $dni_no_registrado,
                    'usuario_comisaria' => $usuario_comisaria,
                    'usuarios_no_registrados' => $usuarios_no_registrados
                ]);
                
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function usuarios()
    {
        try {
            $usuario_no_registrados = UsuarioNoRegistrado::get();

            $usuarios = Collection::make($usuario_no_registrados)->map(function ($ele) {
                $comisaria = UsuarioComisaria::find($ele->id_comisaria);

                $data = [
                    'id' => $ele->id,
                    'dni' => $ele->dni,
                    'nombre' => $ele->nombre,
                    'apellido' => $ele->apellido,
                    'celular' => $ele->celular,
                    'direccion' => $ele->direccion,
                    'correo' => $ele->correo,
                    'comisaria' => $comisaria->nombre
                ];

                return (object)$data;
            });

            if (isset($_SESSION['usuario'])) {

                $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();

                return view('./comisaria/usuarios', [
                    'usuario_comisaria' => $usuario_comisaria,
                    'usuario_no_registrado' => $usuarios
                ]);
                
            } else {
                return redirect('/InicioSesion');
            }
        }
        catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function perfil()
    {
        try {
            if (isset($_SESSION['usuario'])) {

                 $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();
                return view('./comisaria/perfil', [
                    'usuario_comisaria' => $usuario_comisaria
                ]);
                
            } else {
                return redirect('/InicioSesion');
            }
        }
        catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }
}
