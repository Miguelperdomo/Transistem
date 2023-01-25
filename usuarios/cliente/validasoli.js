/* Obtener los elementos del archivo HTML. */
const pasajeros = document.getElementById("pas")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")


/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let entrar = false

 /* Comprobación de si el valor de la entrada es mayor que 100. Si lo es, añadirá una advertencia a la variable
  warnings1 y pondrá entrar a true. También evitará que el formulario sea enviado. */
    if(pasajeros.value > 100){        
        warnings1 += `Número de Pasajeros no válido. Menor a 100. <br>`
        entrar = true 
        e.preventDefault() 
    }   
    if(pasajeros.value < 9){        
      warnings1 += `Número de Pasajeros no válido <br>`
      entrar = true 
      e.preventDefault() 
  }
      /* Comprobación de si la variable entrar es verdadera. Si lo es, añadirá los avisos al elemento HTML
    aviso1. */
    if(entrar){
        aviso1.innerHTML = warnings1
    }
})