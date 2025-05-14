
function Validcorreo(){
    let CORREO = document.getElementById("correo").value
    let error = document.getElementById("errorcorreo")

    if(CORREO.length === 0 || CORREO == null){
        error.textContent = "Introduce un correo";
        error.style.color = "red";
        return;
    }

    if(!(/^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/.test(CORREO))){
        error.textContent = "introduce un correo valido";
        error.style.color = "red";
        return;
      }
    error.textContent = "El correo esta OK";
    error.style.color = "green";

}

function ValidNum(){
    let numtelf = document.getElementById("telefono").value
    let error = document.getElementById("errortelf")

    if(numtelf.length === 0 || numtelf == null){
        error.textContent = "Introduce un numero de telefono";
        error.style.color = "red";
        return;
    }

    error.textContent = "El telefono esta OK";
    error.style.color = "green";
}