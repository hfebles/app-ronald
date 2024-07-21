<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\DatosEmpresa;
use App\Models\Proveedor;
use App\Models\Retencion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        return response()->json($retenciones, 200);
    }

    public function create()
    {
        $clientes = Clientes::select('name', 'id')->get();
        $propias = DB::table('datos_empresas')->get();

        return view('retenciones.create', compact('clientes', 'propias'));
    }

    public function getEmpresas($id)
    {
        $empresa = DatosEmpresa::find($id);

        if ($empresa !== null) {
            return response()->json($empresa, 200);
        }
        return response()->json(['status' => 0, 'message' => 'No existe empresa con ese identificador, por favor seleccione una de la lista.'], 200);
    }

    public function getCliente($rif)
    {
        $cliente = Proveedor::where('rif', '=', $rif)->get();
        if (count($cliente) > 0) {
            return response()->json($cliente[0], 200);
        }
        return response()->json(['status' => 0, 'message' => 'error', 'data' => 'El proveedor no existe, por favor ingrese un *RIF Existente*'], 200);
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

        $retencion->save();

        DB::table('datos_empresas')->where('id', $request->empresa_id)->update(['nro_correlativo' => (int) $nro_correlativo + 1]);

        return $this->retencionPdfAPI($retencion->id, 0);
    }

    public function getRetencionFactura($factura)
    {
        $retencion_id = Retencion::where('nro_factura', '=', $factura)->first()->id;
        return $this->retencionPdfAPI($retencion_id, 0);
    }

    public function retencionPdfAPI($id, $type)
    {
        $retencion = Retencion::getRetencion($id);
        $rif_cliente = preg_replace('/(\D)(\d{8})(\d)/', '$1-$2-$3', $retencion->rif);
        $data = [
            'title' => $retencion->nro_comprobante . '_' . date('Ymd', strtotime($retencion->created_at)),
            'retencion' => $retencion,
            'rif_cliente' => $rif_cliente,
            'fecha_retencion' => date('d/m/Y', strtotime($retencion->created_at)),
            'mes_fiscal' => date('m', strtotime($retencion->created_at)),
            'anio_fiscal' => date('Y', strtotime($retencion->created_at)),
            'base_imponible' => $retencion->monto,
            'total_iva' => $retencion->monto + ($retencion->monto * 0.16),
            'iva' => $retencion->monto * 0.16,
            'retenido' => $retencion->ag === 0 ? $retencion->monto * 0.16 * 0.75 : $retencion->monto * 0.16 * $retencion->percent,

        ];
        $pdf = Pdf::loadView('reportes.retencion-pdf', $data)->setPaper('a4', 'landscape');
        Storage::disk('public')->put('pdf/' . $retencion->nro_comprobante . '.pdf', $pdf->output());
        $b64 = base64_encode($pdf->output());
        if ($type === 0) {
            Retencion::where('id', '=', $retencion->id)->update(['ruta' => 'http://127.0.0.1:8000/storage/pdf/' . $retencion->nro_comprobante . '.pdf', 'b64' => $b64]);
            return response()->json(['nombre' => $retencion->nro_comprobante, 'pdf' => 'http://127.0.0.1:8000/storage/pdf/' . $retencion->nro_comprobante . '.pdf'], 200);
        }
        return ['pdf' => 'http://127.0.0.1:8000/storage/pdf/' . $retencion->nro_comprobante . '.pdf', 'b64' => $b64];
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
