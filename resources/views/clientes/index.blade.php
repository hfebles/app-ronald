@extends('layouts.app')



@section('content')
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Nuevo proveedor</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-sm text-uppercase mb-0 table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Rif</th>
                        <th>telefono</th>
                        <th class="d">email</th>
                        <th class="">acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $k => $cliente)
                        <tr>
                            <td>{{ $cliente->name }}</td>
                            <td>{{ $cliente->rif }}</td>
                            <td>{{ $cliente->phone }}</td>
                            <td class="">{{ $cliente->mail }}</td>
                            <td class=" text-center">
                                <a class="btn btn-sm btn-warning" onclick="modalEditar({{ $cliente->id }})"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn btn-sm btn-danger" onclick="eliminar({{ $cliente->id }})"><i
                                        class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="col-12 mt-3 d-flex justify-content-center align-items-center">
            {{ $clientes->render() }}
        </div>
    </div>
@endsection


@section('js')
    <script>
        const csrfToken = "{{ csrf_token() }}";
        const expresionRegularRif = /^[VJGjvg][0-9]{9}$/;

        // var myModal = document.getElementById('editModal')

        function eliminar(id) {
            if (window.confirm("¿Estás seguro de que deseas borrar este elemento?")) {


                fetch('{{ route('proveedor.eliminar') }}', {
                        method: 'POST',
                        body: JSON.stringify({
                            id: id,
                        }),
                        headers: {
                            'content-type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Error de red o solicitud fallida');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data)
                        if (data.status == 200) {
                            alert('Eliminado con exito');
                            location.reload()
                        } else {
                            alert('No se puede eliminar')
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } else {
                return false
            }
        }


        const myModal = new bootstrap.Modal(document.getElementById('editModal'))


        function modalEditar(id) {

            fetch(`/proveedor/${id}/edit`, {
                    method: 'GET',
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Error de red o solicitud fallida');
                    }
                    return response.json();
                })
                .then(data => {
                    var cliente = data.rif
                    linea = '';

                    linea += `
                    <form action="proveedor/${id}" method="post">
                        {{ method_field('PUT') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class="row">
                                        <div class="col-12">
                                            <div class="form-floating mb-3 input-group ">
                                                <input onkeyup="validaConsulta(this.value)" minlength="10" maxlength="10"
                                                    id="rif2" type="text" value="${cliente}" name="rif"
                                                    class="form-control form-control-sm" placeholder="J1234567890">
                                                <button onclick="consultaRif(document.getElementById('rif2'), 2)"
                                                    class="btn btn-outline-secondary" id='btn-consulta'
                                                    type="button">consultar</button>
                                                <label>RIF</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required id="clientname2" disabled type="text" name="name"
                                                    class="form-control form-control-sm" placeholder="Nombre">
                                                <label>Nombre</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <textarea required id="clientaddress2" disabled class="form-control form-control-sm" name="address"
                                                    placeholder="Direccion"></textarea>
                                                <label>Direccion</label>
                                            </div>
                                            <div class="form-floating my-3">
                                                <input minlength="11" maxlength="11" required id="clientphone2" disabled
                                                    type="text" class="form-control form-control-sm" name="phone"
                                                    placeholder="04XX0000000">
                                                <label>Telefono</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required id="clientmail2" disabled type="email"
                                                    class="form-control form-control-sm" name="email"
                                                    placeholder="name@example.com">
                                                <label>Correo</label>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" id="btn-save2" disabled
                                                class="btn btn-success">Guardar</button>
                                        </div>
                                    </div>
                                    </form>`

                    document.querySelector('#edit-data').innerHTML = linea
                    myModal.show()

                })
                .catch(error => {
                    console.error(error);
                });


            // console.log(id)
        }

        function validarCampoNumerico() {
            const patron = /^[04]\d(12|14|24|26|16)\d{7}$/;
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

            fetch('{{ route('proveedor.consulta') }}', {
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
                    document.querySelector('#clientname2').disabled = false
                    document.querySelector('#clientaddress2').disabled = false
                    document.querySelector('#clientphone2').disabled = false
                    document.querySelector('#clientmail2').disabled = false
                    document.querySelector('#btn-save2').disabled = false
                    document.querySelector('#clientname2').value = data.data.name;
                    document.querySelector('#clientaddress2').value = data.data.address;
                    document.querySelector('#clientphone2').value = data.data.phone;
                    document.querySelector('#clientmail2').value = data.data.email;
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

@section('modal')
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    {!! Form::open([
                                        'route' => 'proveedor.store',
                                        'method' => 'POST',
                                        'onsubmit' => 'return validarCampoNumerico()',
                                    ]) !!}
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
                                                    placeholder="04XX0000000">
                                                <label>Telefono</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input required id="clientmail" disabled type="email"
                                                    class="form-control form-control-sm" name="email"
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


    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" id='edit-data'>

                </div>

            </div>
        </div>
    </div>
@endsection
