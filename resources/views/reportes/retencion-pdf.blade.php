<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <style>
        * {
            font-size: 12px !important;
        }

        .fuente-14 {
            font-size: 14px !important;
        }

        .text-bold {
            font-weight: bold !important;
        }

        .text-justificado {
            text-align: justify !important;
        }
    </style>
</head>

<body>


    <table class="table table-bordered mb-0">
        <tr>
            <td width="60%" class=" ">
                <p class="text-bold text-uppercase text-center">comprobante de retencion del inpuesto al valor agregado
                    i.v.a.</p>
                <p class="text-center">Providencia Administrativa SNAT/2013-0030 del 20/05/2013</p>
                <p class="text-justificado">Ley IVA-Art.11 "La administración Tibrutaria podra designar como responsables
                    del pago del
                    impuesto, en calidad de agentes de retención, a quienes por sus funciones públicas o por
                    razón de sus actividades privadas, intervengan en operaciones grabadas con impuesto
                    establecido en esta ley"</p>
            </td>
            <td class="text-uppercase text-center">
                <p class="mb-0">0. NUMERO DE COMPROBANTE</p>
                <p class="mb-0 fuente-14 ">{{ $retencion->nro_comprobante }}</p>
            </td>
            <td class="text-uppercase text-center">
                <p class="mb-0">1. fecha</p>
                <p class="mb-0 fuente-14 ">{{ $fecha_retencion }}</p>
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-condensed mt-2 mb-3 table-sm">
        <tr class="text-center text-uppercase">
            <td width='38%'>2. nombre o razón social del agente de retencióN</td>
            <td width='22%'>3. rif del agente de retención</td>
            <td rowspan="3" width='30%' colspan="2" class="text-center">
                <p class="">4. periodo fiscal</p>
                <p class="mb-0 fuente-14">Año: {{ $anio_fiscal }} / Mes: {{ $mes_fiscal }}</p>
            </td>
        </tr>
        <tr class="text-center text-uppercase">
            <td class="fuente-14">{{ $retencion->name_empresa }}</td>
            <td class="fuente-14">{{ preg_replace('/(\D)(\d{8})(\d)/', '$1-$2-$3', $retencion->rif_empresa) }}</td>
        </tr>
        <tr class="text-center text-uppercase">
            <td class="fuente-14" colspan="2">
                {{ $retencion->address_empresa }}
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-condensed mb-0 table-sm">
        <tr class="text-center text-uppercase">
            <td width='38%'>6. nombre o razón social del sujeto retenido</td>
            <td width='22%'>7. rif del del sujeto retenido</td>
            <td rowspan="3" colspan="2">&nbsp;</td>
        </tr>
        <tr class="text-center text-uppercase">
            <td class="fuente-14">{{ $retencion->name }}</td>
            <td class="fuente-14">{{ $rif_cliente }}</td>
        </tr>
        <tr class="text-center text-uppercase">
            <td class="fuente-14" colspan="2">
                {{ $retencion->address }}
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-condensed mt-3 mb-3 table-sm">
        <tr class="text-center text-uppercase">
            <td class="align-middle" rowspan="2">fecha de la factura</td>
            <td class="align-middle" colspan="2">datos de la factura</td>
            <td class="align-middle" rowspan="2">numero de nota de credito</td>
            <td class="align-middle" rowspan="2">tipo de transaccion</td>
            <td class="align-middle" rowspan="2">nro factura afectada</td>
            <td class="align-middle" rowspan="2">total de compras incluyendo iva</td>
            <td class="align-middle" rowspan="2">compras exentas</td>
            <td class="align-middle" rowspan="2">base imponible</td>
            <td class="align-middle" rowspan="2">% alicuota</td>
            <td class="align-middle" rowspan="2">monto</td>
            <td class="align-middle" rowspan="2">iva retenido</td>
        </tr>
        <tr class="text-center text-uppercase">
            <td class="align-middle">numero</td>
            <td class="align-middle">no control</td>
        </tr>
        <tr class="text-center text-uppercase">
            <td width="8.4%" class="align-middle">{{ date('d/m/Y', strtotime($retencion->fecha_factura)) }}</td>
            <td width="8.4%" class="align-middle">{{ $retencion->nro_factura }}</td>
            <td width="8.4%" class="align-middle">{{ $retencion->nro_control }}</td>
            <td width="8.4%" class="align-middle">&nbsp;</td>
            <td width="8.3%" class="align-middle">FACTURA</td>
            <td width="8.3%" class="align-middle">&nbsp;</td>
            <td width="8.3%" class="align-middle">{{ number_format($total_iva, 2, ',', '.') }}</td>
            <td width="8.3%" class="align-middle">&nbsp;</td>
            <td width="8.3%" class="align-middle">{{ number_format($base_imponible, 2, ',', '.') }}</td>
            <td width="8.3%" class="align-middle">0,16</td>
            <td width="8.3%" class="align-middle">{{ number_format($iva, 2, ',', '.') }}</td>
            <td width="8.3%" class="align-middle">{{ number_format($retenido, 2, ',', '.') }}</td>
        </tr>
    </table>

    <table class="table table-sm table-bordered">

        <tr class="text-center text-uppercase">
            <td width="52%" class="align-middle">Totales</td>
            <td width="8.9%" class="align-middle">{{ number_format($total_iva, 2, ',', '.') }}</td>
            <td width="8.7%" class="align-middle">&nbsp;</td>
            <td width="8.3%" class="align-middle">{{ number_format($base_imponible, 2, ',', '.') }}</td>
            <td width="8.3%" class="align-middle">0,16</td>
            <td width="8.3%" class="align-middle">{{ number_format($iva, 2, ',', '.') }}</td>
            <td width="8.3%" class="align-middle">{{ number_format($retenido, 2, ',', '.') }}</td>
        </tr>
    </table>
    <div style="height: 53px"></div>
    <table class="table table-borderless">
        <tr class="text-center text-uppercase">
            <td class="align-middle" width='50%'>
                <p>________________________</p>
                <p>Firma y sello del <br> agente de retencion</p>
            </td>
            <td class="align-middle" width='50%'>
                <p>________________________</p>
                <p>Firma y fecha del <br> sujeto retenido</p>
            </td>
        </tr>
    </table>
</body>

</html>
