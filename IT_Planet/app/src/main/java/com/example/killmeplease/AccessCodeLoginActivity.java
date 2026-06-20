package com.example.killmeplease;

import android.content.Intent;
import android.os.Bundle;
import android.text.TextUtils;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.button.MaterialButton;

public class AccessCodeLoginActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_access_code_login);

        DbHelper dbHelper = new DbHelper(this);

        EditText identifierInput = findViewById(R.id.input_identifier);
        EditText passwordInput = findViewById(R.id.input_password);
        EditText accessCodeInput = findViewById(R.id.input_access_code);
        MaterialButton submitButton = findViewById(R.id.btn_submit_access_code);

        submitButton.setOnClickListener(v -> {
            String identifier = identifierInput.getText().toString().trim();
            String password = passwordInput.getText().toString().trim();
            String accessCode = accessCodeInput.getText().toString().trim();

            if (TextUtils.isEmpty(identifier) || TextUtils.isEmpty(password) || TextUtils.isEmpty(accessCode)) {
                Toast.makeText(this, "Заполните: эл-почта/телефон, пароль и код доступа", Toast.LENGTH_SHORT).show();
                return;
            }

            DbHelper.AccessCodeRegisterResult result =
                    dbHelper.registerUserByIdentifierWithAccessCode(identifier, password, accessCode);

            if (result == DbHelper.AccessCodeRegisterResult.OK) {
                startActivity(new Intent(this, MainActivity.class));
                finish();
            } else if (result == DbHelper.AccessCodeRegisterResult.CODE_NOT_FOUND) {
                Toast.makeText(this, "Код доступа не найден", Toast.LENGTH_SHORT).show();
            } else if (result == DbHelper.AccessCodeRegisterResult.CODE_ALREADY_USED) {
                Toast.makeText(this, "Код доступа занят", Toast.LENGTH_SHORT).show();
            } else if (result == DbHelper.AccessCodeRegisterResult.IDENTIFIER_ALREADY_EXISTS) {
                Toast.makeText(this, "Пользователь с таким email/телефоном уже есть", Toast.LENGTH_SHORT).show();
            } else {
                Toast.makeText(this, "Ошибка регистрации по коду доступа", Toast.LENGTH_SHORT).show();
            }
        });
    }
}

