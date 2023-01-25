
// Obtención de los elementos del archivo HTML. 
const pasajeros = document.getElementById("pasa")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")

/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let entrar = false
  
    /* Comprueba si el valor de la entrada es superior a 100. Si lo es, añadirá una advertencia a la variable
    warnings1 e impedirá que se envíe el formulario.  */
    if(pasajeros.value.length > 100){        
        warnings1 += `Número de documento no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
    /* Comprobando si la variable entrar es verdadera, si lo es, mostrará las advertencias. */
    if(entrar){
        aviso1.innerHTML = warnings1
    }
})