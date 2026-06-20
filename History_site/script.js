// Массив исторических событий
const historicalEvents = [
    {
        id: 1,
        title: "Великая Октябрьская революция",
        description: "Октябрьская революция 1917 года - одно из важнейших событий XX века, которое привело к созданию первого в мире социалистического государства.",
        period: "contemporary",
        category: "politics",
        date: "1917-10-25"
    },
    {
        id: 2,
        title: "Крещение Руси",
        description: "Принятие христианства в 988 году князем Владимиром стало поворотным моментом в истории Древней Руси.",
        period: "middle",
        category: "culture",
        date: "0988-01-01"
    },
    {
        id: 3,
        title: "Ледовое побоище",
        description: "Битва на Чудском озере в 1242 году, где войска Александра Невского разгромили немецких рыцарей.",
        period: "middle",
        category: "war",
        date: "1242-04-05"
    },
    {
        id: 4,
        title: "Полет Гагарина",
        description: "12 апреля 1961 года Юрий Гагарин стал первым человеком, побывавшим в космосе.",
        period: "contemporary",
        category: "science",
        date: "1961-04-12"
    },
    {
        id: 5,
        title: "Куликовская битва",
        description: "Решающее сражение между русскими войсками и ордой Мамая в 1380 году.",
        period: "middle",
        category: "war",
        date: "1380-09-08"
    },
    {
        id: 6,
        title: "Основание Санкт-Петербурга",
        description: "В 1703 году Петр I основал новый город, который стал столицей Российской империи.",
        period: "modern",
        category: "politics",
        date: "1703-05-27"
    },
    {
        id: 7,
        title: "Бородинское сражение",
        description: "Крупнейшее сражение Отечественной войны 1812 года между русской и французской армиями.",
        period: "modern",
        category: "war",
        date: "1812-09-07"
    },
    {
        id: 8,
        title: "Отмена крепостного права",
        description: "В 1861 году Александр II подписал манифест об отмене крепостного права в России.",
        period: "modern",
        category: "politics",
        date: "1861-03-03"
    },
    {
        id: 9,
        title: "Первая русская революция",
        description: "Революционные события 1905-1907 годов, приведшие к созданию Государственной думы.",
        period: "modern",
        category: "politics",
        date: "1905-01-22"
    },
    {
        id: 10,
        title: "Великая Отечественная война",
        description: "Начало Великой Отечественной войны 22 июня 1941 года.",
        period: "contemporary",
        category: "war",
        date: "1941-06-22"
    },
    {
        id: 11,
        title: "Первый полет человека в космос",
        description: "12 апреля 1961 года Юрий Гагарин совершил первый в истории человечества космический полет.",
        period: "contemporary",
        category: "science",
        date: "1961-04-12"
    },
    {
        id: 12,
        title: "Распад СССР",
        description: "26 декабря 1991 года Советский Союз официально прекратил свое существование.",
        period: "contemporary",
        category: "politics",
        date: "1991-12-26"
    },
    {
        id: 13,
        title: "Основание Москвы",
        description: "Первое упоминание Москвы в летописях в 1147 году.",
        period: "middle",
        category: "politics",
        date: "1147-04-04"
    },
    {
        id: 14,
        title: "Стояние на Угре",
        description: "Окончательное освобождение Руси от ордынского ига в 1480 году.",
        period: "middle",
        category: "war",
        date: "1480-11-11"
    },
    {
        id: 15,
        title: "Смутное время",
        description: "Период в истории России с 1598 по 1613 год, характеризующийся кризисом государственности.",
        period: "middle",
        category: "politics",
        date: "1598-01-01"
    },
    {
        id: 16,
        title: "Северная война",
        description: "Война между Россией и Швецией 1700-1721 годов, в результате которой Россия получила выход к Балтийскому морю.",
        period: "modern",
        category: "war",
        date: "1700-08-30"
    },
    {
        id: 17,
        title: "Восстание декабристов",
        description: "Попытка государственного переворота 14 декабря 1825 года.",
        period: "modern",
        category: "politics",
        date: "1825-12-14"
    },
    {
        id: 18,
        title: "Открытие Периодической таблицы",
        description: "Дмитрий Менделеев открыл Периодический закон химических элементов в 1869 году.",
        period: "modern",
        category: "science",
        date: "1869-03-06"
    },
    {
        id: 19,
        title: "Русско-японская война",
        description: "Война между Российской и Японской империями 1904-1905 годов.",
        period: "modern",
        category: "war",
        date: "1904-02-08"
    },
    {
        id: 20,
        title: "Гражданская война",
        description: "Вооруженная борьба между различными политическими силами в России 1917-1922 годов.",
        period: "contemporary",
        category: "war",
        date: "1917-11-07"
    },
    {
        id: 21,
        title: "Сталинградская битва",
        description: "Крупнейшее сражение Второй мировой войны, переломный момент в войне.",
        period: "contemporary",
        category: "war",
        date: "1942-07-17"
    },
    {
        id: 22,
        title: "Первый искусственный спутник",
        description: "Запуск первого искусственного спутника Земли 4 октября 1957 года.",
        period: "contemporary",
        category: "science",
        date: "1957-10-04"
    },
    {
        id: 23,
        title: "Битва при Ватерлоо",
        description: "Решающее сражение Наполеоновских войн 18 июня 1815 года.",
        period: "modern",
        category: "war",
        date: "1815-06-18"
    },
    {
        id: 24,
        title: "Открытие ДНК",
        description: "Джеймс Уотсон и Фрэнсис Крик открыли структуру ДНК в 1953 году.",
        period: "contemporary",
        category: "science",
        date: "1953-02-28"
    },
    {
        id: 25,
        title: "Падение Берлинской стены",
        description: "9 ноября 1989 года началось разрушение Берлинской стены.",
        period: "contemporary",
        category: "politics",
        date: "1989-11-09"
    },
    {
        id: 26,
        title: "Великая китайская стена",
        description: "Начало строительства Великой китайской стены в III веке до н.э.",
        period: "ancient",
        category: "culture",
        date: "-0221-01-01"
    },
    {
        id: 27,
        title: "Открытие радиоволн",
        description: "Генрих Герц открыл радиоволны в 1887 году.",
        period: "modern",
        category: "science",
        date: "1887-01-01"
    },
    {
        id: 28,
        title: "Битва при Куликовом поле",
        description: "Решающее сражение между русскими войсками и Золотой Ордой в 1380 году.",
        period: "middle",
        category: "war",
        date: "1380-09-08"
    },
    {
        id: 29,
        title: "Открытие Антарктиды",
        description: "Первая высадка на Антарктиду экспедиции Беллинсгаузена и Лазарева в 1820 году.",
        period: "modern",
        category: "science",
        date: "1820-01-28"
    },
    {
        id: 30,
        title: "Создание ООН",
        description: "Основание Организации Объединенных Наций 24 октября 1945 года.",
        period: "contemporary",
        category: "politics",
        date: "1945-10-24"
    },
    {
        id: 31,
        title: "Открытие гробницы Тутанхамона",
        description: "Говард Картер обнаружил гробницу фараона Тутанхамона в 1922 году.",
        period: "contemporary",
        category: "culture",
        date: "1922-11-04"
    },
    {
        id: 32,
        title: "Первая высадка на Луну",
        description: "Аполлон-11: первая высадка человека на Луну 20 июля 1969 года.",
        period: "contemporary",
        category: "science",
        date: "1969-07-20"
    },
    {
        id: 33,
        title: "Основание Рима",
        description: "Легендарное основание города Рима в 753 году до н.э.",
        period: "ancient",
        category: "culture",
        date: "-0753-04-21"
    },
    {
        id: 34,
        title: "Битва при Каннах",
        description: "Одно из крупнейших сражений Второй Пунической войны в 216 году до н.э.",
        period: "ancient",
        category: "war",
        date: "-0216-08-02"
    },
    {
        id: 35,
        title: "Великий шелковый путь",
        description: "Открытие Великого шелкового пути во II веке до н.э.",
        period: "ancient",
        category: "culture",
        date: "-0200-01-01"
    },
    {
        id: 36,
        title: "Крестовые походы",
        description: "Начало Первого крестового похода в 1096 году.",
        period: "middle",
        category: "war",
        date: "1096-08-15"
    },
    {
        id: 37,
        title: "Черная смерть",
        description: "Начало пандемии чумы в Европе в 1347 году.",
        period: "middle",
        category: "science",
        date: "1347-01-01"
    },
    {
        id: 38,
        title: "Великие географические открытия",
        description: "Эпоха Великих географических открытий XV-XVII веков.",
        period: "modern",
        category: "science",
        date: "1492-10-12"
    },
    {
        id: 39,
        title: "Реформация",
        description: "Начало Реформации в 1517 году с выступления Мартина Лютера.",
        period: "modern",
        category: "culture",
        date: "1517-10-31"
    },
    {
        id: 40,
        title: "Тридцатилетняя война",
        description: "Начало Тридцатилетней войны в 1618 году.",
        period: "modern",
        category: "war",
        date: "1618-05-23"
    },
    {
        id: 41,
        title: "Великая французская революция",
        description: "Начало Великой французской революции в 1789 году.",
        period: "modern",
        category: "politics",
        date: "1789-07-14"
    },
    {
        id: 42,
        title: "Промышленная революция",
        description: "Начало Промышленной революции в XVIII веке.",
        period: "modern",
        category: "science",
        date: "1760-01-01"
    },
    {
        id: 43,
        title: "Гражданская война в США",
        description: "Начало Гражданской войны в США в 1861 году.",
        period: "modern",
        category: "war",
        date: "1861-04-12"
    },
    {
        id: 44,
        title: "Первая мировая война",
        description: "Начало Первой мировой войны в 1914 году.",
        period: "contemporary",
        category: "war",
        date: "1914-07-28"
    },
    {
        id: 45,
        title: "Великая депрессия",
        description: "Начало Великой депрессии в 1929 году.",
        period: "contemporary",
        category: "politics",
        date: "1929-10-29"
    },
    {
        id: 46,
        title: "Вторая мировая война",
        description: "Начало Второй мировой войны в 1939 году.",
        period: "contemporary",
        category: "war",
        date: "1939-09-01"
    },
    {
        id: 47,
        title: "Холодная война",
        description: "Начало Холодной войны в 1947 году.",
        period: "contemporary",
        category: "politics",
        date: "1947-03-12"
    },
    {
        id: 48,
        title: "Деколонизация Африки",
        description: "Начало процесса деколонизации Африки в 1950-х годах.",
        period: "contemporary",
        category: "politics",
        date: "1950-01-01"
    },
    {
        id: 49,
        title: "Кубинский ракетный кризис",
        description: "Кубинский ракетный кризис в 1962 году.",
        period: "contemporary",
        category: "politics",
        date: "1962-10-16"
    },
    {
        id: 50,
        title: "Распад СССР",
        description: "Официальный распад Советского Союза в 1991 году.",
        period: "contemporary",
        category: "politics",
        date: "1991-12-26"
    },
    {
        id: 51,
        title: "Создание Интернета",
        description: "Изобретение Всемирной паутины в 1989 году.",
        period: "contemporary",
        category: "science",
        date: "1989-03-12"
    },
    {
        id: 52,
        title: "Глобализация",
        description: "Начало эпохи глобализации в 1990-х годах.",
        period: "contemporary",
        category: "politics",
        date: "1990-01-01"
    }
];

