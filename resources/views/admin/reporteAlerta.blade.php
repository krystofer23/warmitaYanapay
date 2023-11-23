
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <link rel="stylesheet" href="./css/comisaria/index.css">
    <link rel="stylesheet" href="./css/comisaria/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>

    <script src="./js/jspdf.min.js"></script>
</head>
<body style="background-color: #eff3f4;">

    <header>
        <h2 class="m-0 p-0">Reporte de alertas</h2>
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

    <section>
        <div class="s-denuncia-top">
            <div class="d-flex justify-content-between gap-3 w-100">
                <select id="miSelect" onchange="verificarSeleccion()" class="form-select"
                    aria-label="Default select example" style="width: 250px">
                    <option selected value="1">Todas las alertas</option>
                    <option value="2">Alertas atendidas</option>
                    <option value="3">Alertas por atender</option>
                </select>

               <div>
                    <a class="btn btn-primary" href="{{ url('descargar') }}">Descargar en Excel</a>
                    <a class="btn btn-primary" id="btn_pdf">Descargar en pdf</a>

                    <button id="agregar_usuarios"><a href="{{ url('AlertaA') }}" class="text-black" style="text-decoration: none">Volver</a></button>
               </div>
            </div>
        </div>

        <div class="s-denuncia-top justify-content-start gap-3 align-items-center m-0 pt-0 flex-wrap">
            <p class="p-0 m-0">Fecha de inicio: </p>
            <form class="d-flex gap-3 flex-wrap align-items-center">
                @csrf
                <input id="fecha_inicio" name="fecha_inicio" type="date" class="form-control" required>
                <p class="d-flex align-items-center p-0 m-0">Fecha de fin:</p>
                <input id="fecha_fin" name="fecha_fin" type="date" class="form-control" required>
                <button class="" id="btn_filtrar">Filtrar</button>
            </form>
        </div>

        <div class="d-flex gap-3 justify-content-center flex-wrap px-4 mb-4 pb-2">
            <div  class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                <p class="text-success d-flex align-items-center"><i class="fa-solid fa-bell me-2 text-success"></i> ALERTAS ATENDIDAS <i style="cursor: pointer" title="Todas las alertas atendias por las comisaria." class="fa-solid fa-circle-info ms-3"></i></p>
                <span class="text-success">{{ $alertas_atendidast }}</span>
                {{-- <span class="text-black">{{ $denuncias_n }}</span> --}}
            </div>
            <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                <p class="text-danger d-flex align-items-center"><i class="fa-solid fa-bell me-2 text-danger"></i> ALERTAS POR ATENDER <i title="Alertas por atender por las comisarias." style="cursor: pointer" class="fa-solid fa-circle-info ms-3"></i></p>
                <span class="text-danger">{{ $alertas_no_atendidast }}</span>
            </div>
            <div class="box-inf p-4" style="background-color: #fff; box-shadow: 0px 0px 8px rgba(0, 0, 0, .1)">
                <p class="text-danger d-flex align-items-center"><i class="fa-solid fa-bell me-2"></i> TOTAL DE ALERTAS
                    <i title="Todas las aletas hechas por los usuarios, incluidas las atendias y por las que falta atender." style="cursor: pointer;"  class="fa-solid fa-circle-info ms-3"></i>
                </p>
                <span class="text-danger">{{ $total_alertast }}</span>
            </div>
        </div>
     
        <div class="s-denuncia-bottom" id="total">
            {{-- Todas las atertas --}}
            <table class="default" style="width: 100%;" id="mis_denunciasc">
                <thead>
                    <tr style="width: 100%; text-align: center !important">
                        <th style="cursor: pointer" onclick="ordenarColumna(0)">
                           N° <i id="btn_ya" class="ms-1 mt-1 fa-solid fa-arrow-up" style="display: inline-block"></i>
                        </th>
                        <th>DNI de la victima</th>
                        <th>Fecha de emisión de la alerta</th>
                        <th>Status de la alerta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($alertas as $row)
                        <tr style="width: 100%;">
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->dni }}</td>
                            <td>{{ $row->created_at }}</td>
                            @if ($row->status == '1')
                            <td>Atendida</td>
                            @else
                                <td>Por atender</td>
                            @endif
                            <td>
                                <form action="{{ url('verMasUsuario') . '/' . $row->id_victima }}" method="GET">
                                    <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                    <button class="btn btn-warning fs-7 px-3 py-2 border">Ver información de la victima</button>
                                </form>
                                <form action="{{ url('eliminarReporteAlerta') . '/' . $row->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                    <button class="btn btn-danger mt-1 fs-7 px-3 py-2 border">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>

        <div class="s-denuncia-bottom none" id="atendidas">
            {{-- Todas atendidas --}}
            <table class="default" style="width: 100%;" id="atendidassc">
                <thead>
                    <tr style="width: 100%; text-align: center !important">
                        <th style="cursor: pointer" onclick="ordenarColumna2(0)">N° <i id="btn_yd" class="ms-1 mt-1 fa-solid fa-arrow-up" style="display: inline-block"></i></th>
                        <th>DNI de la victima</th>
                        <th>Fecha de emisión de la alerta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
               <tbody>
                @foreach ($alertas_atendidas as $row)
                    <tr style="width: 100%;">
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->dni }}</td>
                        <td style="text-align: center !important;" class="px-4">{{ $row->created_at }}</td>
                        <td>
                            <form action="{{ url('verMasUsuario') . '/' . $row->id_victima }}" method="GET">
                                <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                <button class="btn btn-warning fs-7 px-3 py-2 border">Ver información de la victima</button>
                            </form>
                            <form action="{{ url('eliminarReporteAlerta') . '/' . $row->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                <button class="btn btn-danger mt-1 fs-7 px-3 py-2 border">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
               </tbody>
            </table>
        </div>

        <div class="s-denuncia-bottom none" id="no_atendidas">
            {{-- Todas no atendidas --}}
            <table class="default" style="width: 100%;" id="no_atendidasss">
                <thead>
                    <tr style="width: 100%; text-align: center !important">
                        <th style="cursor: pointer" onclick="ordenarColumna3(0)">N° <i id="btn_yt" class="ms-1 mt-1 fa-solid fa-arrow-up" style="display: inline-block"></i></th>
                        <th>DNI de la victima</th>
                        <th>Fecha de emisión de la alerta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($alertas_por_atender as $row)
                    <tr style="width: 100%;">
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->dni }}</td>
                        <td style="text-align: center !important;" class="px-4">{{ $row->created_at }}</td>
                        <td>
                            <form action="{{ url('verMasUsuario') . '/' . $row->id_victima }}" method="GET">
                                <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                <button class="btn btn-warning fs-7 px-3 py-2 border">Ver información de la victima</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
               </tbody>
            </table>
        </div>
    </section>

    @if($errors->any())
    @foreach($errors->all() as $error)
        @if($error == "success")
        <div class="alert alert-success mt-3">
            <a href="{{ url('/AlertaA') }}">Reporte eliminado</a>
        </div>
        @else 
        <div class="alert alert-danger mt-3">
            <a href="{{ url('/AlertaA') }}">{{ $error }}</a>
        </div>
        @endif
    @endforeach
    @endif

    <script>
        // Todas las evidencias
        function traerEvidencias() {
            fetch('{{ url('traerReporteAlertasTotal') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                      
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // document.querySelector('#count_e').textContent = data.evidencias.length;
                    console.log(data);
                    var tabla = document.querySelector('#mis_denunciasc tbody');
                    tabla.innerHTML = '';

                    data.reporteAlertas.forEach(fila => {
                        var tr = document.createElement('tr');

                        var td1 = document.createElement('td');
                        td1.textContent = fila.id;
                        tr.appendChild(td1);

                        var td2 = document.createElement('td');
                        td2.textContent = fila.dni;
                        tr.appendChild(td2);

                        var td3 = document.createElement('td');
                        td3.textContent = fila.created_at;
                        tr.appendChild(td3);

                        var td4 = document.createElement('td');
                        if (fila.status == 1) {
                            td4.textContent = 'Atendida';
                        }
                        else {
                            td4.textContent = 'Por atender';
                        }
                        tr.appendChild(td4);

                        var td5 = document.createElement('td');
                        td5.innerHTML = `
                                <form action="{{ url('verMasUsuario/` + fila.id_victima + `') }}" method="GET">
                                    <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                    <button class="btn btn-warning fs-7 px-3 py-2 border">Ver información de la victima</button>
                                </form>
                                <form action="{{ url('eliminarReporteAlerta/` + fila.id + `') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="text" name="page" class="none" value="ReporteDeAlertas">
                                    <button class="btn btn-danger mt-1 fs-7 px-3 py-2 border">Eliminar</button>
                                </form>`;
                        tr.appendChild(td5);
 
                        tabla.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        traerEvidencias();

        let ordenAscendente = true;
        let columnaActual = 0;

        const tbody = document.querySelector("#mis_denunciasc tbody");
      
        function ordenarTabla() {
            const filas = Array.from(tbody.querySelectorAll("tr"));
        
            filas.sort((a, b) => {
                const valorA = a.children[columnaActual].textContent.trim();
                const valorB = b.children[columnaActual].textContent.trim();
        
                if (!isNaN(valorA) && !isNaN(valorB)) {
                return ordenAscendente ? valorA - valorB : valorB - valorA;
                } else {
                return ordenAscendente
                    ? valorA.localeCompare(valorB)
                    : valorB.localeCompare(valorA);
                }
            });
        
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }
        
            filas.forEach((fila) => {
                tbody.appendChild(fila);
            });
        
            ordenAscendente = !ordenAscendente;
            document.querySelector('#btn_ya').classList.toggle('fa-arrow-up');
            document.querySelector('#btn_ya').classList.toggle('fa-arrow-down');
        }
      
        function ordenarColumna(index) {
            columnaActual = index;
            ordenarTabla();
        }

        ordenarTabla();
    </script>
    
    <script>
        let ordenAscendente2 = true;
        let columnaActual2 = 0;

        const tbody2 = document.querySelector("#atendidassc tbody");
      
        function ordenarTabla2() {
            const filas = Array.from(tbody2.querySelectorAll("tr"));
        
            filas.sort((a, b) => {
                const valorA = a.children[columnaActual2].textContent.trim();
                const valorB = b.children[columnaActual2].textContent.trim();
        
                if (!isNaN(valorA) && !isNaN(valorB)) {
                return ordenAscendente2 ? valorA - valorB : valorB - valorA;
                } else {
                return ordenAscendente2
                    ? valorA.localeCompare(valorB)
                    : valorB.localeCompare(valorA);
                }
            });
        
            while (tbody2.firstChild) {
                tbody2.removeChild(tbody2.firstChild);
            }
        
            filas.forEach((fila) => {
                tbody2.appendChild(fila);
            });
        
            ordenAscendente2 = !ordenAscendente2;
            document.querySelector('#btn_yd').classList.toggle('fa-arrow-up');
            document.querySelector('#btn_yd').classList.toggle('fa-arrow-down');
        }
      
        function ordenarColumna2(index) {
            columnaActual2 = index;
            ordenarTabla2();
        }

        ordenarTabla2();
    </script>

    <script>
        let ordenAscendente3 = true;
        let columnaActual3 = 0;

        const tbody3 = document.querySelector("#no_atendidasss tbody");
    
        function ordenarTabla3() {
            const filas = Array.from(tbody3.querySelectorAll("tr"));
        
            filas.sort((a, b) => {
                const valorA = a.children[columnaActual2].textContent.trim();
                const valorB = b.children[columnaActual2].textContent.trim();
        
                if (!isNaN(valorA) && !isNaN(valorB)) {
                return ordenAscendente3 ? valorA - valorB : valorB - valorA;
                } else {
                return ordenAscendente3
                    ? valorA.localeCompare(valorB)
                    : valorB.localeCompare(valorA);
                }
            });
        
            while (tbody3.firstChild) {
                tbody3.removeChild(tbody3.firstChild);
            }
        
            filas.forEach((fila) => {
                tbody3.appendChild(fila);
            });
        
            ordenAscendente3 = !ordenAscendente3;
            document.querySelector('#btn_yt').classList.toggle('fa-arrow-up');
            document.querySelector('#btn_yt').classList.toggle('fa-arrow-down');
        }
    
        function ordenarColumna3(index) {
            columnaActual2 = index;
            ordenarTabla3();
        }

        ordenarTabla3();
    </script>

    <script>
        document.querySelector('#btn_pdf').addEventListener('click', e => {
            descargarPDF();
        });

        function descargarPDF() {
            const element = document.getElementById("mis_denunciasc");
            
            html2canvas(element).then((canvas) => {
                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF({
                    orientation: 'landscape'
                });
                pdf.addImage(imgData, "PNG", 10, 10, null, null, null);
                pdf.save("Reporte.pdf");
            });
        }
    </script>

    <script>
        function verificarSeleccion() {
            var selectElement = document.getElementById('miSelect');
            var selectedValue = selectElement.value;
            if (selectedValue === '1') {
                document.querySelector('#total').classList.remove('none');
                document.querySelector('#atendidas').classList.add('none');
                document.querySelector('#no_atendidas').classList.add('none');
            } else if (selectedValue === '2') {
                document.querySelector('#total').classList.add('none');
                document.querySelector('#atendidas').classList.remove('none');
                document.querySelector('#no_atendidas').classList.add('none');
            } else if (selectedValue === '3') {
                document.querySelector('#total').classList.add('none');
                document.querySelector('#atendidas').classList.add('none');
                document.querySelector('#no_atendidas').classList.remove('none');
            }
        }
    </script>

</body>
</html>