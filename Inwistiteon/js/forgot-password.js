document.addEventListener('DOMContentLoaded', function () {
    const loginInput = document.querySelector('input[name="login"]');
    const secretQuestionContainer = document.getElementById('secret-question-container');

    loginInput.addEventListener('blur', function () {
        const login = loginInput.value;

        if (login) {
            fetch(`../auth/get_secret_question.php?login=${login}`)
                .then(response => response.json())
                .then(data => {
                    if (data.question) {
                        secretQuestionContainer.innerHTML = `<p>Секретный вопрос: ${data.question}</p>`;
                    } else {
                        secretQuestionContainer.innerHTML = `<p style="color: red;">Пользователь не найден</p>`;
                    }
                })
                .catch(error => console.error('Ошибка:', error));
        }
    });
});