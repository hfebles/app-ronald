<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Retencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetencionController extends Controller
{

    public function index()
    {

        $retenciones = Retencion::select('retencions.*', 'clientes.name', 'datos_empresas.name_empresa')
            ->join('clientes', 'clientes.id', '=', 'retencions.client_id')
            ->join('datos_empresas', 'retencions.empresa_id', '=', 'datos_empresas.id')
            ->orderBy('retencions.created_at', 'DESC')
            ->get();

        // return $retenciones;

        return view('retenciones.index', compact('retenciones'));
    }


    public function create()
    {
        $clientes = Clientes::select('name', 'id')->get();
        $propias = DB::table('datos_empresas')->get();

        return view('retenciones.create', compact('clientes', 'propias'));
    }

    public function store(Request $request)
    {
        $nro_correlativo = \DB::select('select nro_correlativo from datos_empresas where id=' . $request->empresa_id)[0]->nro_correlativo;

        $longitud_deseada = max(0, 7 - strlen($nro_correlativo)) + strlen($nro_correlativo);
        $correlativo = str_pad($nro_correlativo, $longitud_deseada, '0', STR_PAD_LEFT);


        // formateamos el numero de control de la factura
        $nro_control = sprintf('%08d', $request->nro_control);
        $nro_control = substr_replace($nro_control, '-', 2, 0);

        $retencion = new Retencion();
        $retencion->client_id = $request->client_id;
        $retencion->empresa_id = $request->empresa_id;
        $retencion->nro_factura = $request->nro_factura;
        $retencion->nro_control = $nro_control;
        $retencion->fecha_factura = $request->fecha;
        $retencion->monto = $request->monto;
        $retencion->nro_comprobante = date('Ym') . $correlativo;


        // return $retencion;
        $retencion->save();

        DB::table('datos_empresas')->where('id', $request->empresa_id)->update(['nro_correlativo' => (int)$nro_correlativo + 1]);

        return redirect()->route('retenciones.index');
    }
}
