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
                <article>Comisarias</a>
            </li>

            <li class="">
                <i class="fa-solid fa-receipt"></i>
                <a>Evidencias</a>
            </li>

            <li class="">
                <i class="fa-solid fa-address-book"></i>
                <a href="{{ url('ContactosA') }}">Contactos</a>
            </li>

            <li class="li-active">
                <i class="fa-solid fa-user"></i>
                <a href="{{ url('PerfilA') }}">Mi perfil</a>
            </li>
        </ul>
    </nav>

    <main>
        <header>
            <h2 class="m-0 p-0">Perfil</h2>
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

        <section class="sec-denuncias" id="form-perfil">

            <form action="{{ url('EditarPerfilAdmin') . '/' . $usuario->id }}" method="POST">
                @csrf
                @method('PUT')
                
                <span>Datos de la comisaria</span> 
                <br>
                <br>

                <label for="nombre">Nombre</label>
                <br>
                <input name="name" id="nombre" type="text" value="{{ $usuario->name }}">
                <br>
                <label for="correo">Correo</label>
                <br>
                <input name="email" id="correo" type="email" value="{{ $usuario->email }}">
                <br>
                <button>Guardar</button>

                <br>
            </form>

            <div id="cont-forms">

                {{-- <form action="">
                    @csrf
                    @method('DELETE')
                    <span>Eliminar la cuenta de la comisaria</span>
                    <br>
                    <p style="color: #7f7f7f; padding-top: 2px;">Esta acción es permanente e irreversible. Perderás acceso a la cuenta y toda la información <br> que contiene. (Pide al administrador eliminar la cuenta)</p>
                    <br>
                    <button style="background-color: #da292e; color: #fff;">Eliminar cuenta</button>
                </form>
                
                <br> --}}

                <form>
                    <span>Cambiar la contraseña de la cuenta</span>
                    <br>
                    <p style="color: #7f7f7f; padding-top: 2px;">Esta acción es permanente e irreversible.</p>
                    <br>
                    <button id="btn_cambio_clave" style="background-color: #f5b03a; color: #fff;">Cambiar contraseña</button>
                </form>

                <br>

            </div>

        </section>

        <section class="d-flex">

            <div class="s-denuncia-bottom">
                <form action="{{ url('llavePOST') }}" method="POST">
                    @csrf
                    <input type="text" name="llave" id="llave" class="none">
                    <button class="btn btn-primary mb-3" onclick="generarPalabraAleatoria()">Generar llave</button>
                </form>

                <table class="default w-100" style="width: 100%;" id="mis_denuncias">
                    <tr style="width: 100%; text-align: center !important">
                        <th>N°</th>
                        <th>Llave</th>
                        <th>Estado</th>
                        <th>Acciónes</th>
                    </tr>
                    @foreach ($llave as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->llave }}</td>
                        @if($row->status == '1')
                            <td>No ah sido usado</td>
                        @else
                            <td>Ya ah sido usado</td>
                        @endif
                        <td>
                            <form action="{{ url('EliminarLlave') . '/' . $row->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button style="background: #da292e">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>

        </section>
    </main>

    <section class="form-cambio-clave none">
        <form action="{{ url('EditarContrasenaAdmin') . '/' . $usuario->id }}" class="form-clave" method="POST">
            @csrf
            @method('PUT')
            <i class="fa-solid fa-xmark xmark"></i>

            <label for="clave">Contraseña</label>
            <br>
            <input name="password" id="clave" type="text" placeholder="Contraseña" required>

            <br>
            <button>Guardar</button>
        </form>
    </section>

    @if($errors->any())
    <div class="alert alert-danger mt-3">
    @foreach($errors->all() as $error)
        <a href="{{ url('/PerfilA') }}">{{ $error }}</a>
    @endforeach
    </div>
    @endif

    <script>
        const btn_cambio_clave = document.querySelector('#btn_cambio_clave');
        const btn_xmark = document.querySelector('.xmark');

        btn_cambio_clave.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector('.form-cambio-clave').classList.toggle('none');
        });

        btn_xmark.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector('.form-cambio-clave').classList.toggle('none');
        });
    </script>
    
    <script>
        function generarPalabraAleatoria() {
            const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let cadenaAleatoria = '';

            for (let i = 0; i < 6; i++) {
                cadenaAleatoria += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }
            
            document.querySelector('#llave').value = cadenaAleatoria;
        }
    </script>

</body>
</html>