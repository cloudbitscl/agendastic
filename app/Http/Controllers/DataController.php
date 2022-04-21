<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Models\ServicioProveedor;

class DataController extends Controller
{
    public function getServicios()
    {
        return Servicio::all();
    }

    public function getProveedores()
    {
        return Proveedor::all();
    }

    public function getServiciosProveedor(Request $request)
    {
        $proveedor_id = $request->proveedor_id;
        return Servicio::whereHas('proveedores', function($query) use($proveedor_id){
            $query->where('proveedores.id',$proveedor_id);
        })->get();
    }

    public function getProveedoresServicio(Request $request)
    {
        $servicio_id = $request->servicio_id;
        return Proveedor::whereHas('servicios', function($query) use($servicio_id){
            $query->where('servicios.id',$servicio_id);
        })->get();
    }

    public function getDiasProveedorServicio(Request $request)
    {
        /**
         * Días: 0-domingo, 1-lunes, ..., 6-sabado
         */

        $proveedor_id = $request->proveedor_id;
        $servicio_id = $request->servicio_id;
        $dias = [];

        // Busca disponibilidad de servicio de proveedor
        $servicio_proveedor = ServicioProveedor::where([
                ['proveedor_id',$proveedor_id],
                ['servicio_id',$servicio_id],
            ])
            ->whereNotNull('disponibilidad')
            ->select('disponibilidad')
            ->first();
        
        // Si no tiene establecida disponibilidad por servicio, busca por proveedor en ultima instancia
        if(!empty($servicio_proveedor->disponibilidad)) {
            $disponibilidad = json_decode($servicio_proveedor->disponibilidad, true);
        } else {
            $proveedor = Proveedor::find($proveedor_id);
            $disponibilidad = json_decode($proveedor->disponibilidad, true);
        }

        if(is_array($disponibilidad)) {
            foreach($disponibilidad as $dia => $horas){
                $dias[] = $dia;
            }
        }

        return $dias;
    }

    public function getHorasDiaProveedorServicio(Request $request)
    {
        return [
            ['15:00'],
            ['16:00'],
            ['17:00'],
            ['19:00'],
        ];
    }
}
