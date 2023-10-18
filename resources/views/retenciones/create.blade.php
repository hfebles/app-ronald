@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('retenciones.index') }}" class="btn btn-sm btn-dark">Regresar</a>
                    <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Nuevo cliente</a>
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

@section('modal')
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    {!! Form::open(['route' => 'clientes.store', 'method' => 'POST', 'onsubmit' => 'return validarCampoNumerico()']) !!}
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-floating mb-3 input-group ">
                                                <input onkeyup="validaConsulta(this.value)" minlength="10" maxlength="10"
                                                    id="rif" type="text" name="rif"
                                                    class="form-control form-control-sm" placeholder="J1234567890">
                                                <button onclick="consultaRif(document.getElementById('rif'))"
                                                    class="btn btn-outline-secondary" id='btn-consulta'
                                                    type="button">consultar</button>
                                                <label>RIF</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required id="clientname" disabled type="text" name="name"
                                                    class="form-control form-control-sm" placeholder="Nombre">
                                                <label>Nombre</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <textarea required id="clientaddress" disabled class="form-control form-control-sm" name="address"
                                                    placeholder="Direccion"></textarea>
                                                <label>Direccion</label>
                                            </div>
                                            <div class="form-floating my-3">
                                                <input minlength="11" maxlength="11" required id="clientphone" disabled
                                                    type="text" class="form-control form-control-sm" name="phone"
                                                    placeholder="04XX0000000 o 02XX0000000">
                                                <label>Telefono</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required id="clientmail" disabled type="email"
                                                    class="form-control form-control-sm" name="mail"
                                                    placeholder="name@example.com">
                                                <label>Correo</label>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" id="btn-save" disabled
                                                class="btn btn-success">Guardar</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const csrfToken = "{{ csrf_token() }}";
        const expresionRegularRif = /^[VJGjvg][0-9]{9}$/;

        function validarCampoNumerico() {
            const patron = /^0(412|414|424|426|416|212|243|244|246|242|245|241|235|238)\d{7}$/;
            var phone = document.querySelector('#clientphone').value
            if (phone.match(patron) == null) {
                alert('El numero de telefono debe ser un numero venezolano')
                document.querySelector('#clientphone').focus()
                return false
            }
            return true

        }


        function consultaRif(value, edit = '') {

            var rif = value.value

            document.querySelector('#clientname').value = "";
            document.querySelector('#clientaddress').value = "";
            document.querySelector('#clientphone').value = "";
            document.querySelector('#clientmail').value = "";

            if (rif.length < 10) {
                alert('debe contener el rif completo para consultar')
                value.focus();
                return false
            }


            if (rif.match(expresionRegularRif) == null) {
                alert('el rif debe comenzar por un caracter valido J V G y continuar con los numeros')
                value.focus();
                return false
            }

            fetch('{{ route('clientes.consulta') }}', {
                method: 'POST',
                body: JSON.stringify({
                    rif: rif,
                }),
                headers: {
                    'content-type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            }).then(response => {
                return response.json()
            }).then(data => {
                if (edit == '2') {
                    console.log('asdasd')
                    document.querySelector('#clientname2').disabled = false
                    document.querySelector('#clientaddress2').disabled = false
                    document.querySelector('#clientphone2').disabled = false
                    document.querySelector('#clientmail2').disabled = false
                    document.querySelector('#btn-save2').disabled = false
                    document.querySelector('#clientname2').value = data.data.name;
                    document.querySelector('#clientaddress2').value = data.data.address;
                    document.querySelector('#clientphone2').value = data.data.phone;
                    document.querySelector('#clientmail2').value = data.data.mail;
                    document.querySelector('#rif2').focus()

                } else if (data.status === 400) {
                    alert('El cliente ya existe');
                    document.querySelector('#rif').focus()
                    document.querySelector('#clientname').value = data.data.name;
                    document.querySelector('#clientaddress').value = data.data.address;
                    document.querySelector('#clientphone').value = data.data.phone;
                    document.querySelector('#clientmail').value = data.data.mail;
                } else {
                    document.querySelector('#clientname').disabled = false
                    document.querySelector('#clientaddress').disabled = false
                    document.querySelector('#clientphone').disabled = false
                    document.querySelector('#clientmail').disabled = false
                    document.querySelector('#btn-save').disabled = false
                    document.querySelector('#clientname').focus()
                    document.querySelector('#btn-consulta').disabled = true

                }
            });
        }

        function validaConsulta(value) {
            if (value.length < 10) {
                document.querySelector('#clientname').value = "";
                document.querySelector('#clientaddress').value = "";
                document.querySelector('#clientphone').value = "";
                document.querySelector('#clientmail').value = "";
                document.querySelector('#clientname').disabled = true
                document.querySelector('#clientaddress').disabled = true
                document.querySelector('#clientphone').disabled = true
                document.querySelector('#clientmail').disabled = true
                document.querySelector('#btn-save').disabled = true

                document.querySelector('#btn-consulta').disabled = false
            }
        }
    </script>
@endsection
