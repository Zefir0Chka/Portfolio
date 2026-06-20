// js/togglePassword.js

function togglePasswordVisibility(fieldId, button) {
    const passwordField = document.getElementById(fieldId);
    const eyeIcon = button.querySelector('i');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash'); // Иконка "глаз закрыт"
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye'); // Иконка "глаз открыт"
    }
}