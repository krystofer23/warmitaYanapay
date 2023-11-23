
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/comisaria/index.css">
    <link rel="stylesheet" href="../css/comisaria/nav.css">
    <link rel="stylesheet" href="../css/comisaria/header.css">
    <link rel="stylesheet" href="../css/comisaria/vermas.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>
</head>

<body>

    <div class="container-ver-m-d flex-column" >
        <div class="border container-info-m-d" style="box-shadow: rgba(0, 0, 0, 0.1) 2px 2px 8px; height: 650px; overflow: hidden;">
            <div class="border-bottom px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3 align-items-center">
                    <img src="../img/Logo.png" alt="" style="height: 80px">
                    <h3 class="m-0">Información del usuario</h3>
                </div>
                <span>Fecha de registro: 2023-10-30 18:12:47</span>
            </div>
            <div class="d-flex w-100">
                <div class="p-4 w-100 border-end">
                    <h4>Usuario</h4>

                    <div class="w-100">
                        <span class="pb-2" style="font-size: 13px">DNI</span>
                        <p class="pb-2 border-bottom">{{ $usuario->dni }}</p>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Nombres</span>
                            <p class="pb-2 border-bottom">{{ $usuario->nombre }}</p>
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Apellidos</span>
                            <p class="pb-2 border-bottom">{{ $usuario->apellido }}</p>
                        </div>
                    </div>

                    <form action="{{ url('ActualizarUsuarioA') . '/' . $usuario->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Celular</span>
                            <br>
                            <input name="celular" class="inp-p" type="text" value="{{ $usuario->celular }}">
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Dirección</span>
                            <br>
                            <input name="direccion" class="inp-p" type="text" value="{{ $usuario->direccion }}">
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Correo</span>
                            <br>
                            <input name="correo" class="inp-p" type="text" value="{{ $usuario->correo }}">
                        </div>
                        <button class="btn-edit-d">Guardar cambios</button>
                    </form>
                </div>
                <div class="w-100 p-4" style="overflow-y: scroll; height: 550px;">
                    <h4>Denuncias {{ $t_denuncias }} </h4>

                    <div style="width: 100%;">
                        <table style="width: 100%;" class="table table-striped">
                            <tr style="width: 100%;" class="text-center">
                                <th>N°</th>
                                <th>Comisaria</th>
                                <th>Fecha y hora</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($denuncias as $row)
                                <tr class="default text-center" style="width: 100%;">
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $comisaria[($row->id_comisaria) - 1]->nombre }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td>
                                        <form action="{{ url('verMasDenuncia') . '/' . $row->id }}" method="GET">
                                            <button class=" btn btn-warning px-3 py-2"
                                                style="background: #f4bd61; margin-bottom: 10px">Ver más</button>
                                        </form>
                                        <form action="{{ url('EliminarDenunciaMas') . '/' . $row->id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" class="none" name="user" value="{{ $usuario->id }}">
                                            <button class="btn btn-danger px-3 py-2"
                                                style="background: #da292e">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <h4>Evidencias {{ $t_evidencias }}</h4>

                    <div style="width: 100%;">
                        <table style="width: 100%;" class="table table-striped">
                            <tr style="width: 100%;" class="text-center">
                                <th>N°</th>
                                <th>Descripción</th>
                                <th>Datos del agresor</th>
                                <th>Evidencia</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($evidencias as $row)
                                <tr class="default text-center" style="width: 100%;">
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->descripcion }}</td>
                                    <td>{{ $row->datos_agresor }}</td>
                                    @if($row->evidencia_media == '')
                                    <th>No hay evidencia</th>
                                    @else
                                    <th><a href="{{ $row->evidencia_media }}" target="_BLANK">Ver evidencia</a></th>
                                    @endif
                                    <td>
                                        <form action="{{ url('EliminarEvidenciaEE/' . $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" class="none" name="id" value="{{ $usuario->id }}">
                                            <button class="btn btn-danger px-3 py-2" style="background: #da292e">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                    <h4>Contactos {{ $t_contactos }}</h4>

                    <div style="width: 100%;">
                        <table style="width: 100%;" class="table table-striped">
                            <tr style="width: 100%;" class="text-center">
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Celular</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                            @foreach ($contactos as $row)
                                <tr class="default text-center" style="width: 100%;">
                                    <td>{{ $row->id }}</td>
                                    <td>{{ $row->nombre }}</td>
                                    <td>{{ $row->apellido }}</td>
                                    <td>{{ $row->celular }}</td>
                                    <td>{{ $row->direccion }}</td>
                                    <td>
                                        <form action="{{ url('verMasContacto') . '/' . $row->id }}" method="GET">
                                            <button class=" btn btn-warning px-3 py-2"
                                                style="background: #f4bd61; margin-bottom: 10px">Ver más</button>
                                        </form>
                                        <form action="{{ url('EliminarContactoV/' . $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" name="id" value="{{ $usuario->id }}" class="none">
                                            <button class="btn btn-danger px-3 py-2"
                                                style="background: #da292e">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3 d-flex justify-content-end container-info-m-d" style="background-color: #00000000 !important">
            <button class="btn btn-secondary" onclick="imprimir()">Imprimir</button>
            <button class="ms-2 btn-primarys" onclick="goBack()">Volver</button>
        </div>
    </div>

    @if($errors->any())
    @foreach($errors->all() as $error)
        @if($error == "success")
        <div class="alert alert-success mt-3">
            <a>Usuario actualizado</a>
        </div>
        @elseif($error == "successs")
        <div class="alert alert-success mt-3">
            <a>Denuncia eliminada</a>
        </div>
        @elseif($error == "successss")
        <div class="alert alert-success mt-3">
            <a>Contacto eliminada</a>
        </div>
        @elseif($error == "successw")
        <div class="alert alert-success mt-3">
            <a>Evidencia eliminada</a>
        </div>
        @else 
        <div class="alert alert-danger mt-3">
            <a>{{ $error }}</a>
        </div>
        @endif
    @endforeach
    @endif

    <script>
        function goBack(e) {
            window.history.back();
        }
    </script>

    <script>
        function imprimir() {
            window.print();
        }
    </script>

</body>
</html>
