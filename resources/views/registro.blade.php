
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="shortcut icon" href="./img/Logo.png" />
    <link rel="stylesheet" href="./css/index.css">
    <title>Prevenir | Registro</title>
</head>
<body style="background: #fff;" id="res">

    <div class="container-inicio-sesion pb-3 pt-3">
        <div class="border rounded-3 p-5 pt-2 bg-white" style="box-shadow: #f3f3f3 0 0 15px; max-width: 95%; width: 700px;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>REGISTRO</h2>
                    <p>Ingrese los datos de la comisaria.</p>
                </div>
                <img src="./img/Logo.png" alt="" style="width: 90px">
            </div>

            <form method="POST" action="{{ url('RegistroComisariaPost') }}">
                @csrf
                <div class="d-flex gap-3" id="container-wrap">
                    <div class="w-100 mb-3">
                        <label for="nombre" class="form-label">Nombre de la comisaria</label>
                        <input name="nombre" id="nombre" type="text" class="form-control" placeholder="Nombre de la comisaria" required>
                    </div>
                    <div class="w-100 mb-4">
                        <label for="direccion" class="form-label">Dirección de la comisaria</label>
                        <input name="direccion" id="direccion" type="text" class="form-control" placeholder="Dirección de la comisaria" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="correo" class="form-label">Correo a registrar por la comisaria</label>
                    <input name="correo" id="correo" type="email" class="form-control" placeholder="Correo" required>
                </div>

                <div class=" mb-4">
                    <label for="clave" class="form-label">Contraseña</label>
                    <input name="clave" id="clave" type="password" class="form-control" placeholder="Contraseña" required>
                </div>

                <div class=" mb-4">
                    <label for="llave" class="form-label">
                        LLave 
                        <span style="color: #949494">(La llave es proporcionada e unica para poder registrase)</span>
                    </label>
                    <input name="llave" id="llave" type="password" class="form-control" placeholder="Llave" required>
                </div>
                <button type="submit" class="btn btn-primary">Registrar comisaria</button>

                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        @foreach($errors->all() as $error)
                            <p class="m-0 p-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>

        <div class="mt-5">
            <span>¿Ya tienes una cuenta? </span>
            <a href="{{ url('InicioSesion') }}" class="">Iniciar sesión</a>
        </div>
    </div>

</body>
</html>