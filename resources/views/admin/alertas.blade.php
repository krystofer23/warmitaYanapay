
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

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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

            <li class="li-active">
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

            <li class="">
                <i class="fa-solid fa-address-book"></i>
                <a href="{{ url('ContactosA') }}">Contactos</a>
            </li>

            <li class="">
                <i class="fa-solid fa-user"></i>
                <a href="{{ url('PerfilA') }}">Mi perfil</a>
            </li>
        </ul>
    </nav>

    <main style="height: 100%">
        <header>
            <h2 class="m-0 p-0">Alertas</h2>
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
                <button><a style="padding: 10px 15px; color: #000; text-decoration: none" href="{{ url('/AlertaA') }}">Actualizar</a></button>
                <button style="background-color: #e84c51;"><a style="padding: 10px 15px; color: #fff; text-decoration: none" href="{{ url('/ReporteAlertaA') }}">Reporte de alertas</a></button>
            </div>

            <div class="s-denuncia-bottom" id="map">
                
            </div>
            
            <div id="mapid" style="height: 400px;"></div>
        </section>

        <section class="p-4">

            <ul class="d-flex justify-content-start flex-wrap gap-3 p-0">

                @foreach ($dni_alertas as $row)
                <li class="p-4 d-flex flex-column rounded-2 border list-group-item list-group-item-danger d-flex justify-content-between align-items-center" style="max-width: 100%; width: 450px; overflow: hidden;">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span>{{$row->created_at}}</span>

                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger rounded-pill">N° {{$row->id}}</span>
                            <form action="{{ url('EliminarAlerta') . '/' . $row->id_victima }}" class="ms-2" method="POST">
                                @csrf
                                @method('DELETE')
                                <button style="background-color: #00000000; border: none;"><i class="fa-solid fa-trash" style="cursor: pointer"></i></button>
                            </form>
                        </div>
                    </div>
                    <div class="pt-3 d-flex gap-1 align-items-center justify-content-between w-100" style="overflow: hidden;">
                        <span class="border border-danger px-3 py-2 rounded-3 text-danger">DNI: {{ $row->dni }}</span>
                        <form action="{{ url('verMasUsuario') . '/' . $row->id_victima }}" method="GET">
                            <button class="btn btn-danger fs-7 px-3 py-2 border border-danger">Ver información de la victima</button>
                        </form>
                    </div>
                </li>
                @endforeach
                
            </ul>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var mymap = L.map('mapid').setView([-12.0344587,-77.006632], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        var redIcon = new L.Icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var greenIcon = new L.Icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
    </script>

    @foreach ($alertas as $row)
    <script>
        var marker = L.marker([{{$row->latitud}}, {{$row->longitud}}], {icon: redIcon}).addTo(mymap);
        @foreach ($victimas as $key)
            @if ($key->id === $row->id_victima)
                marker.bindPopup("DNI: " +{{ $key->dni }});
            @endif
        @endforeach
    </script>
    @endforeach
</body>
</html>