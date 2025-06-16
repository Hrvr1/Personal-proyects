/* script.js */

// Ejemplo de validación básica de formulario
function validateForm() {
    var username = document.getElementById('txtUsername').value;
    var password = document.getElementById('txtPassword').value;

    if (username === '' || password === '') {
        alert('Please fill in all fields.');
        return false;
    }
    return true;
}
