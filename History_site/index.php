
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Исторические события</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2B48C;
            --accent-color: #DEB887;
            --background-color: #FFF8DC;
            --text-color: #4A2C2A;
            --border-color: #CD853F;
            --card-bg: #FFF8DC;
            --hover-color: #CD853F;
            --shadow-color: rgba(139, 69, 19, 0.2);
            
            /* Добавляем новые цветовые переменные */
            --gradient-primary: linear-gradient(135deg, #8B4513, #CD853F);
            --gradient-secondary: linear-gradient(45deg, #D2B48C, #DEB887);
            --glass-bg: rgba(255, 248, 220, 0.8);
            --glass-border: rgba(255, 255, 255, 0.2);
            --neon-shadow: 0 0 15px rgba(222, 184, 135, 0.5);
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            background-image: 
                linear-gradient(135deg, rgba(139, 69, 19, 0.1) 0%, rgba(210, 180, 140, 0.1) 100%),
                url('https://images.unsplash.com/photo-1518636306295-1870b3b2d6b2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-blend-mode: overlay;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: var(--gradient-primary) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: linear-gradient(to right, #FFF8DC, #DEB887);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 10px 0;
        }

        .nav-link {
            position: relative;
            padding: 10px 20px !important;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: all 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-custom, .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before, .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .btn-custom:hover::before, .btn-primary:hover::before {
            left: 100%;
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--neon-shadow);
        }

        .card-header {
            background: var(--gradient-secondary);
            border-bottom: none;
            padding: 20px;
        }

        .stat-item {
            background: var(--glass-bg);
            backdrop-filter: blur(5px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: var(--neon-shadow);
        }

        .stat-number {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .timeline-item {
            background: var(--glass-bg);
            backdrop-filter: blur(5px);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .timeline-item:hover {
            transform: scale(1.02);
            box-shadow: var(--neon-shadow);
        }

        .achievements {
            position: relative;
            overflow: hidden;
        }

        .achievements::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0.9;
        }

        .achievement-item {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
        }

        .achievement-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .achievement-icon, .stat-icon {
            position: relative;
        }

        .achievement-icon::after, .stat-icon::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0;
            height: 0;
            background: var(--accent-color);
            border-radius: 50%;
            opacity: 0;
            transition: all 0.5s ease;
        }

        .achievement-item:hover .achievement-icon::after,
        .stat-item:hover .stat-icon::after {
            width: 50px;
            height: 50px;
            opacity: 0.2;
        }

        .footer {
            background: var(--gradient-primary);
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--accent-color), transparent);
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--accent-color);
            transform: translateY(-5px);
            box-shadow: var(--neon-shadow);
        }

        h1, h2, h3 {
            position: relative;
            overflow: hidden;
        }

        h1::after, h2::after, h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--gradient-secondary);
            transform: translateX(-100%);
            transition: all 0.5s ease;
        }

        h1:hover::after, h2:hover::after, h3:hover::after {
            transform: translateX(0);
        }

        .modal-content {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
        }

        .modal-header {
            background: var(--gradient-secondary);
            border-bottom: none;
            border-radius: 20px 20px 0 0;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            padding: 12px;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: var(--neon-shadow);
            border-color: var(--accent-color);
        }

        /* Стили для новых интерактивных блоков */
        .hero-section {
            position: relative;
            height: 80vh;
            background: linear-gradient(rgba(139, 69, 19, 0.7), rgba(210, 180, 140, 0.7)), url('https://images.unsplash.com/photo-1528181304800-259b08848526?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--background-color);
            text-align: center;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeIn 1.5s ease;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .hero-button {
            padding: 15px 30px;
            border-radius: 30px;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--background-color);
        }

        .hero-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px var(--shadow-color);
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        /* Секция с интерактивными карточками */
        .interactive-cards {
            padding: 80px 0;
            background: var(--background-color);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .interactive-card {
            background: var(--card-bg);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px var(--shadow-color);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid var(--border-color);
        }

        .interactive-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px var(--shadow-color);
        }

        .card-image {
            height: 200px;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .interactive-card:hover .card-image img {
            transform: scale(1.1);
        }

        .card-content {
            padding: 25px;
        }

        .card-title {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .card-text {
            color: var(--text-color);
            margin-bottom: 20px;
        }

        .card-stats {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px var(--shadow-color);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .stat-number::after {
            content: '+';
            position: absolute;
            top: -10px;
            right: -20px;
            font-size: 1.5rem;
            color: var(--accent-color);
        }

        .stat-label {
            font-size: 1.1rem;
            color: var(--text-color);
            position: relative;
            padding-bottom: 15px;
        }

        .stat-label::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: var(--accent-color);
        }

        .stat-icon {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .stat-item:hover .stat-icon {
            transform: scale(1.2);
        }

        .stat-progress {
            width: 80%;
            height: 4px;
            background: var(--background-color);
            margin: 15px auto;
            border-radius: 2px;
            overflow: hidden;
        }

        .stat-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            width: 0;
            transition: width 1.5s ease;
        }

        .stat-item.revealed .stat-progress-bar {
            width: 100%;
        }

        .stat-details {
            font-size: 0.9rem;
            color: var(--text-color);
            opacity: 0.8;
            margin-top: 10px;
        }

        @keyframes countUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .stat-number.animate {
            animation: countUp 1s ease forwards;
        }

        /* Секция с временной шкалой */
        .timeline-preview {
            padding: 80px 0;
            background: var(--background-color);
        }

        .timeline-container {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 0;
        }

        .timeline-item {
            position: relative;
            padding: 20px;
            background: var(--card-bg);
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px var(--shadow-color);
            border: 1px solid var(--border-color);
        }

        .timeline-date {
            color: var(--primary-color);
            font-weight: bold;
        }

        .timeline-title {
            color: var(--text-color);
            margin: 10px 0;
        }

        .timeline-description {
            color: var(--text-color);
        }

        /* Секция с картой */
        .map-section {
            padding: 80px 0;
            background: var(--background-color);
        }

        .map-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px var(--shadow-color);
            border: 2px solid var(--border-color);
            height: 400px;
            position: relative;
        }

        #miniMap {
            width: 100%;
            height: 100%;
        }

        .map-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 248, 220, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .map-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .map-legend {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--card-bg);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px var(--shadow-color);
            z-index: 1000;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .legend-text {
            color: var(--text-color);
        }

        /* Подвал */
        .footer {
            background-color: var(--primary-color);
            color: var(--background-color);
            padding: 40px 0;
        }

        .footer-title {
            color: var(--background-color);
            margin-bottom: 20px;
        }

        .footer-link {
            color: var(--accent-color);
            text-decoration: none;
        }

        .footer-link:hover {
            color: var(--background-color);
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            color: var(--background-color);
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .social-link:hover {
            color: var(--accent-color);
        }

        /* Анимации */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-subtitle {
                font-size: 1.2rem;
            }
            .hero-buttons {
                flex-direction: column;
            }
            .card-container {
                grid-template-columns: 1fr;
            }
        }

        /* Дополнительные стили для новых блоков */
        .quote-carousel {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            padding: 60px 0;
            color: white;
            margin: 40px 0;
            border-radius: 15px;
        }

        .quote-item {
            text-align: center;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .quote-text {
            font-size: 1.5rem;
            font-style: italic;
            margin-bottom: 20px;
        }

        .quote-author {
            font-weight: bold;
        }

        /* Стили для викторины */
        .quiz-section {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--background-color) 0%, var(--secondary-color) 100%);
        }

        .quiz-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px var(--shadow-color);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .quiz-question {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            position: relative;
            padding-left: 40px;
        }

        .quiz-question::before {
            content: "?";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .quiz-options {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .quiz-option {
            display: block;
            width: 100%;
            padding: 15px 20px;
            margin: 10px 0;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            background: var(--background-color);
            color: var(--text-color);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quiz-option:hover {
            transform: translateX(10px);
            background: var(--accent-color);
            color: white;
        }

        .quiz-option.correct {
            background: #2ecc71;
            color: white;
            border-color: #27ae60;
        }

        .quiz-option.wrong {
            background: #e74c3c;
            color: white;
            border-color: #c0392b;
        }

        .quiz-feedback {
            padding: 15px;
            border-radius: 10px;
            font-weight: 500;
            display: none;
        }

        .quiz-feedback.correct {
            background: rgba(46, 204, 113, 0.2);
            color: #27ae60;
            display: block;
        }

        .quiz-feedback.wrong {
            background: rgba(231, 76, 60, 0.2);
            color: #c0392b;
            display: block;
        }

        .quiz-result-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .quiz-next-btn {
            display: none;
            margin-top: 20px;
            padding: 10px 25px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quiz-next-btn:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }

        .quiz-next-btn.show {
            display: inline-block;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .quiz-option.shake {
            animation: shake 0.5s ease;
        }

        /* Стили для секции достижений */
        .achievements {
            padding: 80px 0;
            background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80') center/cover fixed;
            position: relative;
        }

        .achievements::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(139, 69, 19, 0.9);
        }

        .achievement-container {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }

        .achievement-item {
            text-align: center;
            padding: 40px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            color: white;
            transition: all 0.3s ease;
        }

        .achievement-item:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.2);
        }

        .achievement-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .achievement-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #fff, var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .achievement-text {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Стили для секции временной шкалы */
        .historical-timeline {
            padding: 80px 0;
            background: var(--background-color);
            position: relative;
            overflow: hidden;
        }

        .timeline-wrapper {
            position: relative;
            padding: 40px 0;
        }

        .timeline-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transform: translateY(-50%);
        }

        .timeline-event {
            position: relative;
            margin: 50px 0;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease;
        }

        .timeline-event.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .timeline-dot {
            width: 20px;
            height: 20px;
            background: var(--primary-color);
            border-radius: 50%;
            position: absolute;
            left: 50%;
            top: 0;
            transform: translate(-50%, -50%);
            z-index: 2;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .timeline-dot:hover {
            transform: translate(-50%, -50%) scale(1.5);
            background: var(--accent-color);
        }

        .timeline-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px var(--shadow-color);
            margin: 20px;
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            transform: scale(1.05);
        }

        .timeline-year {
            font-size: 1.2rem;
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .timeline-description {
            color: var(--text-color);
            line-height: 1.6;
        }

        .btn-custom {
            background-color: var(--accent-color);
            color: var(--text-color);
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-custom:hover {
            background-color: var(--hover-color);
            color: var(--background-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-custom i {
            margin-right: 8px;
        }

        .btn-outline-light {
            border-radius: 20px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* Добавляем стили для новых элементов */
        .quick-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .quick-link-item {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .quick-link-item:hover {
            transform: translateY(-5px) scale(1.1);
            background: rgba(255, 255, 255, 0.3);
            color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .floating-nav {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 1000;
        }

        .floating-nav-toggle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary-color);
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .floating-nav-toggle:hover {
            transform: rotate(45deg);
            background: var(--accent-color);
        }

        .floating-nav-menu {
            position: absolute;
            bottom: 70px;
            right: 0;
            background: white;
            border-radius: 15px;
            padding: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: none;
            flex-direction: column;
            gap: 10px;
            min-width: 200px;
        }

        .floating-nav-menu.active {
            display: flex;
        }

        .floating-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            color: var(--text-color);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .floating-nav-item:hover {
            background: var(--background-color);
            color: var(--primary-color);
            transform: translateX(-5px);
        }

        .floating-nav-item i {
            font-size: 1.2rem;
        }

        /* Добавляем анимацию для интерактивных карточек */
        .interactive-card {
            cursor: pointer;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .interactive-card:hover {
            transform: translateY(-15px) rotate(2deg);
        }

        .interactive-card:hover .card-image img {
            transform: scale(1.2) rotate(-5deg);
        }

        .interactive-card:hover .stat-icon {
            animation: bounce 0.5s ease infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Добавляем стили для викторины */
        .quiz-progress {
            margin-bottom: 30px;
        }

        .quiz-progress .progress {
            height: 10px;
            border-radius: 5px;
            background: rgba(0, 0, 0, 0.1);
        }

        .quiz-progress .progress-bar {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
        }

        .score-circle {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
        }

        .score-number {
            font-size: 3rem;
            font-weight: bold;
        }

        .score-percent {
            font-size: 1.5rem;
        }

        .score-message {
            margin-top: 20px;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .restart-quiz {
            margin-top: 20px;
            padding: 10px 25px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .restart-quiz:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <!-- Навигационная панель -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Исторические события</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">События</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chronology.php">Хронология</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php">Карта</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">О нас</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if ($isLoggedIn): ?>
                        <a href="profile.php" class="btn btn-custom me-2">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($userData['username']); ?>
                        </a>
                        <a href="logout.php" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt"></i> Выход
                        </a>
                    <?php else: ?>
                        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Войти
                        </button>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="fas fa-user-plus"></i> Регистрация
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Герой секция -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Исторические события</h1>
            <p class="hero-subtitle">Исследуйте важные моменты истории через интерактивную временную шкалу</p>
            <div class="hero-buttons">
                <a href="events.php" class="btn btn-primary hero-button">
                    <i class="fas fa-calendar-alt"></i> Смотреть события
                </a>
                <a href="chronology.php" class="btn btn-outline-light hero-button">
                    <i class="fas fa-history"></i> Хронология
                </a>
            </div>
            <!-- Добавляем быстрые ссылки -->
            <div class="quick-links mt-4">
               
                </a>
                <a href="#" class="quick-link-item" data-bs-toggle="tooltip" title="Римская империя">
                    <i class="fas fa-monument"></i>
                </a>
                <a href="#" class="quick-link-item" data-bs-toggle="tooltip" title="Средневековье">
                    <i class="fas fa-chess-rook"></i>
                </a>
                <a href="#" class="quick-link-item" data-bs-toggle="tooltip" title="Эпоха Возрождения">
                    <i class="fas fa-palette"></i>
                </a>
                <a href="#" class="quick-link-item" data-bs-toggle="tooltip" title="Современность">
                    <i class="fas fa-city"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Добавляем плавающую панель навигации -->
    <div class="floating-nav">
        <button class="floating-nav-toggle">
            <i class="fas fa-compass"></i>
        </button>
        <div class="floating-nav-menu">
            <a href="#" class="floating-nav-item" data-section="timeline">
                <i class="fas fa-clock"></i>
                <span>Временная шкала</span>
            </a>
            <a href="#" class="floating-nav-item" data-section="quiz">
                <i class="fas fa-question-circle"></i>
                <span>Викторина</span>
            </a>
            <a href="#" class="floating-nav-item" data-section="achievements">
                <i class="fas fa-trophy"></i>
                <span>Достижения</span>
            </a>
            <a href="#" class="floating-nav-item" data-section="map">
                <i class="fas fa-map-marked-alt"></i>
                <span>Карта</span>
            </a>
        </div>
    </div>

    <!-- Секция с интерактивными карточками -->
    <section class="interactive-cards">
        <div class="container">
            <h2 class="text-center mb-5">Популярные исторические периоды</h2>
            <div class="card-container">
                <div class="interactive-card">
                    <div class="card-image">
                        <img src="https://images.unsplash.com/photo-1528181304800-259b08848526?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&h=400&q=80" alt="Древний мир">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Древний мир</h3>
                        <p class="card-text">Исследуйте события от зарождения цивилизации до падения Римской империи.</p>
                        <div class="card-stats">
                            <div class="stat-item">
                                <i class="fas fa-scroll stat-icon"></i>
                                <div class="stat-number animate" data-value="500">0</div>
                                <div class="stat-label">Событий</div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar"></div>
                                </div>
                                <div class="stat-details">Подтвержденных исторических фактов</div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-landmark stat-icon"></i>
                                <div class="stat-number animate" data-value="100">0</div>
                                <div class="stat-label">Цивилизаций</div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar"></div>
                                </div>
                                <div class="stat-details">Древних культур и народов</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="interactive-card">
                    <div class="card-image">
                        <img src="images/midle_time.jpg" alt="Средние века">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Средние века</h3>
                        <p class="card-text">Погрузитесь в эпоху рыцарей, замков и великих открытий.</p>
                        <div class="card-stats">
                            <div class="stat-item">
                                <i class="fas fa-scroll stat-icon"></i>
                                <div class="stat-number animate" data-value="300">0</div>
                                <div class="stat-label">Событий</div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar"></div>
                                </div>
                                <div class="stat-details">Исторических событий</div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-landmark stat-icon"></i>
                                <div class="stat-number animate" data-value="50">0</div>
                                <div class="stat-label">Королевств</div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar"></div>
                                </div>
                                <div class="stat-details">Средневековых государств</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="interactive-card">
                    <div class="card-image">
                        <img src="images/new_time.webp" alt="Новое время">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">Новое время</h3>
                        <p class="card-text">Откройте для себя эпоху великих революций и научных открытий.</p>
                        <div class="card-stats">
                            <div class="stat-item">
                                <i class="fas fa-scroll stat-icon"></i>
                                <div class="stat-number animate" data-value="400">0</div>
                                <div class="stat-label">Событий</div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar"></div>
                                </div>
                                <div class="stat-details">Исторических событий</div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-landmark stat-icon"></i>
                                <div class="stat-number animate" data-value="30">0</div>
                                <div class="stat-label">Стран</div>
                                <div class="stat-progress">
                                    <div class="stat-progress-bar"></div>
                                </div>
                                <div class="stat-details">Новых государств</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Секция с временной шкалой -->
    <section class="timeline-preview">
        <div class="container">
            <h2 class="text-center mb-5">Последние добавленные события</h2>
            <div class="timeline-container">
                <div class="timeline-item">
                    <div class="timeline-date">2023</div>
                    <h3>Открытие нового музея истории</h3>
                    <p>В Москве открылся новый интерактивный музей, посвященный истории России.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">2022</div>
                    <h3>100-летие СССР</h3>
                    <p>Крупная историческая конференция, посвященная столетию образования СССР.</p>
                </div>
                <div class="timeline-item">
                    <div class="timeline-date">2021</div>
                    <h3>Археологическая находка</h3>
                    <p>Обнаружены новые артефакты древней цивилизации в Сибири.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Историческая викторина -->
    <section class="quiz-section">
        <div class="container">
            <h2 class="text-center mb-4">Проверьте свои знания истории</h2>
            <div class="quiz-container">
                <div class="quiz-card active" data-quiz-id="1">
                    <div class="quiz-progress mb-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">1/3</div>
                        </div>
                    </div>
                    <h3 class="quiz-question">В каком году произошло крещение Руси?</h3>
                    <div class="quiz-options">
                        <button class="quiz-option" data-correct="false">865 год</button>
                        <button class="quiz-option" data-correct="true">988 год</button>
                        <button class="quiz-option" data-correct="false">1054 год</button>
                        <button class="quiz-option" data-correct="false">1147 год</button>
                    </div>
                    <div class="quiz-feedback mt-3"></div>
                    <button class="quiz-next-btn btn btn-primary mt-3" style="display: none;">Следующий вопрос</button>
                </div>

                <div class="quiz-card" data-quiz-id="2" style="display: none;">
                    <div class="quiz-progress mb-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">2/3</div>
                        </div>
                    </div>
                    <h3 class="quiz-question">Кто был первым императором России?</h3>
                    <div class="quiz-options">
                        <button class="quiz-option" data-correct="false">Иван Грозный</button>
                        <button class="quiz-option" data-correct="true">Пётр I</button>
                        <button class="quiz-option" data-correct="false">Александр I</button>
                        <button class="quiz-option" data-correct="false">Николай II</button>
                    </div>
                    <div class="quiz-feedback mt-3"></div>
                    <button class="quiz-next-btn btn btn-primary mt-3" style="display: none;">Следующий вопрос</button>
                </div>

                <div class="quiz-card" data-quiz-id="3" style="display: none;">
                    <div class="quiz-progress mb-3">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">3/3</div>
                        </div>
                    </div>
                    <h3 class="quiz-question">В каком году состоялась Куликовская битва?</h3>
                    <div class="quiz-options">
                        <button class="quiz-option" data-correct="false">1242 год</button>
                        <button class="quiz-option" data-correct="false">1340 год</button>
                        <button class="quiz-option" data-correct="true">1380 год</button>
                        <button class="quiz-option" data-correct="false">1480 год</button>
                    </div>
                    <div class="quiz-feedback mt-3"></div>
                    <button class="quiz-next-btn btn btn-primary mt-3" style="display: none;">Завершить викторину</button>
                </div>

                <div id="quiz-results" class="text-center p-4" style="display: none;">
                    <h3>Результаты викторины</h3>
                    <div class="score-display my-4">
                        <div class="score-circle">
                            <span class="score-number">0</span>
                            <span class="score-percent">%</span>
                        </div>
                    </div>
                    <p class="score-message"></p>
                    <button class="btn btn-primary restart-quiz">Пройти викторину заново</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Цитаты великих историков -->
    <section class="quote-carousel">
        <div class="container">
            <div id="quoteCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="quote-item">
                            <p class="quote-text">"История — это философия в примерах."</p>
                            <p class="quote-author">Фукидид</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="quote-item">
                            <p class="quote-text">"Народ, не знающий своего прошлого, не имеет будущего."</p>
                            <p class="quote-author">М.В. Ломоносов</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="quote-item">
                            <p class="quote-text">"История — сокровищница наших деяний, свидетельница прошлого, пример и поучение для настоящего, предостережение для будущего."</p>
                            <p class="quote-author">Мигель де Сервантес</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#quoteCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#quoteCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </section>

    <!-- Секция достижений -->
    <section class="achievements">
        <div class="container">
            <h2 class="text-center mb-5 text-white">Наши достижения</h2>
            <div class="achievement-container">
                <div class="achievement-item">
                    <i class="fas fa-users achievement-icon"></i>
                    <div class="achievement-number" data-value="10000">0</div>
                    <div class="achievement-text">Активных пользователей</div>
                </div>
                <div class="achievement-item">
                    <i class="fas fa-book-open achievement-icon"></i>
                    <div class="achievement-number" data-value="5000">0</div>
                    <div class="achievement-text">Исторических статей</div>
                </div>
                <div class="achievement-item">
                    <i class="fas fa-globe achievement-icon"></i>
                    <div class="achievement-number" data-value="150">0</div>
                    <div class="achievement-text">Стран в базе данных</div>
                </div>
                <div class="achievement-item">
                    <i class="fas fa-clock achievement-icon"></i>
                    <div class="achievement-number" data-value="3000">0</div>
                    <div class="achievement-text">Лет истории</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Модальные окна -->
    <!-- Модальное окно регистрации -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Регистрация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" action="process_register.php" method="POST">
                        <div class="mb-3">
                            <label for="registerUsername" class="form-label">Имя пользователя</label>
                            <input type="text" class="form-control" id="registerUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="registerPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Подтвердите пароль</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                        </div>
                        <div class="alert alert-danger" id="registerError" style="display: none;"></div>
                        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно входа -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вход</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm" action="process_login.php" method="POST">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <div class="alert alert-danger" id="loginError" style="display: none;"></div>
                        <button type="submit" class="btn btn-primary w-100">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Подвал -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>О проекте</h5>
                    <p>Исторические события - это платформа для изучения и обсуждения важных исторических моментов.</p>
                </div>
                <div class="col-md-4">
                    <h5>Контакты</h5>
                    <p>Email: info@historical-events.ru</p>
                    <p>Телефон: +7 (123) 456-78-90</p>
                </div>
                <div class="col-md-4">
                    <h5>Социальные сети</h5>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-vk"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Анимация появления элементов при прокрутке
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.timeline-item, .interactive-card').forEach(item => {
            observer.observe(item);
        });

        // Обработка фильтров
        document.querySelectorAll('.filter-item select').forEach(select => {
            select.addEventListener('change', () => {
                // Здесь будет логика фильтрации
                console.log('Фильтр изменен:', select.value);
            });
        });

        // Инициализация мини-карты
        const miniMap = L.map('miniMap').setView([20, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(miniMap);

        // Добавление маркеров исторических событий
        const historicalEvents = [
            { lat: 55.7558, lng: 37.6173, title: "Основание Москвы", category: "culture" },
            { lat: 48.8566, lng: 2.3522, title: "Взятие Бастилии", category: "politics" },
            { lat: 51.5074, lng: -0.1278, title: "Великая хартия вольностей", category: "politics" },
            { lat: 41.9028, lng: 12.4964, title: "Основание Рима", category: "culture" },
            { lat: 30.0444, lng: 31.2357, title: "Постройка пирамид", category: "culture" },
            { lat: 35.6762, lng: 139.6503, title: "Бомбардировка Хиросимы", category: "war" },
            { lat: 40.7128, lng: -74.0060, title: "Декларация независимости США", category: "politics" },
            { lat: 52.5200, lng: 13.4050, title: "Падение Берлинской стены", category: "politics" }
        ];

        const categoryColors = {
            war: '#e74c3c',
            science: '#3498db',
            culture: '#2ecc71',
            politics: '#f1c40f'
        };

        historicalEvents.forEach(event => {
            const marker = L.marker([event.lat, event.lng], {
                icon: L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background-color: ${categoryColors[event.category]}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white;"></div>`,
                    iconSize: [20, 20]
                })
            }).addTo(miniMap);

            marker.bindPopup(`<b>${event.title}</b><br>Категория: ${event.category}`);
        });

        // Управление картой
        document.getElementById('zoomIn').addEventListener('click', () => {
            miniMap.zoomIn();
        });

        document.getElementById('zoomOut').addEventListener('click', () => {
            miniMap.zoomOut();
        });

        document.getElementById('resetView').addEventListener('click', () => {
            miniMap.setView([20, 0], 2);
        });

        // Скрытие оверлея при клике
        document.querySelector('.map-overlay').addEventListener('click', function() {
            this.style.display = 'none';
        });

        // Обработка формы регистрации
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const password = formData.get('password');
            const confirmPassword = formData.get('confirm_password');
            
            if (password !== confirmPassword) {
                document.getElementById('registerError').textContent = 'Пароли не совпадают';
                document.getElementById('registerError').style.display = 'block';
                return;
            }
            
            fetch('process_register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index.php';
                } else {
                    document.getElementById('registerError').textContent = data.message;
                    document.getElementById('registerError').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Обработка формы входа
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('process_login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'profile.php';
                } else {
                    document.getElementById('loginError').textContent = data.message;
                    document.getElementById('loginError').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('loginError').textContent = 'Произошла ошибка при входе';
                document.getElementById('loginError').style.display = 'block';
            });
        });

        // Обновленный код для викторины
        document.addEventListener('DOMContentLoaded', function() {
            let currentScore = 0;
            const totalQuestions = document.querySelectorAll('.quiz-card').length;

            function handleQuizOption(option) {
                const quizCard = option.closest('.quiz-card');
                const options = quizCard.querySelectorAll('.quiz-option');
                const feedback = quizCard.querySelector('.quiz-feedback');
                const nextButton = quizCard.querySelector('.quiz-next-btn');
                const isCorrect = option.getAttribute('data-correct') === 'true';

                // Отключаем все опции
                options.forEach(opt => {
                    opt.disabled = true;
                    opt.style.cursor = 'not-allowed';
                });

                // Показываем правильный/неправильный ответ
                option.classList.add(isCorrect ? 'correct' : 'wrong');
                
                // Если ответ неправильный, показываем правильный ответ
                if (!isCorrect) {
                    option.classList.add('shake');
                    options.forEach(opt => {
                        if (opt.getAttribute('data-correct') === 'true') {
                            opt.classList.add('correct');
                        }
                    });
                } else {
                    currentScore++;
                }

                // Показываем сообщение
                feedback.textContent = isCorrect ? 
                    'Правильно! Отличное знание истории!' : 
                    'Неправильно. Попробуйте следующий вопрос!';
                feedback.classList.add(isCorrect ? 'correct' : 'wrong');

                // Показываем кнопку "Следующий вопрос"
                nextButton.style.display = 'block';
            }

            function showResults() {
                const quizCards = document.querySelectorAll('.quiz-card');
                const resultsDiv = document.getElementById('quiz-results');
                const scoreNumber = resultsDiv.querySelector('.score-number');
                const scoreMessage = resultsDiv.querySelector('.score-message');
                
                // Скрываем все карточки с вопросами
                quizCards.forEach(card => card.style.display = 'none');
                
                // Показываем результаты
                resultsDiv.style.display = 'block';
                
                // Вычисляем процент правильных ответов
                const percentage = Math.round((currentScore / totalQuestions) * 100);
                
                // Анимируем счетчик
                let current = 0;
                const timer = setInterval(() => {
                    if (current >= percentage) {
                        clearInterval(timer);
                    } else {
                        current++;
                        scoreNumber.textContent = current;
                    }
                }, 20);

                // Устанавливаем сообщение в зависимости от результата
                if (percentage === 100) {
                    scoreMessage.textContent = 'Отлично! Вы настоящий знаток истории!';
                } else if (percentage >= 70) {
                    scoreMessage.textContent = 'Хороший результат! Продолжайте изучать историю!';
                } else {
                    scoreMessage.textContent = 'Неплохо! Но есть куда расти. Попробуйте еще раз!';
                }
            }

            function restartQuiz() {
                currentScore = 0;
                const resultsDiv = document.getElementById('quiz-results');
                const quizCards = document.querySelectorAll('.quiz-card');
                
                // Скрываем результаты
                resultsDiv.style.display = 'none';
                
                // Сбрасываем все карточки
                quizCards.forEach((card, index) => {
                    card.style.display = index === 0 ? 'block' : 'none';
                    
                    // Сбрасываем опции
                    card.querySelectorAll('.quiz-option').forEach(option => {
                        option.classList.remove('correct', 'wrong', 'shake');
                        option.disabled = false;
                        option.style.cursor = 'pointer';
                    });
                    
                    // Сбрасываем feedback
                    const feedback = card.querySelector('.quiz-feedback');
                    feedback.textContent = '';
                    feedback.classList.remove('correct', 'wrong');
                    
                    // Скрываем кнопку "Следующий"
                    card.querySelector('.quiz-next-btn').style.display = 'none';
                });
            }

            // Обработчики событий для опций викторины
            document.querySelectorAll('.quiz-option').forEach(option => {
                option.addEventListener('click', () => handleQuizOption(option));
            });

            // Обработчики для кнопок "Следующий вопрос"
            document.querySelectorAll('.quiz-next-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const currentCard = this.closest('.quiz-card');
                    const nextCard = currentCard.nextElementSibling;
                    
                    currentCard.style.display = 'none';
                    
                    if (nextCard && nextCard.classList.contains('quiz-card')) {
                        nextCard.style.display = 'block';
                    } else {
                        showResults();
                    }
                });
            });

            // Обработчик для кнопки "Пройти викторину заново"
            document.querySelector('.restart-quiz').addEventListener('click', restartQuiz);
        });

        // Улучшенная анимация счетчиков
        function animateValue(element, start, end, duration) {
            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= end) {
                    element.textContent = end;
                    clearInterval(timer);
                    element.classList.add('counted');
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 16);
        }

        // Наблюдатель для анимации статистики
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const statItem = entry.target;
                    const numberElement = statItem.querySelector('.stat-number');
                    const targetValue = parseInt(numberElement.getAttribute('data-value'));
                    
                    // Анимация числа
                    animateValue(numberElement, 0, targetValue, 2000);
                    
                    // Анимация прогресс-бара
                    statItem.classList.add('revealed');
                    
                    statsObserver.unobserve(statItem);
                }
            });
        }, {
            threshold: 0.5
        });

        // Наблюдение за элементами статистики
        document.querySelectorAll('.stat-item').forEach(item => {
            statsObserver.observe(item);
        });

        // Добавление эффекта при наведении
        document.querySelectorAll('.stat-item').forEach(item => {
            item.addEventListener('mouseenter', () => {
                const icon = item.querySelector('.stat-icon');
                icon.style.transform = 'scale(1.2) rotate(10deg)';
            });

            item.addEventListener('mouseleave', () => {
                const icon = item.querySelector('.stat-icon');
                icon.style.transform = 'scale(1) rotate(0deg)';
            });
        });

        // Анимация для достижений
        const achievementObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const numberElement = entry.target.querySelector('.achievement-number');
                    const targetValue = parseInt(numberElement.getAttribute('data-value'));
                    animateValue(numberElement, 0, targetValue, 2000);
                    achievementObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.achievement-item').forEach(item => {
            achievementObserver.observe(item);
        });

        // Анимация для временной шкалы
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.3 });

        document.querySelectorAll('.timeline-event').forEach(event => {
            timelineObserver.observe(event);
        });

        // Анимация для карточек событий
        document.querySelectorAll('.event-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-10px) rotate(2deg)';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) rotate(0)';
            });
        });

        // Добавляем обработчик для плавающей навигации
        document.querySelector('.floating-nav-toggle').addEventListener('click', function() {
            document.querySelector('.floating-nav-menu').classList.toggle('active');
        });

        // Инициализация тултипов
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Плавная прокрутка к секциям
        document.querySelectorAll('.floating-nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.getAttribute('data-section');
                const element = document.querySelector(`section.${section}-section`) || 
                               document.querySelector(`section.${section}-preview`) ||
                               document.querySelector(`section.${section}`);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth' });
                }
                document.querySelector('.floating-nav-menu').classList.remove('active');
            });
        });

        // Добавляем эффект при наведении на быстрые ссылки
        document.querySelectorAll('.quick-link-item').forEach(link => {
            link.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.1) rotate(10deg)';
            });
            
            link.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1) rotate(0)';
            });
        });
    </script>
</body>
</html>
