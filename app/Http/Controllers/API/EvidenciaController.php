<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Evidencia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EvidenciaController extends Controller
{
    public function index(Request $request) {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $evidencias = Evidencia::where('id_victima', $request->id)->get();

        return $evidencias;
    }

    public function store (Request $request) 
    {
        try {
            $this->validate($request, [
                'id_victima' => 'required',
                'descripcion' => 'required',
                'file' => '',
                'datos_agresor' => 'required',
            ]);

            $url = 'https://apiperu.dev/api/dni';

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Bearer c59a841e3207922843de445f6e4b58dce01fed82aabbaa068163586d1ce3a486'
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['dni' => $request->id_victima]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);

            curl_close($ch);
    
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move('images', $imageName);
                
                Evidencia::create([
                    'id_victima' => json_decode($response)->data->numero,
                    'descripcion' => $request->descripcion,
                    'evidencia_media' => '/images/' . $imageName,
                    'datos_agresor' => $request-> datos_agresor
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Evidencia creada con exito.'
                ], Response::HTTP_CREATED);
            }
            else {
                Evidencia::create([
                    'id_victima' => json_decode($response)->data->numero,
                    'descripcion' => $request->descripcion,
                    'evidencia_media' => '',
                    'datos_agresor' => $request-> datos_agresor
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Evidencia creada con exito.'
                ], Response::HTTP_CREATED);
            }
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al crear la evidencia.' . $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy (Request $request) 
    {
        try {
            $this->validate($request, [
                'id' => 'required'
            ]);

            $evi = Evidencia::find($request->id);
            $evi->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Evidencia eliminada con exito.'
            ], Response::HTTP_CREATED);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un error al eliminar la evidencia.'
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update (Request $request) 
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('images', $imageName);
            
            $evidencia = Evidencia::find($request->id);
            $evidencia->update([
                'descripcion' => $request->descripcion,
                'evidencia_media' => '/images/' . $imageName,
                'datos_agresor' => $request-> datos_agresor
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Evidencia actualizado con exito.'
            ], Response::HTTP_CREATED);
        }
        else {
            $evidencia = Evidencia::find($request->id);
            $evidencia->update([
                'descripcion' => $request->descripcion,
                'evidencia_media' => '',
                'datos_agresor' => $request-> datos_agresor
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Evidencia actualizado con exito.'
            ], Response::HTTP_CREATED);
        }
    }

    public function getEvidence (Request $request)
    {
        $detalle_contacto = Evidencia::find($request->id);
        return $detalle_contacto;
    }
}
