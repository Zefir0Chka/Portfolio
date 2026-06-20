package com.example.killmeplease;

import android.os.Bundle;
import android.view.Gravity;
import android.text.TextUtils;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.button.MaterialButton;

import java.util.ArrayList;
import java.util.List;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class CodePracticeActivity extends AppCompatActivity {
    public static final String EXTRA_LANGUAGE = "extra_language";
    public static final String EXTRA_TOPIC_INDEX = "extra_topic_index";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_code_practice);
        UiSettings.apply(this);

        String language = getIntent().getStringExtra(EXTRA_LANGUAGE);
        int topicIndex = getIntent().getIntExtra(EXTRA_TOPIC_INDEX, 0);
        DbHelper dbHelper = new DbHelper(this);
        if (language == null || language.trim().isEmpty()) language = dbHelper.getSelectedLanguage();

        List<TopicItem> topics = TopicsRepository.createTopics(language);
        TopicItem topic = topics.get(topicIndex);

        TextView title = findViewById(R.id.practice_title);
        TextView task = findViewById(R.id.practice_task);
        EditText editor = findViewById(R.id.practice_editor);
        TextView output = findViewById(R.id.practice_output);
        MaterialButton runButton = findViewById(R.id.btn_run);
        MaterialButton checkButton = findViewById(R.id.btn_check);

        title.setText(language + " IDE — " + topic.title);
        task.setText(topic.taskText);
        editor.setText(topic.starterCode);

        String finalLanguage = language;
        runButton.setOnClickListener(v -> {
            String code = editor.getText().toString();
            output.setText(simulateCompilerOutput(code, topic.expectedOutput, finalLanguage));
        });

        checkButton.setOnClickListener(v -> {
            String code = editor.getText().toString();
            if (TextUtils.isEmpty(code.trim())) {
                Toast.makeText(this, "Код пустой", Toast.LENGTH_SHORT).show();
                return;
            }
            if (normalizeExpected(code).equals(normalizeExpected(topic.starterCode))) {
                output.setText("Проверка: НЕ ПРОЙДЕНА\n\nСначала исправьте шаблон кода, затем запустите проверку.");
                showSpaceToast("Исправьте шаблон кода");
                return;
            }
            String console = simulateRunConsole(code, finalLanguage);
            output.setText(console);
            boolean ok = simulateCheck(code, topic.expectedOutput, finalLanguage, console)
                    && simulateTopicRequirements(code, topic.requiredSnippets, finalLanguage);
            if (ok) {
                output.setText(console + "\n\nПроверка: OK\nОжидаемый вывод: " + topic.expectedOutput);
                boolean rewarded = dbHelper.awardCoinsForTask(finalLanguage, topicIndex, 1);
                if (rewarded) {
                    showSpaceToast("Правильно! +1 монета");
                } else {
                    showSpaceToast("Задача уже была зачтена ранее");
                }
                dbHelper.markTopicAsCompleted(finalLanguage, topicIndex);
            } else {
                output.setText(console + "\n\nПроверка: НЕ ПРОЙДЕНА\nОжидаемый вывод: " + topic.expectedOutput);
                showSpaceToast("Проверка не пройдена");
            }
        });
    }

    @Override
    protected void onResume() {
        super.onResume();
        UiSettings.apply(this);
    }

    private String simulateCompilerOutput(String code, String expected, String language) {
        String console = simulateRunConsole(code, language);
        boolean ok = simulateCheck(code, expected, language, console);
        if (ok) return console + "\n\nПроверка: OK";
        return console + "\n\nПроверка: ожидаемая строка не найдена.";
    }

    private String simulateRunConsole(String code, String language) {
        List<String> lines = extractPrintedLines(code, language);
        if (lines.isEmpty()) {
            return "Console:\n(нет вывода)";
        }
        StringBuilder sb = new StringBuilder("Console:\n");
        for (int i = 0; i < lines.size(); i++) {
            sb.append(lines.get(i));
            if (i != lines.size() - 1) sb.append("\n");
        }
        return sb.toString();
    }

    private boolean simulateCheck(String code, String expected, String language, String consoleText) {
        String expectedNorm = normalizeExpected(expected);
        if (expectedNorm.isEmpty()) return false;

        List<String> printed = extractPrintedLines(code, language);
        String actualNorm = normalizeExpected(joinLines(printed));
        return expectedNorm.equals(actualNorm);
    }

    private List<String> extractPrintedLines(String code, String language) {
        ArrayList<String> out = new ArrayList<>();
        if (code == null) return out;
        String source = stripComments(code, language);

        // Python: print("...") / print('...')
        if ("Python".equals(language)) {
            Pattern p = Pattern.compile("print\\s*\\(\\s*([\"'])(.*?)\\1\\s*\\)");
            Matcher m = p.matcher(source);
            while (m.find()) out.add(m.group(2));
            return out;
        }

        // 1C: Сообщить("...") / Сообщить('...')
        if ("1C".equals(language)) {
            Pattern p = Pattern.compile("Сообщить\\s*\\(\\s*([\"'])(.*?)\\1\\s*\\)", Pattern.CASE_INSENSITIVE | Pattern.UNICODE_CASE);
            Matcher m = p.matcher(source);
            while (m.find()) out.add(m.group(2));
            return out;
        }

        // Java/C#/C++ (упрощенно): println("...") или print("...")
        Pattern p = Pattern.compile("(println|print)\\s*\\(\\s*([\"'])(.*?)\\2\\s*\\)");
        Matcher m = p.matcher(source);
        while (m.find()) out.add(m.group(3));
        return out;
    }

    private String joinLines(List<String> lines) {
        if (lines == null || lines.isEmpty()) return "";
        StringBuilder sb = new StringBuilder();
        for (int i = 0; i < lines.size(); i++) {
            sb.append(lines.get(i));
            if (i != lines.size() - 1) sb.append("\n");
        }
        return sb.toString();
    }

    private String normalizeExpected(String s) {
        if (s == null) return "";
        // Normalize newlines + trim trailing spaces on each line
        String normalized = s.replace("\r\n", "\n").replace("\r", "\n");
        String[] parts = normalized.split("\n", -1);
        StringBuilder sb = new StringBuilder();
        for (int i = 0; i < parts.length; i++) {
            sb.append(rtrim(parts[i]));
            if (i != parts.length - 1) sb.append("\n");
        }
        return sb.toString().trim();
    }

    private String rtrim(String s) {
        int end = s.length();
        while (end > 0) {
            char c = s.charAt(end - 1);
            if (c == ' ' || c == '\t') end--;
            else break;
        }
        return s.substring(0, end);
    }

    private boolean simulateTopicRequirements(String code, String[] requiredSnippets, String language) {
        if (requiredSnippets == null || requiredSnippets.length == 0) return true;
        String cleaned = stripComments(code, language);
        for (String snippet : requiredSnippets) {
            if (snippet == null || snippet.trim().isEmpty()) continue;
            if (!cleaned.contains(snippet)) return false;
        }
        return true;
    }

    private String stripComments(String code, String language) {
        if (code == null) return "";
        String s = code;
        // Remove /* */ blocks (Java-like)
        s = s.replaceAll("/\\*[\\s\\S]*?\\*/", "");
        // Remove // line comments
        s = s.replaceAll("(?m)//.*$", "");
        // Remove Python # line comments
        if ("Python".equals(language)) {
            s = s.replaceAll("(?m)#.*$", "");
        }
        // 1C also uses // for comments (already handled)
        return s;
    }

    private void showSpaceToast(String message) {
        View view = LayoutInflater.from(this).inflate(R.layout.toast_space, null);
        ((TextView) view.findViewById(R.id.toast_text)).setText(message);
        Toast toast = new Toast(this);
        toast.setView(view);
        toast.setDuration(Toast.LENGTH_LONG);
        toast.setGravity(Gravity.BOTTOM | Gravity.CENTER_HORIZONTAL, 0, (int) (90 * getResources().getDisplayMetrics().density));
        toast.show();
    }
}
