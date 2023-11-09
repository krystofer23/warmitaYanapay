
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gabarito&display=swap" rel="stylesheet">
    <title>{{ $victimas->nombre }} {{ $victimas->apellido }} | Warmita Yanapay Alerta </title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
</head>
<body>

    <a href="" style="position: fixed; top: 0; right: 0; margin: 25px; z-index: 999999;
    padding: 10px 20px; background-color: #cdf463; color: #000; font-family: Gabarito; text-decoration: none
    ; box-shadow: #0000003a 0 0 10px">Actualizar</a>

    <div id="mapid" style="height: 100vh !important; width: 100%;"></div>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
    </style>
    
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

    <script>
        var marker = L.marker([{{$alertas->latitud}}, {{$alertas->longitud}}], {icon: redIcon}).addTo(mymap);
        marker.bindPopup("DNI: " +{{ $victimas->dni }});
    </script>

</body>
</html>