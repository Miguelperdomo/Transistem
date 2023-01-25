/* Obtener los elementos del archivo HTML. */
const doc = document.getElementById("doc")
const tel = document.getElementById("tel")
const correo = document.getElementById("email")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")
const aviso2 = document.getElementById("warnings2")
const aviso3 = document.getElementById("warnings3")

/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let warnings2 = ""
    let warnings3 = ""
    let entrar = false
    let correoval = /^[-\w.%+]{1,20}@(?:[A-Z0-9-]{1,20}\.){1,125}[A-Z]{2,30}$/i; //Expresiones regulares

   /* Comprobando si la longitud del valor de la entrada es menor que 7. Si lo es, agrega una advertencia a
   la variable advertencias1, establece entrar en verdadero e impide la acción predeterminada del evento. */
    if(doc.value.length < 7){        
        warnings1 += `Número de documento no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
/* Comprobando si la longitud del valor de la entrada es menor que 7. Si lo es, agrega una advertencia a
    la variable advertencias2, establece entrar en verdadero e impide la acción por defecto del evento. */
    if(tel.value.length < 7){        
        warnings2 += `Número de teléfono no válido <br>`
        entrar = true 
        e.preventDefault()
    }
    if(!correoval.test(correo.value)){
        warnings3 += `El Correo debe ser valido <br>`
        entrar = true
        e.preventDefault() 
    }

    
    if(entrar){
        aviso1.innerHTML = warnings1
        aviso2.innerHTML = warnings2
        aviso3.innerHTML = warnings3
    }
})