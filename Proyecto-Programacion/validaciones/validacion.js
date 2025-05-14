function validacionNombre(){
    let nombre = document.getElementById("user").value
    let error = document.getElementById("errorNombre")

    if(nombre.length === 0 || nombre == null){
        error.textContent = "introduce un nombre";
        error.style.color = "red";
        return;
    }

    if (nombre.length < 3){
        error.textContent = "introduce un nombre con mas de 3cc";
        error.style.color = "red";
        return;
    }
     

    error.textContent = "El usuario esta OK";
    error.style.color = "green";

}

function validacionEmail(){
    let email = document.getElementById("email").value
    let error = document.getElementById("errorEmail")

    if(email.length === 0 || email == null){
        error.textContent = "introduce un correo";
        error.style.color = "red";
        return;
    }

    if(!(/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/.test(email))){
        error.textContent = "introduce un correo valido";
        error.style.color = "red";
        return;
      }
      

    error.textContent = "El correo esta OK";
    error.style.color = "green";

}

function validacionContra1(){

    let contra1 = document.getElementById("passwd").value
    let error = document.getElementById("errorContra1")
    let formatocontra = /^(?=.*[A-Z])(?=.*\d).{8,}$/;


    if(contra1.length === 0 || contra1 == null){
        error.textContent = "introduce una contraseña";
        error.style.color = "red";
        return;
    }

    if(!formatocontra.test(contra1)){
        error.textContent = "No tiene formato valido, minimo tiene que tener: 8cc 1num y 1 una mayuscula ";
        error.style.color = "red";
        return;
    }

    error.textContent = "La contraseña esta OK";
    error.style.color = "green";


}

function validacionContra2(){
    let contra2 = document.getElementById("passwd2").value
    let error = document.getElementById("errorContra2")
    let passwd = document.getElementById("passwd1").value;

    if(contra2.length === 0 || contra2 == null){
        error.textContent = "introduce introduce lo mismo del campo anterior";
        error.style.color = "red";
        return;
    }

    if(contra2 != passwd){
        error.textContent = "La comparacion es incorrecta";
        error.style.color = "red";
        return;
    }
    
    error.textContent = "La comparacion es correcta";
    error.style.color = "green";
}
