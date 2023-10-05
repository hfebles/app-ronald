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
@endsection
