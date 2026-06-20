from typing import List, Optional
from .items import Item, Weapon, Armor, Consumable

class Player:
    def __init__(self, name: str):
        self.name = name
        self.health = 100
        self.max_health = 100
        self.stamina = 100
        self.max_stamina = 100
        self.inventory: List[Item] = []
        self.equipped_weapon: Optional[Weapon] = None
        self.equipped_armor: Optional[Armor] = None
        self.max_weight = 50.0
        self.money = 0
        self.experience = 0
        self.level = 1

    def get_current_weight(self) -> float:
        return sum(item.weight for item in self.inventory)

    def can_carry(self, item: Item) -> bool:
        return self.get_current_weight() + item.weight <= self.max_weight

    def add_item(self, item: Item) -> bool:
        if not self.can_carry(item):
            return False
        self.inventory.append(item)
        return True

    def remove_item(self, item: Item) -> bool:
        if item in self.inventory:
            self.inventory.remove(item)
            return True
        return False

    def equip_weapon(self, weapon: Weapon) -> bool:
        if weapon not in self.inventory:
            return False
        self.equipped_weapon = weapon
        return True

    def equip_armor(self, armor: Armor) -> bool:
        if armor not in self.inventory:
            return False
        self.equipped_armor = armor
        return True

    def use_item(self, item: Item) -> bool:
        if item not in self.inventory:
            return False
        
        if isinstance(item, Consumable):
            if item.effect_type == "health":
                self.health = min(self.max_health, self.health + item.effect_value)
            elif item.effect_type == "stamina":
                self.stamina = min(self.max_stamina, self.stamina + item.effect_value)
            
            if not item.use():
                self.remove_item(item)
            return True
        
        return item.use()

    def take_damage(self, amount: int) -> bool:
        defense = self.equipped_armor.defense if self.equipped_armor else 0
        actual_damage = max(1, amount - defense)
        self.health -= actual_damage
        
        if self.equipped_armor:
            self.equipped_armor.durability -= 1
            if self.equipped_armor.durability <= 0:
                self.inventory.remove(self.equipped_armor)
                self.equipped_armor = None
        
        return self.health <= 0

    def attack(self) -> int:
        if not self.equipped_weapon:
            return 1
        
        if self.equipped_weapon.durability <= 0:
            self.inventory.remove(self.equipped_weapon)
            self.equipped_weapon = None
            return 1
        
        self.equipped_weapon.durability -= 1
        return self.equipped_weapon.damage

    def gain_experience(self, amount: int) -> None:
        self.experience += amount
        while self.experience >= self.level * 100:
            self.level_up()

    def level_up(self) -> None:
        self.level += 1
        self.max_health += 10
        self.max_stamina += 10
        self.max_weight += 5
        self.health = self.max_health
        self.stamina = self.max_stamina

    def show_stats(self) -> None:
        print(f"\n=== Характеристики {self.name} ===")
        print(f"Уровень: {self.level}")
        print(f"Опыт: {self.experience}/{self.level * 100}")
        print(f"Здоровье: {self.health}/{self.max_health}")
        print(f"Выносливость: {self.stamina}/{self.max_stamina}")
        print(f"Деньги: {self.money}")
        print(f"Вес: {self.get_current_weight():.1f}/{self.max_weight:.1f}")
        
        if self.equipped_weapon:
            print(f"\nОружие: {self.equipped_weapon.name} (Урон: {self.equipped_weapon.damage})")
        if self.equipped_armor:
            print(f"Броня: {self.equipped_armor.name} (Защита: {self.equipped_armor.defense})")

    def show_inventory(self) -> None:
        print("\n=== Инвентарь ===")
        if not self.inventory:
            print("Инвентарь пуст")
            return
        
        for i, item in enumerate(self.inventory, 1):
            print(f"{i}. {item}")
            if isinstance(item, Weapon):
                print(f"   Урон: {item.damage}, Прочность: {item.durability}")
            elif isinstance(item, Armor):
                print(f"   Защита: {item.defense}, Прочность: {item.durability}")
            elif isinstance(item, Consumable):
                print(f"   Эффект: {item.effect_type} +{item.effect_value}")
                if item.uses_left:
                    print(f"   Осталось использований: {item.uses_left}") 