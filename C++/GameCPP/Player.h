#ifndef PLAYER_H
#define PLAYER_H

#include <string>
#include <vector>

class Player {
private:
    std::string name;
    int health;
    int maxHealth;
    int stamina;
    int maxStamina;
    int level;
    int experience;
    int gold;
    std::vector<std::string> inventory;
    std::vector<Item*> equippedItems;
    int inventoryCapacity;

public:
    Player();
    ~Player();

    // Getters
    std::string getName() const;
    int getHealth() const;
    int getMaxHealth() const;
    int getStamina() const;
    int getMaxStamina() const;
    int getLevel() const;
    int getExperience() const;
    int getGold() const;
    const std::vector<Item*>& getInventory() const;
    const std::vector<Item*>& getEquippedItems() const;
    int getInventoryCapacity() const;

    // Player actions
    void setName(const std::string& newName);
    void addItem(const std::string& item);
    void removeItem(const std::string& item);
    bool equipItem(const std::string& itemName);
    bool unequipItem(const std::string& itemName);
    bool useItem(const std::string& itemName);
    void takeDamage(int damage);
    void heal(int amount);
    void restoreStamina(int amount);
    void gainExperience(int amount);
    void levelUp();
    void addGold(int amount);
    bool spendGold(int amount);

    // Status methods
    bool isAlive() const;
    std::string getStatus() const;
    void showInventory() const;
    void showEquippedItems() const;

    // Setters
    void setHealth(int newHealth);
};

#endif // PLAYER_H 