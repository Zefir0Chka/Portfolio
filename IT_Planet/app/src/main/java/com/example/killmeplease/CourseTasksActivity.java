package com.example.killmeplease;

import android.content.Intent;
import android.os.Bundle;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import java.util.ArrayList;
import java.util.List;

public class CourseTasksActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_course_tasks);

        String language = getIntent().getStringExtra("language");
        if (language == null) language = "Java";
        TextView title = findViewById(R.id.course_tasks_title);
        ListView listView = findViewById(R.id.course_tasks_list);
        title.setText("Задачи курса: " + language);

        List<TopicItem> topics = TopicsRepository.createTopics(language);
        List<String> items = new ArrayList<>();
        for (int i = 0; i < topics.size(); i++) {
            items.add((i + 1) + ". " + topics.get(i).title);
        }
        listView.setAdapter(new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, items));

        String finalLanguage = language;
        listView.setOnItemClickListener((parent, view, position, id) -> {
            Intent intent = new Intent(this, CodePracticeActivity.class);
            intent.putExtra(CodePracticeActivity.EXTRA_LANGUAGE, finalLanguage);
            intent.putExtra(CodePracticeActivity.EXTRA_TOPIC_INDEX, position);
            startActivity(intent);
        });
    }
}