// Получение элементов DOM
const eventsList = document.getElementById('eventsList');
const searchInput = document.getElementById('searchInput');
const periodFilter = document.getElementById('periodFilter');
const categoryFilter = document.getElementById('categoryFilter');
const applyFilters = document.getElementById('applyFilters');
const dateRangeStart = document.getElementById('dateRangeStart');
const dateRangeEnd = document.getElementById('dateRangeEnd');
const sortSelect = document.getElementById('sortSelect');

// Функция для отображения событий
function displayEvents(events) {
    eventsList.innerHTML = '';
    
    if (events.length === 0) {
        eventsList.innerHTML = `
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> События не найдены
                </div>
            </div>
        `;
        return;
    }

    events.forEach(event => {
        const eventCard = document.createElement('div');
        eventCard.className = 'col-md-6 col-lg-4 mb-4';
        eventCard.innerHTML = `
            <div class="event-card">
                <div class="event-image">
                    <img src="${event.image}" alt="${event.title}">
                    <div class="event-date">${formatDate(event.date)}</div>
                </div>
                <div class="event-content">
                    <h3 class="event-title">${event.title}</h3>
                    <p class="event-description">${event.description}</p>
                    <div class="event-tags">
                        <span class="badge bg-primary">${getPeriodName(event.period)}</span>
                        <span class="badge bg-secondary">${getCategoryName(event.category)}</span>
                    </div>
                    <div class="event-actions mt-3">
                        <button class="btn btn-sm btn-outline-primary me-2" onclick="showEventDetails(${event.id})">
                            <i class="fas fa-info-circle"></i> Подробнее
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="addToFavorites(${event.id})">
                            <i class="fas fa-star"></i> В избранное
                        </button>
                    </div>
                </div>
            </div>
        `;
        eventsList.appendChild(eventCard);
    });
}

