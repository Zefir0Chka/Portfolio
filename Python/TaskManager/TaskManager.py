import json
import os
from datetime import datetime
from typing import List, Dict, Optional

class Task:
    def __init__(self, title: str, description: str = "", priority: int = 1, 
                 deadline: Optional[str] = None, completed: bool = False):
        self.title = title
        self.description = description
        self.priority = priority
        self.deadline = deadline
        self.completed = completed
        self.created_at = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        self.completed_at = None

    def to_dict(self) -> Dict:
        return {
            "title": self.title,
            "description": self.description,
            "priority": self.priority,
            "deadline": self.deadline,
            "completed": self.completed,
            "created_at": self.created_at,
            "completed_at": self.completed_at
        }

    @classmethod
    def from_dict(cls, data: Dict) -> 'Task':
        task = cls(
            title=data["title"],
            description=data["description"],
            priority=data["priority"],
            deadline=data["deadline"],
            completed=data["completed"]
        )
        task.created_at = data["created_at"]
        task.completed_at = data["completed_at"]
        return task

    def __str__(self) -> str:
        status = "✓" if self.completed else "✗"
        priority_str = "★" * self.priority
        deadline_str = f" | Дедлайн: {self.deadline}" if self.deadline else ""
        return f"{status} {priority_str} {self.title}{deadline_str}"

