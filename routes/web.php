<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\ComisariaController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\InicioSesionComisaria;
use App\Http\Controllers\UsuarioComisariaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UsuarioNoRegistradoController;
use App\Http\Controllers\VerMasController;
use App\Models\Alerta;
use App\Models\Denuncia;
use App\Models\Llaves;
use App\Models\ReporteAlertas;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioNoRegistrado;
use App\Models\UsuarioVictima;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;

use function PHPUnit\Framework\returnValueMap;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(InicioSesionComisaria::class)->group(function () {

    session_start();

    Route::get('InicioSesion', 'inicio_sesion_route');

    Route::post('InicioSesionPost', 'inicio_sesion_post');
    Route::post('CerrarSesion', 'cerrar_sesion');
    
    Route::get('RegistroComisaria', 'registro_comisaria_route');
    Route::post('RegistroComisariaPost', 'registro_comisaria_post');
    
});

Route::controller(DenunciaController::class )->group(function () {

    Route::post('RegistroDenunciaPOST', 'registro_denuncia_post');
    Route::delete('EliminarDenuncia/{id}', [DenunciaController::class, 'eliminar_denuncia'])->name('EliminarDenuncia');
    
});

Route::controller(UsuarioComisariaController::class)->group(function () {

    Route::put('EditarComisaria/{id}', 'editar_comisaria');
    Route::put('EditarClave/{id}', 'editar_clave');
    Route::delete('EliminarComisaria/{id}', 'eliminar_comisaria');
    
});

Route::controller(VerMasController::class)->group(function () {

    Route::get('VerMasDenuncia/{id}', 'VerMasDenuncia');
    Route::get('VerUsuarioNoRegistrado/{id}', 'VerMasUsuarioNoRegistrado');

});

Route::get('Inicio', function () {

    try {
        $denuncia = Denuncia::where('id_comisaria', $_SESSION['id_usuario'])->get();

        $dni_registrado = UsuarioVictima::get();
        $dni_no_registrado = UsuarioNoRegistrado::where('id_comisaria', $_SESSION['id_usuario'])->get();

        $denuncias = Collection::make($denuncia)->map(function ($ele) {
            try {
                $victima = UsuarioVictima::find($ele->id_victima);

                $data = [
                    'id' => $ele->id,
                    'dni' => $victima->dni,
                    'lugar' => $ele->lugar,
                    'descripcion' => $ele->descripcion,
                    'prueba_media' => $ele->prueba_media,
                    'created_at' => $ele->created_at,
                ];
            }
            catch (Exception $e) {
                $victima = UsuarioNoRegistrado::find($ele->id_victima);

                $data = [
                    'id' => $ele->id,
                    'dni' => $victima->dni,
                    'lugar' => $ele->lugar,
                    'descripcion' => $ele->descripcion,
                    'prueba_media' => $ele->prueba_media,
                    'created_at' => $ele->created_at,
                ];
            }

            return (object)$data;
        });

        $usuarios_no_registrados = UsuarioNoRegistrado::where('id_comisaria', $_SESSION['id_usuario'])->get();

        if(isset($_SESSION['usuario'])) {

            $usuario_comisaria = UsuarioComisaria::where('nombre', $_SESSION['usuario'])->first();
            return view('./home/HomeComisaria', ['denuncias' => $denuncias, 'dni_1' => $dni_registrado, 'dni_2' => $dni_no_registrado, 'usuario_comisaria' => $usuario_comisaria, 'usuarios_no_registrados' => $usuarios_no_registrados]);
        } 
        else {
            return redirect('/InicioSesion');
        }
    }
    catch (Exception $e) {
        return redirect('/InicioSesion');
    }
    
});


// Web 

Route::controller(ComisariaController::class)->group(function () {

    Route::get('/', 'home');
    Route::get('Alertas', 'alertas');
    Route::get('Denuncias', 'denuncias');
    Route::get('Usuarios', 'usuarios');
    Route::get('Perfil', 'perfil');

    // Report de alertas
    Route::get('ReporteDeAlertas', 'ReporteDeAlertas');

});

Route::controller(UsuarioController::class)->group(function () {

    Route::post('RegistrarVictima', 'RegistrarVictima');
    Route::put('ActualizarUsuario/{id}', 'ActualizarUsuario');
    Route::put('ActualizarClave/{id}', 'ActualizarClave');
    Route::delete('EliminarUsuario/{id}', 'EliminarUsuario');

});

Route::controller(VerMasController::class)->group(function () {

    Route::get('verMasDenuncia/{id}', 'verMasDenuncia');
    Route::get('verMasUsuario/{id}', 'verMasUsuario');

});

// Cambio 

Route::put('ActualizarDenuncia/{id}', [VerMasController::class, 'ActualizarDenuncia']);
Route::put('ActualizarUsuario/{id}', [VerMasController::class, 'ActualizarUsuario']);

// Eliminar Alerta

Route::delete('EliminarAlerta/{id}', function ($id) {

    $alerta = Alerta::where('id_victima', $id)->get();
    $r_alerta = ReporteAlertas::where('id_alerta', $alerta[0]->id);
        $r_alerta->update([
            'status' => '1'
        ]);
    $alerta = Alerta::where('id_victima', $id)->delete();

    return redirect('Alertas');

});

// Link alert

Route::get('alerta/users/{id}', [AlertaController::class, 'VerAlertaVictima']);

// Admin

Route::controller(AdministradorController::class)->group(function () {

    Route::get('HomeA', 'home');
    Route::get('AlertaA', 'alertas');
    Route::get('DenunciasA', 'denuncias');
    
    // Alertas
    Route::get('ReporteAlertaA', 'ReporteDeAlertas');
    Route::delete('eliminarReporteAlerta/{id}', 'eliminarReporteAlerta');

    // Denuncias
    Route::get('verMasDenunciaA/{id}', 'verMasDenunciaA');
    Route::put('ActualizarDenunciaA/{id}', 'ActualizarDenunciaA');

    // Usuarios
    Route::get('UsuariosA', 'Usuarios');
    Route::get('verMasUsuarioA/{id}', 'verMasUsuario');

    // Comisarias

    // Evidencias

    // Contactos
    Route::get('ContactosA', 'Contactos');
    Route::post('AgregarContacto', 'AgregarContacto');
    Route::put('EditarContacto/{id}', 'EditarContacto');
    Route::delete('EliminarContacto/{id}', 'EliminarContacto');

    Route::get('verMasContacto/{id}', 'verMasContacto');

    // Perfil
    Route::get('PerfilA', 'perfil');
    Route::put('EditarPerfilAdmin/{id}', 'EditarPerfilAdmin');
    Route::put('EditarContrasenaAdmin/{id}', 'EditarContrasenaAdmin');
    Route::delete('EliminarLlave/{id}', 'EliminarLlave');

});

// LLaves

Route::post('llavePOST', function (Request $request) {

    Llaves::create([
        'llave_acceso' => Crypt::encryptString($request->llave),
        'status' => '1' // No ah iso usado
    ]);

    return redirect('PerfilA');

});
