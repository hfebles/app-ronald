@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('clientes.index') }}" class="btn btn-sm btn-dark">Regresar</a>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'clientes.store', 'method' => 'POST']) !!}
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control form-control-sm"
                                    placeholder="Nombre">
                                <label>Nombre</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="rif" class="form-control form-control-sm"
                                    placeholder="J1234567890">
                                <label>RIF</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control form-control-sm" name="address" placeholder="Direccion"></textarea>
                                <label>Direccion</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="ag" type="checkbox" value="1">
                                <label class="form-check-label">
                                    ¿Agente de retencion?
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="75" name="percent">
                                <label class="form-check-label">
                                    75%
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="100" name="percent">
                                <label class="form-check-label">
                                    100%
                                </label>
                            </div>
                            <div class="form-floating my-3">
                                <input type="text" class="form-control form-control-sm" name="phone"
                                    placeholder="04XX0000000">
                                <label>Telefono</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control form-control-sm" name="mail"
                                    placeholder="name@example.com">
                                <label>Correo</label>
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
