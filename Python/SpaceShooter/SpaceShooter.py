import os
import random
import time
import keyboard
from threading import Thread
from typing import List, Tuple

class GameObject:
    def __init__(self, x: int, y: int, symbol: str):
        self.x = x
        self.y = y
        self.symbol = symbol

    def move(self, dx: int, dy: int, width: int, height: int) -> bool:
        new_x = self.x + dx
        new_y = self.y + dy
        if 0 <= new_x < width and 0 <= new_y < height:
            self.x = new_x
            self.y = new_y
            return True
        return False

class Player(GameObject):
    def __init__(self, x: int, y: int):
        super().__init__(x, y, "▲")
        self.health = 100
        self.score = 0
        self.power_level = 1
        self.invincible = False
        self.invincible_timer = 0

    def shoot(self) -> List[Tuple[int, int]]:
        bullets = [(self.x, self.y - 1)]
        if self.power_level >= 2:
            bullets.append((self.x - 1, self.y - 1))
        if self.power_level >= 3:
            bullets.append((self.x + 1, self.y - 1))
        return bullets

    def take_damage(self, amount: int) -> bool:
        if not self.invincible:
            self.health -= amount
            if self.health <= 0:
                return True
        return False

    def update(self):
        if self.invincible:
            self.invincible_timer -= 1
            if self.invincible_timer <= 0:
                self.invincible = False

class Enemy(GameObject):
    def __init__(self, x: int, y: int, symbol: str, health: int, points: int):
        super().__init__(x, y, symbol)
        self.health = health
        self.points = points
        self.shoot_chance = 0.1

    def update(self) -> bool:
        if random.random() < self.shoot_chance:
            return True
        return False

class Bullet(GameObject):
    def __init__(self, x: int, y: int, is_player: bool):
        super().__init__(x, y, "|" if is_player else "!")
        self.is_player = is_player
        self.damage = 10

class PowerUp(GameObject):
    def __init__(self, x: int, y: int):
        super().__init__(x, y, "★")
        self.type = random.choice(["health", "power", "shield"])

class Game:
    def __init__(self, width: int = 40, height: int = 20):
        self.width = width
        self.height = height
        self.player = Player(width // 2, height - 2)
        self.enemies: List[Enemy] = []
        self.bullets: List[Bullet] = []
        self.power_ups: List[PowerUp] = []
        self.game_over = False
        self.score = 0
        self.level = 1
        self.enemy_spawn_timer = 0
        self.power_up_timer = 0
        self.setup_level()

    def setup_level(self):
        self.enemies.clear()
        self.bullets.clear()
        self.power_ups.clear()
        self.enemy_spawn_timer = 0
        self.power_up_timer = 0

        for _ in range(3 + self.level):
            self.spawn_enemy()

    def spawn_enemy(self):
        x = random.randint(1, self.width - 2)
        enemy_type = random.choices(
            ["small", "medium", "large"],
            weights=[0.6, 0.3, 0.1]
        )[0]
        
        if enemy_type == "small":
            enemy = Enemy(x, 1, "▼", 20, 10)
        elif enemy_type == "medium":
            enemy = Enemy(x, 1, "▼", 40, 20)
        else:
            enemy = Enemy(x, 1, "▼", 60, 30)
        
        self.enemies.append(enemy)

    def spawn_power_up(self):
        if random.random() < 0.1:  
            x = random.randint(1, self.width - 2)
            power_up = PowerUp(x, 1)
            self.power_ups.append(power_up)

    def handle_input(self):
        if keyboard.is_pressed('left'):
            self.player.move(-1, 0, self.width, self.height)
        if keyboard.is_pressed('right'):
            self.player.move(1, 0, self.width, self.height)
        if keyboard.is_pressed('space'):
            for bullet_pos in self.player.shoot():
                self.bullets.append(Bullet(bullet_pos[0], bullet_pos[1], True))

    def update(self):

        self.player.update()


        for enemy in self.enemies[:]:
            if enemy.update():
                self.bullets.append(Bullet(enemy.x, enemy.y + 1, False))
            
            if random.random() < 0.1:  
                enemy.move(random.choice([-1, 0, 1]), 1, self.width, self.height)


        for bullet in self.bullets[:]:
            if bullet.is_player:
                if not bullet.move(0, -1, self.width, self.height):
                    self.bullets.remove(bullet)
                    continue
                

                for enemy in self.enemies[:]:
                    if bullet.x == enemy.x and bullet.y == enemy.y:
                        enemy.health -= bullet.damage
                        self.bullets.remove(bullet)
                        if enemy.health <= 0:
                            self.enemies.remove(enemy)
                            self.score += enemy.points
                        break
            else:
                if not bullet.move(0, 1, self.width, self.height):
                    self.bullets.remove(bullet)
                    continue

                if bullet.x == self.player.x and bullet.y == self.player.y:
                    if self.player.take_damage(bullet.damage):
                        self.game_over = True
                    self.bullets.remove(bullet)

        for power_up in self.power_ups[:]:
            if not power_up.move(0, 1, self.width, self.height):
                self.power_ups.remove(power_up)
                continue
     
            if power_up.x == self.player.x and power_up.y == self.player.y:
                if power_up.type == "health":
                    self.player.health = min(100, self.player.health + 20)
                elif power_up.type == "power":
                    self.player.power_level = min(3, self.player.power_level + 1)
                elif power_up.type == "shield":
                    self.player.invincible = True
                    self.player.invincible_timer = 30
                self.power_ups.remove(power_up)

        self.enemy_spawn_timer += 1
        if self.enemy_spawn_timer >= 20:
            self.enemy_spawn_timer = 0
            if len(self.enemies) < 5 + self.level:
                self.spawn_enemy()

        self.power_up_timer += 1
        if self.power_up_timer >= 100:
            self.power_up_timer = 0
            self.spawn_power_up()

        if self.score >= self.level * 100:
            self.level += 1
            self.setup_level()

    def draw(self):
        os.system('cls' if os.name == 'nt' else 'clear')

        print("+" + "-" * self.width + "+")
 
        for y in range(self.height):
            print("|", end="")
            for x in range(self.width):

                if x == self.player.x and y == self.player.y:
                    print(self.player.symbol, end="")

                elif any(e.x == x and e.y == y for e in self.enemies):
                    print("▼", end="")

                elif any(b.x == x and b.y == y for b in self.bullets):
                    print("|", end="")

                elif any(p.x == x and p.y == y for p in self.power_ups):
                    print("★", end="")
                else:
                    print(" ", end="")
            print("|")
        
        print("+" + "-" * self.width + "+")
        

        print(f"Здоровье: {self.player.health}")
        print(f"Очки: {self.score}")
        print(f"Уровень: {self.level}")
        print(f"Мощность: {self.player.power_level}")
        if self.player.invincible:
            print("ЩИТ АКТИВЕН!")

    def run(self):
        print("Космический стрелок")
        print("Управление: стрелки влево/вправо - движение, пробел - стрельба")
        print("Нажмите любую клавишу для начала...")
        input()
        
        while not self.game_over:
            self.handle_input()
            self.update()
            self.draw()
            time.sleep(0.1)
        
        print("\nИгра окончена!")
        print(f"Ваш счет: {self.score}")
        print(f"Достигнутый уровень: {self.level}")

if __name__ == "__main__":
    game = Game()
    game.run() 