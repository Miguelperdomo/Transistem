const formulario = document.getElementById("formulario")
const enviar = document.getElementById("insert")
const contenido  = document.getElementById("contenido")

/*Una función que se ejecuta cuando se hace clic en el botón. */
enviar.addEventListener("click", (e) => {
    e.preventDefault()

    const datos = new FormData(formulario)

   /* Envío de los datos al servidor. */
    fetch("../users.php", {
        method:"POST",
        body:datos
    }).then(res => res.text()).then(info => {
        
/* Comprobar si la respuesta del servidor es 2, si lo es, alertará "mal", si no, alertará
"bien" y establecerá el innerHTML del elemento con el id "contenido" a la respuesta del servidor. */
        if (info == 2) {
            alert("mal")
        } else {
            contenido.innerHTML=info
            alert("bien")
        }
    })
})


