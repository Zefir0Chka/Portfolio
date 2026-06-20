package com.example.killmeplease;

import java.util.ArrayList;
import java.util.List;

public class TopicsRepository {
    public static List<TopicItem> createTopics(String language) {
        String[] titles = {
                "Введение", "Переменные и типы данных", "Операторы", "Условия if/else", "Циклы",
                "Массивы", "Строки", "Методы и функции", "Область видимости", "ООП: классы",
                "ООП: инкапсуляция", "ООП: наследование", "ООП: полиморфизм", "Интерфейсы",
                "Коллекции", "Исключения", "Ввод и вывод", "Дата и время", "JSON", "Основы SQL",
                "SQLite", "Архитектура приложения", "Сеть и API", "Асинхронность", "Тестирование",
                "Рефакторинг", "Паттерны проектирования", "Безопасность", "Подготовка к релизу", "Финальный проект"
        };

        List<TopicItem> topics = new ArrayList<>();
        for (int i = 0; i < titles.length; i++) {
            String title = titles[i];
            TaskSpec spec = buildTaskSpec(language, title, i);
            String expected = spec.expectedOutput;
            topics.add(new TopicItem(
                    title,
                    buildTopicContent(language, title),
                    buildTaskText(language, title, expected, spec.requiredSnippets),
                    buildStarterCode(language, title, expected, spec.requiredSnippets),
                    expected,
                    spec.requiredSnippets
                    ,
                    spec.videoUrl,
                    spec.exampleImages
            ));
        }
        return topics;
    }

    private static String buildTopicContent(String language, String topic) {
        // We store this as simple HTML so we can mix bold/color/uppercase in the UI.
        String accent = "#7DD3FC"; // light-cyan accent in space style
        return "<b>ТЕМА:</b> <font color='" + accent + "'>" + escape(topic) + "</font> (" + escape(language) + ")<br><br>" +
                "<b>Что это</b><br>" +
                escape(topic) + " — важная часть изучения " + escape(language) + ". Здесь ты закрепляешь синтаксис и логику, " +
                "которые потом встречаются в реальных проектах.<br><br>" +
                "<b>Зачем изучать</b><br>" +
                "Чтобы писать <b>стабильный</b> код, быстрее находить ошибки и увереннее проходить собеседования.<br><br>" +
                "<b>Где применяется</b><br>" +
                "• Android<br>• API и backend<br>• Автоматизация и данные<br><br>" +
                "<b>После темы ты сможешь</b><br>" +
                "• объяснить ключевые идеи<br>" +
                "• написать минимальный пример<br>" +
                "• применить в мини‑задаче<br><br>" +
                "<font color='#FDE68A'><b>План закрепления:</b></font> теория → примеры → практика → мини‑проект.";
    }

    private static String buildTaskText(String language, String topic, String expected, String[] requiredSnippets) {
        StringBuilder sb = new StringBuilder();
        sb.append("Практическое задание:\n");
        sb.append("Напишите программу на ").append(language).append(", которая выводит строку:\n");
        sb.append("\"").append(expected).append("\"\n\n");
        sb.append("Требования:\n");
        sb.append("1) Используйте стандартный вывод.\n");
        sb.append("2) Строка должна совпадать полностью.\n");
        sb.append("3) Не добавляйте лишних символов.\n");
        if (requiredSnippets != null && requiredSnippets.length > 0) {
            sb.append("4) Используйте тему урока (в коде должны встречаться):\n");
            for (int i = 0; i < requiredSnippets.length; i++) {
                sb.append("- ").append(requiredSnippets[i]).append("\n");
            }
        }
        return sb.toString().trim();
    }

