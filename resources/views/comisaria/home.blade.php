
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
            <span>Warmita Yanapay Comisaria</span>
        </div>

        <ul class="nav-down">
            <li class="li-active">
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

            <li class="">
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
            <h2 class="m-0 p-0">Inicio</h2>
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

        <section class="sec-home">
           
            <div class="boxes-inf">
                <div class="box-inf" style="background-color: #e84c51;">
                    <span class="text-black">{{ $alertas_n }}</span>
                    <p class="text-black">Alertas</p>
                </div>
                <div class="box-inf" style="background-color: #92e3b8;">
                    <span class="text-black">{{ $denuncias_n }}</span>
                    <p class="text-black">Denuncias</p>
                </div>
                <div class="box-inf" style="background-color: #aac9ff;">
                    <span class="text-black">{{ $usuarios_n }}</span>
                    <p class="text-black">Usuarios</p>
                </div>
            </div>

        </section>
    </main>

</body>
</html>