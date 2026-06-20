package com.example.killmeplease;

import android.os.Bundle;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;
import android.content.Intent;

import androidx.appcompat.app.AppCompatActivity;

import java.util.List;

public class CoursesActivity extends AppCompatActivity {
    public static final String EXTRA_LANGUAGE = "extra_language";
    public static final String EXTRA_CONTINUE_MODE = "extra_continue_mode";

    private DbHelper dbHelper;
    private String language;
    private List<TopicItem> topics;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_courses);
        UiSettings.apply(this);

        dbHelper = new DbHelper(this);
        language = getIntent().getStringExtra(EXTRA_LANGUAGE);
        if (language == null || language.trim().isEmpty()) {
            language = dbHelper.getSelectedLanguage();
        }

        TextView titleView = findViewById(R.id.txt_courses_title);
        ListView listView = findViewById(R.id.list_topics);
        titleView.setText("Курс: " + language);

        topics = TopicsRepository.createTopics(language);
        int currentTopic = dbHelper.getCurrentTopic(language);
        TopicAdapter adapter = new TopicAdapter(this, topics, currentTopic);
        listView.setAdapter(adapter);

        boolean continueMode = getIntent().getBooleanExtra(EXTRA_CONTINUE_MODE, false);
        if (continueMode) {
            int nextTopic = Math.min(currentTopic + 1, topics.size() - 1);
            listView.setSelection(Math.max(nextTopic - 1, 0));
            Toast.makeText(this, "Открыт курс с точки остановки", Toast.LENGTH_SHORT).show();
        }

        listView.setOnItemClickListener((parent, view, position, id) -> {
            Intent intent = new Intent(this, TopicDetailActivity.class);
            intent.putExtra(TopicDetailActivity.EXTRA_LANGUAGE, language);
            intent.putExtra(TopicDetailActivity.EXTRA_TOPIC_INDEX, position);
            startActivity(intent);
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        UiSettings.apply(this);
        ListView listView = findViewById(R.id.list_topics);
        int updatedCurrent = dbHelper.getCurrentTopic(language);
        listView.setAdapter(new TopicAdapter(this, topics, updatedCurrent));
    }
}
