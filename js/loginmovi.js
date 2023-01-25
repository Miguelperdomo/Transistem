/* Asignación de las variables a los elementos del HTML.. */
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

/* Añadir la clase "right-panel-active" al contenedor */
signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

/* Eliminación de la clase "right-panel-active" del contenedor */
signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});