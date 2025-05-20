// Validaciones de formulario de registro de personal en Perriatra

function r_validarNombre() { // Validación nombre de usuario en el registro
    let nombre_r = document.getElementById('r_nombre').value;
    let errornombre_r = document.getElementById('r_errorNombre');

    if (nombre_r == null || nombre_r.length == 0) {
        errornombre_r.innerHTML = "El nombre es obligatorio.";
        errornombre_r.style.color = "red";
        return false;
    }
    if (nombre_r.length < 3) {
        errornombre_r.innerHTML = "El nombre debe tener como mínimo 3 carácteres.";
        errornombre_r.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre_r)) {
        errornombre_r.innerHTML = "El nombre no puede tener números.";
        errornombre_r.style.color = "red";
        return false;
    }
    errornombre_r.innerHTML = "";
    return true;
}

function r_validarEmail() { // Validación email en el registro
    let email_r = document.getElementById("r_email").value;
    let erroremail_r = document.getElementById("r_errorEmail");

    if (email_r == null || email_r.length == 0) {
        erroremail_r.innerHTML = "El email es obligatorio.";
        erroremail_r.style.color = "red";
        return false;
    }
    if (!/^[\w.+-]+@[\w.-]+\.[a-zA-Z]{2,10}$/.test(email_r)) {
        erroremail_r.innerHTML = "El formato no es válido.";
        erroremail_r.style.color = "red";
        return false;
    }
    erroremail_r.innerHTML = "";
    return true;
}

function r_validarPwd() { // Validación contraseña en el registro
    let pwd_r = document.getElementById("r_pwd").value;
    let errorpwd_r = document.getElementById("r_errorPwd");

    if (pwd_r == null || pwd_r.length == 0) {
        errorpwd_r.innerHTML = "La contraseña es obligatoria.";
        errorpwd_r.style.color = "red";
        return false;
    }
    if (pwd_r.length < 8) {
        errorpwd_r.innerHTML = "La contraseña debe tener al menos 8 caracteres.";
        errorpwd_r.style.color = "red";
        return false;
    }
    if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/.test(pwd_r)) {
        errorpwd_r.innerHTML = "La contraseña debe tener al menos una mayúscula y un número.";
        errorpwd_r.style.color = "red";
        return false;
    }
    errorpwd_r.innerHTML = "";
    return true;
}

function r_validarconfirmPwd() { // Validación confirmación de contraseña en el registro
    let pwd_r = document.getElementById("r_pwd").value;
    let confirmpwd_r = document.getElementById("r_confirmPwd").value;
    let errorconfirmpwd_r = document.getElementById("r_errorconfirmPwd");

    if (confirmpwd_r == null || confirmpwd_r.length == 0) {
        errorconfirmpwd_r.innerHTML = "La confirmación de la contraseña es obligatoria.";
        errorconfirmpwd_r.style.color = "red";
        return false;
    }
    if (pwd_r !== confirmpwd_r) {
        errorconfirmpwd_r.innerHTML = "Las contraseñas no coinciden.";
        errorconfirmpwd_r.style.color = "red";
        return false;
    }
    errorconfirmpwd_r.innerHTML = "";
    return true;
}


// MASCOTAS

// Validaciones Creación Mascotas

