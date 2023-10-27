<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="shortcut icon" href="./img/Logo.png" />
    <title>Prevenir | Incio de sesión</title>
</head>
<body style="background: #fff">

    <div class="container-inicio-sesion pb-5">
        <img src="./img/Logo.png" alt="" class="img_init">

        <div class="border rounded-3 p-5 bg-white" style="max-width: 90%; width: 400px; box-shadow: #f3f3f3 0 0 15px;">
            <h3 class="fs-4 text-center mb-2">INICIO DE SESIÓN</h3>
            <p class="text-start mb-3" style="color: #949494">Ingrese sus credenciales</p>

            <form method="POST" action="{{ url('InicioSesionPost') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Correo</label>
                    <input name="correo" type="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="Correo" required>
                </div>
                <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Contraseña</label>
                    <input name="clave" type="password" class="form-control" id="exampleInputPassword1"
                        placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Inciar sesión</button>
                
                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach($errors->all() as $error)
                            <p class="m-0 p-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>

        <div class="pb-4 mt-5"><span>¿No tienes una cuenta? </span><a href="{{ url('RegistroComisaria') }}"> Crear
                cuenta</a></div>
    </div>

</body>
</html>
