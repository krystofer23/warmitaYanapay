<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alerta;
use App\Models\ReporteAlertas;
use App\Models\UsuarioVictima;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AlertasController extends Controller
{
    public function RegistrarAlerta (Request $request) {
        try {
            $this->validate($request, [
                'id_victima' => 'required',
                'latitud' => 'required',
                'longitud' => 'required'
            ]);

            $alerta = Alerta::create([
                'id_victima' => $request->id_victima,
                'latitud' => $request->latitud,
                'longitud' => $request->longitud
            ]);

            ReporteAlertas::create([
                'id_victima' => $alerta->id_victima,
                'id_alerta' => $alerta->id,
                'status' => '0'
            ]);

            return response()->json([
                'status' => 'success',
                'id_alerta' => $alerta->id
            ], Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al registrar la alerta',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ActualizarAlerta (Request $request) {
        try {
            $this->validate($request, [
                'id_victima' => 'required',
                'latitud' => 'required',
                'longitud' => 'required'
            ]);

            $alerta = Alerta::where('id_victima', $request->id_victima);
            
            $alerta->update([
                'latitud' => $request->latitud,
                'longitud' =>  $request->longitud
            ]);
            
            return response()->json([
                'status' => 'success'
            ], Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al actualizar la alerta',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function EliminarAlerta (Request $request) {
        $this->validate($request, [
            'id_victima' => 'required'
        ]);

        $alerta = Alerta::where('id_victima', $request->id_victima)->first();

        $reporte_alerta = ReporteAlertas::where('id_alerta', $alerta->id);
        $reporte_alerta->update([
            'status' => '1'
        ]);

        $alerta2 = Alerta::where('id_victima', $request->id_victima);
        $alerta2->delete();

        return response()->json([
            'status' => 'success'
        ], Response::HTTP_CREATED);
    }
}
