#include "Player.h"
#include <iostream>

Player::Player() : health(100) {
    name = "Player";
}

void Player::setName(const std::string& newName) {
    name = newName;
}

std::string Player::getName() const {
    return name;
}

void Player::addItem(const std::string& item) {
    inventory.push_back(item);
    std::cout << "Added " << item << " to inventory.\n";
}

void Player::removeItem(const std::string& item) {
    for (auto it = inventory.begin(); it != inventory.end(); ++it) {
        if (*it == item) {
            inventory.erase(it);
            std::cout << "Removed " << item << " from inventory.\n";
            return;
        }
    }
    std::cout << "Item not found in inventory.\n";
}

void Player::showInventory() const {
    if (inventory.empty()) {
        std::cout << "Your inventory is empty.\n";
    } else {
        std::cout << "Inventory:\n";
        for (const auto& item : inventory) {
            std::cout << "- " << item << "\n";
        }
    }
}

int Player::getHealth() const {
    return health;
}

void Player::setHealth(int newHealth) {
    health = newHealth;
} 