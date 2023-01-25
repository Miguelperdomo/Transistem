/* Selección de los elementos del HTML.. */
const userNameField = document.querySelector("[name=username]");
const passwordField = document.querySelector("[name=password]");
const emailField = document.querySelector("[name=email]");
const fileField = document.querySelector("[name=avatar]");

/**
Si isError es verdadero, añade la clase "invalid" al campo, añade la clase "error" al siguiente
 * del campo, y asigna el mensaje al innerText del siguiente hermano del campo. En caso contrario, elimina la clase
 * clase "invalid" del campo, quita la clase "error" del siguiente hermano del campo y establece el
 * innerText del siguiente hermano del campo a una cadena vacía.
 */
const setErrors = (message, field, isError = true) => {
  if (isError) {
    field.classList.add("invalid");
    field.nextElementSibling.classList.add("error");
    field.nextElementSibling.innerText = message;
  } else {
    field.classList.remove("invalid");
    field.nextElementSibling.classList.remove("error");
    field.nextElementSibling.innerText = "";
  }
}

/**
 Si el campo está vacío, escriba el mensaje de error. En caso contrario, borra el mensaje de error.
 */
const validateEmptyField = (message, e) => {
  const field = e.target;
  const fieldValue = e.target.value;
  if (fieldValue.trim().length === 0) {
    setErrors(message, field);
  } else {
    setErrors("", field, false);
  }
}

/**
 * Si el valor del campo tiene más de 5 caracteres y el valor del campo no coincide con la expresión regular, entonces ponga
 * el mensaje de error.
 */
const validateEmailFormat = e => {
  const field = e.target;
  const fieldValue = e.target.value;
  const regex = new RegExp(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/);
  if (fieldValue.trim().length > 5 && !regex.test(fieldValue)) {
    setErrors("Please enter a valid email", field);
  } else {
    setErrors("", field, false);
  }
}

/* Añadiendo un escuchador de eventos al elemento userNameField. El receptor de eventos está a la escucha de un evento blur
. Cuando se produce el evento blur(El evento blur se dispara cuando un elemento ha perdido el foco.) */
userNameField.addEventListener("blur", (e) => validateEmptyField("Add your username", e));
passwordField.addEventListener("blur", (e) => validateEmptyField("Write your password", e));
emailField.addEventListener("blur", (e) => validateEmptyField("Please provide an email", e));

emailField.addEventListener("input", validateEmailFormat);

/* Comprobación de la extensión del archivo foto cargado */
fileField.addEventListener("change", (e) => {
  const field = e.target;
  const fileExt = e.target.files[0].name.split(".").pop().toLowerCase();
  const allowedExt = ["jpg", "jpeg", "png", "gif"];
  if (!allowedExt.includes(fileExt)) {
    setErrors(`The only extensions allowed are ${allowedExt.join(", ")}`, field);
  } else {
    setErrors("", field, false);
  }
});