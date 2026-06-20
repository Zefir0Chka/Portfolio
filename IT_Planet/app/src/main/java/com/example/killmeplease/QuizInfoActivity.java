package com.example.killmeplease;

import android.os.Bundle;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class QuizInfoActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_quiz_info);

        String testName = getIntent().getStringExtra("test_name");
        if (testName == null) testName = "Тест";

        TextView title = findViewById(R.id.quiz_title);
        TextView content = findViewById(R.id.quiz_content);
        title.setText(testName);
        content.setText("Формат проверки:\n\n" +
                "1. 5 вопросов по теме.\n" +
                "2. 1 правильный ответ в каждом вопросе.\n" +
                "3. Успех при 4/5 и выше.\n\n" +
                "Блок с реальными интерактивными вопросами можно легко добавить следующим шагом.");
    }
}
