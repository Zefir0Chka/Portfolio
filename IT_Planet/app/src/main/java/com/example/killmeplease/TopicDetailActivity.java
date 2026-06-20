package com.example.killmeplease;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.text.Html;
import android.text.method.LinkMovementMethod;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.button.MaterialButton;

import java.util.List;

public class TopicDetailActivity extends AppCompatActivity {
    public static final String EXTRA_LANGUAGE = "extra_language";
    public static final String EXTRA_TOPIC_INDEX = "extra_topic_index";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_topic_detail);
        UiSettings.apply(this);

        String language = getIntent().getStringExtra(EXTRA_LANGUAGE);
        int topicIndex = getIntent().getIntExtra(EXTRA_TOPIC_INDEX, 0);
        DbHelper dbHelper = new DbHelper(this);

        if (language == null || language.trim().isEmpty()) {
            language = dbHelper.getSelectedLanguage();
        }

        List<TopicItem> topics = TopicsRepository.createTopics(language);
        TopicItem topic = topics.get(topicIndex);

        TextView titleView = findViewById(R.id.txt_topic_detail_title);
        TextView contentView = findViewById(R.id.txt_topic_detail_content);
        TextView taskView = findViewById(R.id.txt_topic_task);
        MaterialButton ideButton = findViewById(R.id.btn_open_ide);
        MaterialButton completeButton = findViewById(R.id.btn_mark_complete);
        MaterialButton watchVideoButton = findViewById(R.id.btn_watch_video);
        ImageView ex1 = findViewById(R.id.img_example_1);
        ImageView ex2 = findViewById(R.id.img_example_2);
        ImageView ex3 = findViewById(R.id.img_example_3);

        titleView.setText((topicIndex + 1) + ". " + topic.title);
        contentView.setText(Html.fromHtml(topic.content, Html.FROM_HTML_MODE_LEGACY));
        contentView.setMovementMethod(LinkMovementMethod.getInstance());
        taskView.setText(topic.taskText);

        String finalLanguage = language;
        watchVideoButton.setOnClickListener(v -> {
            if (topic.videoUrl == null || topic.videoUrl.trim().isEmpty()) {
                Toast.makeText(this, "Видео не задано", Toast.LENGTH_SHORT).show();
                return;
            }
            startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse(topic.videoUrl)));
        });

        int[] imgs = topic.exampleImageRes;
        if (imgs != null && imgs.length > 0) {
            ex1.setImageResource(imgs[0]);
            ex1.setVisibility(ImageView.VISIBLE);
        }
        if (imgs != null && imgs.length > 1) {
            ex2.setImageResource(imgs[1]);
            ex2.setVisibility(ImageView.VISIBLE);
        }
        if (imgs != null && imgs.length > 2) {
            ex3.setImageResource(imgs[2]);
            ex3.setVisibility(ImageView.VISIBLE);
        }

        ideButton.setOnClickListener(v -> {
            Intent intent = new Intent(this, CodePracticeActivity.class);
            intent.putExtra(CodePracticeActivity.EXTRA_LANGUAGE, finalLanguage);
            intent.putExtra(CodePracticeActivity.EXTRA_TOPIC_INDEX, topicIndex);
            startActivity(intent);
        });

        completeButton.setOnClickListener(v -> {
            dbHelper.markTopicAsCompleted(finalLanguage, topicIndex);
            Toast.makeText(this, "Тема отмечена как изученная", Toast.LENGTH_SHORT).show();
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        UiSettings.apply(this);
    }
}
