@extends('layouts.app')



@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-success">Nuevo cliente</a>
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
                        <th>Nombre</th>
                        <th>Rif</th>
                        <th>telefono</th>
                        <th class="d-none d-sm-block">email</th>
                        <th class="d-none d-sm-block">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $k => $cliente)
                        <tr>
                            <td class="d-none d-sm-block">{{ ++$k }}</td>
                            <td>{{ $cliente->name }}</td>
                            <td>{{ $cliente->rif }}</td>
                            <td>{{ $cliente->phone }}</td>
                            <td class="d-none d-sm-block">{{ $cliente->mail }}</td>
                            <td class="d-none d-sm-block"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
