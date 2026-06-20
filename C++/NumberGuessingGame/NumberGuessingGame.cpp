#include <iostream>
#include <ctime>
#include <cstdlib>
#include <vector>
#include <algorithm>

class NumberGuessingGame {
private:
    int secretNumber;
    int attempts;
    std::vector<int> previousGuesses;
    int minRange;
    int maxRange;

public:
    NumberGuessingGame(int min = 1, int max = 100) 
        : minRange(min), maxRange(max), attempts(0) {
        std::srand(static_cast<unsigned int>(std::time(nullptr)));
        secretNumber = minRange + std::rand() % (maxRange - minRange + 1);
    }

    void play() {
        std::cout << "Welcome to the Number Guessing Game!\n";
        std::cout << "I'm thinking of a number between " << minRange << " and " << maxRange << ".\n\n";

        while (true) {
            int guess;
            std::cout << "Enter your guess: ";
            std::cin >> guess;

            if (std::cin.fail()) {
                std::cin.clear();
                std::cin.ignore(10000, '\n');
                std::cout << "Please enter a valid number!\n";
                continue;
            }

            attempts++;
            previousGuesses.push_back(guess);

            if (guess == secretNumber) {
                std::cout << "\nCongratulations! You guessed the number " << secretNumber << "!\n";
                std::cout << "Number of attempts: " << attempts << "\n";
                showStatistics();
                break;
            }
            else if (guess < secretNumber) {
                std::cout << "The secret number is higher.\n";
            }
            else {
                std::cout << "The secret number is lower.\n";
            }

            if (attempts % 3 == 0) {
                showHint();
            }
        }
    }

private:
    void showHint() {
        std::cout << "\nHint: ";
        if (secretNumber % 2 == 0) {
            std::cout << "The number is even.\n";
        }
        else {
            std::cout << "The number is odd.\n";
        }

        if (!previousGuesses.empty()) {
            auto closest = *std::min_element(previousGuesses.begin(), previousGuesses.end(),
                [this](int a, int b) {
                    return std::abs(a - secretNumber) < std::abs(b - secretNumber);
                });
            std::cout << "Your closest guess: " << closest << "\n";
        }
    }

    void showStatistics() {
        std::cout << "\nGame Statistics:\n";
        std::cout << "Total attempts: " << attempts << "\n";
        std::cout << "Your guesses: ";
        for (int guess : previousGuesses) {
            std::cout << guess << " ";
        }
        std::cout << "\n";

        int tooHigh = 0, tooLow = 0;
        for (int guess : previousGuesses) {
            if (guess > secretNumber) tooHigh++;
            else if (guess < secretNumber) tooLow++;
        }
        std::cout << "Too high guesses: " << tooHigh << "\n";
        std::cout << "Too low guesses: " << tooLow << "\n";
    }
};

int main() {
    NumberGuessingGame game(1, 100);
    
    game.play();

    while (true) {
        std::cout << "\nWould you like to play again? (y/n): ";
        char choice;
        std::cin >> choice;
        
        if (choice == 'y' || choice == 'Y') {
            NumberGuessingGame newGame(1, 100);
            newGame.play();
        }
        else {
            std::cout << "Thank you for playing! Goodbye!\n";
            break;
        }
    }

    return 0;
} 