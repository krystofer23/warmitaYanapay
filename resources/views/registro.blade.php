
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./img/Logo.png" />
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>Warmita Yanapay | Registro</title>
</head>
<body id="res">

    <div class="containerr">
        <div class="left">
            <p class="m-0">Registrate en</p>
            <h2 style="font-size: 28px;">WARMITA YANAPAY WEB</h2>
            <form style="max-width: 99%; width: 400px;" method="POST" action="{{ url('RegistroComisariaPost') }}">
                @csrf
                <div class="mt-3 mb-1">
                    <input name="nombre" class="w-100 rounded-5" type="text" placeholder="Nombre" required />
                </div>
                <div class="mt-3 mb-1">
                    <input name="direccion" class="w-100 rounded-5" type="text" placeholder="Dirección" required />
                </div>
                <div class="mt-3 mb-1">
                    <input name="correo" class="w-100 rounded-5" type="email" placeholder="Correo" required />
                </div>
                <div class="mt-3 mb-1">
                    <input name="clave" class="w-100 rounded-5" type="password" placeholder="Contraseña" required />
                </div>
                <div class="mt-3 mb-1">
                    <input name="llave" class="w-100 rounded-5" type="password" placeholder="Llave" required />
                </div>
                <button class="rounded-5 mt-4 w-100" type="submit">Registrarme</button>

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
                    ¿Ya tienes una cuenta?
                    <a class="aa" href="{{ url('InicioSesion') }}">¡Inicia sesión!</a>
                </p>
            </div>
        </div>
        <div class="right">
            <h1>WARMITA YANAPAY</h1>
            <p>
                Pagina para registrarte en la aplicacion web "Warmita
                Yanapay"
            </p>
        </div>
    </div>

</body>
</html>