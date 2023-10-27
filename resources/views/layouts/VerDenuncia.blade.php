
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="shortcut icon" href="../img/Logo.png" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <title>Prevenir | Web</title>
</head>
<body class="d-flex justify-content-center align-items-center w-100" style="height: 100vh; background-image: url('https://sistemas.policia.gob.pe/denuncias_digitales/images/fondo.jpg');">

    <div class="d-flex gap-3 border p-5 rounded-3 bg-white" style="max-width: 95%; width: 1100px; margin: 0 auto;">
        <div class="w-100 border-end pe-3">
            <h3>DATOS DEL DENUNCIANTE</h3>

            <form action="">
                <div class="mb-3">
                    <label class="form-label" for="">DNI</label>
                    <input class="form-control" type="text" value="{{ $usuario->dni }}" disabled="">
                </div>
                <div class="d-flex gap-3">
                    <div class="mb-3 w-100">
                        <label class="form-label" for="">Nombre</label>
                        <input class="form-control" type="text" value="{{ $usuario->nombre }}" disabled="">
                    </div>
                    <div class="mb-3 w-100">
                        <label class="form-label" for="">Apellido</label>
                        <input class="form-control" type="text" value={{ $usuario->apellido }} disabled="">
                    </div>
                </div>
                <div class="mb-3 w-100">
                    <label class="form-label" for="">Celular</label>
                    <input class="form-control" type="text" value="{{ $usuario->celular }}" disabled="">
                </div>
                <div class="mb-3 w-100">
                    <label class="form-label" for="">Correo</label>
                    <input class="form-control" type="text" value="{{ $usuario->correo }}" disabled="">
                </div>
                <div class="mb-3 w-100">
                    <label class="form-label" for="">Dirección</label>
                    <input class="form-control" type="text" value="{{ $usuario->direccion }}" disabled="">
                </div>
            </form>
        </div>
        <div class="w-100">
            <h3>INFORMACIÓN DE LA DENUNCIA</h3>

            <form action="">
                <div class="mb-3">
                    <label class="form-label" for="">Lugar del hecho</label>
                    <input class="form-control" type="text" value="{{ $denuncia->lugar }}" disabled="">
                </div>
                <div class="mb-3 w-100">
                    <label class="form-label" for="">Descripcion</label>
                    <textarea class="form-control" rows="3" cols="30" disabled="">{{ $denuncia->descripcion }}</textarea>
                </div>
                <div class="mb-3 w-100">
                    <label class="form-label" for="">Evidencia</label>
                    <input class="form-control" type="text" value="{{ $usuario->correo }}" disabled="">
                </div>
            </form>

            <a href="{{ url('/') }}" class="btn btn-info">Volver</a>
        </div>
    </div>

</body>
</html>