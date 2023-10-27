<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">

    <link rel="shortcut icon" href="./img/Logo.png" />

    <title>Prevenir | Web</title>
</head>
<body>

    <!-- Barrade navegacion -->
    <nav class="container-nav">
        <div class="title-nav p-4 d-flex gap-3 align-items-center justify-content-center">
            <img src="./img/Logo.png" alt="" style="height: 55px; width: 55px;">
        </div>
        <ul class="nav-ul m-0 p-0">
            <li title="Alertas" class="d-flex align-items-center justify-content-center" id="btn_alerts_li"
                style="cursor: pointer;">
                <i class="fa-solid fa-bell fs-4"
                    style="width: 35px; display: flex; justify-content: center; align-items: center"></i>
            </li>
            <li title="Denuncias" class="d-flex align-items-center justify-content-center active" id="btn_complaints_li"
                style="cursor: pointer;">
                <i class="fa-solid fa-clipboard-list fs-4"
                    style="width: 35px; display: flex; justify-content: center; align-items: center"></i>
            </li>
            <li title="Usuarios nos registrados en la app" class="d-flex align-items-center justify-content-center"
                id="btn_usuarios_no_registrados_li" style="cursor: pointer;">
                <i class="fa-solid fa-users fs-4"
                    style="width: 35px; display: flex; justify-content: center; align-items: center"></i>
            </li>
            <li title="Perfil" class="d-flex align-items-center justify-content-center" id="btn_profile_li"
                style="cursor: pointer;">
                <i class="fa-solid fa-address-card fs-4"
                    style="width: 35px; display: flex; justify-content: center; align-items: center"></i>
            </li>
        </ul>
    </nav>

    <!-- Modal de agregar denuncias -->
    <div class="denuncia_container none">
        <form method="POST" class="denuncia_form border  rounded-3 bg-white p-5"
            action="{{ url('RegistroDenunciaPOST') }}" enctype="multipart/form-data">
            @csrf
            <div class="btn_x"><i class="fa-solid fa-x"></i></div>

            <div class="d-flex align-items-center">
                <img src="./img/Logo.png" alt="" id="img_res">
                <h3 class="text-center mb-4">REGISTRAR DENUNCIA</h3>
            </div>
            <p>Para inicar la denuncia debe debe indicar los hechos como lo narra el denunciante.</p>
            <div class="d-flex gap-3">
                <div class="mb-3 w-50">
                    <label for="dni1" class="form-label">DNI de la victima</label>
                    <select class="form-select" name="id_victima" id="dni1" required>
                        <option selected></option>
                        @foreach ($dni_1 as $row)
                            <option value="{{ $row->id }}">{{ $row->dni }}</option>
                        @endforeach
                        @foreach ($dni_2 as $row)
                            <option value="{{ $row->id }}">{{ $row->dni }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 w-50">
                    <label for="place" class="form-label">Lugar | Av. - Jr. - Calle.</label>
                    <input type="text" class="form-control" id="place" placeholder="Av." name="lugar" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción de los hechos</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Descripción del echo" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Evidencia (Foto, video,
                    audio)</label>
                <input class="form-control" id="file" type="file" name="file" required>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2">
                <a id="btn_add_resg_usuario" href="">¿La victima no esta registrada?</a>
                <button class="btn btn-success" type="submit">Registrar denuncia</button>
            </div>
        </form>
    </div>

    <!-- Modal de agregar usuario no registrado -->
    <div class="denuncia_container none" id="registro_no_usuario_form">
        <form method="POST" class="denuncia_form border  rounded-3 bg-white p-5"
            action="{{ url('RegistroUsuarioNoRegistrado') }}">
            @csrf
            <div class="btn_x_resg"><i class="fa-solid fa-x"></i></div>

            <div class="d-flex align-items-center">
                <img src="./img/Logo.png" alt="" id="img_res">
                <h3 class="text-center mb-4">REGISTRAR VICTIMA</h3>
            </div>
            <p>Por favor, ingrese los datos de la victima.</p>

            <div class="mb-3">
                
                <label for="dni" class="form-label">DNI</label>
                <input class="form-control" type="text" id="dni" placeholder="DNI" maxlength="8" name="dni" required>
            </div>
            <div class="d-flex gap-3">
                <div class="mb-3 w-100">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input class="form-control" type="text" id="nombre" placeholder="Nombre" name="nombre" required>
                </div>
                <div class="mb-3 w-100">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="apellido" placeholder="Apellido" name="apellido" required>
                </div>
            </div>
            <div class="mb-3 w-100">
                <label for="celular" class="form-label">Celular</label>
                <input type="text" class="form-control" id="celular" placeholder="Celular" maxlength="9" name="celular" required>
            </div>
            <div class="mb-3 w-100">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" placeholder="Av." name="lugar" required>
            </div>
            <div class="mb-3 w-100">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" placeholder="Correo" name="correo" required>
            </div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <button class="btn btn-success" type="submit">Registrar victima</button>
            </div>
        </form>
    </div>

    <main>
        <!-- Alertas -->
        <section class="none" id="alerts">
            <ul class="m-0 py-4 px-4 d-flex justify-content-between border-bottom">
                <h4 class="m-0 p-0 pt-1" style="font-family: Aldrich; font-weight: bold;">ALERTAS</h4>
                <div class="d-flex align-items-center gap-2">
                    <p class="m-0" style="font-weight: 500; font-family: Abel;">{{ $usuario_comisaria->correo }}
                    </p>
                    <i class="fa-solid fa-chevron-down p-2" style="cursor: pointer;">
                        <div class="alert alert-light" id="modal-alert-closed">
                            <form action="{{ url('CerrarSesion') }}" method="POST">
                                @csrf
                                <button class="badge bg-danger border px-3 py-2">Cerrar sesión</button>
                            </form>
                        </div>
                    </i>
                </div>
            </ul>

            <div class="px-4 pt-4">
                <div class="d-flex flex-wrap gap-4">
                    <div class="alert alert-dismissible alert-danger p-3 m-0" style="width: 280px">
                        <div class="d-flex justify-content-between mb-2 w-100">
                            <p class="badge bg-danger">N° 1</p>
                            <p class="badge bg-danger">12-08-2023 14:14:00</p>
                        </div>
                        <div class="alert alert-dismissible alert-light p-3 m-0" style="font-family: monospace">
                            <p class="p-0 m-0 border-bottom p-1">DNI: 21748655</p>
                            <p class="p-0 m-0 border-bottom p-1">Nombre: Jose</p>
                            <p class="p-0 m-0 p-1 mb-2">Apellido: Patiño</p>

                            <div class="d-flex justify-content-center">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d3902.043304226526!2d-77.0930583!3d-12.0405398!3m2!1i1024!2i768!4f13.1!3m2!1m1!2s!5e0!3m2!1ses-419!2spe!4v1697673652232!5m2!1ses-419!2spe"
                                    width="200" height="200" style="border:0;" allowfullscreen=""
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Denuncias -->
        <section id="complaints">
            <ul class="m-0 py-4 px-4 d-flex justify-content-between border-bottom">
                <h4 class="m-0 p-0 pt-1" style="font-family: Aldrich; font-weight: bold;">DENUNCIAS</h4>
                <div class="d-flex align-items-center gap-2">
                    <p class="m-0" style="font-weight: 500; font-family: Abel;">{{ $usuario_comisaria->correo }}
                    </p>
                    <i class="fa-solid fa-chevron-down p-2" style="cursor: pointer;">
                        <div class="alert alert-light" id="modal-alert-closed">
                            <form action="{{ url('CerrarSesion') }}" method="POST">
                                @csrf
                                <button class="badge bg-danger border px-3 py-2">Cerrar sesión</button>
                            </form>
                        </div>
                    </i>
                </div>
            </ul>

            <div class="px-4 d-flex justify-content-end pt-3">
                <button class="btn btn-success" id="btn-add-c">Agregar denuncia</button>
            </div>

            <!-- Tabla de denuncias -->
            <div class="px-4 pt-3">
                <table class="table table-striped">
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Descripción</th>
                        <th>Pueba</th>
                        <th>Acciones</th>
                    </tr>
                    @foreach ($denuncias as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->dni }}</td>
                            <td>{{ $row->descripcion }}</td>
                            @if ($row->prueba_media == null)
                                <td><button class="py-2 px-3 badge bg-info border"><span class="text-white"
                                            href="">No hay Pruebas</span></button></td>
                                <td>
                                @else
                                <td><button class="py-2 px-3 badge bg-info border"><a class="text-white"
                                            target="_blank"
                                            href="{{ url('http://127.0.0.1:8000' . $row->prueba_media) }}">Ver
                                            Prueba</a></button></td>
                                <td>
                            @endif
                            <form action="{{ url('VerMasDenuncia') . '/' . $row->id}}">
                                <button class="py-2 px-3 badge bg-success border">Ver más</button>
                            </form>
                            <form action="{{ url('EliminarDenuncia/' . $row->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="py-2 px-3 badge bg-danger border">Eliminar</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>

        <!-- Usuarios no registrados en la App -->
        <section class="none" id="seccion_usuarios_no_registrados">
            <ul class="m-0 py-4 px-4 d-flex justify-content-between border-bottom">
                <h4 class="m-0 p-0 pt-1" style="font-family: Aldrich; font-weight: bold;">USUARIOS NO REGISTRADOS EN LA APP</h4>
                <div class="d-flex align-items-center gap-2">
                    <p class="m-0" style="font-weight: 500; font-family: Abel;">{{ $usuario_comisaria->correo }}
                    </p>
                    <i class="fa-solid fa-chevron-down p-2" style="cursor: pointer;">
                        <div class="alert alert-light" id="modal-alert-closed">
                            <form action="{{ url('CerrarSesion') }}" method="POST">
                                @csrf
                                <button class="badge bg-danger border px-3 py-2">Cerrar sesión</button>
                            </form>
                        </div>
                    </i>
                </div>
            </ul>

            <div class="px-4 d-flex justify-content-end pt-3">
                <button class="btn btn-success" id="btn_add_usuario_no_res">Agregar usuario</button>
            </div>

            <!-- Tabla de denuncias -->
            <div class="px-4 pt-3">
                <table class="table table-striped">
                    <tr>
                        <th>N°</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Celular</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                    @foreach ($usuarios_no_registrados as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->dni }}</td>
                            <td>{{ $row->nombre }}</td>
                            <td>{{ $row->apellido }}</td>
                            <td>{{ $row->celular }}</td>
                            <td>{{ $row->direccion }}</td>
                            <td>{{ $row->correo }}</td>
                            <td>
                            <form action="{{ url('VerUsuarioNoRegistrado') . '/' . $row->id }}">
                                <button class="py-2 px-3 badge bg-success border">Ver más</button>
                            </form>
                            <form action="{{ url('VerUsuarioNoRegistrado') . '/' . $row->id }}">
                                <button class="py-2 px-3 badge bg-warning border">Editar</button>
                            </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </section>

        <!-- Perfil -->
        <section class="none" id="profile">
            <ul class="m-0 py-4 px-4 d-flex justify-content-between border-bottom">
                <h4 class="m-0 p-0 pt-1" style="font-family: Aldrich; font-weight: bold;">PERFIL</h4>
                <div class="d-flex align-items-center gap-2">
                    <p class="m-0" style="font-weight: 500; font-family: Abel;">{{ $usuario_comisaria->correo }}
                    </p>
                    <i class="fa-solid fa-chevron-down p-2" style="cursor: pointer;">
                        <div class="alert alert-light" id="modal-alert-closed">
                            <form action="{{ url('CerrarSesion') }}" method="POST">
                                @csrf
                                <button class="badge bg-danger border px-3 py-2">Cerrar sesión</button>
                            </form>
                        </div>
                    </i>
                </div>
            </ul>

            <div class="px-4 pt-3">
                <div class="d-flex" id="cont-profile">
                    <div class="w-100 pe-3 border-end" id="form-profile">
                        <div class="d-flex gap-3 align-items-center mb-4">
                            <div class="d-flex justify-content-center align-items-center"
                                style="width: 60px; height: 60px; background-color: #EBEDFF; border-radius: 50%;">
                                <span style="color: #838383">U</span>
                            </div>
                            <div>
                                <p class="p-0 m-0" style="font-weight: bold">{{ $usuario_comisaria->nombre }}</p>
                                <p class="p-0 m-0" style="font-size: 14px;">{{ $usuario_comisaria->correo }}</p>
                            </div>
                        </div>

                        <form class="w-100"
                            action="{{ url('EditarComisaria') . '/' . $usuario_comisaria->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="nombre">Nombre de la comisaria</label>
                                <input name="nombre" class="form-control" id="nombre" type="text"
                                    value="{{ $usuario_comisaria->nombre }}"">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="direccion">Dirección de la comisaria</label>
                                <input name="direccion" class="form-control" id="direccion" type="text"
                                    value="{{ $usuario_comisaria->direccion }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="correo">Correo</label>
                                <input name="correo" class="form-control" id="correo" type="email"
                                    value="{{ $usuario_comisaria->correo }}">
                            </div>

                            <button class="btn btn-success">Guardar</button>
                        </form>
                    </div>

                    <div class="w-100 px-4" id="delete-form-profile">
                        <div>
                            <h6 style="font-weight: bold">Eliminar cuenta comisaria</h6>
                            <p style="font-size: 14px;">Esta acción es permanente e irreversible. Perderás acceso a la
                                cuenta y toda la información que contiene.</p>
                        </div>
                        <form action="{{ url('EliminarComisaria') . '/' . $usuario_comisaria->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-warning">Eliminar cuenta</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="./js/home.js"></script>

</body>
</html>
