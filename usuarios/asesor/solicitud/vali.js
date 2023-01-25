/* Obtener los elementos del archivo HTML. */
const doc = document.getElementById("doc")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")

/* Una función que se ejecuta cuando se envía el formulario. */
form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let entrar = false
   
    /* Comprueba si el valor de la entrada es inferior a 7 caracteres. Si lo es, añadirá una advertencia a
   la variable warnings1, pondrá entrar a true e impedirá la acción por defecto del formulario */
    if(doc.value.length < 7){        
        warnings1 += `Número de documento no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
    /* Comprobando si la variable entrar es verdadera, si lo es, añadirá las advertencias al HTML. */
    if(entrar){
        aviso1.innerHTML = warnings1
    }
})