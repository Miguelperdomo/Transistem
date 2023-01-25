const doc = document.getElementById("doc")
const tel = document.getElementById("tel")
const clave = document.getElementById("clave")
const correo = document.getElementById("email")
const form = document.getElementById("form")
const aviso1 = document.getElementById("warnings1")
const aviso2 = document.getElementById("warnings2")
const aviso3 = document.getElementById("warnings3")
const aviso4 = document.getElementById("warnings4")

form.addEventListener("submit", e=>{
    
    let warnings1 = ""
    let warnings2 = ""
    let warnings3 = ""
    let warnings4 = ""
    let entrar = false
    let passreque = /^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d)(?=.*[!#$%&? "]).*$/ //Expresiones regulares
    let correoval = /^[-\w.%+]{1,20}@(?:[A-Z0-9-]{1,20}\.){1,125}[A-Z]{2,30}$/i; //Expresiones regulares
    
    if(doc.value.length < 7){        
        warnings1 += `Número de documento no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
    if(tel.value.length < 7){        
        warnings2 += `Número de teléfono no válido <br>`
        entrar = true 
        e.preventDefault()
    }
    if(!passreque.test(clave.value)){
        warnings3 += `Clave debe tener mínimo 8 caracteres entre minúsculas, mayúsculas, símbolos y números <br>`
        entrar = true
        e.preventDefault() 
    }

    if(!correoval.test(correo.value)){
        warnings4 += `El Correo debe ser válido <br>`
        entrar = true
        e.preventDefault() 
    }

    if(entrar){
        aviso1.innerHTML = warnings1
        aviso2.innerHTML = warnings2
        aviso3.innerHTML = warnings3
        aviso4.innerHTML = warnings4
    }
})