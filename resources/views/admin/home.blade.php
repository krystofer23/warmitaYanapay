
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/comisaria/index.css">
    <link rel="stylesheet" href="./css/comisaria/nav.css">
    <link rel="stylesheet" href="./css/comisaria/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>
</head>
<body>

    <nav>
        <div class="nav-up">
            <img src="./img/Logo.png" alt="" class="img-logo">
            <span>Warmita Yanapay Dashboard</span>
        </div>

        <ul class="nav-down">
            <li class="li-active">
                <i class="fa-solid fa-house"></i>
                <a href="{{ url('/HomeA') }}">Inicio</a>
            </li>

            <li class="">
                <i class="fa-solid fa-bell"></i>
                <a href="{{ url('AlertaA') }}">Alertas</a>
            </li>

            <li class="">
                <i class="fa-solid fa-clipboard"></i>
                <a href="{{ url('DenunciasA') }}">Denuncias</a>
            </li>

            <li class="">
                <i class="fa-solid fa-users"></i>
                <a href="{{ url('') }}">Usuarios</a>
            </li>

            <li class="">
                <i class="fa-solid fa-building-flag"></i>
                <a href="{{ url('') }}">Comisarias</a>
            </li>

            <li class="">
                <i class="fa-solid fa-receipt"></i>
                <a href="{{ url('') }}">Evidencias</a>
            </li>

            <li class="">
                <i class="fa-solid fa-address-book"></i>
                <a href="{{ url('') }}">Contactos</a>
            </li>

            <li class="">
                <i class="fa-solid fa-user"></i>
                <a href="{{ url('PerfilA') }}">Mi perfil</a>
            </li>
        </ul>
    </nav>

    <main>
        <header>
            <h2 class="m-0 p-0">Inicio</h2>
            <div class="info-profile-header">
                <div class="circulo-perfil">U</div>
                <div class="info-p-header">
                    <p class="m-0">{{ $usuario->name }}</p>
                    <span>{{ $usuario->email }}</span>
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

        <section class="sec-home">

            <div class="px-4 pt-3 d-flex gap-3 flex-wrap">
                <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                    <p class="text-info d-flex align-items-center"><i class="fa-solid fa-users me-3"></i> TOTAL DE USUARIOS
                        <i title="Todos los usuarios registrados." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i>
                    </p>
                    <span class="text-info">{{ $usuarios }}</span>
                </div>
                <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                    <p class="text-success d-flex align-items-center"><i class="fa-solid fa-clipboard me-3"></i> TOTAL DE DENUNCIAS
                        <i title="Todas las denuncias registradas por las comisarias." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i>
                    </p>
                    <span class="text-success">{{ $denuncias_n }}</span>
                </div>

                <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                    <p class="text-info d-flex align-items-center"><i class="fa-solid fa-building-flag me-3"></i> TOTAL DE COMISARIAS
                        <i title="Todos las comisarias registradas." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i>
                    </p>
                    <span class="text-info">{{ $comisarias_t }}</span>
                </div>

                <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                    <p class="text-info d-flex align-items-center"><i class="fa-solid fa-address-book me-3"></i> TOTAL DE CONTACTOS
                        <i title="Todos los contactos registrados por las victimas." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i>
                    </p>
                    <span class="text-info">{{ $contactos_t }}</span>
                </div>

                <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                    <p class="text-info d-flex align-items-center"><i class="fa-solid fa-receipt me-3"></i> TOTAL DE EVIDENCIAS
                        <i title="Todas las evidencias registradas por las victimas." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i>
                    </p>
                    <span class="text-info">{{ $evidencias_t }}</span>
                </div>
            </div>

            <div class="px-4 pt-3">
                <div class="d-flex gap-3 flex-wrap">
                    <div  class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                        <p class="text-success d-flex align-items-center"><i class="fa-solid fa-bell me-2 text-success"></i> ALERTAS ATENDIDAS <i style="cursor: pointer" title="Todas las alertas atendias por las comisaria." class="fa-solid fa-circle-info ms-3"></i></p>
                        <span class="text-success">{{ $alertas_atendidas }}</span>
                        {{-- <span class="text-black">{{ $denuncias_n }}</span> --}}
                    </div>
                    <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                        <p class="text-danger d-flex align-items-center"><i class="fa-solid fa-bell me-2 text-danger"></i> ALERTAS POR ATENDER <i title="Alertas por atender por las comisarias." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i></p>
                        <span class="text-danger">{{ $alertas_no_atendidas }}</span>
                    </div>
                    <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                        <p class="text-danger d-flex align-items-center"><i class="fa-solid fa-bell me-2"></i> TOTAL DE ALERTAS
                            <i title="Todas las aletas hechas por los usuarios, incluidas las atendias y por las que falta atender." style="cursor: pointer;"  class="fa-solid fa-circle-info ms-3"></i>
                        </p>
                        <span class="text-danger">{{ $total_alertas }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <h4 class="px-4 mb-3 d-flex align-items-center">Ultimas denuncias (24h) - N° {{ $denuncias_H }}<i title="Todas las denuncias hechas por las comisaria en las ultimas 24 horas." style="cursor: pointer;"  class="fa-solid fa-circle-info ms-3"></i></h4>

                <div class="s-denuncia-bottom">
                    <table class="default" style="width: 100%;" id="mis_denuncias">
                        <tr style="width: 100%; text-align: center !important">
                            <th>N°</th>
                            <th>DNI</th>
                            <th>Descripción</th>
                            <th>Prueba</th>
                            <th>Acciónes</th>
                        </tr>
                        @foreach ($denuncias as $row)
                            <tr style="width: 100%;">
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->id_victima }}</td>
                                <td style="text-align: start !important;" class="px-4">{{ $row->descripcion }}</td>
                                @if ($row->prueba_media != null)
                                    <td><a href="{{ $row->prueba_media }}" target="_blank">Ver prueba</a></td>
                                @else
                                    <td>No hay pruebas</td>
                                @endif
                                <td>
                                    <form action="{{ url('verMasDenuncia') . '/' . $row->id }}" method="GET">
                                        <button style="background: #f4bd61; margin-bottom: 10px">Ver más</button>
                                    </form>
                                    <form action="{{ url('EliminarDenuncia/' . $row->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button style="background: #da292e">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </section>
    </main>

</body>
</html>