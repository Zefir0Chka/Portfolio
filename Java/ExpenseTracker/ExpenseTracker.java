import java.util.*;
import java.io.*;
import java.time.*;
import java.text.NumberFormat;

class Expense implements Serializable {
    String description;
    double amount;
    String category;
    LocalDate date;
    String paymentMethod;

    Expense(String d, double a, String c, String pm) {
        description = d;
        amount = a;
        category = c;
        date = LocalDate.now();
        paymentMethod = pm;
    }

    public String toString() {
        NumberFormat nf = NumberFormat.getCurrencyInstance();
        return date + " | " + category + " | " + description + " | " + 
               nf.format(amount) + " | " + paymentMethod;
    }
}

class ExpenseTracker implements Serializable {
    ArrayList<Expense> expenses;
    Scanner scanner;
    private static final String SAVE_FILE = "expenses.ser";
    private static final String[] CATEGORIES = {
        "Еда", "Транспорт", "Жилье", "Развлечения", 
        "Здоровье", "Одежда", "Образование", "Другое"
    };
    private static final String[] PAYMENT_METHODS = {
        "Наличные", "Карта", "Безналичный расчет"
    };

    ExpenseTracker() {
        expenses = new ArrayList<>();
        scanner = new Scanner(System.in);
        loadExpenses();
    }

    private void loadExpenses() {
        try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream(SAVE_FILE))) {
            ExpenseTracker loaded = (ExpenseTracker) ois.readObject();
            this.expenses = loaded.expenses;
        } catch (Exception e) {
            System.out.println("Не удалось загрузить расходы. Начинаем с нуля.");
        }
    }

    private void saveExpenses() {
        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream(SAVE_FILE))) {
            oos.writeObject(this);
        } catch (Exception e) {
            System.out.println("Ошибка при сохранении расходов!");
        }
    }

    void addExpense() {
        try {
            System.out.println("\nДобавление нового расхода:");
            
            System.out.println("\nВыберите категорию:");
            for (int i = 0; i < CATEGORIES.length; i++) {
                System.out.println((i + 1) + ". " + CATEGORIES[i]);
            }
            System.out.print("Введите номер категории: ");
            int categoryIndex = Integer.parseInt(scanner.nextLine()) - 1;
            if (categoryIndex < 0 || categoryIndex >= CATEGORIES.length) {
                System.out.println("Неверный номер категории!");
                return;
            }
            String category = CATEGORIES[categoryIndex];
            
            System.out.print("Введите описание расхода: ");
            String description = scanner.nextLine();
            
            System.out.print("Введите сумму: ");
            double amount = Double.parseDouble(scanner.nextLine());
            
            System.out.println("\nВыберите способ оплаты:");
            for (int i = 0; i < PAYMENT_METHODS.length; i++) {
                System.out.println((i + 1) + ". " + PAYMENT_METHODS[i]);
            }
            System.out.print("Введите номер способа оплаты: ");
            int paymentIndex = Integer.parseInt(scanner.nextLine()) - 1;
            if (paymentIndex < 0 || paymentIndex >= PAYMENT_METHODS.length) {
                System.out.println("Неверный номер способа оплаты!");
                return;
            }
            String paymentMethod = PAYMENT_METHODS[paymentIndex];
            
            Expense expense = new Expense(description, amount, category, paymentMethod);
            expenses.add(expense);
            System.out.println("Расход добавлен!");
            saveExpenses();
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void showExpenses() {
        if (expenses.isEmpty()) {
            System.out.println("Список расходов пуст!");
            return;
        }

        System.out.println("\nСписок расходов:");
        for (int i = 0; i < expenses.size(); i++) {
            System.out.println((i + 1) + ". " + expenses.get(i));
        }
    }

    void showExpensesByCategory() {
        if (expenses.isEmpty()) {
            System.out.println("Список расходов пуст!");
            return;
        }

        Map<String, Double> categoryTotals = new HashMap<>();
        Map<String, Integer> categoryCounts = new HashMap<>();

        for (Expense expense : expenses) {
            categoryTotals.put(expense.category, 
                categoryTotals.getOrDefault(expense.category, 0.0) + expense.amount);
            categoryCounts.put(expense.category, 
                categoryCounts.getOrDefault(expense.category, 0) + 1);
        }

        NumberFormat nf = NumberFormat.getCurrencyInstance();
        System.out.println("\nРасходы по категориям:");
        for (String category : CATEGORIES) {
            double total = categoryTotals.getOrDefault(category, 0.0);
            int count = categoryCounts.getOrDefault(category, 0);
            if (count > 0) {
                System.out.println(category + ": " + nf.format(total) + 
                                 " (" + count + " расходов)");
            }
        }
    }

    void showExpensesByMonth() {
        if (expenses.isEmpty()) {
            System.out.println("Список расходов пуст!");
            return;
        }

        Map<YearMonth, Double> monthlyTotals = new TreeMap<>();
        Map<YearMonth, Integer> monthlyCounts = new HashMap<>();

        for (Expense expense : expenses) {
            YearMonth month = YearMonth.from(expense.date);
            monthlyTotals.put(month, 
                monthlyTotals.getOrDefault(month, 0.0) + expense.amount);
            monthlyCounts.put(month, 
                monthlyCounts.getOrDefault(month, 0) + 1);
        }

        NumberFormat nf = NumberFormat.getCurrencyInstance();
        System.out.println("\nРасходы по месяцам:");
        for (Map.Entry<YearMonth, Double> entry : monthlyTotals.entrySet()) {
            YearMonth month = entry.getKey();
            double total = entry.getValue();
            int count = monthlyCounts.get(month);
            System.out.println(month + ": " + nf.format(total) + 
                             " (" + count + " расходов)");
        }
    }

    void showPaymentMethodStats() {
        if (expenses.isEmpty()) {
            System.out.println("Список расходов пуст!");
            return;
        }

        Map<String, Double> methodTotals = new HashMap<>();
        Map<String, Integer> methodCounts = new HashMap<>();

        for (Expense expense : expenses) {
            methodTotals.put(expense.paymentMethod, 
                methodTotals.getOrDefault(expense.paymentMethod, 0.0) + expense.amount);
            methodCounts.put(expense.paymentMethod, 
                methodCounts.getOrDefault(expense.paymentMethod, 0) + 1);
        }

        NumberFormat nf = NumberFormat.getCurrencyInstance();
        System.out.println("\nСтатистика по способам оплаты:");
        for (String method : PAYMENT_METHODS) {
            double total = methodTotals.getOrDefault(method, 0.0);
            int count = methodCounts.getOrDefault(method, 0);
            if (count > 0) {
                System.out.println(method + ": " + nf.format(total) + 
                                 " (" + count + " расходов)");
            }
        }
    }

    void showMenu() {
        System.out.println("\n=== Учет расходов ===");
        System.out.println("1. Добавить расход");
        System.out.println("2. Показать все расходы");
        System.out.println("3. Показать расходы по категориям");
        System.out.println("4. Показать расходы по месяцам");
        System.out.println("5. Показать статистику по способам оплаты");
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
                        addExpense();
                        break;
                    case 2:
                        showExpenses();
                        break;
                    case 3:
                        showExpensesByCategory();
                        break;
                    case 4:
                        showExpensesByMonth();
                        break;
                    case 5:
                        showPaymentMethodStats();
                        break;
                    case 6:
                        saveExpenses();
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
        ExpenseTracker tracker = new ExpenseTracker();
        tracker.run();
    }
} 