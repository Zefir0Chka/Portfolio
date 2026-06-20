package com.example.killmeplease;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.text.SpannableStringBuilder;
import android.text.Spanned;
import android.text.TextUtils;
import androidx.appcompat.app.AlertDialog;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.activity.result.ActivityResultLauncher;
import androidx.activity.result.contract.ActivityResultContracts;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;
import androidx.core.content.ContextCompat;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.materialswitch.MaterialSwitch;
import android.graphics.drawable.Drawable;
import android.text.style.ImageSpan;

public class ProfileActivity extends AppCompatActivity {
    private final int[] avatarResOptions = {
            R.drawable.avatar_astronaut,
            R.drawable.avatar_rocket,
            R.drawable.avatar_planet,
            R.drawable.planet_python
    };

    private DbHelper dbHelper;
    private ImageView avatarPreview;
    private EditText nicknameInput;
    private EditText emailInput;
    private EditText phoneInput;
    private EditText statusInput;
    private TextView progressView;
    private int selectedAvatarRes;
    private String selectedAvatarUri = "";
    private ActivityResultLauncher<String[]> pickAvatarLauncher;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_profile);
        UiSettings.apply(this);

        dbHelper = new DbHelper(this);
        avatarPreview = findViewById(R.id.profile_avatar_preview);
        nicknameInput = findViewById(R.id.input_profile_nickname);
        emailInput = findViewById(R.id.input_profile_email);
        phoneInput = findViewById(R.id.input_profile_phone);
        statusInput = findViewById(R.id.input_profile_status);
        progressView = findViewById(R.id.txt_progress);
        MaterialButton saveButton = findViewById(R.id.btn_save_profile);
        MaterialButton logoutButton = findViewById(R.id.btn_logout);
        MaterialButton homeButton = findViewById(R.id.btn_profile_home);
        MaterialSwitch themeSwitch = findViewById(R.id.switch_profile_theme);

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

        bindProfileData();

        avatarPreview.setOnClickListener(v -> showAvatarChooser());

        themeSwitch.setOnCheckedChangeListener(null);
        themeSwitch.setChecked(AppCompatDelegate.getDefaultNightMode() == AppCompatDelegate.MODE_NIGHT_YES);
        themeSwitch.setOnCheckedChangeListener((buttonView, isChecked) -> {
            int target = isChecked ? AppCompatDelegate.MODE_NIGHT_YES : AppCompatDelegate.MODE_NIGHT_NO;
            if (AppCompatDelegate.getDefaultNightMode() != target) {
                AppCompatDelegate.setDefaultNightMode(target);
            }
        });

        homeButton.setOnClickListener(v -> startActivity(new Intent(this, MainActivity.class)));

        saveButton.setOnClickListener(v -> saveProfile());
        logoutButton.setOnClickListener(v -> {
            dbHelper.logout();
            Intent intent = new Intent(this, LoginActivity.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
            startActivity(intent);
            finish();
        });

        applyPressFeedback(saveButton);
        applyPressFeedback(logoutButton);
        applyPressFeedback(homeButton);
        applyPressFeedback(avatarPreview);
    }

    @Override
    protected void onResume() {
        super.onResume();
        UiSettings.apply(this);
    }

    private void bindProfileData() {
        DbHelper.Profile profile = dbHelper.getProfile();
        nicknameInput.setText(profile.nickname);
        emailInput.setText(profile.email);
        phoneInput.setText(profile.phone);
        statusInput.setText(profile.status);
        selectedAvatarRes = profile.avatarRes;
        selectedAvatarUri = profile.avatarUri == null ? "" : profile.avatarUri;
        if (!TextUtils.isEmpty(selectedAvatarUri)) {
            avatarPreview.setImageURI(Uri.parse(selectedAvatarUri));
        } else {
            avatarPreview.setImageResource(profile.avatarRes);
        }

        int completedCourses = dbHelper.getCompletedCoursesCount();
        int level = 1 + completedCourses;
        progressView.setText(buildProgressText(level, completedCourses, profile.tasksDone, profile.coins));
    }

    private void saveProfile() {
        String nickname = nicknameInput.getText().toString().trim();
        String email = emailInput.getText().toString().trim();
        String phone = phoneInput.getText().toString().trim();
        if (TextUtils.isEmpty(nickname)) {
            Toast.makeText(this, "Никнейм не может быть пустым", Toast.LENGTH_SHORT).show();
            return;
        }

        dbHelper.updateProfile(
                nickname,
                email,
                phone,
                selectedAvatarRes,
                selectedAvatarUri
        );
        Toast.makeText(this, "Профиль обновлен", Toast.LENGTH_SHORT).show();
        bindProfileData();
    }

    private void showAvatarChooser() {
        String[] root = {"Встроенные аватары", "Загрузить из галереи"};
        new AlertDialog.Builder(this)
                .setTitle("Выберите аватар")
                .setItems(root, (dialog, which) -> {
                    if (which == 0) {
                        String[] avatarNames = {"Астронавт", "Ракета", "Планета", "Python-планета"};
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

    private CharSequence buildProgressText(int level, int completedCourses, int tasksDone, int coins) {
        SpannableStringBuilder sb = new SpannableStringBuilder();
        sb.append("Уровень: ").append(String.valueOf(level));
        sb.append("\nПройдено курсов: ").append(String.valueOf(completedCourses));
        sb.append("\nРешено заданий: ").append(String.valueOf(tasksDone));
        sb.append("\nМонеты: ");

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
