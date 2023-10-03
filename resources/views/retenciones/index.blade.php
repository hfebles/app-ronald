@extends('layouts.app')



@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('retenciones.create') }}" class="btn btn-sm btn-success">Nueva retencion</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-sm text-uppercase mb-0 table-bordered align-middle">
                <thead>
                    <tr>
                        <th class="d-none d-sm-block">#</th>
                        <th>Factura</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>RIF</th>
                        <th class="d-none d-sm-block">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($retenciones as $k => $retencion)
                        <tr style="cursor:pointer;" onclick="window.location='retencion-pdf/{{ $retencion->id }}';">
                            <td class="d-none d-sm-block">{{ ++$k }}</td>
                            <td>{{ $retencion->nro_factura }}</td>
                            <td>{{ date('d/m/Y', strtotime($retencion->fecha)) }}</td>
                            <td>{{ $retencion->name }}</td>
                            <td>{{ $retencion->rif }}</td>
                            <td class="d-none d-sm-block"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
