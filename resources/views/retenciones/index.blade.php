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
                        <th>comprobante</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Empresa</th>
                        <th class="">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($retenciones as $k => $retencion)
                        <tr>
                            <td class="d-none d-sm-block">{{ ++$k }}</td>
                            <td style="cursor:pointer;" onclick="window.location='retencion-pdf/{{ $retencion->id }}';">
                                {{ $retencion->nro_comprobante }}</td>
                            <td>{{ date('d/m/Y', strtotime($retencion->created_at)) }}</td>
                            <td>{{ $retencion->name }}</td>
                            <td>{{ $retencion->name_empresa }}</td>
                            <td class=""></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
