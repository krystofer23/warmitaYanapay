<?php

use App\Http\Controllers\ComisariaController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\InicioSesionComisaria;
use App\Http\Controllers\UsuarioComisariaController;
use App\Http\Controllers\UsuarioNoRegistradoController;
use App\Http\Controllers\VerMasController;
use App\Models\Denuncia;
use App\Models\UsuarioComisaria;
use App\Models\UsuarioNoRegistrado;
use App\Models\UsuarioVictima;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Route;

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

Route::controller(UsuarioNoRegistradoController::class)->group(function () {

    Route::post('RegistroUsuarioNoRegistrado', 'registro_usuario_no_registrado');
    Route::put('EditarUsuarioNoRegistrado/{id}', 'editar_usuario_no_registrado');

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

Route::controller(ComisariaController::class)->group(function () {

    Route::get('/', 'home');
    Route::get('Alertas', 'alertas');
    Route::get('Denuncias', 'denuncias');
    Route::get('Usuarios', 'usuarios');
    Route::get('Perfil', 'perfil');

});