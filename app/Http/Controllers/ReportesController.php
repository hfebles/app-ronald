<?php

namespace App\Http\Controllers;

use App\Models\DatosEmpresa;
use App\Models\Retencion;
use App\Models\User;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesController extends Controller
{
    //

    public function retencionPdf($id)

    {





        // return $id;

        $retencion = Retencion::select('retencions.*', 'clientes.*')
            ->where('retencions.id', '=', $id)
            ->join('clientes', 'clientes.id', '=', 'retencions.client_id')
            ->get()[0];


        $empresa = DatosEmpresa::all()[0];

        // return $retencion;


        $rif_cliente = preg_replace('/(\D)(\d{8})(\d)/', '$1-$2-$3', $retencion->rif);


        $data = [
            'title' => $retencion->nro_comprobante . '_' . date('Ymd', strtotime($retencion->created_at)),
            'retencion' => $retencion,
            'empresa' => $empresa,
            'rif_cliente' => $rif_cliente,
            'fecha_retencion' => date('d/m/Y', strtotime($retencion->created_at)),
            'mes_fiscal' => date('m', strtotime($retencion->created_at)),
            'anio_fiscal' => date('Y', strtotime($retencion->created_at)),
            'base_imponible' => $retencion->monto,
            'total_iva' => $retencion->monto + ($retencion->monto * 0.16),
            'iva' => $retencion->monto * 0.16,
            'retenido' => ($retencion->ag === 0) ? ($retencion->monto * 0.16) * 0.75 : ($retencion->monto * 0.16) * $retencion->percent,

        ];

        // return $data;





        $pdf = Pdf::loadView('reportes.retencion-pdf', $data)->setPaper('a4', 'landscape');



        return $pdf->download($retencion->nro_comprobante . '_' . date('Ymd', strtotime($retencion->created_at)) . '_' . $retencion->rif);
    }
}
