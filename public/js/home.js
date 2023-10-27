
const btn_alerts_li = document.querySelector('#btn_alerts_li');
const btn_complaints_li = document.querySelector('#btn_complaints_li');
const btn_profile_li = document.querySelector('#btn_profile_li');
const btn_usuarios_no_registrados = document.querySelector('#btn_usuarios_no_registrados_li');

const alerts = document.querySelector('#alerts');
const complaints = document.querySelector('#complaints');
const profile = document.querySelector('#profile');
const usuarios_no_registrados = document.querySelector('#seccion_usuarios_no_registrados');

btn_alerts_li.addEventListener('click', e => {
    btn_alerts_li.classList.add('active');
    btn_complaints_li.classList.remove('active');
    btn_profile_li.classList.remove('active');
    btn_usuarios_no_registrados.classList.remove('active');
    
    e.preventDefault();

    alerts.classList.remove('none');
    complaints.classList.add('none');
    profile.classList.add('none');
    usuarios_no_registrados.classList.add('none');
});

btn_complaints_li.addEventListener('click', e => {
    btn_alerts_li.classList.remove('active');
    btn_complaints_li.classList.add('active');
    btn_profile_li.classList.remove('active');
    btn_usuarios_no_registrados.classList.remove('active');

    e.preventDefault();

    alerts.classList.add('none');
    complaints.classList.remove('none');
    profile.classList.add('none');
    usuarios_no_registrados.classList.add('none');
});

btn_profile_li.addEventListener('click', e => {
    btn_alerts_li.classList.remove('active');
    btn_complaints_li.classList.remove('active');
    btn_profile_li.classList.add('active');
    btn_usuarios_no_registrados.classList.remove('active');

    e.preventDefault();

    alerts.classList.add('none');
    complaints.classList.add('none');
    profile.classList.remove('none');
    usuarios_no_registrados.classList.add('none');
});

btn_usuarios_no_registrados.addEventListener('click', e => {
    btn_alerts_li.classList.remove('active');
    btn_complaints_li.classList.remove('active');
    btn_profile_li.classList.remove('active');
    btn_usuarios_no_registrados.classList.add('active');

    e.preventDefault()
    alerts.classList.add('none');
    complaints.classList.add('none');
    profile.classList.add('none');
    usuarios_no_registrados.classList.remove('none');
});

// Denuncia

const btn_abir_denuncia = document.querySelector('#btn-add-c');
const btn_cerrar_denuncia = document.querySelector('.fa-x');

const modal_denuncia = document.querySelector('.denuncia_container');

btn_abir_denuncia.addEventListener('click', e => {
    modal_denuncia.classList.toggle('none');
});

btn_cerrar_denuncia.addEventListener('click', e => {
    modal_denuncia.classList.toggle('none');
});

// Registro de usuario no registrado

const btn_abrir_registro_usuario = document.querySelector('#btn_add_usuario_no_res');
const btn_cerrar_registro_usuario = document.querySelector('.btn_x_resg');

const registro_no_usuario_form = document.querySelector('#registro_no_usuario_form');

btn_abrir_registro_usuario.addEventListener('click', e => {
    registro_no_usuario_form.classList.toggle('none');
});

btn_cerrar_registro_usuario.addEventListener('click', e => {
    registro_no_usuario_form.classList.toggle('none');
});

const btn_add_resg_usuario = document.querySelector('#btn_add_resg_usuario');

btn_add_resg_usuario.addEventListener('click', e => {
    e.preventDefault();

    registro_no_usuario_form.classList.toggle('none');
    modal_denuncia.classList.toggle('none');
});
