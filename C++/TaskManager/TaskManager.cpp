#include <iostream>
#include <vector>
#include <string>
#include <fstream>
#include <ctime>
#include <algorithm>
#include <iomanip>
#include <windows.h>
#include <map>

#define RESET   "\033[0m"
#define RED     "\033[31m"
#define GREEN   "\033[32m"
#define YELLOW  "\033[33m"
#define BLUE    "\033[34m"
#define MAGENTA "\033[35m"
#define CYAN    "\033[36m"

class Task {
public:
    std::string description;
    std::string deadline;
    int priority; 
    bool completed;
    std::string category;
    std::string notes;
    time_t created_at;

    Task(const std::string& desc, const std::string& dl, int prio, const std::string& cat = "General")
        : description(desc), deadline(dl), priority(prio), completed(false), 
          category(cat), notes(""), created_at(time(nullptr)) {}
};

class TaskManager {
private:
    std::vector<Task> tasks;
    const std::string filename = "tasks.txt";
    std::map<std::string, int> categoryStats;

    void saveTasks() {
        std::ofstream file(filename);
        if (file.is_open()) {
            for (const auto& task : tasks) {
                file << task.description << "\n"
                     << task.deadline << "\n"
                     << task.priority << "\n"
                     << task.completed << "\n"
                     << task.category << "\n"
                     << task.notes << "\n"
                     << task.created_at << "\n";
            }
        }
    }

    void loadTasks() {
        std::ifstream file(filename);
        if (file.is_open()) {
            tasks.clear();
            std::string desc, deadline, category, notes;
            int prio;
            bool completed;
            time_t created_at;
            while (std::getline(file, desc) &&
                   std::getline(file, deadline) &&
                   file >> prio >> completed &&
                   file.ignore() &&
                   std::getline(file, category) &&
                   std::getline(file, notes) &&
                   file >> created_at) {
                tasks.emplace_back(desc, deadline, prio, category);
                tasks.back().completed = completed;
                tasks.back().notes = notes;
                tasks.back().created_at = created_at;
                file.ignore();
            }
        }
        updateCategoryStats();
    }

    void updateCategoryStats() {
        categoryStats.clear();
        for (const auto& task : tasks) {
            categoryStats[task.category]++;
        }
    }

    std::string getCurrentDate() {
        time_t now = time(nullptr);
        tm* localTime = localtime(&now);
        char buffer[11];
        strftime(buffer, sizeof(buffer), "%Y-%m-%d", localTime);
        return std::string(buffer);
    }

    std::string formatDate(const std::string& date) {
        if (date == "today") return getCurrentDate();
        return date;
    }

    void printTask(const Task& task, int index) {
        std::string priorityColor;
        switch (task.priority) {
            case 1: priorityColor = RED; break;
            case 2: priorityColor = YELLOW; break;
            case 3: priorityColor = GREEN; break;
            default: priorityColor = RESET;
        }

        std::cout << std::setw(3) << index + 1 << ". "
                  << (task.completed ? GREEN "[X]" RESET : RED "[ ]" RESET) << " "
                  << priorityColor << "Priority: " << std::string(task.priority, '!') << RESET << " "
                  << BLUE << "Category: " << task.category << RESET << "\n"
                  << "    Deadline: " << (isOverdue(task) ? RED : CYAN) << task.deadline << RESET << "\n"
                  << "    " << task.description << "\n";
        if (!task.notes.empty()) {
            std::cout << "    Notes: " << MAGENTA << task.notes << RESET << "\n";
        }
    }

    bool isOverdue(const Task& task) {
        if (task.completed) return false;
        time_t now = time(nullptr);
        tm* localTime = localtime(&now);
        char currentDate[11];
        strftime(currentDate, sizeof(currentDate), "%Y-%m-%d", localTime);
        return task.deadline < currentDate;
    }

    void printStatistics() {
        std::cout << "\n=== Task Statistics ===\n";
        std::cout << "Total tasks: " << tasks.size() << "\n";
        
        int completed = std::count_if(tasks.begin(), tasks.end(), 
            [](const Task& t) { return t.completed; });
        std::cout << "Completed tasks: " << completed << "\n";
        std::cout << "Completion rate: " 
                  << std::fixed << std::setprecision(1)
                  << (tasks.empty() ? 0 : (completed * 100.0 / tasks.size()))
                  << "%\n";

        std::cout << "\nTasks by category:\n";
        for (const auto& stat : categoryStats) {
            std::cout << "  " << stat.first << ": " << stat.second << "\n";
        }

        int overdue = std::count_if(tasks.begin(), tasks.end(),
            [this](const Task& t) { return isOverdue(t); });
        std::cout << "\nOverdue tasks: " << overdue << "\n";
    }

public:
    TaskManager() {
        loadTasks();
    }

    ~TaskManager() {
        saveTasks();
    }

    void addTask() {
        std::string desc, deadline, category, notes;
        int priority;

        std::cout << "Enter task description: ";
        std::cin.ignore();
        std::getline(std::cin, desc);

        std::cout << "Enter deadline (YYYY-MM-DD) or 'today': ";
        std::cin >> deadline;
        deadline = formatDate(deadline);

        std::cout << "Enter category (default: General): ";
        std::cin.ignore();
        std::getline(std::cin, category);
        if (category.empty()) category = "General";

        std::cout << "Enter priority (1-3, 1 is highest): ";
        std::cin >> priority;
        priority = std::max(1, std::min(3, priority));

        std::cout << "Enter notes (optional): ";
        std::cin.ignore();
        std::getline(std::cin, notes);

        tasks.emplace_back(desc, deadline, priority, category);
        tasks.back().notes = notes;
        updateCategoryStats();
        std::cout << GREEN << "Task added successfully!" << RESET << "\n";
    }

