#include <iostream>
#include <string>
#include "Player.h"
#include "Room.h"

int main() {
    std::cout << "Welcome to Text Adventure!\n";
    
    Player player;
    Room currentRoom;
    
    bool gameRunning = true;
    std::string input;
    
    while (gameRunning) {
        std::cout << "\nWhat would you like to do? (move/look/inventory/quit): ";
        std::getline(std::cin, input);
        
        if (input == "quit") {
            gameRunning = false;
        } else if (input == "move") {
            std::cout << "Which direction? (north/south/east/west): ";
            std::getline(std::cin, input);
            currentRoom.movePlayer(player, input);
        } else if (input == "look") {
            currentRoom.describe();
        } else if (input == "inventory") {
            player.showInventory();
        } else {
            std::cout << "I don't understand that command.\n";
        }
    }
    
    std::cout << "Thanks for playing!\n";
    return 0;
} 