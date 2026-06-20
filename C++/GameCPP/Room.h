#ifndef ROOM_H
#define ROOM_H

#include "Player.h"
#include <string>
#include <map>

class Room {
private:
    std::string description;
    std::map<std::string, std::string> exits;
    std::vector<std::string> items;
    
public:
    Room();
    void setDescription(const std::string& desc);
    void addExit(const std::string& direction, const std::string& roomName);
    void addItem(const std::string& item);
    void removeItem(const std::string& item);
    void describe() const;
    void movePlayer(Player& player, const std::string& direction);
    bool hasItem(const std::string& item) const;
};

#endif // ROOM_H 