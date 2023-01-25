/* Obtener los elementos del archivo HTML. */
const pasajeros = document.getElementById("pas")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")


/* Escuchando un evento de envío en el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let entrar = false

 /* Comprobando si el valor de la entrada es mayor que 100. Si lo es, agregará un mensaje de advertencia
   a la variable advertencias1. También establecerá la variable entrar en verdadero y evitará el valor predeterminado.
   acción de la forma. Si entrar es verdadero, agregará el mensaje de advertencia al elemento HTML
   aviso1. */
    if(pasajeros.value > 100){        
        warnings1 += `Número de Pasajeros no válido <br>`
        entrar = true 
        e.preventDefault() 
    }

    if(pasajeros.value < 9){        
        warnings1 += `Número de Pasajeros no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
    
    if(entrar){
        aviso1.innerHTML = warnings1
    }
})