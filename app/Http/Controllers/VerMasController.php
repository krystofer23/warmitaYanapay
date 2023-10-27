<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\UsuarioNoRegistrado;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Http\Request;

class VerMasController extends Controller
{
    public function VerMasDenuncia ($id) 
    {
        $denuncia = Denuncia::find($id);
        
        try {
            $usuario = UsuarioVictima::find($denuncia->id_victima);
        }
        catch (Exception $e) {
            $usuario = UsuarioNoRegistrado::find($denuncia->id_victima);
        }

        return view('./layouts/VerDenuncia', ['denuncia' => $denuncia, 'usuario' => $usuario]);
    }

    public function VerMasUsuarioNoRegistrado ($id) 
    {
        $usuario_no_registrado = UsuarioNoRegistrado::find($id);

        return view('./layouts/VerUsuarioNoRegistrado', ['usuario' => $usuario_no_registrado]);
    }
}
