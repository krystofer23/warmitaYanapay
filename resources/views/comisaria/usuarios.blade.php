<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/comisaria/index.css">
    <link rel="stylesheet" href="./css/comisaria/nav.css">
    <link rel="stylesheet" href="./css/comisaria/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>
</head>

<body>

    <nav>
        <div class="nav-up">
            <img src="./img/Logo.png" alt="" class="img-logo">
            <span>Warmita Yanapay Comisaria</span>
        </div>

        <ul class="nav-down">
            <li class="">
                <i class="fa-solid fa-house"></i>
                <a href="{{ url('/') }}">Inicio</a>
            </li>

            <li class="">
                <i class="fa-solid fa-bell"></i>
                <a href="{{ url('Alertas') }}">Alertas</a>
            </li>

            <li class="">
                <i class="fa-solid fa-clipboard"></i>
                <a href="{{ url('Denuncias') }}">Denuncias</a>
            </li>

            <li class="li-active">
                <i class="fa-solid fa-users"></i>
                <a href="{{ url('Usuarios') }}">Usuarios</a>
            </li>

            <li class="">
                <i class="fa-solid fa-user"></i>
                <a href="{{ url('Perfil') }}">Perfil</a>
            </li>
        </ul>
    </nav>

    <main>
        <header>
            <h2 class="m-0 p-0">Usuarios</h2>
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

        <section class="sec-denuncias">
            <div class="s-denuncia-top">
                <form action="{{ url('BuscarUsuario') }}" method="POST" class="d-flex align-items-center">
                    @csrf
                    <input type="search" placeholder="Buscar" maxlength="8" name="dni">
                    <i title="Ingrese el dni para poder buscar." style="cursor: pointer" class="fs-4 fa-solid fa-circle-info ms-3"></i>
                </form>

                <div class="d-flex gap-3">
                    <select id="miSelect" onchange="verificarSeleccion()" class="form-select" aria-label="Default select example" style="width: 250px">
                        <option selected value="1">Todos los usuarios</option>
                        <option value="2">Usuarios creados por la comisaria</option>
                    </select>
                    <button id="agregar_usuarios">AGREGAR USUARIO</button>
                </div>
            </div>

            <div id="tabla_todo_usuarios" class="s-denuncia-bottom" style="width: 100%;">
                <table class="default" style="width: 100%;">
                    <tr style="width: 100%; text-align: center !important">
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>

                    @foreach ($usuarios as $row)
                        <tr style="width: 100%;">
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->dni }}</td>
                            <td>{{ $row->nombre }}</td>
                            <td>{{ $row->apellido }}</td>
                            <td>{{ $row->celular }}</td>
                            <td>{{ $row->direccion }}</td>
                            <td>{{ $row->correo }}</td>

                            <td>
                                <form action="{{ url('verMasUsuario') . '/' . $row->id }}" method="GET">
                                    <input type="text" name="page" class="none" value="Usuarios">
                                    <button style="background: #f4bd61; margin-bottom: 10px">Ver más</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div id="tabla_comisaria_usuarios" class="s-denuncia-bottom none" style="width: 100%;">
                <table class="default" style="width: 100%;">
                    <tr style="width: 100%; text-align: center !important">
                        <th>N°</th>
                        <th>Comisaria (Registro)</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>

                    @foreach ($usuarios_comisaria as $row)
                        <tr style="width: 100%;">
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->comisaria }}</td>
                            <td>{{ $row->dni }}</td>
                            <td>{{ $row->nombre }}</td>
                            <td>{{ $row->apellido }}</td>
                            <td>{{ $row->celular }}</td>
                            <td>{{ $row->direccion }}</td>
                            <td>{{ $row->correo }}</td>

                            <td>
                                <form action="{{ url('verMasUsuario') . '/' . $row->id }}" method="GET">
                                    <input type="text" name="page" class="none" value="Usuarios">
                                    <button style="background: #f4bd61; margin-bottom: 10px">Ver más</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </section>
    </main>

    <section class="form-registro-no-usuarios none">
        <form action="{{ url('RegistrarVictima') }}" method="POST">
            <h2>REGISTRO DE USUARIO</h2>
            <p style="color: #5c5c5c; padding-bottom: 20px">Por favor, ingrese los datos de la victima para registrarlo
                en el sistema.</p>
            @csrf
            <i class="fa-solid fa-xmark xmark xmark-usuarios"></i>
            <label for="dni">DNI</label>
            <br>
            <input type="text" maxlength="8" name="dni" id="dni" placeholder="DNI" required>
            <br>
            <div class="inp-cont">
                <div>
                    <label for="celular">Celular</label>
                    <br>
                    <input type="text" maxlength="9" name="celular" id="celular" placeholder="Celular" required>
                    <br>
                </div>
                <div>
                    <label for="direccion">Dirección (Lugar donde reside)</label>
                    <br>
                    <input type="text" name="direccion" id="direccion" placeholder="Dirección" required>
                </div>
            </div>
            <label for="correo">Correo</label>
            <br>
            <input type="email" name="correo" id="correo" placeholder="Correo" required>
            <br>
            <label for="clave">Contraseña (Minimo 4 digitos)</label>
            <br>
            <input type="password" name="clave" id="clave" placeholder="Contraseña" required>
            <button>Registrar</button>
        </form>
    </section>

    @if($errors->any())
    @foreach($errors->all() as $error)
        @if($error == "success")
        <div class="alert alert-success mt-3">
            <a href="{{ url('/Usuarios') }}">Usuario registrado</a>
        </div>
        @else 
        <div class="alert alert-danger mt-3">
            <a href="{{ url('/Usuarios') }}">{{ $error }}</a>
        </div>
        @endif
    @endforeach
    @endif

    <script>
        const btn_cambio_clave = document.querySelector('#agregar_usuarios');
        const btn_xmark = document.querySelector('.xmark-usuarios');

        btn_cambio_clave.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector('.form-registro-no-usuarios').classList.toggle('none');
        });

        btn_xmark.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector('.form-registro-no-usuarios').classList.toggle('none');
        });

        function verificarSeleccion() {
            var selectElement = document.getElementById('miSelect');
            var selectedValue = selectElement.value;
            if (selectedValue === '1') {
                document.querySelector('#tabla_comisaria_usuarios').classList.add('none');
                document.querySelector('#tabla_todo_usuarios').classList.remove('none');
            }
            else if (selectedValue === '2') {
                document.querySelector('#tabla_comisaria_usuarios').classList.remove('none');
                document.querySelector('#tabla_todo_usuarios').classList.add('none');
            }
        }
    </script>

</body>

</html>
