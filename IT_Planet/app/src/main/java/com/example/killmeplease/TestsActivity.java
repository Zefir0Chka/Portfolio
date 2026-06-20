package com.example.killmeplease;

import android.content.Intent;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

public class TestsActivity extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = new Intent(this, CourseSelectActivity.class);
        intent.putExtra(CourseSelectActivity.EXTRA_MODE, CourseSelectActivity.MODE_TESTS);
        startActivity(intent);
        finish();
    }
}