    private static String buildStarterCode(String language, String topic, String expected, String[] requiredSnippets) {
        if ("Python".equals(language)) {
            if ("Циклы".equals(topic)) {
                return "def main():\n" +
                        "    # Используй цикл и выведи строку ровно один раз\n" +
                        "    for i in range(1):\n" +
                        "        print(\"Исправь меня\")\n\n" +
                        "if __name__ == \"__main__\":\n" +
                        "    main()\n";
            }
            if ("Условия if/else".equals(topic)) {
                return "def main():\n" +
                        "    # Используй if/else и выведи строку\n" +
                        "    x = 1\n" +
                        "    if x == 1:\n" +
                        "        print(\"" + expected + "\")\n" +
                        "    else:\n" +
                        "        print(\"ошибка\")\n\n" +
                        "if __name__ == \"__main__\":\n" +
                        "    main()\n";
            }
            if ("Переменные и типы данных".equals(topic)) {
                return "def main():\n" +
                        "    # Создай переменную и выведи строку из неё\n" +
                        "    msg = \"Исправь меня\"\n" +
                        "    print(msg)\n\n" +
                        "if __name__ == \"__main__\":\n" +
                        "    main()\n";
            }
            return "def main():\n" +
                    "    # Выведи строку точно как в задании\n" +
                    "    print(\"Исправь меня\")\n\n" +
                    "if __name__ == \"__main__\":\n" +
                    "    main()\n";
        }
        if ("1C".equals(language)) {
            if ("Циклы".equals(topic)) {
                return "Процедура Выполнить()\n" +
                        "    // Используй цикл Для/Пока и выведи строку ровно один раз\n" +
                        "    Для Сч = 1 По 1 Цикл\n" +
                        "        Сообщить(\"Исправь меня\");\n" +
                        "    КонецЦикла;\n" +
                        "КонецПроцедуры\n";
            }
            if ("Условия if/else".equals(topic)) {
                return "Процедура Выполнить()\n" +
                        "    // Используй Если/Иначе и выведи строку\n" +
                        "    Если 1 = 1 Тогда\n" +
                        "        Сообщить(\"" + expected + "\");\n" +
                        "    Иначе\n" +
                        "        Сообщить(\"ошибка\");\n" +
                        "    КонецЕсли;\n" +
                        "КонецПроцедуры\n";
            }
            return "Процедура Выполнить()\n" +
                    "    Сообщить(\"Исправь меня\");\n" +
                    "КонецПроцедуры\n";
        }
        // Java / Kotlin / C# / C++ (упрощенная заготовка)
        StringBuilder sb = new StringBuilder();
        sb.append("public class Solution {\n");
        sb.append("    public static void main(String[] args) {\n");
        if ("Циклы".equals(topic)) {
            sb.append("        for (int i = 0; i < 1; i++) {\n");
            sb.append("            System.out.println(\"Исправь меня\");\n");
            sb.append("        }\n");
        } else if ("Условия if/else".equals(topic)) {
            sb.append("        int x = 1;\n");
            sb.append("        if (x == 1) {\n");
            sb.append("            System.out.println(\"").append(expected).append("\");\n");
            sb.append("        } else {\n");
            sb.append("            System.out.println(\"ошибка\");\n");
            sb.append("        }\n");
        } else if ("Переменные и типы данных".equals(topic)) {
            sb.append("        String msg = \"Исправь меня\";\n");
            sb.append("        System.out.println(msg);\n");
        } else {
            sb.append("        System.out.println(\"Исправь меня\");\n");
        }
        sb.append("    }\n");
        sb.append("}\n");
        return sb.toString();
    }

    private static TaskSpec buildTaskSpec(String language, String topic, int topicIndex) {
        // Expected output stays simple (we simulate output), but we also require snippets
        // so the task matches the lesson topic.
        String expected = "Тема " + (topicIndex + 1) + " по " + language + " изучена";
        String videoUrl = defaultVideo(language, topic);
        int[] images = defaultImagesForTopic(topic);

        if ("Циклы".equals(topic)) {
            return new TaskSpec(expected, requiredForLoops(language), videoUrl, images);
        }
        if ("Условия if/else".equals(topic)) {
            return new TaskSpec(expected, requiredForIfElse(language), videoUrl, images);
        }
        if ("Переменные и типы данных".equals(topic)) {
            return new TaskSpec(expected, requiredForTypes(language), videoUrl, images);
        }
        if ("Массивы".equals(topic)) {
            return new TaskSpec(expected, requiredForArrays(language), videoUrl, images);
        }
        if ("Методы и функции".equals(topic)) {
            return new TaskSpec(expected, requiredForFunctions(language), videoUrl, images);
        }
        return new TaskSpec(expected, new String[0], videoUrl, images);
    }

