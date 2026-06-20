using System;

class SimpleCalculator
{
    static void Main()
    {
        Console.WriteLine("Простой калькулятор");
        Console.WriteLine("------------------");
        
        while (true)
        {
            Console.WriteLine("\nВыберите операцию:");
            Console.WriteLine("1. Сложение");
            Console.WriteLine("2. Вычитание");
            Console.WriteLine("3. Умножение");
            Console.WriteLine("4. Деление");
            Console.WriteLine("5. Выход");
            
            Console.Write("\nВаш выбор (1-5): ");
            string choice = Console.ReadLine();
            
            if (choice == "5")
            {
                Console.WriteLine("До свидания!");
                break;
            }
            
            if (choice != "1" && choice != "2" && choice != "3" && choice != "4")
            {
                Console.WriteLine("Неверный выбор! Попробуйте снова.");
                continue;
            }
            
            Console.Write("Введите первое число: ");
            double num1 = GetNumber();
            
            Console.Write("Введите второе число: ");
            double num2 = GetNumber();
            
            double result = 0;
            string operation = "";
            
            switch (choice)
            {
                case "1":
                    result = num1 + num2;
                    operation = "+";
                    break;
                case "2":
                    result = num1 - num2;
                    operation = "-";
                    break;
                case "3":
                    result = num1 * num2;
                    operation = "*";
                    break;
                case "4":
                    if (num2 == 0)
                    {
                        Console.WriteLine("Ошибка: деление на ноль!");
                        continue;
                    }
                    result = num1 / num2;
                    operation = "/";
                    break;
            }
            
            Console.WriteLine($"\nРезультат: {num1} {operation} {num2} = {result}");
        }
    }
    
    static double GetNumber()
    {
        while (true)
        {
            string input = Console.ReadLine();
            if (double.TryParse(input, out double number))
            {
                return number;
            }
            Console.Write("Неверный ввод. Пожалуйста, введите число: ");
        }
    }
} 