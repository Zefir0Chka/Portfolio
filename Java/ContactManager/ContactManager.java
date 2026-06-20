import java.util.*;
import java.io.*;

class Contact implements Serializable {
    String name;
    String phone;
    String email;
    String address;
    String notes;

    Contact(String n, String p, String e, String a, String nt) {
        name = n;
        phone = p;
        email = e;
        address = a;
        notes = nt;
    }

    public String toString() {
        StringBuilder sb = new StringBuilder();
        sb.append("\nИмя: ").append(name);
        sb.append("\nТелефон: ").append(phone);
        sb.append("\nEmail: ").append(email);
        sb.append("\nАдрес: ").append(address);
        if (!notes.isEmpty()) {
            sb.append("\nЗаметки: ").append(notes);
        }
        return sb.toString();
    }
}

class ContactManager implements Serializable {
    ArrayList<Contact> contacts;
    Scanner scanner;
    private static final String SAVE_FILE = "contacts.ser";

    ContactManager() {
        contacts = new ArrayList<>();
        scanner = new Scanner(System.in);
        loadContacts();
    }

    private void loadContacts() {
        try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream(SAVE_FILE))) {
            ContactManager loaded = (ContactManager) ois.readObject();
            this.contacts = loaded.contacts;
        } catch (Exception e) {
            System.out.println("Не удалось загрузить контакты. Начинаем с нуля.");
        }
    }

    private void saveContacts() {
        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(SAVE_FILE))) {
            oos.writeObject(this);
        } catch (Exception e) {
            System.out.println("Ошибка при сохранении контактов!");
        }
    }

    void addContact() {
        System.out.println("\nДобавление нового контакта:");
        
        System.out.print("Введите имя: ");
        String name = scanner.nextLine();
        
        System.out.print("Введите телефон: ");
        String phone = scanner.nextLine();
        
        System.out.print("Введите email: ");
        String email = scanner.nextLine();
        
        System.out.print("Введите адрес: ");
        String address = scanner.nextLine();
        
        System.out.print("Введите заметки (необязательно): ");
        String notes = scanner.nextLine();
        
        Contact contact = new Contact(name, phone, email, address, notes);
        contacts.add(contact);
        System.out.println("Контакт добавлен!");
        saveContacts();
    }

    void editContact() {
        if (contacts.isEmpty()) {
            System.out.println("Список контактов пуст!");
            return;
        }

        showContacts();
        System.out.print("\nВведите номер контакта для редактирования: ");
        try {
            int index = Integer.parseInt(scanner.nextLine()) - 1;
            if (index >= 0 && index < contacts.size()) {
                Contact contact = contacts.get(index);
                
                System.out.println("\nРедактирование контакта:");
                System.out.println("Текущие данные:");
                System.out.println(contact);
                
                System.out.print("\nВведите новое имя (Enter для пропуска): ");
                String name = scanner.nextLine();
                if (!name.isEmpty()) contact.name = name;
                
                System.out.print("Введите новый телефон (Enter для пропуска): ");
                String phone = scanner.nextLine();
                if (!phone.isEmpty()) contact.phone = phone;
                
                System.out.print("Введите новый email (Enter для пропуска): ");
                String email = scanner.nextLine();
                if (!email.isEmpty()) contact.email = email;
                
                System.out.print("Введите новый адрес (Enter для пропуска): ");
                String address = scanner.nextLine();
                if (!address.isEmpty()) contact.address = address;
                
                System.out.print("Введите новые заметки (Enter для пропуска): ");
                String notes = scanner.nextLine();
                if (!notes.isEmpty()) contact.notes = notes;
                
                System.out.println("Контакт обновлен!");
                saveContacts();
            } else {
                System.out.println("Неверный номер контакта!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void deleteContact() {
        if (contacts.isEmpty()) {
            System.out.println("Список контактов пуст!");
            return;
        }

        showContacts();
        System.out.print("\nВведите номер контакта для удаления: ");
        try {
            int index = Integer.parseInt(scanner.nextLine()) - 1;
            if (index >= 0 && index < contacts.size()) {
                contacts.remove(index);
                System.out.println("Контакт удален!");
                saveContacts();
            } else {
                System.out.println("Неверный номер контакта!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void searchContacts() {
        if (contacts.isEmpty()) {
            System.out.println("Список контактов пуст!");
            return;
        }

        System.out.print("\nВведите текст для поиска: ");
        String searchText = scanner.nextLine().toLowerCase();
        
        boolean found = false;
        for (int i = 0; i < contacts.size(); i++) {
            Contact contact = contacts.get(i);
            if (contact.name.toLowerCase().contains(searchText) ||
                contact.phone.contains(searchText) ||
                contact.email.toLowerCase().contains(searchText) ||
                contact.address.toLowerCase().contains(searchText)) {
                
                System.out.println("\n" + (i + 1) + ". " + contact);
                found = true;
            }
        }
        
        if (!found) {
            System.out.println("Контакты не найдены.");
        }
    }

    void showContacts() {
        if (contacts.isEmpty()) {
            System.out.println("Список контактов пуст!");
            return;
        }

        System.out.println("\nСписок контактов:");
        for (int i = 0; i < contacts.size(); i++) {
            System.out.println((i + 1) + ". " + contacts.get(i).name);
        }
    }

    void showMenu() {
        System.out.println("\n=== Менеджер контактов ===");
        System.out.println("1. Добавить контакт");
        System.out.println("2. Редактировать контакт");
        System.out.println("3. Удалить контакт");
        System.out.println("4. Поиск контактов");
        System.out.println("5. Показать все контакты");
        System.out.println("6. Выход");
        System.out.print("Выберите действие: ");
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
                        addContact();
                        break;
                    case 2:
                        editContact();
                        break;
                    case 3:
                        deleteContact();
                        break;
                    case 4:
                        searchContacts();
                        break;
                    case 5:
                        showContacts();
                        break;
                    case 6:
                        saveContacts();
                        return;
                    default:
                        System.out.println("Неверный выбор!");
                }
            } catch (NumberFormatException e) {
                System.out.println("Ошибка! Введите число от 1 до 6.");
            }
            
            System.out.println("\nНажмите Enter для продолжения...");
            scanner.nextLine();
        }
    }
}

public class Main {
    public static void main(String[] args) {
        ContactManager manager = new ContactManager();
        manager.run();
    }
} 