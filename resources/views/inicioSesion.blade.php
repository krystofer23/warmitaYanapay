<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./img/Logo.png" />
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>Warmita Yanapay | Inicio de sesión</title>
</head>
<body>

    <div class="containerr">
        <div class="left">
            <p class="m-0">Inicio de sesión</p>
            <h2 style="font-size: 28px;">WARMITA YANAPAY WEB</h2>
            <form style="max-width: 90%; width: 400px;" method="POST" action="{{ url('InicioSesionPost') }}">
                @csrf
                <div class="mt-3 mb-1">
                    <input name="correo" class="w-100 rounded-5" type="email" placeholder="Correo" required />
                </div>
                <div class="">
                    <input name="clave" class="w-100 rounded-5 mt-2" type="password" placeholder="Contraseña" required />
                </div>
                <button class="rounded-5 mt-4 w-100" type="submit">Ingresar</button>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach ($errors->all() as $error)
                            <p class="m-0 p-0 text-start"  style="font-size: 14px !important;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
            <div class="text">
                <p class="mt-4">
                    ¿No tienes una cuenta?
                    <a class="aa" href="{{ url('RegistroComisaria') }}">¡Registrate aqui!</a>
                </p>
            </div>
        </div>
        <div class="right">
            <h1>WARMITA YANAPAY</h1>
            <p>
                Pagina para iniciar sesión como en la aplicacion web "Warmita
                Yanapay"
            </p>
        </div>
    </div>

</body>
</html>
