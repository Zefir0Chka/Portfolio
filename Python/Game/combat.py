from typing import Dict, List, Optional
from .player import Player
from .items import Item

class Combat:
    def __init__(self, player: Player, enemy: Dict):
        self.player = player
        self.enemy = enemy
        self.current_enemy_health = enemy['health']
        self.turn = 1
        self.battle_log: List[str] = []
        
    def player_attack(self) -> None:
        # Проверяем, есть ли оружие
        if not self.player.equipped_weapon:
            damage = 2  # Базовый урон без оружия
            self.battle_log.append("Вы атакуете голыми руками!")
        else:
            weapon = self.player.equipped_weapon
            damage = weapon.damage
            
            # Проверяем выносливость
            if self.player.stamina < weapon.stamina_cost:
                damage = damage // 2
                self.battle_log.append("У вас мало выносливости! Урон уменьшен.")
            
            self.player.stamina = max(0, self.player.stamina - weapon.stamina_cost)
            self.battle_log.append(f"Вы атакуете {self.enemy['name']} {weapon.name}!")
        
        # Применяем защиту врага
        actual_damage = max(1, damage - self.enemy['defense'])
        self.current_enemy_health = max(0, self.current_enemy_health - actual_damage)
        
        self.battle_log.append(f"Вы наносите {actual_damage} урона!")
        
        if self.current_enemy_health == 0:
            self.battle_log.append(f"{self.enemy['name']} побежден!")
    
    def enemy_attack(self) -> None:
        if self.current_enemy_health <= 0:
            return
            
        damage = self.enemy['attack']
        self.battle_log.append(f"{self.enemy['name']} атакует вас!")
        
        # Применяем защиту игрока
        if self.player.equipped_armor:
            armor = self.player.equipped_armor
            damage = max(1, damage - armor.defense)
            armor.durability -= 1
            
            if armor.durability <= 0:
                self.battle_log.append(f"Ваш {armor.name} сломан!")
                self.player.equipped_armor = None
        
        self.player.take_damage(damage)
        self.battle_log.append(f"Вы получаете {damage} урона!")
    
    def use_item(self, item_name: str) -> bool:
        # Поиск предмета в инвентаре
        item = None
        for inv_item in self.player.inventory:
            if inv_item.name == item_name:
                item = inv_item
                break
        
        if not item or not hasattr(item, 'effect_type'):
            return False
        
        # Использование предмета
        if item.effect_type == 'health':
            self.player.health = min(self.player.max_health, 
                                   self.player.health + item.effect_value)
            self.battle_log.append(f"Вы восстанавливаете {item.effect_value} здоровья!")
        elif item.effect_type == 'stamina':
            self.player.stamina = min(self.player.max_stamina,
                                    self.player.stamina + item.effect_value)
            self.battle_log.append(f"Вы восстанавливаете {item.effect_value} выносливости!")
        
        self.player.remove_item(item)
        return True
    
    def is_battle_over(self) -> bool:
        return self.player.health <= 0 or self.current_enemy_health <= 0
    
    def get_battle_result(self) -> Optional[Dict]:
        if self.player.health <= 0:
            return {
                'victory': False,
                'message': "Вы проиграли битву!",
                'experience': 0,
                'gold': 0,
                'items': []
            }
        elif self.current_enemy_health <= 0:
            return {
                'victory': True,
                'message': f"Вы победили {self.enemy['name']}!",
                'experience': self.enemy['experience'],
                'gold': self.enemy['gold'],
                'items': self.enemy['items']
            }
        return None
    
    def show_battle_status(self) -> None:
        print("\n=== Статус битвы ===")
        print(f"Ход: {self.turn}")
        print(f"\n{self.enemy['name']}:")
        print(f"Здоровье: {self.current_enemy_health}/{self.enemy['health']}")
        
        print("\nВаш статус:")
        self.player.show_stats()
        
        print("\nПоследние события:")
        for log in self.battle_log[-3:]:  # Показываем последние 3 события
            print(f"- {log}")
    
    def get_available_actions(self) -> List[str]:
        actions = ["атаковать"]
        
        # Проверяем предметы в инвентаре
        for item in self.player.inventory:
            if hasattr(item, 'effect_type') and item.effect_type in ['health', 'stamina']:
                actions.append(f"использовать {item.name}")
        
        return actions 