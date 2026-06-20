package com.example.killmeplease;

import android.os.Bundle;
import android.text.TextUtils;
import android.view.View;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.RatingBar;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.android.material.button.MaterialButton;

public class ReviewsActivity extends AppCompatActivity {
    private DbHelper dbHelper;
    private ReviewAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reviews);

        dbHelper = new DbHelper(this);
        RatingBar ratingBar = findViewById(R.id.rating_input);
        EditText reviewInput = findViewById(R.id.review_input);
        MaterialButton sendButton = findViewById(R.id.btn_send_review);
        ListView listView = findViewById(R.id.list_reviews);
        LinearLayout form = findViewById(R.id.review_form);

        boolean isAdmin = "admin".equals(dbHelper.getProfile().role);
        if (isAdmin) {
            // Админ видит все отзывы, но не может писать
            form.setVisibility(View.GONE);
            adapter = new ReviewAdapter(this, dbHelper.getReviewsCursor());
            listView.setAdapter(adapter);
        } else {
            // Пользователь может писать, но не видит список отзывов
            listView.setVisibility(View.GONE);
        }

        sendButton.setOnClickListener(v -> {
            if (isAdmin) {
                Toast.makeText(this, "Администратор не может отправлять отзывы", Toast.LENGTH_SHORT).show();
                return;
            }
            String text = reviewInput.getText().toString().trim();
            int rating = Math.max(1, Math.round(ratingBar.getRating()));
            if (TextUtils.isEmpty(text)) {
                Toast.makeText(this, "Напишите отзыв или предложение", Toast.LENGTH_SHORT).show();
                return;
            }
            dbHelper.addReview(rating, text);
            reviewInput.setText("");
            Toast.makeText(this, "Отзыв отправлен", Toast.LENGTH_SHORT).show();
        });
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (adapter != null) {
            adapter.swapCursor(null);
        }
    }
}
