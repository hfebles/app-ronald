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

        $retenciones = Retencion::select('retencions.*', 'clientes.*')->join('clientes', 'clientes.id', '=', 'retencions.client_id')->get();

        // return $retenciones;

        return view('retenciones.index', compact('retenciones'));
    }


    public function create()
    {
        $clientes = Clientes::select('name', 'id')->get();
        $propia = DB::table('datos_empresas')->get();

        // return $propia;

        return view('retenciones.create', compact('clientes'));
    }

    public function store(Request $request)
    {

        // formateamos el numero de control de la factura
        $nro_control = sprintf('%08d', $request->nro_control);
        $nro_control = substr_replace($nro_control, '-', 2, 0);

        $retencion = new Retencion();
        $retencion->client_id = $request->client_id;
        $retencion->nro_factura = $request->nro_factura;
        $retencion->nro_control = $nro_control;
        $retencion->fecha_factura = $request->fecha;
        $retencion->monto = $request->monto;
        $retencion->save();

        //formateamos el nro de comprobante 
        $longitud_deseada = max(0, 7 - strlen($retencion->id)) + strlen($retencion->id);
        $correlativo = str_pad($retencion->id, $longitud_deseada, '0', STR_PAD_LEFT);

        // Actualizamos el numero de comprobante.
        Retencion::find($retencion->id)->update(['nro_comprobante' => date('Ym', strtotime($retencion->created_at)) . $correlativo]);

        return (new ReportesController)->retencionPdf($retencion->id);
        return back();
    }
}
