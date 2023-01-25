/* Obtener los elementos del HTML. */
const pasajeros = document.getElementById("pas")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")


/* Una función que se ejecuta cuando se envía el formulario.  */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let entrar = false

  /* Comprueba si el valor de la entrada es superior a 100. Si lo es, añadirá una advertencia a la variable
  warnings1 y pondrá entrar a true. También evitará que el formulario sea enviado. */
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