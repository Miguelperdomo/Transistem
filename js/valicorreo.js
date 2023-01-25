/* Obtener los elementos del archivo HTML. */
const correo = document.getElementById("email")
const ced = document.getElementById("docu")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")
const aviso2 = document.getElementById("warnings2")


/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let warnings2 = ""
    let entrar = false
    let correoval = /^[-\w.%+]{1,20}@(?:[A-Z0-9-]{1,20}\.){1,125}[A-Z]{2,30}$/i; //Expresiones regulares
   
    /* Comprueba si el valor de la entrada es inferior a 7 caracteres. Si lo es, añadirá una advertencia a
   la variable warnings1, pondrá entrar a true e impedirá la acción por defecto del formulario */
   
    if(!correoval.test(correo.value)){
        warnings1 += `El Correo debe ser válido<br>`
        entrar = true
        e.preventDefault() 
    }
    if(ced.value.length < 7){        
        warnings2 += `Número de documento no válido <br>`
        entrar = true 
        e.preventDefault() 
    }

    /* Comprobando si la variable entrar es verdadera, si lo es, añadirá las advertencias al HTML. */
    if(entrar){
        aviso1.innerHTML = warnings1
        aviso2.innerHTML = warnings2
    }
})