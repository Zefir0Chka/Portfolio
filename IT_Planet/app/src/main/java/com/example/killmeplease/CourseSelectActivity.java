package com.example.killmeplease;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class CourseSelectActivity extends AppCompatActivity {
    public static final String EXTRA_MODE = "mode";
    public static final String MODE_TASKS = "tasks";
    public static final String MODE_TESTS = "tests";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_course_select);

        String mode = getIntent().getStringExtra(EXTRA_MODE);
        if (mode == null) mode = MODE_TASKS;

        TextView title = findViewById(R.id.course_select_title);
        ListView listView = findViewById(R.id.course_select_list);
        String[] languages = {"Java", "Kotlin", "Python", "1C", "C++", "C#"};

        title.setText(MODE_TESTS.equals(mode) ? "Выберите курс для тестов" : "Выберите курс для задач");
        listView.setAdapter(new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, languages));

        String finalMode = mode;
        listView.setOnItemClickListener((parent, view, position, id) -> {
            String language = languages[position];
            if (MODE_TESTS.equals(finalMode)) {
                startActivity(new Intent(this, CourseTestsActivity.class).putExtra("language", language));
            } else {
                startActivity(new Intent(this, CourseTasksActivity.class).putExtra("language", language));
            }
        });
    }
}
