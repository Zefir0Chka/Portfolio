package com.example.killmeplease;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.button.MaterialButton;

public class LoginActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        DbHelper dbHelper = new DbHelper(this);
        EditText identifierInput = findViewById(R.id.input_identifier);
        EditText passwordInput = findViewById(R.id.input_password);
        MaterialButton loginButton = findViewById(R.id.btn_login);
        MaterialButton registerButton = findViewById(R.id.btn_register);
        MaterialButton accessCodeLoginButton = findViewById(R.id.btn_login_by_access_code);
        ImageButton adminLoginButton = findViewById(R.id.btn_admin_login);

        loginButton.setOnClickListener(v -> {
            String identifier = identifierInput.getText().toString().trim();
            String password = passwordInput.getText().toString().trim();
            if (TextUtils.isEmpty(identifier) || TextUtils.isEmpty(password)) {
                Toast.makeText(this, "Введите эл-почту/телефон и пароль", Toast.LENGTH_SHORT).show();
                return;
            }
            if (!dbHelper.loginByIdentifier(identifier, password)) {
                Toast.makeText(this, "Неверные данные для входа", Toast.LENGTH_SHORT).show();
                return;
            }
            if ("admin".equals(dbHelper.getProfile().role)) {
                startActivity(new Intent(this, AdminActivity.class));
            } else {
                startActivity(new Intent(this, MainActivity.class));
            }
            finish();
        });

        registerButton.setOnClickListener(v -> {
            String identifier = identifierInput.getText().toString().trim();
            String password = passwordInput.getText().toString().trim();

            if (TextUtils.isEmpty(identifier) || TextUtils.isEmpty(password)) {
                Toast.makeText(this, "Для регистрации нужны эл-почта/телефон и пароль", Toast.LENGTH_SHORT).show();
                return;
            }
            boolean created = dbHelper.registerUserByIdentifier(identifier, password);
            if (!created) {
                Toast.makeText(this, "Пользователь с таким email/телефоном уже есть", Toast.LENGTH_SHORT).show();
                return;
            }

            startActivity(new Intent(this, MainActivity.class));
            finish();
        });

        accessCodeLoginButton.setOnClickListener(v ->
                startActivity(new Intent(this, AccessCodeLoginActivity.class)));

        adminLoginButton.setOnClickListener(v -> {
            AdminLoginDialog.show(this, code -> {
                if (!dbHelper.loginAdminByCode(code)) {
                    Toast.makeText(this, "Неверный код администратора", Toast.LENGTH_SHORT).show();
                    return;
                }
                startActivity(new Intent(this, AdminActivity.class));
                finish();
            });
        });
    }
}
