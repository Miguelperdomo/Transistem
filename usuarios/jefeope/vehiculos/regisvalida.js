const placa = document.getElementById("placa")
const chasis = document.getElementById("chasis")
const motor = document.getElementById("motor")
const interno = document.getElementById("interno")
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

    if(placa.value > 6){        
        warnings1 += `Número de Placa no válido <br>`
        entrar = true 
        e.preventDefault() 
    }
    if(placa.value < 5){        
        warnings1 += `Número de Placa no válido <br>`
        entrar = true 
        e.preventDefault() 
    }


    if(chasis.value.length > 17){        
        warnings2 += `El número de Chasis no es válido <br>`
        entrar = true 
        e.preventDefault()
    }
    if(chasis.value.length < 16){        
        warnings2 += `El n+umero de Chasis no es vólido <br>`
        entrar = true 
        e.preventDefault()
    }


    if(motor.value.length > 17){        
        warnings3 += `El numero de Motor no es valido <br>`
        entrar = true 
        e.preventDefault()
    }
    if(motor.value.length < 16){        
        warnings3 += `El numero de Motor no es valido <br>`
        entrar = true 
        e.preventDefault()
    }

    if(interno.value.length > 17){        
        warnings4 += `El numero de Interno no es valido <br>`
        entrar = true 
        e.preventDefault()
    }
    if(interno.value.length < 16){        
        warnings4 += `El numero de Interno no es valido <br>`
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