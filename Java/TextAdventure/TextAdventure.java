import java.util.*;
import java.util.concurrent.ThreadLocalRandom;

abstract class Entity {
    String name;
    int health;
    int maxHealth;
    int attack;
    int defense;

    Entity(String name, int health, int attack, int defense) {
        this.name = name;
        this.maxHealth = health;
        this.health = health;
        this.attack = attack;
        this.defense = defense;
    }

    boolean isAlive() {
        return health > 0;
    }

    void takeDamage(int damage) {
        health = Math.max(0, health - damage);
    }

    int calculateDamage(int targetDefense) {
        return Math.max(1, attack - targetDefense);
    }
}

class Player extends Entity {
    int level;
    int experience;
    int gold;
    ArrayList<Item> inventory;
    Weapon equippedWeapon;
    Armor equippedArmor;

    Player(String name) {
        super(name, 100, 10, 5);
        level = 1;
        experience = 0;
        gold = 0;
        inventory = new ArrayList<>();
        equippedWeapon = new Weapon("Кулаки", 2, 0);
        equippedArmor = new Armor("Одежда", 1, 0);
    }

    void gainExperience(int exp) {
        experience += exp;
        if (experience >= level * 100) {
            levelUp();
        }
    }

    void levelUp() {
        level++;
        maxHealth += 20;
        health = maxHealth;
        attack += 3;
        defense += 2;
        System.out.println("Уровень повышен! Теперь вы " + level + " уровня!");
    }

    void addItem(Item item) {
        inventory.add(item);
    }

    void equipWeapon(Weapon weapon) {
        if (inventory.contains(weapon)) {
            attack -= equippedWeapon.damage;
            equippedWeapon = weapon;
            attack += weapon.damage;
            System.out.println("Вы экипировали " + weapon.name);
        }
    }

    void equipArmor(Armor armor) {
        if (inventory.contains(armor)) {
            defense -= equippedArmor.defense;
            equippedArmor = armor;
            defense += armor.defense;
            System.out.println("Вы экипировали " + armor.name);
        }
    }

    void showStats() {
        System.out.println("\n=== Характеристики ===");
        System.out.println("Имя: " + name);
        System.out.println("Уровень: " + level);
        System.out.println("Опыт: " + experience + "/" + (level * 100));
        System.out.println("Здоровье: " + health + "/" + maxHealth);
        System.out.println("Атака: " + (attack + equippedWeapon.damage));
        System.out.println("Защита: " + (defense + equippedArmor.defense));
        System.out.println("Золото: " + gold);
    }

    void showInventory() {
        System.out.println("\n=== Инвентарь ===");
        System.out.println("Оружие: " + equippedWeapon.name + " (Урон: " + equippedWeapon.damage + ")");
        System.out.println("Броня: " + equippedArmor.name + " (Защита: " + equippedArmor.defense + ")");
        System.out.println("\nПредметы:");
        for (int i = 0; i < inventory.size(); i++) {
            System.out.println((i + 1) + ". " + inventory.get(i));
        }
    }
}

class Monster extends Entity {
    int experienceReward;
    int goldReward;

    Monster(String name, int health, int attack, int defense, int exp, int gold) {
        super(name, health, attack, defense);
        this.experienceReward = exp;
        this.goldReward = gold;
    }
}

abstract class Item {
    String name;
    int value;

    Item(String name, int value) {
        this.name = name;
        this.value = value;
    }

    public String toString() {
        return name + " (Цена: " + value + " золота)";
    }
}

class Weapon extends Item {
    int damage;

    Weapon(String name, int damage, int value) {
        super(name, value);
        this.damage = damage;
    }

    public String toString() {
        return name + " (Урон: " + damage + ", Цена: " + value + " золота)";
    }
}

class Armor extends Item {
    int defense;

    Armor(String name, int defense, int value) {
        super(name, value);
        this.defense = defense;
    }

    public String toString() {
        return name + " (Защита: " + defense + ", Цена: " + value + " золота)";
    }
}

class Potion extends Item {
    int healing;

    Potion(String name, int healing, int value) {
        super(name, value);
        this.healing = healing;
    }

    public String toString() {
        return name + " (Лечение: " + healing + ", Цена: " + value + " золота)";
    }
}

