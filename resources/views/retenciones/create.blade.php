@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('retenciones.index') }}" class="btn btn-sm btn-dark">Regresar</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'retenciones.store', 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <select class="form-select" name="empresa_id" aria-label="Seleccione una empresa">
                                    <option selected>Empresa</option>
                                    @foreach ($propias as $propia)
                                        <option value="{{ $propia->id }}">{{ $propia->name_empresa }}</option>
                                    @endforeach
                                </select>
                                <label>Seleccione</label>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" name="client_id" aria-label="Seleccione un proveedor">
                                    <option selected>Proveedor</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                    @endforeach

                                </select>
                                <label>Seleccione</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="nro_factura" class="form-control form-control-sm"
                                    placeholder="000000000000">
                                <label>Numero de Factura</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="nro_control" class="form-control form-control-sm"
                                    placeholder="000000000000">
                                <label>Numero de control factura</label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="date" class="form-control form-control-sm" name="fecha" placeholder="">
                                <label>Fecha</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-sm" name="monto"
                                    placeholder="Monto">
                                <label>Monto</label>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