// Функция для форматирования даты
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Функция для получения названия периода
function getPeriodName(period) {
    const periods = {
        'ancient': 'Древний мир',
        'middle': 'Средние века',
        'modern': 'Новое время',
        'contemporary': 'Новейшее время'
    };
    return periods[period] || period;
}

// Функция для получения названия категории
function getCategoryName(category) {
    const categories = {
        'politics': 'Политика',
        'war': 'Войны',
        'culture': 'Культура',
        'science': 'Наука'
    };
    return categories[category] || category;
}

// Функция для расширенного поиска
function advancedSearch(events) {
    const searchTerm = searchInput.value.toLowerCase();
    const selectedPeriod = periodFilter.value;
    const selectedCategory = categoryFilter.value;
    const startDate = dateRangeStart.value;
    const endDate = dateRangeEnd.value;
    const sortBy = sortSelect.value;

    let filteredEvents = events.filter(event => {
        // Поиск по тексту
        const matchesSearch = event.title.toLowerCase().includes(searchTerm) ||
                            event.description.toLowerCase().includes(searchTerm);
        
        // Фильтрация по периоду
        const matchesPeriod = !selectedPeriod || event.period === selectedPeriod;
        
        // Фильтрация по категории
        const matchesCategory = !selectedCategory || event.category === selectedCategory;
        
        // Фильтрация по дате
        const eventDate = new Date(event.date);
        const matchesDateRange = (!startDate || eventDate >= new Date(startDate)) &&
                               (!endDate || eventDate <= new Date(endDate));

        return matchesSearch && matchesPeriod && matchesCategory && matchesDateRange;
    });

    // Сортировка
    filteredEvents.sort((a, b) => {
        const dateA = new Date(a.date);
        const dateB = new Date(b.date);
        
        switch(sortBy) {
            case 'date_asc':
                return dateA - dateB;
            case 'date_desc':
                return dateB - dateA;
            case 'title_asc':
                return a.title.localeCompare(b.title);
            case 'title_desc':
                return b.title.localeCompare(a.title);
            default:
                return 0;
        }
    });

    return filteredEvents;
}

