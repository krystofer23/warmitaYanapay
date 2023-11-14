<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Contactos;
use App\Models\Denuncia;
use App\Models\DetalleContacto;
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

    // Inicio

    // Alertas
    public function eliminarReporteAlerta ($id) 
    {   
        $reporte_alerta = ReporteAlertas::find($id);
        $reporte_alerta->delete();

        return redirect('ReporteAlertaA');
    }

    // Denuncias
    public function ActualizarDenunciaA (Request $request, $id) 
    {
        $denuncia = Denuncia::find($id);
        $denuncia->update([
            'descripcion' => $request->descripcion,
            'lugar' => $request->lugar
        ]);

        return redirect('verMasDenunciaA/' . $id);
    }

    public function verMasDenunciaA ($id) 
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

        return view('./admin/verMasDenuncia', [
            'denuncia' => $denuncia,
            'victima' => $victima,
            'comisaria' => $comisaria
        ]);
    }

    // Usuarios 
    public function Usuarios () 
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

                return view('./admin/usuarios', [
                    'usuario_comisaria' => User::find($_SESSION['id_usuario']),
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

    public function verMasUsuario ($id) 
    {
        $usuario = UsuarioVictima::find($id);

        $evidencias = Evidencia::where('id_victima', $usuario->dni)->get();
        $contactos = Contactos::where('id_victima', $usuario->id)->get();
        $denuncias = Denuncia::where('id_victima', $usuario->dni)->get();

        $detalle_contactos = Collection::make($contactos)->map(function ($ele) {
            $detalle_contacto = DetalleContacto::find($ele->id_detalle_contacto);

            $data = [
                'id' => $ele->id,
                'nombre' => $detalle_contacto->nombre,
                'apellido' => $detalle_contacto->apellido,
                'celular' => $detalle_contacto->celular,
                'direccion' => $detalle_contacto->dirrecion,
            ];

            return (object)$data;
        });

        return view('./admin/verMasUsuario', [
            'usuario' => $usuario,
            'evidencias' => $evidencias,
            'contactos' => $detalle_contactos,
            'denuncias' => $denuncias,



            't_evidencias' =>  Evidencia::where('id_victima', $usuario->dni)->count(),
            't_contactos' =>  Contactos::where('id_victima', $usuario->id)->count(),
            't_denuncias' =>  Denuncia::where('id_victima', $usuario->dni)->count(),
        ]);
    }

    // Comisarias

    // Evidencias

    // Contactos 
    public function Contactos () 
    {
        try {
            if (isset($_SESSION['usuario'])) {
                $contactos = Contactos::get();
                $contactos_get = Collection::make($contactos)->map(function ($ele) {
                    $victima = UsuarioVictima::find($ele->id_victima);
                    $detalle_contacto = DetalleContacto::find($ele->id_detalle_contacto);

                    $data = [
                        'id' => $ele->id,
                        'nombre_victima' => $victima->nombre . ' ' . $victima->apellido,
                        'dni' => $victima->dni,
                        'nombre_contacto' => strtoupper($detalle_contacto->nombre . ' ' . $detalle_contacto->apellido),
                        'numero_contacto' => $detalle_contacto->celular
                    ];
                    
                    return (object)$data;
                }); 

                return view('./admin/contactos', [
                    'usuario_comisaria' => User::find($_SESSION['id_usuario']),
                    'contactos' => $contactos_get
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    public function AgregarContacto (Request $request) 
    {
        try {
            $this->validate($request, [
                'dni' => 'required', 
                'nombre' => 'required', 
                'apellido' => 'required', 
                'celular' => 'required', 
                'direccion' => 'required'
            ]);

            $victima = UsuarioVictima::where('dni', $request->dni)->first();

            if ($victima) {
                $detalle_contacto = DetalleContacto::create([
                    'nombre' => $request->nombre,
                    'apellido' => $request->apellido,
                    'celular' => $request->celular,
                    'dirrecion' => $request->direccion
                ]);

                $contacto = Contactos::create([
                    'id_victima' => $victima->id,
                    'id_detalle_contacto' => $detalle_contacto->id
                ]);

                return redirect('ContactosA');
            }
            else {
                return redirect('ContactosA')->withErrors(['error' => 'Hubo un error al registrar el contacto, verifique los datos (DNI). ']);
            }
        }
        catch (Exception $e) {
            return redirect('ContactosA')->withErrors(['error' => 'Hubo un error al registrar el contacto, verifique los datos (DNI). ']);
        }
    } 

    public function EditarContacto (Request $request, $id) 
    {
        $contacto = Contactos::find($id);

        $detalle_contacto = DetalleContacto::find($contacto->id_detalle_contacto);
        $detalle_contacto->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'celular' => $request->celular,
            'dirrecion' => $request->direccion
        ]);

        return redirect('verMasContacto' . '/' . $id);
    }

    public function EliminarContacto ($id) 
    {
        $contacto = Contactos::find($id);
        $contacto->delete();
        $detalle_contacto = DetalleContacto::where('id', $contacto->id_detalle_contacto)->delete();

        return redirect('ContactosA');
    }    
    
    public function verMasContacto ($id) 
    {
        try {
            if (isset($_SESSION['usuario'])) {
                $contacto = Contactos::find($id);
                $victima = UsuarioVictima::find($contacto->id_victima);
                $detalle_contacto = DetalleContacto::find($contacto->id_detalle_contacto);



                return view('./admin/verMasContactos', [
                    'usuario_comisaria' => User::find($_SESSION['id_usuario']),
    
                    'victima' => $victima,
                    'detalle_contacto' => $detalle_contacto,
                    't_contactos' => Contactos::where('id_victima', $victima->id)->count(),

                    'id' => $id
                ]);
            } else {
                return redirect('/InicioSesion');
            }
        } catch (Exception $e) {
            return redirect('/InicioSesion');
        }
    }

    // Mi perfil
    public function EditarPerfilAdmin (Request $request, $id) 
    {
        $usuario = User::find($id);
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect('PerfilA');
    }

    public function EditarContrasenaAdmin (Request $request, $id) 
    {
        $usuario = User::find($id);
        $usuario->update([
            'password' => $request->password
        ]);

        return redirect('PerfilA');
    }

    public function EliminarLlave ($id) 
    {
        $llave = Llaves::find($id);
        $llave->delete();

        return redirect('PerfilA');
    }

    // Ver mas
}
