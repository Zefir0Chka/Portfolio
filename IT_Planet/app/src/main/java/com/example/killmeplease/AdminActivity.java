package com.example.killmeplease;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;
import androidx.core.content.ContextCompat;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.materialswitch.MaterialSwitch;
import android.graphics.drawable.Drawable;
import android.text.style.ImageSpan;

public class AdminActivity extends AppCompatActivity {
    private final int[] avatarResOptions = {
            R.drawable.avatar_astronaut,
            R.drawable.avatar_rocket,
            R.drawable.avatar_planet,
            R.drawable.ic_black_hole
    };

    private DbHelper dbHelper;
    private ImageView avatarPreview;
    private EditText nicknameInput;
    private EditText emailInput;
    private EditText phoneInput;
    private EditText statusInput;
    private TextView progressView;
    private TextView statsView;
    private TextView lastAccessCodeView;
    private TextView lastAccessCodeStatusView;
    private int selectedAvatarRes;
    private String selectedAvatarUri = "";
    private ActivityResultLauncher<String[]> pickAvatarLauncher;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_admin);
        UiSettings.apply(this);

        dbHelper = new DbHelper(this);
        avatarPreview = findViewById(R.id.admin_avatar_preview);
        nicknameInput = findViewById(R.id.input_admin_nickname);
        emailInput = findViewById(R.id.input_admin_email);
        phoneInput = findViewById(R.id.input_admin_phone);
        statusInput = findViewById(R.id.input_admin_status);
        progressView = findViewById(R.id.txt_admin_progress);
        statsView = findViewById(R.id.txt_admin_stats);
        lastAccessCodeView = findViewById(R.id.txt_last_access_code);
        lastAccessCodeStatusView = findViewById(R.id.txt_last_access_code_status);

        MaterialButton saveButton = findViewById(R.id.btn_save_admin);
        MaterialButton homeButton = findViewById(R.id.btn_admin_home);
        MaterialButton reviewsButton = findViewById(R.id.btn_admin_reviews);
        MaterialButton logoutButton = findViewById(R.id.btn_admin_logout);
        MaterialButton createAccessCodeButton = findViewById(R.id.btn_create_access_code);
        MaterialButton showAccessCodesButton = findViewById(R.id.btn_show_access_codes);
        MaterialSwitch themeSwitch = findViewById(R.id.switch_admin_theme);

        pickAvatarLauncher = registerForActivityResult(
                new ActivityResultContracts.OpenDocument(),
                uri -> {
                    if (uri == null) return;
                    try {
                        getContentResolver().takePersistableUriPermission(
                                uri, Intent.FLAG_GRANT_READ_URI_PERMISSION);
                    } catch (Exception ignored) {
                        // no-op
                    }
                    selectedAvatarUri = uri.toString();
                    avatarPreview.setImageURI(uri);
                });

        themeSwitch.setOnCheckedChangeListener(null);
        themeSwitch.setChecked(AppCompatDelegate.getDefaultNightMode() == AppCompatDelegate.MODE_NIGHT_YES);
        themeSwitch.setOnCheckedChangeListener((buttonView, isChecked) -> {
            int target = isChecked ? AppCompatDelegate.MODE_NIGHT_YES : AppCompatDelegate.MODE_NIGHT_NO;
            if (AppCompatDelegate.getDefaultNightMode() != target) {
                AppCompatDelegate.setDefaultNightMode(target);
            }
        });

        avatarPreview.setOnClickListener(v -> showAvatarChooser());
        homeButton.setOnClickListener(v -> startActivity(new Intent(this, MainActivity.class)));
        reviewsButton.setOnClickListener(v -> startActivity(new Intent(this, ReviewsActivity.class)));
        saveButton.setOnClickListener(v -> saveAdmin());
        logoutButton.setOnClickListener(v -> {
            dbHelper.logout();
            startActivity(new Intent(this, LoginActivity.class));
            finish();
        });

        createAccessCodeButton.setOnClickListener(v -> {
            String code = dbHelper.createAccessCodeForAdmin();
            if (code == null) {
                Toast.makeText(this, "Не удалось создать код доступа", Toast.LENGTH_SHORT).show();
                return;
            }
            Toast.makeText(this, "Код доступа создан: " + code, Toast.LENGTH_LONG).show();
            bindAccessCodeBlock();
        });

        showAccessCodesButton.setOnClickListener(v ->
                startActivity(new Intent(this, AccessCodesActivity.class)));

        bindAdmin();

        applyPressFeedback(saveButton);
        applyPressFeedback(homeButton);
        applyPressFeedback(reviewsButton);
        applyPressFeedback(logoutButton);
        applyPressFeedback(createAccessCodeButton);
        applyPressFeedback(showAccessCodesButton);
        applyPressFeedback(avatarPreview);
    }

    @Override
    protected void onResume() {
        super.onResume();
        UiSettings.apply(this);
    }

    private void bindAdmin() {
        DbHelper.Profile profile = dbHelper.getProfile();
        nicknameInput.setText(profile.nickname);
        emailInput.setText(profile.email);
        phoneInput.setText(profile.phone);
        statusInput.setText("Администратор");
        selectedAvatarRes = profile.avatarRes;
        selectedAvatarUri = profile.avatarUri == null ? "" : profile.avatarUri;
        if (selectedAvatarUri != null && !selectedAvatarUri.isEmpty()) {
            avatarPreview.setImageURI(Uri.parse(selectedAvatarUri));
        } else {
            avatarPreview.setImageResource(profile.avatarRes);
        }
        progressView.setText(buildProgressText(profile.tasksDone, profile.coins));

        String stats = "Зарегистрировано пользователей: " + dbHelper.getRegisteredUsersCount()
                + "\nЗадонатили: " + dbHelper.getDonorsCount();
        statsView.setText(stats);
        bindAccessCodeBlock();
    }

    private void bindAccessCodeBlock() {
        DbHelper.AccessCodeInfo info = dbHelper.getLastAccessCodeCreatedByCurrentAdmin();
        if (info == null || info.code == null || info.code.trim().isEmpty()) {
            lastAccessCodeView.setText("Код доступа: —");
            lastAccessCodeStatusView.setVisibility(View.GONE);
            return;
        }
        lastAccessCodeStatusView.setVisibility(View.VISIBLE);
        lastAccessCodeView.setText("Код доступа: " + info.code);
        if (info.used) {
            lastAccessCodeStatusView.setText("Код доступа занят");
            lastAccessCodeStatusView.setTextColor(0xFFD32F2F);
        } else {
            lastAccessCodeStatusView.setText("Свободный код доступа");
            lastAccessCodeStatusView.setTextColor(0xFF2E7D32);
        }
    }

    private void saveAdmin() {
        dbHelper.updateProfile(
                nicknameInput.getText().toString().trim(),
                emailInput.getText().toString().trim(),
                phoneInput.getText().toString().trim(),
                selectedAvatarRes,
                selectedAvatarUri
        );
        Toast.makeText(this, "Данные администратора сохранены", Toast.LENGTH_SHORT).show();
        bindAdmin();
    }

    private CharSequence buildProgressText(int tasksDone, int coins) {
        SpannableStringBuilder sb = new SpannableStringBuilder();
        sb.append("Личный прогресс: заданий ").append(String.valueOf(tasksDone)).append(", монет ");

        int iconStart = sb.length();
        sb.append(" "); // placeholder for icon

        Drawable d = ContextCompat.getDrawable(this, R.drawable.ic_coin);
        if (d != null) {
            int size = (int) (18 * getResources().getDisplayMetrics().density);
            d.setBounds(0, 0, size, size);
            sb.setSpan(new ImageSpan(d, ImageSpan.ALIGN_BOTTOM), iconStart, iconStart + 1, Spanned.SPAN_EXCLUSIVE_EXCLUSIVE);
        }

        sb.append(" ").append(String.valueOf(coins));
        return sb;
    }

    private void showAvatarChooser() {
        String[] root = {"Встроенные аватары", "Загрузить из галереи"};
        new AlertDialog.Builder(this)
                .setTitle("Выберите аватар")
                .setItems(root, (dialog, which) -> {
                    if (which == 0) {
                        String[] avatarNames = {"Астронавт", "Ракета", "Планета", "Черная дыра"};
                        new AlertDialog.Builder(this)
                                .setTitle("Встроенные аватары")
                                .setItems(avatarNames, (d2, idx) -> {
                                    selectedAvatarRes = avatarResOptions[idx];
                                    selectedAvatarUri = "";
                                    avatarPreview.setImageResource(selectedAvatarRes);
                                })
                                .show();
                    } else {
                        pickAvatarLauncher.launch(new String[]{"image/*"});
                    }
                })
                .show();
    }

    private void applyPressFeedback(android.view.View view) {
        if (view == null) return;
        view.setOnTouchListener((v, event) -> {
            switch (event.getAction()) {
                case android.view.MotionEvent.ACTION_DOWN:
                    v.animate().scaleX(0.97f).scaleY(0.97f).setDuration(90).start();
                    break;
                case android.view.MotionEvent.ACTION_UP:
                case android.view.MotionEvent.ACTION_CANCEL:
                    v.animate().scaleX(1f).scaleY(1f).setDuration(120).start();
                    break;
            }
            return false;
        });
    }
}
