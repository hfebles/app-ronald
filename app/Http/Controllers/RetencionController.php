<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\RetencionController as ApiRetencionController;
use App\Models\DatosEmpresa;
use App\Models\Proveedor;
use App\Models\Retencion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RetencionController extends Controller
{
    public function index()
    {
        $retenciones = Retencion::select('retencions.*', 'proveedors.name', 'datos_empresas.name_empresa')
            ->join('proveedors', 'proveedors.id', '=', 'retencions.proveedor_id')
            ->join('datos_empresas', 'retencions.empresa_id', '=', 'datos_empresas.id')
            ->orderBy('retencions.created_at', 'DESC')
            ->get();

        return view('retenciones.index', compact('retenciones'));
    }

    public function create()
    {
        $proveedores = Proveedor::select('name', 'id')->get();
        $propias = DB::table('datos_empresas')->get();

        return view('retenciones.create', compact('proveedores', 'propias'));
    }

    public function store(Request $request)
    {
        // return $request;

        $nro_correlativo = DatosEmpresa::getCorrelativo($request->empresa_id);

        $longitud_deseada = max(0, 7 - strlen($nro_correlativo)) + strlen($nro_correlativo);
        $correlativo = str_pad($nro_correlativo, $longitud_deseada, '0', STR_PAD_LEFT);

        $retencion = new Retencion();
        $retencion->proveedor_id = $request->proveedor_id;
        $retencion->empresa_id = $request->empresa_id;
        $retencion->nro_factura = $request->nro_factura;
        $retencion->nro_control = $request->nro_control;
        $retencion->fecha_factura = $request->fecha;
        $retencion->monto = $request->monto;
        $retencion->nro_comprobante = date('Ym') . $correlativo;
        // Guardamos la retencion
        $retencion->save();

        // Actualizamos el correlativo
        DatosEmpresa::updateCorrelativo($request->empresa_id, (int) $nro_correlativo + 1);

        $update = (new ApiRetencionController())->retencionPdfAPI($retencion->id, 1);

        Retencion::where('id', '=', $retencion->id)->update(['ruta' => $update['pdf'], 'b64' => $update['b64']]);

        return redirect()->route('retenciones.index');
    }

    public function validarNumeroFactura(Request $request)
    {
        // return $request;
        $retencion = Retencion::where('nro_factura', '=', $request->nro_factura)->first();

        return response()->json($retencion, 200);
    }

    public function validarNumeroControl(Request $request)
    {
        // return $request;
        $retencion = Retencion::where('nro_control', '=', $request->nro_control)->first();

        return response()->json($retencion, 200);
    }
}
