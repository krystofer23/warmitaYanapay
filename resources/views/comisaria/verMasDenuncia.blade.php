
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/comisaria/index.css">
    <link rel="stylesheet" href="../css/comisaria/nav.css">
    <link rel="stylesheet" href="../css/comisaria/header.css">
    <link rel="stylesheet" href="../css/comisaria/vermas.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>
</head>
<body>

    <div class="container-ver-m-d flex-column">
        <div class="border container-info-m-d" style="box-shadow: rgba(0, 0, 0, 0.1) 2px 2px 8px">
            <div class="border-bottom px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3 align-items-center">
                    <img src="../img/Logo.png" alt="" style="height: 80px">
                    <h3 class="m-0">Información de la denuncia</h3>
                </div>
                <span>Fecha de denuncia: {{ $denuncia->created_at }}</span>
            </div>
            <div class="d-flex w-100">
                <div class="p-4 w-100 border-end">
                    <h4>Victima</h4>
                   
                    <div class="w-100">
                        <span class="pb-2" style="font-size: 13px">DNI</span>
                        <p class="pb-2 border-bottom">{{ $victima->dni }}</p>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Nombres</span>
                            <p class="pb-2 border-bottom">{{ $victima->nombre }}</p>
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Apellidos</span>
                            <p class="pb-2 border-bottom">{{ $victima->apellido }}</p>
                        </div>
                    </div>
    
                    <div class="w-100">
                        <span class="pb-2" style="font-size: 13px">Celular</span>
                        <p class="pb-2 border-bottom">{{ $victima->celular }}</p>
                    </div>
                    <div class="w-100">
                        <span class="pb-2" style="font-size: 13px">Dirección</span>
                        <p class="pb-2 border-bottom">{{ $victima->direccion }}</p>
                    </div>
                    <div class="w-100">
                        <span class="pb-2" style="font-size: 13px">Correo</span>
                        <p class="pb-2 border-bottom">{{ $victima->correo }}</p>
                    </div>
                    @if($victima->correo == '' || $victima->correo == null)
                        <span class="badge bg-danger px-3 py-2" style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;">El usuario no esta registrado en la APP, ni en la comisaria.</span>
                    @endif
                </div>
                <div class="w-100 p-4">
                    <h4>Datos de la denuncia </h4>

                    <div class="w-100">
                        <span class="pb-2" style="font-size: 13px">Comisaria</span>
                        <p class="pb-2 border-bottom">{{ $comisaria->nombre }}</p>
                    </div>
                    <form action="{{ url('ActualizarDenuncia') . '/' . $denuncia->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Descripción</span>
                            <br>
                            <textarea name="descripcion" class="text-area" name="" id="" cols="10" rows="3">{{ $denuncia->descripcion }}</textarea>
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Lugar del hecho</span>
                            <br>
                            <input name="lugar" class="inp-p" type="text" value="{{ $denuncia->lugar }}">
                        </div>
                        <div class="w-100 d-flex flex-column">
                            <span class="pb-2" style="font-size: 13px">Prueba</span>
                            @if($denuncia->prueba_media == '' || $denuncia->prueba_media == null)
                                <a>No hay prueba</a>
                            @else
                                <a target="blank" href="{{ $denuncia->prueba_media }}">Ver prueba</a>
                            @endif
                        </div>
                        <button class="btn-edit-d mt-3">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="py-3 d-flex justify-content-end container-info-m-d" style="background-color: #00000000 !important">
            <button class="btn btn-secondary" onclick="imprimir()">Imprimir</button>
            <button class="ms-2 btn-primarys" onclick="goBack()">Volver</button>
        </div>
    </div>

    @if($errors->any())
    @foreach($errors->all() as $error)
        @if($error == "success")
        <div class="alert alert-success mt-3">
            <a href="{{ url('/VerMasDenuncia') . '/' . $denuncia->id }}">Denuncia actualizada</a>
        </div>
        @else 
        <div class="alert alert-danger mt-3">
            <a href="{{ url('/VerMasDenuncia') . '/' . $denuncia->id }}">{{ $error }}</a>
        </div>
        @endif
    @endforeach
    @endif

    <a href="{{ url('/VerMasDenuncia') . '/' . $denuncia->id }}">{{ session('mensaje') }}</a>

    <script>
        function goBack(e) {
            window.history.back();
        }
    </script>

    <script>
        function imprimir() {
            window.print();
        }
    </script>
    
</body>
</html>