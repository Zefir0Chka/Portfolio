from typing import List, Dict, Optional
from .items import Item, Weapon, Armor, Consumable
from .player import Player

class Location:
    def __init__(self, name: str, description: str):
        self.name = name
        self.description = description
        self.items: List[Item] = []
        self.connections: Dict[str, 'Location'] = {}
        self.visited = False
        self.enemies: List[Dict] = []
        self.required_item: Optional[str] = None
        self.required_item_message: Optional[str] = None

    def add_item(self, item: Item) -> None:
        self.items.append(item)

    def remove_item(self, item: Item) -> bool:
        if item in self.items:
            self.items.remove(item)
            return True
        return False

    def add_connection(self, direction: str, location: 'Location') -> None:
        self.connections[direction] = location

    def add_enemy(self, name: str, health: int, attack: int, defense: int, 
                 experience: int, gold: int, items: List[Item] = None) -> None:
        self.enemies.append({
            'name': name,
            'health': health,
            'attack': attack,
            'defense': defense,
            'experience': experience,
            'gold': gold,
            'items': items or []
        })

    def can_enter(self, player: Player) -> bool:
        if not self.required_item:
            return True
        
        for item in player.inventory:
            if item.name == self.required_item:
                return True
        
        return False

    def show_description(self) -> None:
        print(f"\n=== {self.name} ===")
        print(self.description)
        
        if not self.visited:
            self.visited = True
            print("\n(Новое место!)")
        
        if self.items:
            print("\nЗдесь вы видите:")
            for item in self.items:
                print(f"- {item}")
        
        if self.enemies:
            print("\nЗдесь находятся враги:")
            for enemy in self.enemies:
                print(f"- {enemy['name']} (Здоровье: {enemy['health']})")
        
        if self.connections:
            print("\nВы можете пойти:")
            for direction, location in self.connections.items():
                print(f"- {direction}: {location.name}")

    def get_available_actions(self) -> List[str]:
        actions = ["осмотреться", "инвентарь", "статистика"]
        
        if self.items:
            actions.append("взять")
        
        if self.enemies:
            actions.append("атаковать")
        
        if self.connections:
            actions.extend(self.connections.keys())
        
        return actions

class World:
    def __init__(self):
        self.locations: Dict[str, Location] = {}
        self.current_location: Optional[Location] = None

    def add_location(self, location: Location) -> None:
        self.locations[location.name] = location

    def set_start_location(self, location_name: str) -> None:
        if location_name in self.locations:
            self.current_location = self.locations[location_name]

    def move(self, direction: str, player: Player) -> bool:
        if not self.current_location or direction not in self.current_location.connections:
            return False
        
        target_location = self.current_location.connections[direction]
        
        if not target_location.can_enter(player):
            if target_location.required_item_message:
                print(target_location.required_item_message)
            else:
                print(f"Вам нужно {target_location.required_item} чтобы войти сюда.")
            return False
        
        self.current_location = target_location
        return True

    def create_sample_world(self) -> None:
        # Создаем локации
        start = Location("Начальная комната", 
                        "Вы находитесь в небольшой каменной комнате. "
                        "Стены покрыты мхом, а в углу стоит потухший факел.")
        
        corridor = Location("Коридор", 
                          "Длинный темный коридор. "
                          "Стены украшены старыми гобеленами.")
        
        treasure_room = Location("Сокровищница", 
                               "Комната, полная золота и драгоценностей. "
                               "В центре стоит большой сундук.")
        treasure_room.required_item = "ключ"
        treasure_room.required_item_message = "Сокровищница заперта. Нужен ключ."
        
        monster_lair = Location("Логово монстров", 
                              "Большая пещера с костями на полу. "
                              "Здесь явно обитают опасные существа.")
        
        # Добавляем предметы
        start.add_item(Weapon("ржавый меч", "Старый затупившийся меч", 1.5, 5, 10))
        start.add_item(Consumable("малое зелье здоровья", "Восстанавливает 20 здоровья", 0.2, "health", 20))
        
        corridor.add_item(Armor("кожаный доспех", "Простой доспех из кожи", 2.0, 2, 15))
        
        treasure_room.add_item(Consumable("большое зелье здоровья", "Восстанавливает 50 здоровья", 0.3, "health", 50))
        treasure_room.add_item(Weapon("золотой меч", "Красивый и острый меч", 2.0, 8, 20))
        
        # Добавляем врагов
        monster_lair.add_enemy("гоблин", 30, 5, 2, 20, 10, 
                             [Consumable("зелье выносливости", "Восстанавливает 30 выносливости", 0.2, "stamina", 30)])
        
        monster_lair.add_enemy("орк", 50, 8, 4, 40, 25,
                             [Weapon("топор орка", "Тяжелый боевой топор", 3.0, 7, 15)])
        
        # Соединяем локации
        start.add_connection("север", corridor)
        corridor.add_connection("юг", start)
        corridor.add_connection("восток", treasure_room)
        corridor.add_connection("запад", monster_lair)
        treasure_room.add_connection("запад", corridor)
        monster_lair.add_connection("восток", corridor)
        
        # Добавляем локации в мир
        self.add_location(start)
        self.add_location(corridor)
        self.add_location(treasure_room)
        self.add_location(monster_lair)
        
        # Устанавливаем начальную локацию
        self.set_start_location("Начальная комната") 