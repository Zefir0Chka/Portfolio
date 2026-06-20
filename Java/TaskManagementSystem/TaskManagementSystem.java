import java.util.*;
import java.io.*;
import java.time.*;

class Task implements Serializable {
    String title;
    String description;
    String status;
    LocalDate dueDate;
    String priority;
    String assignedTo;
    List<String> comments;
    LocalDate createdAt;
    LocalDate completedAt;

    Task(String t, String d, LocalDate due, String p, String assignee) {
        title = t;
        description = d;
        status = "Новая";
        dueDate = due;
        priority = p;
        assignedTo = assignee;
        comments = new ArrayList<>();
        createdAt = LocalDate.now();
        completedAt = null;
    }

    void updateStatus(String newStatus) {
        status = newStatus;
        if (newStatus.equals("Завершена")) {
            completedAt = LocalDate.now();
        }
    }

    void addComment(String comment) {
        comments.add(LocalDate.now() + ": " + comment);
    }

    void updatePriority(String newPriority) {
        priority = newPriority;
    }

    void reassign(String newAssignee) {
        assignedTo = newAssignee;
    }

    public String toString() {
        StringBuilder sb = new StringBuilder();
        sb.append("\nЗадача: ").append(title);
        sb.append("\nОписание: ").append(description);
        sb.append("\nСтатус: ").append(status);
        sb.append("\nСрок: ").append(dueDate);
        sb.append("\nПриоритет: ").append(priority);
        sb.append("\nИсполнитель: ").append(assignedTo);
        sb.append("\nСоздана: ").append(createdAt);
        if (completedAt != null) {
            sb.append("\nЗавершена: ").append(completedAt);
        }
        if (!comments.isEmpty()) {
            sb.append("\nКомментарии:");
            for (String comment : comments) {
                sb.append("\n- ").append(comment);
            }
        }
        return sb.toString();
    }
}

class Project implements Serializable {
    String name;
    String description;
    List<Task> tasks;
    List<String> teamMembers;
    LocalDate startDate;
    LocalDate endDate;
    String status;

    Project(String n, String d, LocalDate start, LocalDate end) {
        name = n;
        description = d;
        tasks = new ArrayList<>();
        teamMembers = new ArrayList<>();
        startDate = start;
        endDate = end;
        status = "Активный";
    }

    void addTask(Task task) {
        tasks.add(task);
    }

    void addTeamMember(String member) {
        if (!teamMembers.contains(member)) {
            teamMembers.add(member);
        }
    }

    void removeTeamMember(String member) {
        teamMembers.remove(member);
    }

    void updateStatus(String newStatus) {
        status = newStatus;
    }

    double getProgress() {
        if (tasks.isEmpty()) return 0;
        int completed = 0;
        for (Task task : tasks) {
            if (task.status.equals("Завершена")) {
                completed++;
            }
        }
        return (double) completed / tasks.size() * 100;
    }

    public String toString() {
        StringBuilder sb = new StringBuilder();
        sb.append("\nПроект: ").append(name);
        sb.append("\nОписание: ").append(description);
        sb.append("\nСтатус: ").append(status);
        sb.append("\nДаты: ").append(startDate).append(" - ").append(endDate);
        sb.append("\nПрогресс: ").append(String.format("%.1f", getProgress())).append("%");
        sb.append("\nКоманда: ").append(String.join(", ", teamMembers));
        sb.append("\nЗадачи: ").append(tasks.size());
        return sb.toString();
    }
}

class TaskManager implements Serializable {
    List<Project> projects;
    Scanner scanner;
    private static final String SAVE_FILE = "task_data.ser";

    TaskManager() {
        projects = new ArrayList<>();
        scanner = new Scanner(System.in);
        loadData();
    }

