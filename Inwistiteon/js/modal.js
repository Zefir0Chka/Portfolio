// js/modal.js
document.addEventListener('DOMContentLoaded', function() {
    // Открытие модального окна
    document.getElementById('privacy-link').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('privacy-modal').style.display = 'block';
    });

    // Закрытие модального окна
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('privacy-modal').style.display = 'none';
    });

    // Закрытие модального окна при клике вне его
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('privacy-modal')) {
            document.getElementById('privacy-modal').style.display = 'none';
        }
    });
});