    private static String[] requiredForLoops(String language) {
        if ("Python".equals(language)) return new String[]{"for", "range("};
        if ("1C".equals(language)) return new String[]{"Для", "Цикл"};
        return new String[]{"for", "System.out.println"};
    }

    private static String[] requiredForIfElse(String language) {
        if ("Python".equals(language)) return new String[]{"if", "else"};
        if ("1C".equals(language)) return new String[]{"Если", "Иначе"};
        return new String[]{"if", "else"};
    }

    private static String[] requiredForTypes(String language) {
        if ("Python".equals(language)) return new String[]{"msg", "\""};
        if ("1C".equals(language)) return new String[]{"Перем", "Строка"};
        return new String[]{"String"};
    }

    private static String[] requiredForArrays(String language) {
        if ("Python".equals(language)) return new String[]{"[", "]"};
        if ("1C".equals(language)) return new String[]{"Массив", "Новый"};
        return new String[]{"[]"};
    }

    private static String[] requiredForFunctions(String language) {
        if ("Python".equals(language)) return new String[]{"def "};
        if ("1C".equals(language)) return new String[]{"Процедура", "КонецПроцедуры"};
        return new String[]{"static", "main"};
    }

    private static class TaskSpec {
        final String expectedOutput;
        final String[] requiredSnippets;
        final String videoUrl;
        final int[] exampleImages;

        TaskSpec(String expectedOutput, String[] requiredSnippets, String videoUrl, int[] exampleImages) {
            this.expectedOutput = expectedOutput;
            this.requiredSnippets = requiredSnippets == null ? new String[0] : requiredSnippets;
            this.videoUrl = videoUrl;
            this.exampleImages = exampleImages == null ? new int[0] : exampleImages;
        }
    }

    private static String defaultVideo(String language, String topic) {
        // Keep as simple web links; the app will open them in browser/YouTube app.
        if ("Python".equals(language)) {
            if ("Циклы".equals(topic)) return "https://www.youtube.com/results?search_query=python+%D1%86%D0%B8%D0%BA%D0%BB%D1%8B+for+while";
            if ("Переменные и типы данных".equals(topic)) return "https://www.youtube.com/results?search_query=python+%D1%82%D0%B8%D0%BF%D1%8B+%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D1%85";
            if ("Условия if/else".equals(topic)) return "https://www.youtube.com/results?search_query=python+if+else";
        }
        if ("Java".equals(language)) {
            if ("Циклы".equals(topic)) return "https://www.youtube.com/results?search_query=java+for+while+loop";
            if ("Переменные и типы данных".equals(topic)) return "https://www.youtube.com/results?search_query=java+primitive+types+variables";
        }
        return "https://www.youtube.com/results?search_query=" + urlEncode(language + " " + topic);
    }

    private static int[] defaultImagesForTopic(String topic) {
        // Reuse existing vector drawables as "example cards" (no bitmap assets in project).
        if ("Циклы".equals(topic)) {
            return new int[]{R.drawable.decor_star, R.drawable.avatar_rocket, R.drawable.orbit_ring};
        }
        if ("Переменные и типы данных".equals(topic)) {
            return new int[]{R.drawable.ic_coin, R.drawable.avatar_astronaut, R.drawable.decor_star};
        }
        if ("Условия if/else".equals(topic)) {
            return new int[]{R.drawable.ic_sun, R.drawable.ic_black_hole, R.drawable.decor_star};
        }
        return new int[]{R.drawable.decor_star, R.drawable.avatar_planet, R.drawable.avatar_rocket};
    }

    private static String escape(String s) {
        if (s == null) return "";
        return s.replace("&", "&amp;").replace("<", "&lt;").replace(">", "&gt;");
    }

    private static String urlEncode(String s) {
        if (s == null) return "";
        // Minimal encoding for spaces; good enough for YouTube results query.
        return s.trim().replace(" ", "+");
    }
}
