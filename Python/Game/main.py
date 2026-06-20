from typing import Dict, List, Optional
import os
import time
from .player import Player
from .items import Item, Weapon, Armor, Consumable
from .locations import Location, World, create_sample_world
from .combat import Combat

class Game:
    def __init__(self):
        self.player = None
        self.world = None
        self.current_location = None
        self.game_over = False
        
    def clear_screen(self):
        os.system('cls' if os.name == 'nt' else 'clear')
    
    def show_title(self):
        print("=== ТЕКСТОВАЯ RPG ===")
        print("1. Новая игра")
        print("2. Загрузить игру")
        print("3. Выход")
    
    def create_character(self):
        self.clear_screen()
        print("=== СОЗДАНИЕ ПЕРСОНАЖА ===")
        
        name = input("Введите имя персонажа: ")
        self.player = Player(name)
        
        # Начальные предметы
        self.player.add_item(Weapon("Деревянный меч", 5, 2))
        self.player.add_item(Armor("Кожаная броня", 3, 10))
        self.player.add_item(Consumable("Зелье здоровья", "health", 20))
        
        print(f"\nПерсонаж {name} создан!")
        print("Вы получили начальные предметы:")
        self.player.show_inventory()
        input("\nНажмите Enter для продолжения...")
    
    def load_game(self):
        # TODO: Реализовать загрузку игры
        print("Функция загрузки игры будет реализована позже")
        time.sleep(2)
        return False
    
    def show_location(self):
        self.clear_screen()
        self.current_location.show_description()
        self.current_location.show_items()
        self.current_location.show_enemies()
        
        print("\nДоступные действия:")
        actions = self.current_location.get_available_actions()
        for i, action in enumerate(actions, 1):
            print(f"{i}. {action}")
        
        print("\nКуда пойти:")
        connections = self.current_location.get_connections()
        for i, (direction, location) in enumerate(connections.items(), len(actions) + 1):
            print(f"{i}. {direction}: {location.name}")
        
        print(f"{len(actions) + len(connections) + 1}. Статистика")
        print(f"{len(actions) + len(connections) + 2}. Сохранить игру")
        print(f"{len(actions) + len(connections) + 3}. Выход в главное меню")
    
    def handle_action(self, choice: int) -> bool:
        actions = self.current_location.get_available_actions()
        connections = list(self.current_location.get_connections().items())
        
        if 1 <= choice <= len(actions):
            # Обработка действий
            action = actions[choice - 1]
            
            if action == "осмотреться":
                self.current_location.show_description()
                input("\nНажмите Enter для продолжения...")
                
            elif action.startswith("взять"):
                item_name = action.split(" ", 1)[1]
                if self.current_location.take_item(item_name, self.player):
                    print(f"Вы взяли {item_name}")
                else:
                    print("Предмет не найден")
                input("\nНажмите Enter для продолжения...")
                
            elif action.startswith("использовать"):
                item_name = action.split(" ", 1)[1]
                if self.player.use_item(item_name):
                    print(f"Вы использовали {item_name}")
                else:
                    print("Не удалось использовать предмет")
                input("\nНажмите Enter для продолжения...")
                
            elif action.startswith("сразиться"):
                enemy_name = action.split(" ", 1)[1]
                enemy = self.current_location.get_enemy(enemy_name)
                if enemy:
                    self.handle_combat(enemy)
                else:
                    print("Враг не найден")
                    input("\nНажмите Enter для продолжения...")
            
        elif len(actions) < choice <= len(actions) + len(connections):
            # Перемещение
            direction, location = connections[choice - len(actions) - 1]
            if self.world.move_to(location.name):
                print(f"Вы идете {direction}")
                time.sleep(1)
            else:
                print("Вы не можете туда пойти")
                input("\nНажмите Enter для продолжения...")
                
        elif choice == len(actions) + len(connections) + 1:
            # Показать статистику
            self.player.show_stats()
            input("\nНажмите Enter для продолжения...")
            
        elif choice == len(actions) + len(connections) + 2:
            # Сохранить игру
            # TODO: Реализовать сохранение
            print("Функция сохранения будет реализована позже")
            time.sleep(2)
            
        elif choice == len(actions) + len(connections) + 3:
            # Выход в главное меню
            return False
            
        return True
    
    def handle_combat(self, enemy: Dict):
        combat = Combat(self.player, enemy)
        
        while not combat.is_battle_over():
            self.clear_screen()
            combat.show_battle_status()
            
            print("\nДоступные действия:")
            actions = combat.get_available_actions()
            for i, action in enumerate(actions, 1):
                print(f"{i}. {action}")
            
            try:
                choice = int(input("\nВыберите действие: "))
                if 1 <= choice <= len(actions):
                    action = actions[choice - 1]
                    
                    if action == "атаковать":
                        combat.player_attack()
                    elif action.startswith("использовать"):
                        item_name = action.split(" ", 1)[1]
                        combat.use_item(item_name)
                    
                    if not combat.is_battle_over():
                        combat.enemy_attack()
                        combat.turn += 1
                        
            except ValueError:
                print("Неверный ввод")
                time.sleep(1)
        
        result = combat.get_battle_result()
        if result:
            print(result['message'])
            if result['victory']:
                self.player.gain_experience(result['experience'])
                self.player.gold += result['gold']
                for item in result['items']:
                    self.player.add_item(item)
                self.current_location.remove_enemy(enemy['name'])
        input("\nНажмите Enter для продолжения...")
    
    def game_loop(self):
        self.world = create_sample_world()
        self.current_location = self.world.get_starting_location()
        
        while not self.game_over:
            self.show_location()
            
            try:
                choice = int(input("\nВыберите действие: "))
                if not self.handle_action(choice):
                    break
            except ValueError:
                print("Неверный ввод")
                time.sleep(1)
    
    def run(self):
        while True:
            self.clear_screen()
            self.show_title()
            
            try:
                choice = int(input("\nВыберите действие: "))
                
                if choice == 1:
                    self.create_character()
                    self.game_loop()
                elif choice == 2:
                    if self.load_game():
                        self.game_loop()
                elif choice == 3:
                    break
                else:
                    print("Неверный выбор")
                    time.sleep(1)
                    
            except ValueError:
                print("Неверный ввод")
                time.sleep(1)

if __name__ == "__main__":
    game = Game()
    game.run() 