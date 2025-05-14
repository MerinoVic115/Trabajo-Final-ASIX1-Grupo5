function NomLog(){
    let nombre = document.getElementById("user").value
    let error = document.getElementById("errorNombre")

    if(nombre.length === 0 || nombre == null){
        error.textContent = "Introduce un usuario";
        error.style.color = "red";
        return;
    }
}

function ConLog(){
    let contra = document.getElementById("password").value
    let error = document.getElementById("errorContra")

    if(contra.length === 0 || contra == null){
        error.textContent = "Introduce una contraseña";
        error.style.color = "red";
        return;
    }
}