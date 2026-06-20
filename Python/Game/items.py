from dataclasses import dataclass
from typing import Optional, List

@dataclass
class Item:
    name: str
    description: str
    weight: float
    value: int
    can_pick_up: bool = True
    can_use: bool = False
    can_equip: bool = False
    is_consumable: bool = False
    uses_left: Optional[int] = None

    def use(self) -> bool:
        if not self.can_use:
            return False
        if self.is_consumable and self.uses_left is not None:
            self.uses_left -= 1
            return self.uses_left > 0
        return True

    def __str__(self) -> str:
        return f"{self.name} ({self.description})"

@dataclass
class Weapon(Item):
    damage: int
    durability: int
    is_ranged: bool = False
    ammo_type: Optional[str] = None

    def __init__(self, name: str, description: str, weight: float, value: int,
                 damage: int, durability: int, is_ranged: bool = False,
                 ammo_type: Optional[str] = None):
        super().__init__(name, description, weight, value, True, True, True)
        self.damage = damage
        self.durability = durability
        self.is_ranged = is_ranged
        self.ammo_type = ammo_type

    def use(self) -> bool:
        if self.durability <= 0:
            return False
        self.durability -= 1
        return True

@dataclass
class Armor(Item):
    defense: int
    durability: int

    def __init__(self, name: str, description: str, weight: float, value: int,
                 defense: int, durability: int):
        super().__init__(name, description, weight, value, True, False, True)
        self.defense = defense
        self.durability = durability

@dataclass
class Consumable(Item):
    effect_type: str
    effect_value: int

    def __init__(self, name: str, description: str, weight: float, value: int,
                 effect_type: str, effect_value: int, uses: int = 1):
        super().__init__(name, description, weight, value, True, True, False, True, uses)
        self.effect_type = effect_type
        self.effect_value = effect_value

@dataclass
class Key(Item):
    key_id: str

    def __init__(self, name: str, description: str, weight: float, value: int,
                 key_id: str):
        super().__init__(name, description, weight, value, True, False, False)
        self.key_id = key_id

@dataclass
class Container(Item):
    capacity: int
    items: List[Item]

    def __init__(self, name: str, description: str, weight: float, value: int,
                 capacity: int):
        super().__init__(name, description, weight, value, True, True, False)
        self.capacity = capacity
        self.items = []

    def add_item(self, item: Item) -> bool:
        if len(self.items) >= self.capacity:
            return False
        self.items.append(item)
        return True

    def remove_item(self, item: Item) -> bool:
        if item in self.items:
            self.items.remove(item)
            return True
        return False

    def get_total_weight(self) -> float:
        return sum(item.weight for item in self.items)

    def __str__(self) -> str:
        return f"{self.name} ({self.description}) - Содержит {len(self.items)} предметов" 