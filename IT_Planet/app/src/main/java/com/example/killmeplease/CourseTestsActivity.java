package com.example.killmeplease;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;
import java.util.List;

public class CourseTestsActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_course_tests);

        String language = getIntent().getStringExtra("language");
        if (language == null) language = "Java";
        TextView title = findViewById(R.id.course_tests_title);
        ListView listView = findViewById(R.id.course_tests_list);
        title.setText("Тесты курса: " + language);

        List<TopicItem> topics = TopicsRepository.createTopics(language);
        List<String> items = new ArrayList<>();
        for (int i = 0; i < topics.size(); i++) {
            items.add("Тест " + (i + 1) + ": " + topics.get(i).title);
        }
        listView.setAdapter(new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, items));
        listView.setOnItemClickListener((parent, view, position, id) ->
                startActivity(new Intent(this, QuizInfoActivity.class)
                        .putExtra("test_name", items.get(position))));
    }
}
