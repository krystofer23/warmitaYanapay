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
            <span>Warmita Yanapay Dashboard</span>
        </div>

        <ul class="nav-down">
            <li class="">
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
                <a href="{{ url('UsuariosA') }}">Usuarios</a>
            </li>

            <li class="">
                <i class="fa-solid fa-building-flag"></i>
                <a>Comisarias</a>
            </li>

            <li class="">
                <i class="fa-solid fa-receipt"></i>
                <a>Evidencias</a>
            </li>

            <li class="li-active">
                <i class="fa-solid fa-address-book"></i>
                <a href="{{ url('ContactosA') }}">Contactos</a>
            </li>

            <li class="">
                <i class="fa-solid fa-user"></i>
                <a href="{{ url('PerfilA') }}">Mi perfil</a>
            </li>
        </ul>
    </nav>

    <main>
        <header>
            <h2 class="m-0 p-0">Contactos</h2>
            <div class="info-profile-header">
                <div class="circulo-perfil">U</div>
                <div class="info-p-header">
                    <p class="m-0">{{ $usuario_comisaria->name }}</p>
                    <span>{{ $usuario_comisaria->email }}</span>
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
                <form action="">
                    <input type="search" placeholder="Buscar">
                </form>

                <div class="d-flex gap-3">
                    <select id="miSelect" onchange="verificarSeleccion()" class="form-select"
                        aria-label="Default select example" style="width: 250px">
                        <option selected value="1">Todos los contactos</option>
                    </select>
                    <button id="agregar_usuarios">AGREGAR CONTACTO</button>
                </div>
            </div>

            <div class="s-denuncia-bottom">
                <table class="default" style="width: 100%;" id="mis_denuncias">
                    <tr style="width: 100%; text-align: center !important">
                        <th>N°</th>
                        <th>Victima</th>
                        <th>DNI</th>
                        <th>Contacto</th>
                        <th>Número del contacto</th>
                        <th>Acciones</th>
                    </tr>
                    @foreach ($contactos as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->nombre_victima }}</td>
                            <td>{{ $row->dni }}</td>
                            <td>{{ $row->nombre_contacto }}</td>
                            <td>{{ $row->numero_contacto }}</td>
                            <td>
                                <form action="{{ url('verMasContacto') . '/' . $row->id }}">
                                    <button class="btn btn-warning">Ver mas</button>
                                </form>
                                <form action="{{ url('EliminarContacto') . '/' . $row->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger mt-2">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

        </section>
    </main>

    <section class="form-registro-no-usuarios none">
        <form action="{{ url('AgregarContacto') }}" method="POST" enctype="multipart/form-data">
            <h2>REGISTRO DE CONTACTO</h2>
            <p style="color: #5c5c5c; padding-bottom: 20px">Para inicar el registro del contacto debe de tener su información.</p>
            @csrf
            <i class="fa-solid fa-xmark xmark xmark-usuarios"></i>

            <div>
                <label for="dni">DNI de la victima</label>
                <br>
                <input name="dni" type="text" maxlength="8" id="dni" placeholder="DNI"
                    required>
                <br>
            </div>
            <div class="inp-cont">
                <div class="ms-1">
                    <label for="nombre">Nombre del contacto</label>
                    <br>
                    <input name="nombre" type="text" id="nombre" placeholder="Nombre" required>
                </div>
                <div class="ms-1">
                    <label for="apellido">Apellido del contacto</label>
                    <br>
                    <input name="apellido" type="text" id="apellido" placeholder="Apellido" required>
                </div>
            </div>
            <div class="ms-1">
                <label for="celular">Celular del contacto</label>
                <br>
                <input type="text" maxlength="9" name="celular" id="celular" placeholder="Celular" required>
            </div>
            <div class="ms-1">
                <label for="direccion">Dirección del contacto</label>
                <br>
                <input type="text" name="direccion" id="direccion" placeholder="Dirección" required>
            </div>
            
            <div class="cont-for-btn">
                <button>Registrar</button>
            </div>
        </form>
    </section>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            @foreach ($errors->all() as $error)
                <a href="{{ url('/ContactosA') }}">{{ $error }}</a>
            @endforeach
        </div>
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
                
            } else if (selectedValue === '2') {
               
            }
        }
    </script>

</body>

</html>
