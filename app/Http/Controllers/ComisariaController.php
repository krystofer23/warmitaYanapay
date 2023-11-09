<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Denuncia;
use App\Models\ReporteAlertas;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioCreadoComisaria;
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

                $v_denuncias = Denuncia::where('id_comisaria', $usuario_comisaria->id)->count();

                // Alertas
                $total_alertas = ReporteAlertas::count();
                $alertas_no_atendidas = ReporteAlertas::where('status', '0')->count();
                $alertas_atendidas = ReporteAlertas::where('status', '1')->count();

                // Ultimos registro de denuncias
                $fechaActualMenos24Horas = date('Y-m-d H:i:s', strtotime('-24 hours'));
                $denuncias = Denuncia::where('created_at', '>', $fechaActualMenos24Horas)->where('id_comisaria', $_SESSION['id_usuario'])->get();

                return view('./comisaria/home', [
                    'usuario_comisaria' => $usuario_comisaria,

                    'denuncias_n' => $v_denuncias,

                    'usuarios_r' => UsuarioCreadoComisaria::where('id_comisaria', $usuario_comisaria->id)->count(),
                    'usuarios' => UsuarioVictima::count(),

                    // Alertas
                    'total_alertas' => $total_alertas,
                    'alertas_no_atendidas' => $alertas_no_atendidas,
                    'alertas_atendidas' => $alertas_atendidas,

                    'denuncias' => $denuncias,
                    'denuncias_H' => $denuncias->count()
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
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

                $dni_alertas = Collection::make($alertas)->map(function ($ele) {
                    $usuario = UsuarioVictima::find($ele->id_victima);

                    $data = [
                        'id' => $ele->id,
                        'dni' => $usuario->dni,
                        'created_at' => $ele->created_at,
                        'id_victima' => $ele->id_victima
                    ];

                    return (object)$data;
                });

                return view('./comisaria/alertas', [
                    'usuario_comisaria' => $usuario_comisaria,
                    'alertas' => $alertas,
                    'victimas' => $usuarios_victima,
                    'dni_alertas' => $dni_alertas
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function denuncias()
    {
        try {
            if (isset($_SESSION['usuario'])) {

                $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();

                $denuncias_get = Denuncia::get();

                $denuncias = Collection::make($denuncias_get)->map(function ($ele) {
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

                $mis_denuncias = Denuncia::where('id_comisaria', $_SESSION['id_usuario'])->get();

                return view('./comisaria/denuncias', [
                    'usuario_comisaria' => $usuario_comisaria,
                    'denuncias' => $denuncias,
                    'mis_denuncias' => $mis_denuncias
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
            if (isset($_SESSION['usuario'])) {

                $usuarios_creado_comisaria = UsuarioCreadoComisaria::get();
                $usuarios_comisaria = Collection::make($usuarios_creado_comisaria)->map(function ($ele) {
                    $usuario_victima = UsuarioVictima::find($ele->id_victima);
                    $usuario_comisaria = UsuarioComisaria::find($ele->id_comisaria);

                    $data = [
                        'id' => $usuario_victima->id,
                        'comisaria' => $usuario_comisaria->nombre,
                        'dni' => $usuario_victima->dni,
                        'nombre' => $usuario_victima->nombre,
                        'apellido' => $usuario_victima->apellido,
                        'celular' => $usuario_victima->celular,
                        'direccion' => $usuario_victima->direccion,
                        'correo' => $usuario_victima->correo
                    ];

                    return (object)$data;
                });

                $usuarios = UsuarioVictima::get();
                $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();

                return view('./comisaria/usuarios', [
                    'usuario_comisaria' => $usuario_comisaria,
                    'usuarios' => $usuarios,
                    'usuarios_comisaria' => $usuarios_comisaria
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    // Reporte de alertas 

    public function ReporteDeAlertas()
    {
        try {
            if (isset($_SESSION['usuario'])) {
                $usuario_comisaria = UsuarioComisaria::where('id', $_SESSION['id_usuario'])->first();

                // Alertas
                $total_alertast = ReporteAlertas::count();
                $alertas_no_atendidast = ReporteAlertas::where('status', '0')->count();
                $alertas_atendidast = ReporteAlertas::where('status', '1')->count();

                // Alertas por atender
                $alertas_por_atender = ReporteAlertas::where('status', '0')->get();
                $alertas_por_atender_get = Collection::make($alertas_por_atender)->map(function ($alert) {
                    $usuario = UsuarioVictima::find($alert->id_victima);

                    $data = [
                        'id' => $alert->id,
                        'dni' => $usuario->dni,
                        'id_victima' => $alert->id_victima,
                        'created_at' => $alert->created_at
                    ];

                    return (object)$data;
                });

                // Alertas atendias
                $alertas_atendidas = ReporteAlertas::where('status', '1')->get();
                $alertas_atendidas_get = Collection::make($alertas_atendidas)->map(function ($alert) {
                    $usuario = UsuarioVictima::find($alert->id_victima);

                    $data = [
                        'id' => $alert->id,
                        'dni' => $usuario->dni,
                        'id_victima' => $alert->id_victima,
                        'created_at' => $alert->created_at
                    ];

                    return (object)$data;
                });

                // Todas las alertas 
                $alertas = ReporteAlertas::get();
                $alertas_get = Collection::make($alertas)->map(function ($alert) {
                    $usuario = UsuarioVictima::find($alert->id_victima);
                    $data = [
                        'id' => $alert->id,
                        'status' => $alert->status,
                        'dni' => $usuario->dni,
                        'id_victima' => $alert->id_victima,
                        'created_at' => $alert->created_at
                    ];

                    return (object)$data;
                });

                return view('./comisaria/reporteAlertas', [
                    'usuario_comisaria' => $usuario_comisaria,

                    'alertas_por_atender' => $alertas_por_atender_get,
                    'alertas_atendidas' => $alertas_atendidas_get,
                    'alertas' => $alertas_get,

                    // Alertas
                    'total_alertast' => $total_alertast,
                    'alertas_no_atendidast' => $alertas_no_atendidast,
                    'alertas_atendidast' => $alertas_atendidast,
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }
}
