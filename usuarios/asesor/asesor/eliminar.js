/**
Toma el archivo de la entrada y crea una URL temporal para mostrar la imagen en la vista previa.
 */
function preview(e){
    const url = e.target.files[0];
    const urlTmp = URL.createObjectURL(url);
    document.getElementById("img-preview").src = urlTmp;
    document.getElementById("icon-image").classList.add("d-none");
    document.getElementById("icon-cerrar").innerHTML = `<button class="btn btn-danger" onclick="deleteImg(event)"><i class="fas fa-times"></i></button 
    ${url['name']}`;
}

/**
Elimina el icono de cierre, muestra el icono de carga y elimina la vista previa de la imagen.
 */
function deleteImg(e){
    document.getElementById("icon-cerrar").innerHTML = '';
    document.getElementById("icon-image").classList.remove("d-none");
    document.getElementById("img-preview").src = '';
}