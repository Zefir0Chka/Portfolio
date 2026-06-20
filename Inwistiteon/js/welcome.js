document.addEventListener('DOMContentLoaded', () => {
    // Класс для управления анимациями
    class Animator {
        static fadeIn(element, delay = 100) {
            setTimeout(() => {
                element.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                element.style.opacity = 1;
                element.style.transform = 'translateY(0)';
            }, delay);
        }

        static scaleOnHover(element) {
            element.addEventListener('mouseenter', () => {
                element.style.transform = 'scale(1.05)';
            });
            element.addEventListener('mouseleave', () => {
                element.style.transform = 'scale(1)';
            });
        }
    }

    // Анимация появления для карточек
    document.querySelectorAll('.feature-item, .widget, .testimonial-card, .analytics-card').forEach(card => {
        card.style.opacity = 0;
        card.style.transform = 'translateY(20px)';
        Animator.fadeIn(card);
    });

    // Обработчик для кнопок модальных окон
    document.querySelectorAll('[data-modal]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = btn.getAttribute('data-modal');
            const modal = document.getElementById(`${modalId}-modal`);
            if (modal) {
                modal.style.display = 'block';
                modal.querySelector('.modal-content').style.transform = 'scale(1)';
            }
        });
    });

    // Закрытие модальных окон
    document.querySelectorAll('.modal .close').forEach(closeBtn => {
        closeBtn.addEventListener('click', () => {
            const modal = closeBtn.closest('.modal');
            modal.querySelector('.modal-content').style.transform = 'scale(0.9)';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 200);
        });
    });

    // Обработчик для FAQ аккордеона
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            answer.style.display = answer.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Инициализация графиков
    const initializeCharts = () => {
        // График 1: User Activity Overview (линейный график)
        const activityCtx = document.getElementById('activityChart')?.getContext('2d');
        if (activityCtx) {
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'User Activity',
                        data: [12, 19, 3, 5, 2, 3, 15],
                        borderColor: 'rgba(255, 0, 0, 0.8)',
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#ffffff'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        }

        // График 2: Feature Usage Analytics (столбчатая диаграмма)
        const usageCtx = document.getElementById('usageChart')?.getContext('2d');
        if (usageCtx) {
            new Chart(usageCtx, {
                type: 'bar',
                data: {
                    labels: ['Feature 1', 'Feature 2', 'Feature 3', 'Feature 4'],
                    datasets: [{
                        label: 'Usage',
                        data: [4, 6, 8, 7],
                        backgroundColor: 'rgba(255, 215, 0, 0.5)',
                        borderColor: '#ffd700',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#ffffff'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        }

        // График 3: Task Distribution (круговая диаграмма)
        const taskDistributionCtx = document.getElementById('taskDistributionChart')?.getContext('2d');
        if (taskDistributionCtx) {
            new Chart(taskDistributionCtx, {
                type: 'pie',
                data: {
                    labels: ['Team A', 'Team B', 'Team C', 'Team D'],
                    datasets: [{
                        label: 'Task Distribution',
                        data: [30, 25, 20, 25],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        }

        // График 4: Revenue Trends (график области)
        const revenueTrendsCtx = document.getElementById('revenueTrendsChart')?.getContext('2d');
        if (revenueTrendsCtx) {
            new Chart(revenueTrendsCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Revenue',
                        data: [5000, 7000, 4500, 8000, 6000, 9000],
                        borderColor: 'rgba(0, 255, 0, 0.8)',
                        borderWidth: 2,
                        fill: true,
                        backgroundColor: 'rgba(0, 255, 0, 0.2)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                color: '#ffffff'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#ffffff'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#ffffff'
                            }
                        }
                    }
                }
            });
        }
    };

    // Ленивая загрузка графиков с IntersectionObserver
    const lazyLoadCharts = () => {
        const chartContainers = document.querySelectorAll('.chart-wrapper');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    initializeCharts();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        chartContainers.forEach(container => observer.observe(container));
    };

    lazyLoadCharts();

    // Анимация для кнопок
    document.querySelectorAll('.btn').forEach(button => {
        Animator.scaleOnHover(button);
    });

    // Плавная прокрутка для якорных ссылок
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Эффект самоуничтожения
    const selfDestructBtn = document.getElementById('self-destruct-btn');
    if (selfDestructBtn) {
        selfDestructBtn.addEventListener('click', () => {
            // Добавляем эффект помех
            document.body.classList.add('glitch-effect');

            // Через 1 секунду добавляем эффект растворения
            setTimeout(() => {
                document.body.classList.remove('glitch-effect');
                document.body.classList.add('dissolve-effect');

                // Заменяем текст на случайные коды
                const elements = document.querySelectorAll('h1, h2, h3, p, a, span, li');
                elements.forEach((element) => {
                    element.classList.add('code-effect');
                    element.textContent = generateRandomCode();
                });

                // Через 2 секунды перенаправляем на страницу регистрации
                setTimeout(() => {
                    window.location.href = '../views/registr_form.php';
                }, 2000);
            }, 1000);
        });
    }

    // Функция для генерации случайного кода
    function generateRandomCode() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        for (let i = 0; i < 10; i++) {
            code += chars[Math.floor(Math.random() * chars.length)];
        }
        return code;
    }
});
