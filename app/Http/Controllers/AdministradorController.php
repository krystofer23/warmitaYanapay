<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Contactos;
use App\Models\Denuncia;
use App\Models\Evidencia;
use App\Models\Llaves;
use App\Models\ReporteAlertas;
use App\Models\User;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioCreadoComisaria;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AdministradorController extends Controller
{
    // Home 
    public function home () 
    {
        try {
            if (isset($_SESSION['usuario'])) {

                $v_denuncias = Denuncia::count();

                // Alertas
                $total_alertas = ReporteAlertas::count();
                $alertas_no_atendidas = ReporteAlertas::where('status', '0')->count();
                $alertas_atendidas = ReporteAlertas::where('status', '1')->count();

                // Ultimos registro de denuncias
                $fechaActualMenos24Horas = date('Y-m-d H:i:s', strtotime('-24 hours'));
                $denuncias = Denuncia::where('created_at', '>', $fechaActualMenos24Horas)->get();

                return view('./admin/home', [
                    'usuario' => User::find($_SESSION['id_usuario']),

                    'denuncias_n' => $v_denuncias,

                    'usuarios_r' => UsuarioCreadoComisaria::count(),
                    'usuarios' => UsuarioVictima::count(),

                    // Alertas
                    'total_alertas' => $total_alertas,
                    'alertas_no_atendidas' => $alertas_no_atendidas,
                    'alertas_atendidas' => $alertas_atendidas,

                    'denuncias' => $denuncias,
                    'denuncias_H' => $denuncias->count(),

                    // Comisaria
                    'comisarias_t' => UsuarioComisaria::count(),
                    // Contactos
                    'contactos_t' => Contactos::count(),
                    // Evidencias
                    'evidencias_t' => Evidencia::count()
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function alertas () {
        try {
            if (isset($_SESSION['usuario'])) {
                
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

                return view('./admin/alertas', [
                    'usuario_comisaria' => User::find($_SESSION['id_usuario']),
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

    public function perfil () 
    {
        try {
            if (isset($_SESSION['usuario'])) {

                $v_denuncias = Denuncia::count();

                // Alertas
                $total_alertas = ReporteAlertas::count();
                $alertas_no_atendidas = ReporteAlertas::where('status', '0')->count();
                $alertas_atendidas = ReporteAlertas::where('status', '1')->count();

                // Ultimos registro de denuncias
                $fechaActualMenos24Horas = date('Y-m-d H:i:s', strtotime('-24 hours'));
                $denuncias = Denuncia::where('created_at', '>', $fechaActualMenos24Horas)->get();

                // Llaves 
                $llaves = Llaves::get();
                $llaves_view = Collection::make($llaves)->map(function ($ele) {
                    return (object)[
                        'id' => $ele->id,
                        'llave' => Crypt::decryptString($ele->llave_acceso),
                        'status' => $ele->status,
                    ];
                });

                return view('./admin/perfil', [
                    'usuario' => User::find($_SESSION['id_usuario']),

                    'llave' => $llaves_view
                    // 'denuncias_n' => $v_denuncias,

                    // 'usuarios_r' => UsuarioCreadoComisaria::count(),
                    // 'usuarios' => UsuarioVictima::count(),

                    // // Alertas
                    // 'total_alertas' => $total_alertas,
                    // 'alertas_no_atendidas' => $alertas_no_atendidas,
                    // 'alertas_atendidas' => $alertas_atendidas,

                    // 'denuncias' => $denuncias,
                    // 'denuncias_H' => $denuncias->count(),

                    // // Comisaria
                    // 'comisarias_t' => UsuarioComisaria::count(),
                    // // Contactos
                    // 'contactos_t' => Contactos::count(),
                    // // Evidencias
                    // 'evidencias_t' => Evidencia::count()
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function ReporteDeAlertas()
    {
        try {
            if (isset($_SESSION['usuario'])) {

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

                return view('./admin/reporteAlerta', [
                    'usuario_comisaria' => User::find($_SESSION['id_usuario']),

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

    public function denuncias () 
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

                return view('./admin/denuncias', [
                    'usuario_comisaria' => User::find($_SESSION['id_usuario']),
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
}