    void listTasks(const std::string& filter = "", const std::string& sortBy = "priority") {
        if (tasks.empty()) {
            std::cout << "No tasks found.\n";
            return;
        }

        std::vector<Task> filteredTasks = tasks;
        

        if (!filter.empty()) {
            filteredTasks.erase(
                std::remove_if(filteredTasks.begin(), filteredTasks.end(),
                    [&filter](const Task& t) {
                        return t.description.find(filter) == std::string::npos &&
                               t.category.find(filter) == std::string::npos &&
                               t.notes.find(filter) == std::string::npos;
                    }),
                filteredTasks.end()
            );
        }

        if (sortBy == "priority") {
            std::sort(filteredTasks.begin(), filteredTasks.end(),
                [](const Task& a, const Task& b) {
                    if (a.priority != b.priority)
                        return a.priority < b.priority;
                    return a.deadline < b.deadline;
                });
        } else if (sortBy == "deadline") {
            std::sort(filteredTasks.begin(), filteredTasks.end(),
                [](const Task& a, const Task& b) {
                    return a.deadline < b.deadline;
                });
        } else if (sortBy == "category") {
            std::sort(filteredTasks.begin(), filteredTasks.end(),
                [](const Task& a, const Task& b) {
                    return a.category < b.category;
                });
        }

        std::cout << "\n=== Your Tasks ===\n";
        for (size_t i = 0; i < filteredTasks.size(); ++i) {
            printTask(filteredTasks[i], i);
        }
    }

    void editTask() {
        if (tasks.empty()) {
            std::cout << "No tasks to edit.\n";
            return;
        }

        listTasks();
        std::cout << "Enter task number to edit: ";
        int index;
        std::cin >> index;
        index--;

        if (index >= 0 && index < static_cast<int>(tasks.size())) {
            std::string desc, deadline, category, notes;
            int priority;

            std::cout << "Enter new description (press Enter to keep current): ";
            std::cin.ignore();
            std::getline(std::cin, desc);
            if (!desc.empty()) tasks[index].description = desc;

            std::cout << "Enter new deadline (YYYY-MM-DD or 'today', press Enter to keep current): ";
            std::getline(std::cin, deadline);
            if (!deadline.empty()) tasks[index].deadline = formatDate(deadline);

            std::cout << "Enter new category (press Enter to keep current): ";
            std::getline(std::cin, category);
            if (!category.empty()) tasks[index].category = category;

            std::cout << "Enter new priority (1-3, press Enter to keep current): ";
            std::string prioStr;
            std::getline(std::cin, prioStr);
            if (!prioStr.empty()) {
                priority = std::stoi(prioStr);
                tasks[index].priority = std::max(1, std::min(3, priority));
            }

            std::cout << "Enter new notes (press Enter to keep current): ";
            std::getline(std::cin, notes);
            if (!notes.empty()) tasks[index].notes = notes;

            updateCategoryStats();
            std::cout << GREEN << "Task updated successfully!" << RESET << "\n";
        } else {
            std::cout << RED << "Invalid task number." << RESET << "\n";
        }
    }

    void markCompleted() {
        if (tasks.empty()) {
            std::cout << "No tasks to mark.\n";
            return;
        }

        listTasks();
        std::cout << "Enter task number to mark as completed: ";
        int index;
        std::cin >> index;
        index--;

        if (index >= 0 && index < static_cast<int>(tasks.size())) {
            tasks[index].completed = true;
            std::cout << GREEN << "Task marked as completed!" << RESET << "\n";
        } else {
            std::cout << RED << "Invalid task number." << RESET << "\n";
        }
    }

    void deleteTask() {
        if (tasks.empty()) {
            std::cout << "No tasks to delete.\n";
            return;
        }

        listTasks();
        std::cout << "Enter task number to delete: ";
        int index;
        std::cin >> index;
        index--;

        if (index >= 0 && index < static_cast<int>(tasks.size())) {
            tasks.erase(tasks.begin() + index);
            updateCategoryStats();
            std::cout << GREEN << "Task deleted successfully!" << RESET << "\n";
        } else {
            std::cout << RED << "Invalid task number." << RESET << "\n";
        }
    }

    void searchTasks() {
        std::string query;
        std::cout << "Enter search query: ";
        std::cin.ignore();
        std::getline(std::cin, query);
        listTasks(query);
    }

    void showMenu() {
        std::cout << "\n=== Task Manager ===\n"
                  << "1. Add new task\n"
                  << "2. List all tasks\n"
                  << "3. Search tasks\n"
                  << "4. Edit task\n"
                  << "5. Mark task as completed\n"
                  << "6. Delete task\n"
                  << "7. Show statistics\n"
                  << "8. Exit\n"
                  << "Choose an option: ";
    }
};

int main() {
    
    HANDLE hConsole = GetStdHandle(STD_OUTPUT_HANDLE);
    DWORD mode = 0;
    GetConsoleMode(hConsole, &mode);
    SetConsoleMode(hConsole, mode | ENABLE_VIRTUAL_TERMINAL_PROCESSING);

    TaskManager manager;
    int choice;

    while (true) {
        manager.showMenu();
        std::cin >> choice;

        switch (choice) {
            case 1:
                manager.addTask();
                break;
            case 2:
                manager.listTasks();
                break;
            case 3:
                manager.searchTasks();
                break;
            case 4:
                manager.editTask();
                break;
            case 5:
                manager.markCompleted();
                break;
            case 6:
                manager.deleteTask();
                break;
            case 7:
                manager.printStatistics();
                break;
            case 8:
                return 0;
            default:
                std::cout << RED << "Invalid option. Please try again." << RESET << "\n";
        }
    }

    return 0;
} 