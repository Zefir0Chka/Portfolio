#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void processFile(const char* inputFile, const char* outputFile, const char* key) {
    FILE* in = fopen(inputFile, "rb");
    FILE* out = fopen(outputFile, "wb");
    
    if (!in || !out) {
        printf("Ошибка открытия файлов\n");
        if (in) fclose(in);
        if (out) fclose(out);
        return;
    }
    
    int keyLen = strlen(key);
    int keyIndex = 0;
    int ch;
    
    while ((ch = fgetc(in)) != EOF) {
        fputc(ch ^ key[keyIndex], out);
        keyIndex = (keyIndex + 1) % keyLen;
    }
    
    fclose(in);
    fclose(out);
}

int main() {
    char inputFile[256];
    char outputFile[256];
    char key[256];
    int choice;
    
    printf("1. Зашифровать файл\n");
    printf("2. Расшифровать файл\n");
    printf("Выберите действие: ");
    scanf("%d", &choice);
    getchar();
    
    printf("Введите путь к исходному файлу: ");
    fgets(inputFile, sizeof(inputFile), stdin);
    inputFile[strcspn(inputFile, "\n")] = 0;
    
    printf("Введите путь для сохранения результата: ");
    fgets(outputFile, sizeof(outputFile), stdin);
    outputFile[strcspn(outputFile, "\n")] = 0;
    
    printf("Введите ключ шифрования: ");
    fgets(key, sizeof(key), stdin);
    key[strcspn(key, "\n")] = 0;
    
    processFile(inputFile, outputFile, key);
    
    printf("Операция завершена успешно\n");
    return 0;
} 