    private void loadData() {
        try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream(SAVE_FILE))) {
            TaskManager loaded = (TaskManager) ois.readObject();
            this.projects = loaded.projects;
        } catch (Exception e) {
            System.out.println("Не удалось загрузить сохраненные данные. Начинаем с нуля.");
        }
    }

    private void saveData() {
        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(SAVE_FILE))) {
            oos.writeObject(this);
        } catch (Exception e) {
            System.out.println("Ошибка при сохранении данных!");
        }
    }

    void createProject() {
        try {
            System.out.println("Введите название проекта:");
            String name = scanner.nextLine();
            
            System.out.println("Введите описание проекта:");
            String description = scanner.nextLine();
            
            System.out.println("Введите дату начала (ГГГГ-ММ-ДД):");
            LocalDate start = LocalDate.parse(scanner.nextLine());
            
            System.out.println("Введите дату окончания (ГГГГ-ММ-ДД):");
            LocalDate end = LocalDate.parse(scanner.nextLine());
            
            Project project = new Project(name, description, start, end);
            projects.add(project);
            System.out.println("Проект создан!");
            saveData();
        } catch (Exception e) {
            System.out.println("Ошибка! Проверьте правильность ввода даты.");
        }
    }

    void addTask() {
        if (projects.isEmpty()) {
            System.out.println("Нет доступных проектов!");
            return;
        }

        showProjects();
        System.out.println("Введите номер проекта для добавления задачи:");
        try {
            int projectIndex = Integer.parseInt(scanner.nextLine()) - 1;
            if (projectIndex >= 0 && projectIndex < projects.size()) {
                Project project = projects.get(projectIndex);
                
                System.out.println("Введите название задачи:");
                String title = scanner.nextLine();
                
                System.out.println("Введите описание задачи:");
                String description = scanner.nextLine();
                
                System.out.println("Введите срок выполнения (ГГГГ-ММ-ДД):");
                LocalDate dueDate = LocalDate.parse(scanner.nextLine());
                
                System.out.println("Введите приоритет (Высокий/Средний/Низкий):");
                String priority = scanner.nextLine();
                
                System.out.println("Введите исполнителя:");
                String assignee = scanner.nextLine();
                
                Task task = new Task(title, description, dueDate, priority, assignee);
                project.addTask(task);
                project.addTeamMember(assignee);
                
                System.out.println("Задача добавлена!");
                saveData();
            } else {
                System.out.println("Неверный номер проекта!");
            }
        } catch (Exception e) {
            System.out.println("Ошибка! Проверьте правильность ввода данных.");
        }
    }

    void updateTaskStatus() {
        if (projects.isEmpty()) {
            System.out.println("Нет доступных проектов!");
            return;
        }

        showProjects();
        System.out.println("Введите номер проекта:");
        try {
            int projectIndex = Integer.parseInt(scanner.nextLine()) - 1;
            if (projectIndex >= 0 && projectIndex < projects.size()) {
                Project project = projects.get(projectIndex);
                showTasks(project);
                
                System.out.println("Введите номер задачи:");
                int taskIndex = Integer.parseInt(scanner.nextLine()) - 1;
                if (taskIndex >= 0 && taskIndex < project.tasks.size()) {
                    Task task = project.tasks.get(taskIndex);
                    
                    System.out.println("Текущий статус: " + task.status);
                    System.out.println("Введите новый статус (Новая/В работе/На проверке/Завершена):");
                    String newStatus = scanner.nextLine();
                    
                    task.updateStatus(newStatus);
                    System.out.println("Статус обновлен!");
                    saveData();
                } else {
                    System.out.println("Неверный номер задачи!");
                }
            } else {
                System.out.println("Неверный номер проекта!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void addComment() {
        if (projects.isEmpty()) {
            System.out.println("Нет доступных проектов!");
            return;
        }

        showProjects();
        System.out.println("Введите номер проекта:");
        try {
            int projectIndex = Integer.parseInt(scanner.nextLine()) - 1;
            if (projectIndex >= 0 && projectIndex < projects.size()) {
                Project project = projects.get(projectIndex);
                showTasks(project);
                
                System.out.println("Введите номер задачи:");
                int taskIndex = Integer.parseInt(scanner.nextLine()) - 1;
                if (taskIndex >= 0 && taskIndex < project.tasks.size()) {
                    Task task = project.tasks.get(taskIndex);
                    
                    System.out.println("Введите комментарий:");
                    String comment = scanner.nextLine();
                    
                    task.addComment(comment);
                    System.out.println("Комментарий добавлен!");
                    saveData();
                } else {
                    System.out.println("Неверный номер задачи!");
                }
            } else {
                System.out.println("Неверный номер проекта!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void showProjects() {
        if (projects.isEmpty()) {
            System.out.println("Нет доступных проектов!");
            return;
        }

        System.out.println("\nСписок проектов:");
        for (int i = 0; i < projects.size(); i++) {
            System.out.println((i + 1) + ". " + projects.get(i).name + 
                             " (" + projects.get(i).status + ")");
        }
    }

    void showTasks(Project project) {
        if (project.tasks.isEmpty()) {
            System.out.println("В проекте нет задач!");
            return;
        }

        System.out.println("\nЗадачи проекта " + project.name + ":");
        for (int i = 0; i < project.tasks.size(); i++) {
            Task task = project.tasks.get(i);
            System.out.println((i + 1) + ". " + task.title + 
                             " (" + task.status + ", " + task.priority + ")");
        }
    }

    void showProjectDetails() {
        if (projects.isEmpty()) {
            System.out.println("Нет доступных проектов!");
            return;
        }

        showProjects();
        System.out.println("Введите номер проекта для просмотра деталей:");
        try {
            int index = Integer.parseInt(scanner.nextLine()) - 1;
            if (index >= 0 && index < projects.size()) {
                System.out.println(projects.get(index));
            } else {
                System.out.println("Неверный номер проекта!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void showTaskDetails() {
        if (projects.isEmpty()) {
            System.out.println("Нет доступных проектов!");
            return;
        }

        showProjects();
        System.out.println("Введите номер проекта:");
        try {
            int projectIndex = Integer.parseInt(scanner.nextLine()) - 1;
            if (projectIndex >= 0 && projectIndex < projects.size()) {
                Project project = projects.get(projectIndex);
                showTasks(project);
                
                System.out.println("Введите номер задачи:");
                int taskIndex = Integer.parseInt(scanner.nextLine()) - 1;
                if (taskIndex >= 0 && taskIndex < project.tasks.size()) {
                    System.out.println(project.tasks.get(taskIndex));
                } else {
                    System.out.println("Неверный номер задачи!");
                }
            } else {
                System.out.println("Неверный номер проекта!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void showStatistics() {
        if (projects.isEmpty()) {
            System.out.println("Нет доступных проектов!");
            return;
        }

        int totalProjects = projects.size();
        int activeProjects = 0;
        int completedProjects = 0;
        int totalTasks = 0;
        int completedTasks = 0;
        Map<String, Integer> priorityCount = new HashMap<>();
        Set<String> teamMembers = new HashSet<>();

        for (Project project : projects) {
            if (project.status.equals("Активный")) {
                activeProjects++;
            } else if (project.status.equals("Завершен")) {
                completedProjects++;
            }
            
            totalTasks += project.tasks.size();
            for (Task task : project.tasks) {
                if (task.status.equals("Завершена")) {
                    completedTasks++;
                }
                priorityCount.put(task.priority, 
                    priorityCount.getOrDefault(task.priority, 0) + 1);
                teamMembers.add(task.assignedTo);
            }
        }

        System.out.println("\nСтатистика системы:");
        System.out.println("Всего проектов: " + totalProjects);
        System.out.println("Активных проектов: " + activeProjects);
        System.out.println("Завершенных проектов: " + completedProjects);
        System.out.println("Всего задач: " + totalTasks);
        System.out.println("Завершенных задач: " + completedTasks);
        System.out.println("Уникальных исполнителей: " + teamMembers.size());
        
        System.out.println("\nРаспределение задач по приоритетам:");
        priorityCount.forEach((priority, count) -> 
            System.out.println(priority + ": " + count + " задач"));
    }

    void showMenu() {
        System.out.println("\n=== Система управления задачами ===");
        System.out.println("1. Создать проект");
        System.out.println("2. Добавить задачу");
        System.out.println("3. Обновить статус задачи");
        System.out.println("4. Добавить комментарий к задаче");
        System.out.println("5. Показать список проектов");
        System.out.println("6. Показать детали проекта");
        System.out.println("7. Показать детали задачи");
        System.out.println("8. Показать статистику");
        System.out.println("9. Выход");
        System.out.print("Выберите пункт меню: ");
    }

    void clearScreen() {
        try {
            if (System.getProperty("os.name").contains("Windows")) {
                new ProcessBuilder("cmd", "/c", "cls").inheritIO().start().waitFor();
            } else {
                System.out.print("\033[H\033[2J");
                System.out.flush();
            }
        } catch (Exception e) {
            System.out.println("\n".repeat(50));
        }
    }

    void run() {
        while (true) {
            clearScreen();
            
            showMenu();
            try {
                int choice = Integer.parseInt(scanner.nextLine());
                
                switch (choice) {
                    case 1:
                        createProject();
                        break;
                    case 2:
                        addTask();
                        break;
                    case 3:
                        updateTaskStatus();
                        break;
                    case 4:
                        addComment();
                        break;
                    case 5:
                        showProjects();
                        break;
                    case 6:
                        showProjectDetails();
                        break;
                    case 7:
                        showTaskDetails();
                        break;
                    case 8:
                        showStatistics();
                        break;
                    case 9:
                        saveData();
                        return;
                    default:
                        System.out.println("Неверный выбор!");
                }
            } catch (NumberFormatException e) {
                System.out.println("Ошибка! Введите число от 1 до 9.");
            }
            
            System.out.println("\nНажмите Enter для продолжения...");
            scanner.nextLine();
        }
    }
}

public class Main {
    public static void main(String[] args) {
        TaskManager manager = new TaskManager();
        manager.run();
    }
} 