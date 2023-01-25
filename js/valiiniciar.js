// Obtención de los elementos del archivo HTML. 
const doc = document.getElementById("doc")
const clave = document.getElementById("clave")
const form = document.getElementById("segundo")
const aviso5 = document.getElementById("warnings5")
const aviso6 = document.getElementById("warnings6")

/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings5 = ""
    let warnings6 = ""
    let entrar = false
    let passreque = /^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? "]).*$/ //Expresiones regulares

    if(doc.value.length < 7){        
        warnings5 += `Número de documento no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
    if(!passreque.test(clave.value)){
        warnings6 += `Clave debe tener mínimo 8 caracteres entre minúsculas, mayúsculas, símbolos y números <br>`
        entrar = true
        e.preventDefault() 
    }

    if(entrar){
        aviso5.innerHTML = warnings5
        aviso6.innerHTML = warnings6
    }
})