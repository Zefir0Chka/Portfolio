#include "Room.h"
#include <iostream>

Room::Room() {
    description = "A mysterious room.";
}

void Room::setDescription(const std::string& desc) {
    description = desc;
}

void Room::addExit(const std::string& direction, const std::string& roomName) {
    exits[direction] = roomName;
}

void Room::addItem(const std::string& item) {
    items.push_back(item);
}

void Room::removeItem(const std::string& item) {
    for (auto it = items.begin(); it != items.end(); ++it) {
        if (*it == item) {
            items.erase(it);
            return;
        }
    }
}

void Room::describe() const {
    std::cout << description << "\n";
    
    if (!items.empty()) {
        std::cout << "You see the following items:\n";
        for (const auto& item : items) {
            std::cout << "- " << item << "\n";
        }
    }
    
    if (!exits.empty()) {
        std::cout << "Exits:\n";
        for (const auto& exit : exits) {
            std::cout << "- " << exit.first << "\n";
        }
    }
}

void Room::movePlayer(Player& player, const std::string& direction) {
    if (exits.find(direction) != exits.end()) {
        std::cout << "You move " << direction << " to " << exits[direction] << ".\n";
    } else {
        std::cout << "You can't go that way.\n";
    }
}

bool Room::hasItem(const std::string& item) const {
    for (const auto& i : items) {
        if (i == item) {
            return true;
        }
    }
    return false;
} 