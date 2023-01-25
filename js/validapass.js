// Obtención de los elementos del archivo HTML. 
const clave = document.getElementById("nueva")
const clave2 = document.getElementById("nuevarepe")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")
const aviso2 = document.getElementById("warnings2")

// Una función que se ejecuta cuando se envía el formulario
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let warnings2 = ""
    let entrar = false
    let passreque = /^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? "]).*$/ //Expresiones regulares para validar Password

/* Comprobar si la contraseña es válida. */
    if(!passreque.test(clave.value)){
        warnings1 += `Clave debe tener mínimo 8 caracteres entre minúsculas, mayúsculas, símbolos y números <br>`
        entrar = true
        e.preventDefault() 
    }

   /* Comprobar si la contraseña es válida. */
    if(!passreque.test(clave2.value)){
        warnings2 += `Clave debe tener mínimo 8 caracteres entre minúsculas, mayúsculas, símbolos y números <br>`
        entrar = true
        e.preventDefault() 
    }


    /* Comprobando si la variable entrar es verdadera, si lo es, mostrará las advertencias. */
    if(entrar){
        aviso1.innerHTML = warnings1
        aviso2.innerHTML = warnings2
    }
})