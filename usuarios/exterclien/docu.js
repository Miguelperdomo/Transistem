/* Obtener los elementos del archivo HTML. */
const doc = document.getElementById("doc")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")


/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let entrar = false
    

   /* Comprobando si la longitud del valor de la entrada es menor que 7. Si lo es, agrega una advertencia a
   la variable advertencias1, establece entrar en verdadero e impide la acción predeterminada del evento. */
    if(doc.value.length < 7){        
        warnings1 += `Número de documento no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
/* Comprobando si la longitud del valor de la entrada es menor que 7. Si lo es, agrega una advertencia a
    la variable advertencias2, establece entrar en verdadero e impide la acción por defecto del evento. */
    
    if(entrar){
        aviso1.innerHTML = warnings1
    }
})