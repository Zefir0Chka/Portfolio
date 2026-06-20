package com.example.killmeplease;

import android.content.Context;
import android.text.InputType;
import android.widget.EditText;

import androidx.appcompat.app.AlertDialog;

public final class AdminLoginDialog {
    public interface Callback {
        void onCodeEntered(String code);
    }

    private AdminLoginDialog() {}

    public static void show(Context context, Callback callback) {
        EditText input = new EditText(context);
        input.setHint("Код администратора");
        input.setInputType(InputType.TYPE_CLASS_NUMBER | InputType.TYPE_NUMBER_VARIATION_PASSWORD);

        new AlertDialog.Builder(context)
                .setTitle("Вход администратора")
                .setView(input)
                .setPositiveButton("Войти", (d, which) -> {
                    String code = input.getText() == null ? "" : input.getText().toString().trim();
                    callback.onCodeEntered(code);
                })
                .setNegativeButton("Отмена", null)
                .show();
    }
}

