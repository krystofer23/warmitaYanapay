<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contactos;
use App\Models\DetalleContacto;
use Exception;
use Illuminate\Http\Request;

class ContactosController extends Controller
{
    public function index(Request $request) { 
        $contactos = Contactos::where('id_victima', $request->id_victima)->get();
        $lista = [];

        foreach ($contactos as $row) {
            $detalle = DetalleContacto::find($row->id);
            array_push($lista, $detalle);
        }

        return $lista;
    }

    public function RegistroContacto (Request $request) 
    {
        try {
            $this->validate($request, [
                'id_victima' => 'required',
                'nombre' => 'required',
                'apellido' => 'required',
                'celular' => 'required',
                'direccion' => 'required'
            ]);

            $detalle_contacto = DetalleContacto::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'celular' => $request->celular,
                'dirrecion' => $request->direccion,
            ]);

            Contactos::create([
                'id_victima' => $request->id_victima,
                'id_detalle_contacto' => $detalle_contacto->id,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Contacto creado con exito'
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => $e->getMessage()
            ]);
        }
    }   

    public function EliminarContacto (Request $request) 
    {
        $contacto = Contactos::find($request->id);
        $detalle_contacto = DetalleContacto::find($contacto->id_detalle_contacto);

        $contacto->delete();
        $detalle_contacto->delete();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Contacto eliminado con exito'
        ]);
    }

    public function update (Request $request) 
    {
        $detalle_contacto = DetalleContacto::find($request->id);
        $detalle_contacto->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'celular' => $request->celular,
            'dirrecion' => $request->direccion
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Contacto actualizado con exito'
        ]);
    }

    public function getContact (Request $request)
    {
        $detalle_contacto = DetalleContacto::find($request->id);
        return $detalle_contacto;
    }
}