class TaskManager:
    def __init__(self, filename: str = "tasks.json"):
        self.filename = filename
        self.tasks: List[Task] = []
        self.load_tasks()

    def load_tasks(self) -> None:
        if os.path.exists(self.filename):
            try:
                with open(self.filename, 'r', encoding='utf-8') as f:
                    data = json.load(f)
                    self.tasks = [Task.from_dict(task_data) for task_data in data]
            except Exception as e:
                print(f"Ошибка при загрузке задач: {e}")
                self.tasks = []

    def save_tasks(self) -> None:
        try:
            with open(self.filename, 'w', encoding='utf-8') as f:
                json.dump([task.to_dict() for task in self.tasks], f, 
                         ensure_ascii=False, indent=2)
        except Exception as e:
            print(f"Ошибка при сохранении задач: {e}")

    def add_task(self) -> None:
        print("\n=== Добавление новой задачи ===")
        title = input("Введите название задачи: ").strip()
        if not title:
            print("Название задачи не может быть пустым!")
            return

        description = input("Введите описание задачи (необязательно): ").strip()
        
        while True:
            try:
                priority = int(input("Введите приоритет (1-5): ").strip())
                if 1 <= priority <= 5:
                    break
                print("Приоритет должен быть от 1 до 5!")
            except ValueError:
                print("Введите число!")

        deadline = input("Введите дедлайн (ГГГГ-ММ-ДД или пусто): ").strip()
        if deadline:
            try:
                datetime.strptime(deadline, "%Y-%m-%d")
            except ValueError:
                print("Неверный формат даты! Используйте ГГГГ-ММ-ДД")
                return

        task = Task(title, description, priority, deadline if deadline else None)
        self.tasks.append(task)
        self.save_tasks()
        print("Задача успешно добавлена!")

    def edit_task(self) -> None:
        if not self.tasks:
            print("Список задач пуст!")
            return

        self.show_tasks()
        try:
            index = int(input("\nВведите номер задачи для редактирования: ")) - 1
            if 0 <= index < len(self.tasks):
                task = self.tasks[index]
                print("\n=== Редактирование задачи ===")
                print("Оставьте поле пустым, чтобы не изменять значение")
                
                title = input(f"Название [{task.title}]: ").strip()
                if title:
                    task.title = title
                
                description = input(f"Описание [{task.description}]: ").strip()
                if description:
                    task.description = description
                
                priority = input(f"Приоритет (1-5) [{task.priority}]: ").strip()
                if priority:
                    try:
                        priority = int(priority)
                        if 1 <= priority <= 5:
                            task.priority = priority
                        else:
                            print("Приоритет должен быть от 1 до 5!")
                    except ValueError:
                        print("Введите число!")
                
                deadline = input(f"Дедлайн (ГГГГ-ММ-ДД) [{task.deadline}]: ").strip()
                if deadline:
                    try:
                        datetime.strptime(deadline, "%Y-%m-%d")
                        task.deadline = deadline
                    except ValueError:
                        print("Неверный формат даты! Используйте ГГГГ-ММ-ДД")
                
                self.save_tasks()
                print("Задача успешно отредактирована!")
            else:
                print("Неверный номер задачи!")
        except ValueError:
            print("Введите число!")

    def delete_task(self) -> None:
        if not self.tasks:
            print("Список задач пуст!")
            return

        self.show_tasks()
        try:
            index = int(input("\nВведите номер задачи для удаления: ")) - 1
            if 0 <= index < len(self.tasks):
                task = self.tasks.pop(index)
                self.save_tasks()
                print(f"Задача '{task.title}' удалена!")
            else:
                print("Неверный номер задачи!")
        except ValueError:
            print("Введите число!")

    def toggle_task(self) -> None:
        if not self.tasks:
            print("Список задач пуст!")
            return

        self.show_tasks()
        try:
            index = int(input("\nВведите номер задачи для изменения статуса: ")) - 1
            if 0 <= index < len(self.tasks):
                task = self.tasks[index]
                task.completed = not task.completed
                task.completed_at = datetime.now().strftime("%Y-%m-%d %H:%M:%S") if task.completed else None
                self.save_tasks()
                status = "выполнена" if task.completed else "не выполнена"
                print(f"Задача '{task.title}' помечена как {status}!")
            else:
                print("Неверный номер задачи!")
        except ValueError:
            print("Введите число!")

    def show_tasks(self, show_all: bool = True) -> None:
        if not self.tasks:
            print("Список задач пуст!")
            return

        tasks_to_show = self.tasks if show_all else [t for t in self.tasks if not t.completed]
        if not tasks_to_show:
            print("Нет задач для отображения!")
            return

        print("\n=== Список задач ===")
        for i, task in enumerate(tasks_to_show, 1):
            print(f"{i}. {task}")
            if task.description:
                print(f"   Описание: {task.description}")
            if task.completed_at:
                print(f"   Выполнено: {task.completed_at}")

    def show_statistics(self) -> None:
        if not self.tasks:
            print("Список задач пуст!")
            return

        total = len(self.tasks)
        completed = sum(1 for t in self.tasks if t.completed)
        pending = total - completed
        
        print("\n=== Статистика ===")
        print(f"Всего задач: {total}")
        print(f"Выполнено: {completed}")
        print(f"Осталось: {pending}")
        
        if total > 0:
            completion_rate = (completed / total) * 100
            print(f"Процент выполнения: {completion_rate:.1f}%")
        
        if pending > 0:
            print("\nЗадачи с высоким приоритетом:")
            high_priority = [t for t in self.tasks if t.priority >= 4 and not t.completed]
            for task in high_priority:
                print(f"- {task}")

    def clear_screen(self) -> None:
        os.system('cls' if os.name == 'nt' else 'clear')

    def show_menu(self) -> None:
        print("\n=== Менеджер задач ===")
        print("1. Добавить задачу")
        print("2. Редактировать задачу")
        print("3. Удалить задачу")
        print("4. Изменить статус задачи")
        print("5. Показать все задачи")
        print("6. Показать активные задачи")
        print("7. Показать статистику")
        print("0. Выход")
        print("Выберите действие: ", end="")

    def run(self) -> None:
        while True:
            self.clear_screen()
            self.show_menu()
            
            try:
                choice = int(input())
                
                if choice == 0:
                    print("До свидания!")
                    break
                elif choice == 1:
                    self.add_task()
                elif choice == 2:
                    self.edit_task()
                elif choice == 3:
                    self.delete_task()
                elif choice == 4:
                    self.toggle_task()
                elif choice == 5:
                    self.show_tasks(show_all=True)
                elif choice == 6:
                    self.show_tasks(show_all=False)
                elif choice == 7:
                    self.show_statistics()
                else:
                    print("Неверный выбор!")
                
                input("\nНажмите Enter для продолжения...")
            except ValueError:
                print("Пожалуйста, введите число!")
                input("\nНажмите Enter для продолжения...")

if __name__ == "__main__":
    manager = TaskManager()
    manager.run() 