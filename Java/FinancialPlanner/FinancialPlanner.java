import java.util.*;
import java.time.*;
import java.text.NumberFormat;
import java.io.*;

class Transaction implements Serializable {
    String description;
    double amount;
    LocalDate date;
    String category;
    boolean isIncome;

    Transaction(String d, double a, String c, boolean i) {
        description = d;
        amount = a;
        date = LocalDate.now();
        category = c;
        isIncome = i;
    }

    public String toString() {
        NumberFormat nf = NumberFormat.getCurrencyInstance();
        return date + " | " + category + " | " + description + " | " + 
               (isIncome ? "+" : "-") + nf.format(amount);
    }
}

class Investment implements Serializable {
    String name;
    double initialAmount;
    double currentAmount;
    double annualReturn;
    LocalDate startDate;

    Investment(String n, double a, double r) {
        name = n;
        initialAmount = a;
        currentAmount = a;
        annualReturn = r;
        startDate = LocalDate.now();
    }

    void update() {
        long days = startDate.until(LocalDate.now()).getDays();
        double years = (double)days / 365.0;
        currentAmount = initialAmount * Math.pow(1 + annualReturn, years);
    }

    public String toString() {
        NumberFormat nf = NumberFormat.getCurrencyInstance();
        double profit = currentAmount - initialAmount;
        double percent = initialAmount != 0 ? (profit / initialAmount) * 100 : 0;
        return name + ": Начальная сумма: " + nf.format(initialAmount) + 
               " | Текущая сумма: " + nf.format(currentAmount) + 
               " | Прибыль: " + nf.format(profit) + " (" + String.format("%.2f", percent) + "%)";
    }
}

class FinancialPlanner implements Serializable {
    ArrayList<Transaction> transactions;
    ArrayList<Investment> investments;
    double balance;
    Scanner scanner;
    private static final String SAVE_FILE = "financial_data.ser";

    FinancialPlanner() {
        transactions = new ArrayList<>();
        investments = new ArrayList<>();
        balance = 0;
        scanner = new Scanner(System.in);
        loadData();
    }

    private void loadData() {
        try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream(SAVE_FILE))) {
            FinancialPlanner loaded = (FinancialPlanner) ois.readObject();
            this.transactions = loaded.transactions;
            this.investments = loaded.investments;
            this.balance = loaded.balance;
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

    void addTransaction() {
        try {
            System.out.println("Введите описание:");
            String d = scanner.nextLine();
            
            System.out.println("Введите сумму:");
            double a = Double.parseDouble(scanner.nextLine());
            
            System.out.println("Введите категорию:");
            String c = scanner.nextLine();
            
            System.out.println("Это доход? (да/нет):");
            String answer = scanner.nextLine();
            boolean i = answer.equalsIgnoreCase("да");
            
            Transaction t = new Transaction(d, a, c, i);
            transactions.add(t);
            
            if (i) {
                balance += a;
            } else {
                balance -= a;
            }
            
            System.out.println("Транзакция добавлена!");
            saveData();
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void addInvestment() {
        try {
            System.out.println("Введите название инвестиции:");
            String n = scanner.nextLine();
            
            System.out.println("Введите сумму:");
            double a = Double.parseDouble(scanner.nextLine());
            
            System.out.println("Введите годовую доходность (в процентах):");
            double r = Double.parseDouble(scanner.nextLine()) / 100;
            
            Investment inv = new Investment(n, a, r);
            investments.add(inv);
            balance -= a;
            
            System.out.println("Инвестиция добавлена!");
            saveData();
        } catch (NumberFormatException e) {
            System.out.println("Ошибка! Введите корректное число.");
        }
    }

    void showTransactions() {
        System.out.println("\nПоследние транзакции:");
        Collections.sort(transactions, (t1, t2) -> t2.date.compareTo(t1.date));
        for (int i = 0; i < Math.min(10, transactions.size()); i++) {
            System.out.println(transactions.get(i));
        }
    }

    void showInvestments() {
        System.out.println("\nИнвестиции:");
        for (Investment inv : investments) {
            inv.update();
            System.out.println(inv);
        }
    }

    void showSummary() {
        NumberFormat nf = NumberFormat.getCurrencyInstance();
        double income = 0;
        double expenses = 0;
        double invTotal = 0;
        
        for (Transaction t : transactions) {
            if (t.isIncome) {
                income += t.amount;
            } else {
                expenses += t.amount;
            }
        }
        
        for (Investment inv : investments) {
            inv.update();
            invTotal += inv.currentAmount;
        }
        
        System.out.println("\nФинансовая сводка:");
        System.out.println("Текущий баланс: " + nf.format(balance));
        System.out.println("Общий доход: " + nf.format(income));
        System.out.println("Общие расходы: " + nf.format(expenses));
        System.out.println("Общие инвестиции: " + nf.format(invTotal));
        System.out.println("Чистый капитал: " + nf.format(balance + invTotal));
    }

    void showMenu() {
        System.out.println("\n=== Финансовый планировщик ===");
        System.out.println("1. Добавить транзакцию");
        System.out.println("2. Добавить инвестицию");
        System.out.println("3. Показать транзакции");
        System.out.println("4. Показать инвестиции");
        System.out.println("5. Показать сводку");
        System.out.println("6. Выход");
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
                        addTransaction();
                        break;
                    case 2:
                        addInvestment();
                        break;
                    case 3:
                        showTransactions();
                        break;
                    case 4:
                        showInvestments();
                        break;
                    case 5:
                        showSummary();
                        break;
                    case 6:
                        saveData();
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
        FinancialPlanner planner = new FinancialPlanner();
        planner.run();
    }
} 