class Location {
    String name;
    String description;
    ArrayList<Monster> monsters;
    ArrayList<Item> items;
    Location north;
    Location south;
    Location east;
    Location west;

    Location(String name, String description) {
        this.name = name;
        this.description = description;
        monsters = new ArrayList<>();
        items = new ArrayList<>();
    }

    void addMonster(Monster monster) {
        monsters.add(monster);
    }

    void addItem(Item item) {
        items.add(item);
    }

    void showDescription() {
        System.out.println("\n=== " + name + " ===");
        System.out.println(description);
        if (!monsters.isEmpty()) {
            System.out.println("\nМонстры в этой локации:");
            for (Monster monster : monsters) {
                System.out.println("- " + monster.name);
            }
        }
        if (!items.isEmpty()) {
            System.out.println("\nПредметы в этой локации:");
            for (Item item : items) {
                System.out.println("- " + item);
            }
        }
    }
}

class Game {
    Player player;
    Location currentLocation;
    Scanner scanner;
    Random random;

    Game() {
        scanner = new Scanner(System.in);
        random = new Random();
        setupGame();
    }

    void setupGame() {
        System.out.print("Введите имя вашего персонажа: ");
        String playerName = scanner.nextLine();
        player = new Player(playerName);

        // Создаем локации
        Location start = new Location("Начальная комната", 
            "Вы находитесь в темной комнате. Вокруг вас каменные стены.");
        Location corridor = new Location("Коридор", 
            "Длинный коридор с факелами на стенах.");
        Location treasureRoom = new Location("Сокровищница", 
            "Комната, полная золота и драгоценностей.");
        Location monsterRoom = new Location("Логово монстров", 
            "Большая комната с костями на полу.");

        // Соединяем локации
        start.north = corridor;
        corridor.south = start;
        corridor.east = treasureRoom;
        corridor.west = monsterRoom;
        treasureRoom.west = corridor;
        monsterRoom.east = corridor;

        // Добавляем предметы
        start.addItem(new Weapon("Ржавый меч", 5, 10));
        start.addItem(new Potion("Зелье здоровья", 30, 5));
        treasureRoom.addItem(new Armor("Кольчуга", 5, 20));
        treasureRoom.addItem(new Weapon("Стальной меч", 8, 15));

        // Добавляем монстров
        monsterRoom.addMonster(new Monster("Гоблин", 30, 5, 2, 20, 10));
        monsterRoom.addMonster(new Monster("Скелет", 40, 7, 3, 30, 15));
        treasureRoom.addMonster(new Monster("Охраняющий скелет", 50, 8, 4, 40, 20));

        currentLocation = start;
    }

    void start() {
        System.out.println("Добро пожаловать в Текстовый квест!");
        System.out.println("Ваше приключение начинается...");

        while (player.isAlive()) {
            currentLocation.showDescription();
            showMenu();
            handleInput();
        }

        System.out.println("Игра окончена! Вы погибли...");
    }

    void showMenu() {
        System.out.println("\n=== Меню ===");
        System.out.println("1. Идти на север");
        System.out.println("2. Идти на юг");
        System.out.println("3. Идти на восток");
        System.out.println("4. Идти на запад");
        System.out.println("5. Показать характеристики");
        System.out.println("6. Показать инвентарь");
        System.out.println("7. Подобрать предмет");
        System.out.println("8. Атаковать монстра");
        System.out.println("9. Использовать зелье");
        System.out.println("0. Выход");
        System.out.print("Выберите действие: ");
    }