// Функция для показа деталей события
function showEventDetails(eventId) {
    const event = historicalEvents.find(e => e.id === eventId);
    if (event) {
        const modal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
        document.getElementById('eventDetailsTitle').textContent = event.title;
        document.getElementById('eventDetailsDate').textContent = formatDate(event.date);
        document.getElementById('eventDetailsDescription').textContent = event.description;
        document.getElementById('eventDetailsImage').src = event.image;
        document.getElementById('eventDetailsPeriod').textContent = getPeriodName(event.period);
        document.getElementById('eventDetailsCategory').textContent = getCategoryName(event.category);
        modal.show();
    }
}

// Функция для добавления в избранное
function addToFavorites(eventId) {
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    if (!favorites.includes(eventId)) {
        favorites.push(eventId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        showAlert('Событие добавлено в избранное', 'success');
    } else {
        showAlert('Событие уже в избранном', 'info');
    }
}

// Функция для показа уведомлений
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

// Обработчики событий
searchInput.addEventListener('input', () => {
    const filteredEvents = advancedSearch(historicalEvents);
    displayEvents(filteredEvents);
});

periodFilter.addEventListener('change', () => {
    const filteredEvents = advancedSearch(historicalEvents);
    displayEvents(filteredEvents);
});

categoryFilter.addEventListener('change', () => {
    const filteredEvents = advancedSearch(historicalEvents);
    displayEvents(filteredEvents);
});

dateRangeStart.addEventListener('change', () => {
    const filteredEvents = advancedSearch(historicalEvents);
    displayEvents(filteredEvents);
});

dateRangeEnd.addEventListener('change', () => {
    const filteredEvents = advancedSearch(historicalEvents);
    displayEvents(filteredEvents);
});

sortSelect.addEventListener('change', () => {
    const filteredEvents = advancedSearch(historicalEvents);
    displayEvents(filteredEvents);
});

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', () => {
    displayEvents(historicalEvents);
    
    // Установка минимальной и максимальной даты для фильтра
    const dates = historicalEvents.map(event => new Date(event.date));
    const minDate = new Date(Math.min(...dates));
    const maxDate = new Date(Math.max(...dates));
    
    dateRangeStart.min = minDate.toISOString().split('T')[0];
    dateRangeStart.max = maxDate.toISOString().split('T')[0];
    dateRangeEnd.min = minDate.toISOString().split('T')[0];
    dateRangeEnd.max = maxDate.toISOString().split('T')[0];
}); 