<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\ReporteAlertas;
use App\Models\UsuarioVictima;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function VerAlertaVictima ($id) {
        try {
            $alerta = Alerta::find($id);
            $victima = UsuarioVictima::find($alerta->id_victima);

            return view('alerta/alerta', ['alertas' => $alerta, 'victimas' => $victima]);
        }
        catch (\Exception $e) {
            return redirect('https://www.google.com');
        }
    }
}