    void handleInput() {
        try {
            int choice = Integer.parseInt(scanner.nextLine());
            
            switch (choice) {
                case 1:
                    move(currentLocation.north);
                    break;
                case 2:
                    move(currentLocation.south);
                    break;
                case 3:
                    move(currentLocation.east);
                    break;
                case 4:
                    move(currentLocation.west);
                    break;
                case 5:
                    player.showStats();
                    break;
                case 6:
                    player.showInventory();
                    break;
                case 7:
                    pickUpItem();
                    break;
                case 8:
                    attackMonster();
                    break;
                case 9:
                    usePotion();
                    break;
                case 0:
                    System.exit(0);
                    break;
                default:
                    System.out.println("Неверный выбор!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Пожалуйста, введите число!");
        }
    }

    void move(Location location) {
        if (location != null) {
            currentLocation = location;
            System.out.println("Вы перешли в " + location.name);
        } else {
            System.out.println("Вы не можете идти в этом направлении!");
        }
    }

    void pickUpItem() {
        if (currentLocation.items.isEmpty()) {
            System.out.println("Здесь нет предметов!");
            return;
        }

        System.out.println("\nВыберите предмет для подбора:");
        for (int i = 0; i < currentLocation.items.size(); i++) {
            System.out.println((i + 1) + ". " + currentLocation.items.get(i));
        }

        try {
            int choice = Integer.parseInt(scanner.nextLine()) - 1;
            if (choice >= 0 && choice < currentLocation.items.size()) {
                Item item = currentLocation.items.get(choice);
                player.addItem(item);
                currentLocation.items.remove(choice);
                System.out.println("Вы подобрали " + item.name);
            } else {
                System.out.println("Неверный выбор!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Пожалуйста, введите число!");
        }
    }

    void attackMonster() {
        if (currentLocation.monsters.isEmpty()) {
            System.out.println("Здесь нет монстров!");
            return;
        }

        System.out.println("\nВыберите монстра для атаки:");
        for (int i = 0; i < currentLocation.monsters.size(); i++) {
            Monster monster = currentLocation.monsters.get(i);
            System.out.println((i + 1) + ". " + monster.name + 
                             " (Здоровье: " + monster.health + "/" + monster.maxHealth + ")");
        }

        try {
            int choice = Integer.parseInt(scanner.nextLine()) - 1;
            if (choice >= 0 && choice < currentLocation.monsters.size()) {
                Monster monster = currentLocation.monsters.get(choice);
                fight(monster);
            } else {
                System.out.println("Неверный выбор!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Пожалуйста, введите число!");
        }
    }

    void fight(Monster monster) {
        while (player.isAlive() && monster.isAlive()) {
            // Атака игрока
            int playerDamage = player.calculateDamage(monster.defense);
            monster.takeDamage(playerDamage);
            System.out.println("Вы нанесли " + monster.name + " " + playerDamage + " урона!");

            if (!monster.isAlive()) {
                System.out.println("Вы победили " + monster.name + "!");
                player.gainExperience(monster.experienceReward);
                player.gold += monster.goldReward;
                currentLocation.monsters.remove(monster);
                break;
            }

            // Атака монстра
            int monsterDamage = monster.calculateDamage(player.defense + player.equippedArmor.defense);
            player.takeDamage(monsterDamage);
            System.out.println(monster.name + " нанес вам " + monsterDamage + " урона!");

            if (!player.isAlive()) {
                System.out.println("Вы погибли от рук " + monster.name + "!");
                break;
            }

            System.out.println("\nВаше здоровье: " + player.health + "/" + player.maxHealth);
            System.out.println("Здоровье " + monster.name + ": " + monster.health + "/" + monster.maxHealth);
            System.out.println("\nНажмите Enter для продолжения боя...");
            scanner.nextLine();
        }
    }

    void usePotion() {
        ArrayList<Potion> potions = new ArrayList<>();
        for (Item item : player.inventory) {
            if (item instanceof Potion) {
                potions.add((Potion) item);
            }
        }

        if (potions.isEmpty()) {
            System.out.println("У вас нет зелий!");
            return;
        }

        System.out.println("\nВыберите зелье для использования:");
        for (int i = 0; i < potions.size(); i++) {
            System.out.println((i + 1) + ". " + potions.get(i));
        }

        try {
            int choice = Integer.parseInt(scanner.nextLine()) - 1;
            if (choice >= 0 && choice < potions.size()) {
                Potion potion = potions.get(choice);
                player.health = Math.min(player.maxHealth, player.health + potion.healing);
                player.inventory.remove(potion);
                System.out.println("Вы использовали " + potion.name + 
                                 ". Ваше здоровье: " + player.health + "/" + player.maxHealth);
            } else {
                System.out.println("Неверный выбор!");
            }
        } catch (NumberFormatException e) {
            System.out.println("Пожалуйста, введите число!");
        }
    }
}

public class Main {
    public static void main(String[] args) {
        Game game = new Game();
        game.start();
    }
} 