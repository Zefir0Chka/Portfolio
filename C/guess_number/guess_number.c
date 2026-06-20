#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <string.h>

typedef struct {
    char name[50];
    int games_played;
    int games_won;
    int best_score;
    int total_attempts;
} PlayerStats;

void clearInputBuffer() {
    while (getchar() != '\n');
}


int selectDifficulty() {
    int choice;
    printf("\nВыберите уровень сложности:\n");
    printf("1. Легкий (1-50)\n");
    printf("2. Средний (1-100)\n");
    printf("3. Сложный (1-200)\n");
    printf("4. Эксперт (1-500)\n");
    printf("Ваш выбор: ");
    scanf("%d", &choice);
    clearInputBuffer();
    return choice;
}

int getMaxNumber(int difficulty) {
    switch(difficulty) {
        case 1: return 50;
        case 2: return 100;
        case 3: return 200;
        case 4: return 500;
        default: return 100;
    }
}

void updateStats(PlayerStats* stats, int attempts, int won) {
    stats->games_played++;
    if (won) {
        stats->games_won++;
        if (stats->best_score == 0 || attempts < stats->best_score) {
            stats->best_score = attempts;
        }
        stats->total_attempts += attempts;
    }
}


void showStats(PlayerStats* stats) {
    printf("\n=== Статистика игрока ===\n");
    printf("Имя: %s\n", stats->name);
    printf("Сыграно игр: %d\n", stats->games_played);
    printf("Выиграно игр: %d\n", stats->games_won);
    if (stats->games_won > 0) {
        printf("Лучший результат: %d попыток\n", stats->best_score);
        printf("Среднее количество попыток: %.2f\n", 
               (float)stats->total_attempts / stats->games_won);
    }
    printf("=======================\n");
}

int main() {
    srand(time(NULL));
    PlayerStats stats = {"", 0, 0, 0, 0};
    
    printf("Добро пожаловать в игру 'Угадай число'!\n");
    printf("Введите ваше имя: ");
    fgets(stats.name, 50, stdin);
    stats.name[strcspn(stats.name, "\n")] = 0; // Удаляем символ новой строки
    
    int playAgain = 1;
    while (playAgain) {
        int difficulty = selectDifficulty();
        int maxNumber = getMaxNumber(difficulty);
        int secretNumber = rand() % maxNumber + 1;
        int attempts = 0;
        int guess;
        
        printf("\nЯ загадал число от 1 до %d. Попробуйте угадать!\n", maxNumber);
        
        while (1) {
            printf("Ваша догадка: ");
            scanf("%d", &guess);
            clearInputBuffer();
            attempts++;
            
            if (guess < secretNumber) {
                printf("Загаданное число больше!\n");
            } else if (guess > secretNumber) {
                printf("Загаданное число меньше!\n");
            } else {
                printf("\nПоздравляем! Вы угадали число за %d попыток!\n", attempts);
                updateStats(&stats, attempts, 1);
                break;
            }
            
            if (attempts >= 10) {
                printf("\nК сожалению, вы не угадали число. Загаданное число было: %d\n", secretNumber);
                updateStats(&stats, attempts, 0);
                break;
            }
        }
        
        showStats(&stats);
        
        printf("\nХотите сыграть еще раз? (1 - да, 0 - нет): ");
        scanf("%d", &playAgain);
        clearInputBuffer();
    }
    
    printf("\nСпасибо за игру! До свидания!\n");
    return 0;
} 