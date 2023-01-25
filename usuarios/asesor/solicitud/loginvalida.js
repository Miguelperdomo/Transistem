/* Obtener los elementos del archivo HTML. */
const tel = document.getElementById("tel")
const clave = document.getElementById("clave")
const correo = document.getElementById("email")
const form = document.getElementById("form")
const aviso2 = document.getElementById("warnings2")
const aviso3 = document.getElementById("warnings3")
const aviso4 = document.getElementById("warnings4")

/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings2 = "" 
    let warnings3 = ""
    let warnings4 = ""
    let entrar = false  
    let passreque = /^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? "]).*$/ //Expresiones regulares
    let correoval = /^[-\w.%+]{1,20}@(?:[A-Z0-9-]{1,20}\.){1,125}[A-Z]{2,30}$/i; //Expresiones regulares

       /* Comprueba si el valor de la entrada es inferior a 7 caracteres. Si lo es, añadirá una advertencia a
   la variable warnings1, pondrá entrar a true e impedirá la acción por defecto del formulario */
    if(tel.value.length < 7){        
        warnings2 += `Número de teléfono no válido <br>`
        entrar = true 
        e.preventDefault()
    }
    // Comprobar si la contraseña es válida.
    if(!passreque.test(clave.value)){
        warnings3 += `Clave debe tener mínimo 8 caracteres entre minúsculas, mayúsculas, símbolos y números <br>`
        entrar = true
        e.preventDefault() 
    }
    if(!correoval.test(correo.value)){
        warnings4 += `El Correo debe ser valido <br>`
        entrar = true
        e.preventDefault() 
    }



 /* Comprobando si la variable entrar es verdadera, si lo es, añadirá las advertencias al HTML. */
    if(entrar){
        aviso2.innerHTML = warnings2
        aviso3.innerHTML = warnings3
        aviso4.innerHTML = warnings4
    }
})