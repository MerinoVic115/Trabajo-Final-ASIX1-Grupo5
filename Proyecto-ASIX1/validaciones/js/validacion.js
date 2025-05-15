// Validaciones de formulario de registro de personal en Perriatra

function r_validarNombre() { // Validación nombre de usuario en el registro
    let nombre_r = document.getElementById('r_nombre').value;
    let errornombre_r = document.getElementById('r_errorNombre');

    if (nombre_r == null || nombre_r.length == 0) {
        errornombre_r.innerHTML = "El nombre es obligatorio.";
        errornombre_r.style.color = "red";
        return false;
    } else if (nombre_r.length < 3) {
        errornombre_r.innerHTML = "El nombre debe tener como mínimo 3 carácteres.";
        errornombre_r.style.color = "red";
        return false;
    } else if (/\d/.test(nombre_r)) {
        errornombre_r.innerHTML = "El nombre no puede tener números.";
        errornombre_r.style.color = "red";
        return false;
    } else {
        errornombre_r.innerHTML = "";
        return true;
    }
}

function r_validarEmail() { // Validación email en el registro
    let email_r = document.getElementById("r_email").value;
    let erroremail_r = document.getElementById("r_errorEmail");

    if (email_r == null || email_r.length == 0) {
        erroremail_r.innerHTML = "El email es obligatorio.";
        erroremail_r.style.color = "red";
        return false;
    } else if (!/^[\w.+-]+@[\w.-]+\.[a-zA-Z]{2,10}$/.test(email_r)) {
        erroremail_r.innerHTML = "El formato no es válido.";
        erroremail_r.style.color = "red";
        return false;
    } else {
        erroremail_r.innerHTML = "";
        return true;
    }
}

function r_validarPwd() { // Validación contraseña en el registro
    let pwd_r = document.getElementById("r_pwd").value;
    let errorpwd_r = document.getElementById("r_errorPwd");

    if (pwd_r == null || pwd_r.length == 0) {
        errorpwd_r.innerHTML = "La contraseña es obligatoria.";
        errorpwd_r.style.color = "red";
        return false;
    } else if (pwd_r.length < 8) {
        errorpwd_r.innerHTML = "La contraseña debe tener al menos 8 caracteres.";
        errorpwd_r.style.color = "red";
        return false;
    } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/.test(pwd_r)) {
        errorpwd_r.innerHTML = "La contraseña debe tener al menos una mayúscula y un número.";
        errorpwd_r.style.color = "red";
        return false;
    } else {
        errorpwd_r.innerHTML = "";
        return true;
    }
}

function r_validarconfirmPwd() { // Validación confirmación de contraseña en el registro
    let pwd_r = document.getElementById("r_pwd").value;
    let confirmpwd_r = document.getElementById("r_confirmPwd").value;
    let errorconfirmpwd_r = document.getElementById("r_errorconfirmPwd");

    if (confirmpwd_r == null || confirmpwd_r.length == 0) {
        errorconfirmpwd_r.innerHTML = "La confirmación de la contraseña es obligatoria.";
        errorconfirmpwd_r.style.color = "red";
        return false;
    } else if (pwd_r !== confirmpwd_r) {
        errorconfirmpwd_r.innerHTML = "Las contraseñas no coinciden.";
        errorconfirmpwd_r.style.color = "red";
        return false;
    } else {
        errorconfirmpwd_r.innerHTML = "";
        return true;
    }
}





// Validaciones restantes necesarias