function validarNombreMascota() {
    let nombre = document.getElementById('nombre').value;
    let error = document.getElementById('errorNombreMascota');
    if (!nombre || nombre.length < 2) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 2 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarSexoMascota() {
    let sexo = document.getElementById('sexo').value;
    let error = document.getElementById('errorSexoMascota');
    if (!sexo) {
        error.innerHTML = "El sexo es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (sexo !== "M" && sexo !== "H") {
        error.innerHTML = "El sexo debe ser 'M' para Macho o 'H' para Hembra.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarFechaMascota() {
    let fecha = document.getElementById('fecha').value;
    let error = document.getElementById('errorFechaMascota');
    if (!fecha) {
        error.innerHTML = "La fecha de nacimiento es obligatoria.";
        error.style.color = "red";
        return false;
    }
    let fechaIngresada = new Date(fecha);
    if (isNaN(fechaIngresada.getTime())) {
        error.innerHTML = "La fecha ingresada no es válida.";
        error.style.color = "red";
        return false;
    }
    if (fechaIngresada.getFullYear() < 2001) {
        error.innerHTML = "La fecha no puede ser anterior a 2001.";
        error.style.color = "red";
        return false;
    }
    let hoy = new Date();
    if (fechaIngresada > hoy) {
        error.innerHTML = "La fecha no puede ser futura.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarEspecieMascota() {
    let especie = document.getElementById('especie').value;
    let error = document.getElementById('errorEspecieMascota');
    if (!especie) {
        error.innerHTML = "La especie es obligatoria.";
        error.style.color = "red";
        return false;
    }
    if (especie.length < 3) {
        error.innerHTML = "La especie debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(especie)) {
        error.innerHTML = "La especie no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarRazaMascota() {
    let raza = document.getElementById('raza').value;
    let error = document.getElementById('errorRazaMascota');
    if (!raza) {
        error.innerHTML = "La raza es obligatoria.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarPropietarioMascota() {
    let propietario = document.getElementById('propietario').value;
    let error = document.getElementById('errorPropietarioMascota');
    if (!propietario) {
        error.innerHTML = "El propietario es obligatorio.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarVeterinarioMascota() {
    let veterinario = document.getElementById('veterinario').value;
    let error = document.getElementById('errorVeterinarioMascota');
    if (!veterinario) {
        error.innerHTML = "El veterinario es obligatorio.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

// Validaciones Modificación Mascotas

function validarNombreMascotaMod() {
    let nombre = document.getElementById('nombre').value;
    let error = document.getElementById('errorNombreMascota');
    if (!nombre || nombre.length < 2) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 2 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarSexoMascotaMod() {
    let sexo = document.getElementById('sexo').value;
    let error = document.getElementById('errorSexoMascota');
    if (!sexo) {
        error.innerHTML = "El sexo es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (sexo !== "M" && sexo !== "H") {
        error.innerHTML = "El sexo debe ser 'M' para Macho o 'H' para Hembra.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarEspecieMascotaMod() {
    let especie = document.getElementById('especie').value;
    let error = document.getElementById('errorEspecieMascota');
    if (!especie) {
        error.innerHTML = "La especie es obligatoria.";
        error.style.color = "red";
        return false;
    }
    if (especie.length < 3) {
        error.innerHTML = "La especie debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(especie)) {
        error.innerHTML = "La especie no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarRazaMascotaMod() {
    let raza = document.getElementById('raza').value;
    let error = document.getElementById('errorRazaMascota');
    if (!raza) {
        error.innerHTML = "La raza es obligatoria.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

// VETERINARIOS

// Validaciones Creación Veterinarios

function validarNombreVet() {
    let nombre = document.getElementById('vet_nombre').value;
    let error = document.getElementById('errorNombreVet');
    if (!nombre || nombre.length < 3) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarTelefonoVet() {
    let tel = document.getElementById('vet_telefono').value;
    let error = document.getElementById('errorTelefonoVet');
    if (!tel) {
        error.innerHTML = "El teléfono es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^\d{9}$/.test(tel)) {
        error.innerHTML = "El teléfono debe tener exactamente 9 dígitos.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarEspecialidadVet() {
    let esp = document.getElementById('vet_especialidad').value;
    let error = document.getElementById('errorEspecialidadVet');
    if (!esp) {
        error.innerHTML = "La especialidad es obligatoria.";
        error.style.color = "red";
        return false;
    }
    if (esp.length < 4) {
        error.innerHTML = "La especialidad debe tener al menos 4 caracteres.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarFechaContratoVet() {
    let fecha = document.getElementById('vet_fecha_contrato').value;
    let error = document.getElementById('errorFechaContratoVet');
    if (!fecha) {
        error.innerHTML = "La fecha de contrato es obligatoria.";
        error.style.color = "red";
        return false;
    }
    let fechaIngresada = new Date(fecha);
    if (isNaN(fechaIngresada.getTime())) {
        error.innerHTML = "La fecha ingresada no es válida.";
        error.style.color = "red";
        return false;
    }
    let hoy = new Date();
    if (fechaIngresada > hoy) {
        error.innerHTML = "La fecha de contrato no puede ser futura.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarSalarioVet() {
    let salario = document.getElementById('vet_salario').value;
    let error = document.getElementById('errorSalarioVet');
    if (!salario) {
        error.innerHTML = "El salario es obligatorio.";
        error.style.color = "red";
        return false;
    }
    let salarioNum = Number(salario);
    if (isNaN(salarioNum)) {
        error.innerHTML = "El salario debe ser un número.";
        error.style.color = "red";
        return false;
    }
    if (salarioNum <= 0) {
        error.innerHTML = "El salario debe ser un número positivo.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

// Validaciones Modificación Veterinarios

function validarNombreVetMod() {
    let nombre = document.getElementById('mod_vet_nombre').value;
    let error = document.getElementById('errorModNombreVet');
    if (!nombre || nombre.length < 3) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarTelefonoVetMod() {
    let tel = document.getElementById('mod_vet_telefono').value;
    let error = document.getElementById('errorModTelefonoVet');
    if (!tel) {
        error.innerHTML = "El teléfono es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^\d{9}$/.test(tel)) {
        error.innerHTML = "El teléfono debe tener exactamente 9 dígitos.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarEspecialidadVetMod() {
    let esp = document.getElementById('mod_vet_especialidad').value;
    let error = document.getElementById('errorModEspecialidadVet');
    if (!esp) {
        error.innerHTML = "La especialidad es obligatoria.";
        error.style.color = "red";
        return false;
    }
    if (esp.length < 4) {
        error.innerHTML = "La especialidad debe tener al menos 4 caracteres.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarFechaContratoVetMod() {
    let fecha = document.getElementById('mod_vet_fecha_contrato').value;
    let error = document.getElementById('errorModFechaContratoVet');
    if (!fecha) {
        error.innerHTML = "La fecha de contrato es obligatoria.";
        error.style.color = "red";
        return false;
    }
    let fechaIngresada = new Date(fecha);
    if (isNaN(fechaIngresada.getTime())) {
        error.innerHTML = "La fecha ingresada no es válida.";
        error.style.color = "red";
        return false;
    }
    let hoy = new Date();
    if (fechaIngresada > hoy) {
        error.innerHTML = "La fecha de contrato no puede ser futura.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarSalarioVetMod() {
    let salario = document.getElementById('mod_vet_salario').value;
    let error = document.getElementById('errorModSalarioVet');
    if (!salario) {
        error.innerHTML = "El salario es obligatorio.";
        error.style.color = "red";
        return false;
    }
    let salarioNum = Number(salario);
    if (isNaN(salarioNum)) {
        error.innerHTML = "El salario debe ser un número.";
        error.style.color = "red";
        return false;
    }
    if (salarioNum <= 0) {
        error.innerHTML = "El salario debe ser un número positivo.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}


// HISTORIAL

// Validaciones Creación Historial

function validarFechaEntradaHis() {
    let fechaEntHis = document.getElementById('fecha_entrada_his').value;
    let errorEntHis = document.getElementById('errorfecha_ent_his');
    if (!fechaEntHis) {
        errorEntHis.innerHTML = "La fecha de entrada es obligatoria.";
        errorEntHis.style.color = "red";
        return false;
    }
    let fechaHis = new Date(fechaEntHis);
    if (isNaN(fechaHis.getTime())) {
        errorEntHis.innerHTML = "La fecha ingresada no es válida.";
        errorEntHis.style.color = "red";
        return false;
    }
    if (fechaHis.getFullYear() < 2001) {
        errorEntHis.innerHTML = "La fecha no puede ser anterior a 2001.";
        errorEntHis.style.color = "red";
        return false;
    }
    let hoy = new Date();
    if (fechaHis > hoy) {
        errorEntHis.innerHTML = "La fecha no puede ser futura.";
        errorEntHis.style.color = "red";
        return false;
    }
    errorEntHis.innerHTML = "";
    return true;
}

function validarFechaSalidaHis() {
    let fechaSalHis = document.getElementById('fecha_salida_his').value;
    let errorSalHis = document.getElementById('errorfecha_sal_his');
    if (!fechaSalHis) {
        errorSalHis.innerHTML = "La fecha de salida es obligatoria.";
        errorSalHis.style.color = "red";
        return false;
    }
    let fechaHis = new Date(fechaSalHis);
    if (isNaN(fechaHis.getTime())) {
        errorSalHis.innerHTML = "La fecha ingresada no es válida.";
        errorSalHis.style.color = "red";
        return false;
    }
    if (fechaHis.getFullYear() < 2001) {
        errorSalHis.innerHTML = "La fecha no puede ser anterior a 2001.";
        errorSalHis.style.color = "red";
        return false;
    }
    let hoy = new Date();
    if (fechaHis > hoy) {
        errorSalHis.innerHTML = "La fecha no puede ser futura.";
        errorSalHis.style.color = "red";
        return false;
    }
    errorSalHis.innerHTML = "";
    return true;
}

function validarFechaIngresadoHis() {
    let ingHis = document.getElementById('ingresado_his').value;
    let erroringHis = document.getElementById('erroringresado_his');
    if (!ingHis) {
        erroringHis.innerHTML = "La selección es obligatoria.";
        erroringHis.style.color = "red";
        return false;
    }
    erroringHis.innerHTML = "";
    return true;
}

// Validaciones Modificación Historial

function modFechaEntradaHis() {
    let fechaEntHis = document.getElementById('fecha_entrada_his').value;
    let errorEntHis = document.getElementById('errorfecha_ent_his');
    if (!fechaEntHis) {
        errorEntHis.innerHTML = "La fecha de entrada es obligatoria.";
        errorEntHis.style.color = "red";
        return false;
    }
    let fechaHis = new Date(fechaEntHis);
    if (isNaN(fechaHis.getTime())) {
        errorEntHis.innerHTML = "La fecha ingresada no es válida.";
        errorEntHis.style.color = "red";
        return false;
    }
    if (fechaHis.getFullYear() < 2001) {
        errorEntHis.innerHTML = "La fecha no puede ser anterior a 2001.";
        errorEntHis.style.color = "red";
        return false;
    }
    let hoy = new Date();
    if (fechaHis > hoy) {
        errorEntHis.innerHTML = "La fecha no puede ser futura.";
        errorEntHis.style.color = "red";
        return false;
    }
    errorEntHis.innerHTML = "";
    return true;
}

function modFechaSalidaHis() {
    let fechaSalHis = document.getElementById('fecha_salida_his').value;
    let errorSalHis = document.getElementById('errorfecha_sal_his');
    if (!fechaSalHis) {
        errorSalHis.innerHTML = "La fecha de salida es obligatoria.";
        errorSalHis.style.color = "red";
        return false;
    }
    let fechaHis = new Date(fechaSalHis);
    if (isNaN(fechaHis.getTime())) {
        errorSalHis.innerHTML = "La fecha ingresada no es válida.";
        errorSalHis.style.color = "red";
        return false;
    }
    if (fechaHis.getFullYear() < 2001) {
        errorSalHis.innerHTML = "La fecha no puede ser anterior a 2001.";
        errorSalHis.style.color = "red";
        return false;
    }
    let hoy = new Date();
    if (fechaHis > hoy) {
        errorSalHis.innerHTML = "La fecha no puede ser futura.";
        errorSalHis.style.color = "red";
        return false;
    }
    errorSalHis.innerHTML = "";
    return true;
}

// RAZA

// Validaciones Creación Raza
function validarNombreRaza() {
    let nombre = document.getElementById('raza_nombre').value;
    let error = document.getElementById('errorNombreRaza');
    if (!nombre || nombre.length < 3) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarAlturaRaza() {
    let altura = document.getElementById('raza_altura').value;
    let error = document.getElementById('errorAlturaRaza');
    if (!altura) {
        error.innerHTML = "La altura es obligatoria.";
        error.style.color = "red";
        return false;
    }
    let alturaNum = Number(altura);
    if (isNaN(alturaNum) || alturaNum <= 0) {
        error.innerHTML = "La altura debe ser un número positivo.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarPesoRaza() {
    let peso = document.getElementById('raza_peso').value;
    let error = document.getElementById('errorPesoRaza');
    if (!peso) {
        error.innerHTML = "El peso es obligatorio.";
        error.style.color = "red";
        return false;
    }
    let pesoNum = Number(peso);
    if (isNaN(pesoNum) || pesoNum <= 0) {
        error.innerHTML = "El peso debe ser un número positivo.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarCaracterRaza() {
    let caracter = document.getElementById('raza_caracter').value;
    let error = document.getElementById('errorCaracterRaza');
    if (!caracter || caracter.length < 3) {
        error.innerHTML = "El carácter es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

// Validaciones Modificación Raza
function validarNombreRazaMod() {
    let nombre = document.getElementById('mod_raza_nombre').value;
    let error = document.getElementById('errorModNombreRaza');
    if (!nombre || nombre.length < 3) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarAlturaRazaMod() {
    let altura = document.getElementById('mod_raza_altura').value;
    let error = document.getElementById('errorModAlturaRaza');
    if (!altura) {
        error.innerHTML = "La altura es obligatoria.";
        error.style.color = "red";
        return false;
    }
    let alturaNum = Number(altura);
    if (isNaN(alturaNum) || alturaNum <= 0) {
        error.innerHTML = "La altura debe ser un número positivo.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarPesoRazaMod() {
    let peso = document.getElementById('mod_raza_peso').value;
    let error = document.getElementById('errorModPesoRaza');
    if (!peso) {
        error.innerHTML = "El peso es obligatorio.";
        error.style.color = "red";
        return false;
    }
    let pesoNum = Number(peso);
    if (isNaN(pesoNum) || pesoNum <= 0) {
        error.innerHTML = "El peso debe ser un número positivo.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarCaracterRazaMod() {
    let caracter = document.getElementById('mod_raza_caracter').value;
    let error = document.getElementById('errorModCaracterRaza');
    if (!caracter || caracter.length < 3) {
        error.innerHTML = "El carácter es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

// PROPIETARIOS

// Validaciones Creación Propietario
function validarNombrePropietario() {
    let nombre = document.getElementById('propietario_nombre').value;
    let error = document.getElementById('errorNombrePropietario');
    if (!nombre || nombre.length < 3) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarDNIPropietario() {
    let dni = document.getElementById('propietario_dni').value;
    let error = document.getElementById('errorDNIPropietario');
    if (!dni) {
        error.innerHTML = "El DNI es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^[0-9]{8}[A-Za-z]$/.test(dni)) {
        error.innerHTML = "El DNI debe tener 8 números y una letra.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarDireccionPropietario() {
    let direccion = document.getElementById('propietario_direccion').value;
    let error = document.getElementById('errorDireccionPropietario');
    if (!direccion || direccion.length < 5) {
        error.innerHTML = "La dirección es obligatoria y debe tener al menos 5 caracteres.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarTelefonoPropietario() {
    let telefono = document.getElementById('propietario_telefono').value;
    let error = document.getElementById('errorTelefonoPropietario');
    if (!telefono) {
        error.innerHTML = "El teléfono es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^\d{9}$/.test(telefono)) {
        error.innerHTML = "El teléfono debe tener exactamente 9 dígitos.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarEmailPropietario() {
    let email = document.getElementById('propietario_email').value;
    let error = document.getElementById('errorEmailPropietario');
    if (!email) {
        error.innerHTML = "El email es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^[\w.+-]+@[\w.-]+\.[a-zA-Z]{2,10}$/.test(email)) {
        error.innerHTML = "El formato de email no es válido.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

// Validaciones Modificación Propietario
function validarNombrePropietarioMod() {
    let nombre = document.getElementById('mod_propietario_nombre').value;
    let error = document.getElementById('errorModNombrePropietario');
    if (!nombre || nombre.length < 3) {
        error.innerHTML = "El nombre es obligatorio y debe tener al menos 3 caracteres.";
        error.style.color = "red";
        return false;
    }
    if (/\d/.test(nombre)) {
        error.innerHTML = "El nombre no puede contener números.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarDNIPropietarioMod() {
    let dni = document.getElementById('mod_propietario_dni').value;
    let error = document.getElementById('errorModDNIPropietario');
    if (!dni) {
        error.innerHTML = "El DNI es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^[0-9]{8}[A-Za-z]$/.test(dni)) {
        error.innerHTML = "El DNI debe tener 8 números y una letra.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarDireccionPropietarioMod() {
    let direccion = document.getElementById('mod_propietario_direccion').value;
    let error = document.getElementById('errorModDireccionPropietario');
    if (!direccion || direccion.length < 5) {
        error.innerHTML = "La dirección es obligatoria y debe tener al menos 5 caracteres.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarTelefonoPropietarioMod() {
    let telefono = document.getElementById('mod_propietario_telefono').value;
    let error = document.getElementById('errorModTelefonoPropietario');
    if (!telefono) {
        error.innerHTML = "El teléfono es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^\d{9}$/.test(telefono)) {
        error.innerHTML = "El teléfono debe tener exactamente 9 dígitos.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}

function validarEmailPropietarioMod() {
    let email = document.getElementById('mod_propietario_email').value;
    let error = document.getElementById('errorModEmailPropietario');
    if (!email) {
        error.innerHTML = "El email es obligatorio.";
        error.style.color = "red";
        return false;
    }
    if (!/^[\w.+-]+@[\w.-]+\.[a-zA-Z]{2,10}$/.test(email)) {
        error.innerHTML = "El formato de email no es válido.";
        error.style.color = "red";
        return false;
    }
    error.innerHTML = "";
    return true;
}