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

            <li class="li-active">
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

            <li class="">
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
            <h2 class="m-0 p-0">Denuncias</h2>
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
                <form action="{{ url('BuscarUsuarioD') }}" method="POST">
                    @csrf
                    <input maxlength="8" name="dni" type="search" placeholder="Buscar">
                </form>

                <div class="d-flex gap-3">
                    <select id="miSelect" onchange="verificarSeleccion()" class="form-select"
                        aria-label="Default select example" style="width: 250px">
                        <option value="2">Todas las denuncias</option>
                    </select>
                </div>
            </div>

            <div class="s-denuncia-bottom">
                <table class="default" style="width: 100%;" id="denuncias">
                    <thead>
                        <tr style="width: 100%; text-align: center !important">
                            <th style="cursor: pointer" onclick="ordenarColumna(0)">N° <i id="btn_y" class="ms-1 mt-1 fa-solid fa-arrow-up" style="display: inline-block"></i></th>
                            <th>Lugar de denuncia (Comisaria)</th>
                            <th>DNI</th>
                            <th>Descripción</th>
                            <th>Prueba</th>
                            <th>Acciónes</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($denuncias as $row)
                        <tr style="width: 100%;">
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->id_comisaria }}</td>
                            <td>{{ $row->dni }}</td>
                            <td style="text-align: start !important;" class="px-4">{{ $row->descripcion }}</td>
                            @if ($row->prueba_media != null)
                                <td><a href="{{ $row->prueba_media }}" target="_blank">Ver prueba</a></td>
                            @else
                                <td>No hay pruebas</td>
                            @endif
                            <td>
                                <form action="{{ url('verMasDenuncia') . '/' . $row->id }}" method="GET">
                                    <button style="background: #f4bd61;">Ver más</button>
                                </form>
                                <form action="{{ url('EliminarDenunciaA/' . $row->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button style="background: #da292e" class="mt-1">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <section class="form-registro-no-usuarios none">
        <form action="{{ url('RegistroDenunciaPOST') }}" method="POST" enctype="multipart/form-data">
            <h2>REGISTRO DE DENUNCIA</h2>
            <p style="color: #5c5c5c; padding-bottom: 20px">Para inicar la denuncia debe debe indicar los hechos como lo
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

    @if($errors->any())
    @foreach($errors->all() as $error)
        @if($error == "success")
        <div class="alert alert-success mt-3">
            <a href="{{ url('/DenunciasA') }}">Alerta desactivada</a>
        </div>
        @else 
        <div class="alert alert-danger mt-3">
            <a href="{{ url('/DenunciasA') }}">{{ $error }}</a>
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
        const btn_cambio_clave = document.querySelector('#agregar_usuarios');
        const btn_xmark = document.querySelector('.xmark-usuarios');

        btn_cambio_clave.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector('.form-registro-no-usuarios').classList.toggle('none');
        });

        btn_xmark.addEventListener('click', e => {
            e.preventDefault();
            document.querySelector('.form-registro-no-usuarios').classList.toggle('none');
        });
    </script>

</body>

</html>
