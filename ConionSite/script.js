let currentIndex = 0; // Индекс текущего слайда
const slides = document.querySelectorAll('.slide');
const indicators = document.querySelectorAll('.indicator');


// Функция для отображения текущего слайда
function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
        indicators[i].classList.remove('active');
        if (i === index) {
            slide.classList.add('active');
            indicators[i].classList.add('active');
        }
    });
    
    const slidesContainer = document.querySelector('.slides');
    slidesContainer.style.transform = `translateX(-${index * 100}%)`;
}

// Функция для переключения на текущий слайд
function currentSlide(index) {
    currentIndex = index;
    showSlide(currentIndex);
}

// Функция для изменения слайда
function changeSlide(direction) {
    currentIndex += direction;
    
    // Защита от выхода за пределы массива
    if (currentIndex >= slides.length) {
        currentIndex = 0;
    } else if (currentIndex < 0) {
        currentIndex = slides.length - 1;
    }
    
    showSlide(currentIndex);
}

// Автоматическое переключение слайдов каждые 5 секунд
setInterval(() => {
   changeSlide(1);
}, 5000);

// Изначально показываем первый слайд
showSlide(currentIndex);


// Получаем элемент шапки
const header = document.querySelector('.header');

// Функция для изменения класса шапки при прокрутке
function handleScroll() {
    if (window.scrollY > 50) { // Если прокрутка больше 50 пикселей
        header.classList.add('scrolled'); // Добавляем класс для изменения стиля
    } else {
        header.classList.remove('scrolled'); // Убираем класс, если прокрутка меньше 50 пикселей
    }
}

// Добавляем обработчик события прокрутки
window.addEventListener('scroll', handleScroll);

// Плавная прокрутка к якорным ссылкам
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Модальное окно
function openModal(imageSrc) {
    const modal = document.createElement('div');
    modal.classList.add('modal');
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close-button" onclick="closeModal()">&times;</span>
            <img src="${imageSrc}" alt="Модальное изображение" />
        </div>
    `;
    document.body.appendChild(modal);
}

function closeModal() {
    const modal = document.querySelector('.modal');
    if (modal) {
        modal.remove();
    }
}

// Добавление обработчиков событий на изображения
document.querySelectorAll('.image-text-block img').forEach(img => {
    img.addEventListener('click', function () {
        openModal(this.src);
    });
});

// Улучшение слайдера (перетаскивание)
let isDragging = false;
let startX, scrollLeft;

const squareSlider = document.querySelector('.square-slider');

squareSlider.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.pageX - squareSlider.offsetLeft;
    scrollLeft = squareSlider.scrollLeft;
});

squareSlider.addEventListener('mouseleave', () => {
    isDragging = false;
});

squareSlider.addEventListener('mouseup', () => {
    isDragging = false;
});

squareSlider.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - squareSlider.offsetLeft;
    const walk = (x - startX) * 2; // Скорость прокрутки
    squareSlider.scrollLeft = scrollLeft - walk;
});

// Параллакс-эффект для фона
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    document.querySelector('.dark-section').style.backgroundPositionY = `${scrolled * 0.5}px`;
});

// Плавный переход при загрузке страницы
window.onload = () => {
    document.body.style.opacity = 1; // Убираем эффект прозрачности после загрузки
};

document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Предотвращаем стандартное поведение формы

    const name = document.getElementById('name').value;

    document.getElementById('response-message').innerText = `Спасибо, ${name}! Ваше сообщение отправлено.`;
    
    // Очистка формы
    this.reset();
});
