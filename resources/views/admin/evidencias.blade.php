<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/comisaria/index.css">
    <link rel="stylesheet" href="./css/comisaria/nav.css">
    <link rel="stylesheet" href="./css/comisaria/header.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Warmita Yanapay | Web</title>

    <script src="./js/jspdf.min.js"></script>

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

            <li class="">
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
                <a href="{{ url('ComisariaA') }}">Comisarias</a>
            </li>

            <li class="li-active">
                <i class="fa-solid fa-receipt"></i>
                <a href="{{ url('EvidenciasA') }}">Evidencias</a>
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

    <main>
        <header>
            <h2 class="m-0 p-0">Evidencias <br>
                <p class="fs-6 m-0 p-0">N° de evidencias: <span id="count_e"></span></p>
            </h2>
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
            <div class="s-denuncia-top flex-wrap gap-3">
                <form action="{{ url('BuscarUsuarioD') }}" method="POST">
                    @csrf
                    <input maxlength="8" name="dni" type="search" placeholder="Buscar">
                </form>

                <div class="d-flex gap-3" >
                    {{-- <button id="btn_ecxel">Exportar a Excel</button> --}}
                    <a class="btn btn-primary" href="{{ url('descargar') }}">Descargar en Excel</a>
                    <a class="btn btn-primary" id="btn_pdf">Descargar en pdf</a>

                    <div class="d-flex gap-3">
                        <select id="miSelect" onchange="verificarSeleccion()" class="form-select"
                            aria-label="Default select example" style="width: 250px">
                            <option value="2">Todas las evidencias</option>
                        </select>
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

            <div class="s-denuncia-bottom">
                <table class="default" style="width: 100%;" id="denuncias">
                    <thead>
                        <tr style="width: 100%; text-align: center !important">
                            <th style="cursor: pointer" onclick="ordenarColumna(0)">N° <i id="btn_y" class="ms-1 mt-1 fa-solid fa-arrow-up" style="display: inline-block"></i></th>
                            <th>Victima</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Datos del agresor</th>
                            <th>Evidencia</th>
                            <th>Acciónes</th>
                        </tr>
                    </thead>
                    <tbody id="data_view">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </section>
    </main>

    <section class="form-registro-no-usuarios none">
        <form action="{{ url('RegistroDenunciaPOST') }}" method="POST" enctype="multipart/form-data">
            <h2>REGISTRO DE DENUNCIA</h2>
            <p style="color: #5c5c5c; padding-bottom: 20px">Para inicar la denuncia debe debe indicar los hechos como
                lo
                narra el denunciante.</p>
            @csrf
            <i class="fa-solid fa-xmark xmark xmark-usuarios"></i>

            <div class="inp-cont">
                <div>
                    <label for="dni">DNI de la victima</label>
                    <br>
                    <input type="text" maxlength="8" name="id_victima" id="dni" placeholder="DNI"
                        required>
                    <br>
                </div>
                <div class="ms-1">
                    <label for="place">Lugar del hecho</label>
                    <br>
                    <input type="text" name="lugar" id="place" placeholder="Dirección" required>
                </div>
            </div>
            <label for="description">Descipción del hecho</label>
            <br>
            <textarea name="descripcion" id="description" cols="30" rows="3"></textarea>
            <br>
            <label for="celular">Pruba (Imagen, Video, Pdf, docx)</label>
            <br>
            <input name="file" class="form-control input-file" type="file" maxlength="9" name="celular"
                id="celular" placeholder="Celular">
            <br>
            <div class="cont-for-btn">
                <a href="{{ url('/Usuarios') }}">¿La victima no esta registrada? <br> Registrela en la sección
                    usuarios.</a>
                <button>Registrar</button>
            </div>
        </form>
    </section>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            @if ($error == 'success')
                <div class="alert alert-success mt-3">
                    <a href="{{ url('/EvidenciasA') }}">Evidencia eliminada</a>
                </div>
            @else
                <div class="alert alert-danger mt-3">
                    <a href="{{ url('/EvidenciasA') }}">{{ $error }}</a>
                </div>
            @endif
        @endforeach
    @endif

    <script>
        let ordenAscendente = true;
        let columnaActual = 0;

        const tbody = document.querySelector("#denuncias tbody");
      
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
            document.querySelector('#btn_y').classList.toggle('fa-arrow-up');
            document.querySelector('#btn_y').classList.toggle('fa-arrow-down');
        }
      
        function ordenarColumna(index) {
            columnaActual = index;
            ordenarTabla();
        }

        ordenarTabla();
    </script>

    <script>
        document.querySelector('#btn_pdf').addEventListener('click', e => {
            descargarPDF();
        });

        function descargarPDF() {
            const element = document.getElementById("denuncias");
            
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
        document.addEventListener('DOMContentLoaded', function() {
            var fechaInicioInput = document.getElementById('fecha_inicio');
            var fechaFinInput = document.getElementById('fecha_fin');

            fechaInicioInput.addEventListener('change', function() {
                fechaFinInput.min = fechaInicioInput.value;
            });
        });
    </script>

    <script>
        document.querySelector('#btn_filtrar').addEventListener('click', e => {
            e.preventDefault();
            filtrarEvidencias();
        });

        function filtrarEvidencias() {
            var fechaInicio = document.getElementById('fecha_inicio').value;
            var fechaFin = document.getElementById('fecha_fin').value;

            if (fechaInicio == null || fechaInicio == '') {
                alert("Ingrese la fecha de inicio");
            } else if (fechaFin == null || fechaFin == '') {
                alert("Ingrese la fecha de fin");
            } else {
                fetch('{{ url('traerEvidencias') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            fecha_inicio: fechaInicio,
                            fecha_fin: fechaFin
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#count_e').textContent = data.evidencias.length;

                        var tabla = document.getElementById('data_view');
                        tabla.innerHTML = '';

                        data.evidencias.forEach(fila => {
                            var tr = document.createElement('tr');

                            var td1 = document.createElement('td');
                            td1.textContent = fila.id;
                            tr.appendChild(td1);

                            var td2 = document.createElement('td');
                            td2.textContent = fila.id_victima;
                            tr.appendChild(td2);

                            var td3 = document.createElement('td');
                            td3.textContent = fila.created_at;
                            tr.appendChild(td3);

                            var td4 = document.createElement('td');
                            td4.textContent = fila.descripcion;
                            tr.appendChild(td4);

                            var td5 = document.createElement('td');
                            td5.textContent = fila.datos_agresor;
                            tr.appendChild(td5);

                            var td6 = document.createElement('td');
                            if (fila.evidencia_media == '' || fila.evidencia_media == null) {
                                td6.textContent = 'No hay evidencia';
                            } else {
                                let a = document.createElement('a');
                                a.textContent = 'Ver evidencia'
                                a.setAttribute('href', fila.evidencia_media)
                                a.setAttribute('target', '_BLANK')
                                td6.appendChild(a);
                            }
                            tr.appendChild(td6);

                            let td7 = document.createElement('td');
                            td7.innerHTML = `
                                <form action="{{ url('EliminarEvidenciaE/` + fila.id + `') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="background: #da292e" class="mt-1">Eliminar</button>
                                </form>`;
                            tr.appendChild(td7);
    
                            tabla.appendChild(tr);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        }


        
        function traerEvidencias() {
            fetch('{{ url('traerEvidenciasTotal') }}', {
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
                    document.querySelector('#count_e').textContent = data.evidencias.length;

                    var tabla = document.getElementById('data_view');
                    tabla.innerHTML = '';

                    data.evidencias.forEach(fila => {
                        var tr = document.createElement('tr');

                        var td1 = document.createElement('td');
                        td1.textContent = fila.id;
                        tr.appendChild(td1);

                        var td2 = document.createElement('td');
                        td2.textContent = fila.id_victima;
                        tr.appendChild(td2);

                        var td3 = document.createElement('td');
                        td3.textContent = fila.created_at;
                        tr.appendChild(td3);

                        var td4 = document.createElement('td');
                        td4.textContent = fila.descripcion;
                        tr.appendChild(td4);

                        var td5 = document.createElement('td');
                        td5.textContent = fila.datos_agresor;
                        tr.appendChild(td5);

                        var td6 = document.createElement('td');
                        if (fila.evidencia_media == '' || fila.evidencia_media == null) {
                            td6.textContent = 'No hay evidencia';
                        } else {
                            let a = document.createElement('a');
                            a.textContent = 'Ver evidencia'
                            a.setAttribute('href', fila.evidencia_media)
                            a.setAttribute('target', '_BLANK')
                            td6.appendChild(a);
                        }
                        tr.appendChild(td6);

                        let td7 = document.createElement('td');
                        td7.innerHTML = `
                            <form action="{{ url('EliminarEvidenciaE/` + fila.id + `') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button style="background: #da292e" class="mt-1">Eliminar</button>
                            </form>`;
                        tr.appendChild(td7);
 
                        tabla.appendChild(tr);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        traerEvidencias();
    </script>

</body>
</html>
