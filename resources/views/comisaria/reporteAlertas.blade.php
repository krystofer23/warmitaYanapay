
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <link rel="stylesheet" href="./css/comisaria/index.css">
    <link rel="stylesheet" href="./css/comisaria/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>
</head>
<body style="background-color: #eff3f4;">

    <header>
        <h2 class="m-0 p-0">Reporte de alertas</h2>
        <div class="info-profile-header">
            <div class="circulo-perfil">U</div>
            <div class="info-p-header">
                <p class="m-0">{{ $usuario_comisaria->nombre }}</p>
                <span>{{ $usuario_comisaria->correo }}</span>
            </div>
            <i class="fa-solid fa-chevron-down" style="cursor: pointer; padding-top: 1px">
                <div class="cerrar_sesion">
                    <form action="{{ url('CerrarSesion') }}" method="POST">
                        @csrf
                        <button class="badge bg-danger border px-3 py-2">Cerrar sesión</button>
                    </form>
                </div>
            </i>
        </div>
    </header>

    <section>
        <div class="s-denuncia-top">
            <div class="d-flex justify-content-between gap-3 w-100">
                <select id="miSelect" onchange="verificarSeleccion()" class="form-select"
                    aria-label="Default select example" style="width: 250px">
                    <option selected value="1">Todas las alertas</option>
                    <option value="2">Alertas atendidas</option>
                    <option value="3">Alertas por atender</option>
                </select>
                <button id="agregar_usuarios"><a href="{{ url('Alertas') }}" class="text-black" style="text-decoration: none">Volver</a></button>
            </div>
        </div>

        <div class="d-flex gap-3 justify-content-center flex-wrap px-4 mb-4 pb-2">
            <div  class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                <p class="text-success d-flex align-items-center"><i class="fa-solid fa-bell me-2 text-success"></i> ALERTAS ATENDIDAS <i style="cursor: pointer" title="Todas las alertas atendias por las comisaria." class="fa-solid fa-circle-info ms-3"></i></p>
                <span class="text-success">{{ $alertas_atendidast }}</span>
                {{-- <span class="text-black">{{ $denuncias_n }}</span> --}}
            </div>
            <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                <p class="text-danger d-flex align-items-center"><i class="fa-solid fa-bell me-2 text-danger"></i> ALERTAS POR ATENDER <i title="Alertas por atender por las comisarias." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i></p>
                <span class="text-danger">{{ $alertas_no_atendidast }}</span>
            </div>
            <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                <p class="text-danger d-flex align-items-center"><i class="fa-solid fa-bell me-2"></i> TOTAL DE ALERTAS
                    <i title="Todas las aletas hechas por los usuarios, incluidas las atendias y por las que falta atender." style="cursor: pointer;"  class="fa-solid fa-circle-info ms-3"></i>
                </p>
                <span class="text-danger">{{ $total_alertast }}</span>
            </div>
        </div>

        <div class="s-denuncia-bottom" id="total">
            {{-- Todas las atertas --}}
            <table class="default" style="width: 100%;" id="mis_denuncias">
                <tr style="width: 100%; text-align: center !important">
                    <th>N°</th>
                    <th>DNI de la victima</th>
                    <th>Fecha de emisión de la alerta</th>
                    <th>Status de la alerta</th>
                    <th>Acciones</th>
                </tr>
                @foreach ($alertas as $row)
                    <tr style="width: 100%;">
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->dni }}</td>
                        <td style="text-align: center !important;" class="px-4">{{ $row->created_at }}</td>
                        @if ($row->status == '1')
                            <td>Atendida</td>
                        @else
                            <td>Por atender</td>
                        @endif
                        <td>
                            <form action="{{ url('verMasUsuario') . '/' . $row->id_victima }}" method="GET">
                                <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                <button class="btn btn-warning fs-7 px-3 py-2 border">Ver información de la victima</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="s-denuncia-bottom none" id="atendidas">
            {{-- Todas atendidas --}}
            <table class="default" style="width: 100%;" id="mis_denuncias">
                <tr style="width: 100%; text-align: center !important">
                    <th>N°</th>
                    <th>DNI de la victima</th>
                    <th>Fecha de emisión de la alerta</th>
                    <th>Acciones</th>
                </tr>
                @foreach ($alertas_atendidas as $row)
                    <tr style="width: 100%;">
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->dni }}</td>
                        <td style="text-align: center !important;" class="px-4">{{ $row->created_at }}</td>
                        <td>
                            <form action="{{ url('verMasUsuario') . '/' . $row->id_victima }}" method="GET">
                                <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                <button class="btn btn-warning fs-7 px-3 py-2 border">Ver información de la victima</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="s-denuncia-bottom none" id="no_atendidas">
            {{-- Todas no atendidas --}}
            <table class="default" style="width: 100%;" id="mis_denuncias">
                <tr style="width: 100%; text-align: center !important">
                    <th>N°</th>
                    <th>DNI de la victima</th>
                    <th>Fecha de emisión de la alerta</th>
                    <th>Acciones</th>
                </tr>
                @foreach ($alertas_por_atender as $row)
                    <tr style="width: 100%;">
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->dni }}</td>
                        <td style="text-align: center !important;" class="px-4">{{ $row->created_at }}</td>
                        <td>
                            <form action="{{ url('verMasUsuario') . '/' . $row->id_victima }}" method="GET">
                                <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                <button class="btn btn-warning fs-7 px-3 py-2 border">Ver información de la victima</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
    
    <script>
        function verificarSeleccion() {
            var selectElement = document.getElementById('miSelect');
            var selectedValue = selectElement.value;
            if (selectedValue === '1') {
                document.querySelector('#total').classList.remove('none');
                document.querySelector('#atendidas').classList.add('none');
                document.querySelector('#no_atendidas').classList.add('none');
            } else if (selectedValue === '2') {
                document.querySelector('#total').classList.add('none');
                document.querySelector('#atendidas').classList.remove('none');
                document.querySelector('#no_atendidas').classList.add('none');
            } else if (selectedValue === '3') {
                document.querySelector('#total').classList.add('none');
                document.querySelector('#atendidas').classList.add('none');
                document.querySelector('#no_atendidas').classList.remove('none');
            }
        }
    </script>

</body>
</html>