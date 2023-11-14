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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>
</head>

<body>

    <div class="container-ver-m-d flex-column">
        <div class="border container-info-m-d" style="box-shadow: rgba(0, 0, 0, 0.1) 2px 2px 8px">
            <div class="border-bottom px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex gap-3 align-items-center">
                    <img src="../img/Logo.png" alt="" style="height: 80px">
                    <h3 class="m-0">Información del contacto</h3>
                </div>
                <span>Fecha de registro: {{ $detalle_contacto->created_at }}</span>
            </div>
            <div class="d-flex w-100">
                <div class="p-4 w-100 border-end">
                    <h4>Contacto</h4>

                    <form action="{{ url('EditarContacto') . '/' . $id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Número de celular</span>
                            <input name="celular" class="inp-p" type="text" value="{{ $detalle_contacto->celular }}">
                        </div>

                        <div class="d-flex gap-3">
                            <div class="w-100">
                                <span class="pb-2" style="font-size: 13px">Nombre</span>
                                <input name="nombre" class="inp-p" type="text" value="{{ $detalle_contacto->nombre }}">
                            </div>
                            <div class="w-100">
                                <span class="pb-2" style="font-size: 13px">Apellido</span>
                                <input name="apellido" class="inp-p" type="text" value="{{ $detalle_contacto->apellido }}">
                            </div>
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Dirección</span>
                            <br>
                            <input name="direccion" class="inp-p" type="text" value="{{ $detalle_contacto->dirrecion }}">
                        </div>
                        <button class="btn-edit-d">Guardar cambios</button>
                    </form>
                </div>
                <div class="w-100 p-4">
                    <h4>REGISTRADA(O) POR {{ ucwords($victima->nombre) }} {{ ucwords($victima->apellido) }}</h4>

                    <div style="width: 100%;">
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Número de contactos en total </span>
                            <p class="pb-2 border-bottom">{{ $t_contactos }}</p>
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">DNI </span>
                            <p class="pb-2 border-bottom">{{ $victima->dni }}</p>
                        </div>
                        <div class="w-100">
                            <span class="pb-2" style="font-size: 13px">Celular de la victima</span>
                            <p class="pb-2 border-bottom">{{ $victima->celular }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3 d-flex justify-content-end container-info-m-d" style="background-color: #00000000 !important">
            <button class="btn btn-secondary" onclick="imprimir()">Imprimir</button>
        
            <a href="{{ url('ContactosA') }}" class="ms-2 btn-primarys">Volver</a>
        </div>
    </div>

    <script>
        function imprimir() {
            window.print();
        }
    </script>

</body>
</html>
