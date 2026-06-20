package com.example.killmeplease;

import android.graphics.Color;
import android.os.Bundle;
import android.widget.SeekBar;
import android.widget.TextView;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;
import androidx.core.os.LocaleListCompat;

public class SettingsActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_settings);
        UiSettings.apply(this);

        findViewById(R.id.btn_language_menu).setOnClickListener(v -> showLanguageDialog());

        findViewById(R.id.btn_change_theme).setOnClickListener(v -> {
            int current = AppCompatDelegate.getDefaultNightMode();
            int target = current == AppCompatDelegate.MODE_NIGHT_YES
                    ? AppCompatDelegate.MODE_NIGHT_NO
                    : AppCompatDelegate.MODE_NIGHT_YES;
            AppCompatDelegate.setDefaultNightMode(target);
            recreate();
        });

        com.google.android.material.materialswitch.MaterialSwitch readingSwitch = findViewById(R.id.switch_reading_mode);
        readingSwitch.setChecked(UiSettings.isReadingMode(this));
        readingSwitch.setOnCheckedChangeListener((buttonView, isChecked) -> {
            UiSettings.setReadingMode(this, isChecked);
            UiSettings.apply(this);
        });

        TextView textScaleLabel = findViewById(R.id.txt_text_scale);
        SeekBar seekScale = findViewById(R.id.seek_text_scale);
        float currentScale = UiSettings.getTextScale(this);
        int progress = Math.round((currentScale - 0.85f) * 100f);
        seekScale.setProgress(Math.max(0, Math.min(50, progress)));
        textScaleLabel.setText("Размер текста: " + Math.round(currentScale * 100f) + "%");
        seekScale.setOnSeekBarChangeListener(new SeekBar.OnSeekBarChangeListener() {
            @Override
            public void onProgressChanged(SeekBar seekBar, int p, boolean fromUser) {
                float scale = 0.85f + (p / 100f);
                UiSettings.setTextScale(SettingsActivity.this, scale);
                textScaleLabel.setText("Размер текста: " + Math.round(scale * 100f) + "%");
                UiSettings.apply(SettingsActivity.this);
            }

            @Override
            public void onStartTrackingTouch(SeekBar seekBar) {
            }

            @Override
            public void onStopTrackingTouch(SeekBar seekBar) {
            }
        });

        findViewById(R.id.color_blue).setOnClickListener(v -> setAccent("#5B8CFF"));
        findViewById(R.id.color_green).setOnClickListener(v -> setAccent("#4ADE80"));
        findViewById(R.id.color_purple).setOnClickListener(v -> setAccent("#A78BFA"));
        findViewById(R.id.color_orange).setOnClickListener(v -> setAccent("#FB923C"));
    }

    private void setAccent(String colorHex) {
        UiSettings.setAccentColor(this, Color.parseColor(colorHex));
        UiSettings.apply(this);
    }

    private void showLanguageDialog() {
        String[] labels = {"Русский", "English", "中文", "العربية", "Беларуская", "Português", "Español"};
        String[] tags = {"ru", "en", "zh", "ar", "be", "pt", "es"};
        new AlertDialog.Builder(this)
                .setTitle("Язык интерфейса")
                .setItems(labels, (d, which) -> {
                    String tag = tags[which];
                    AppCompatDelegate.setApplicationLocales(LocaleListCompat.forLanguageTags(tag));
                    recreate();
                })
                .show();
    }

    @Override
    protected void onResume() {
        super.onResume();
        UiSettings.apply(this);
    }
}

