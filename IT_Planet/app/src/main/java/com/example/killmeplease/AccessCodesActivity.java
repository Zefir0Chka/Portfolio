package com.example.killmeplease;

import android.database.Cursor;
import android.os.Bundle;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

public class AccessCodesActivity extends AppCompatActivity {
    private DbHelper dbHelper;
    private AccessCodesAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_access_codes);

        dbHelper = new DbHelper(this);
        ListView listView = findViewById(R.id.list_access_codes);

        adapter = new AccessCodesAdapter(this, dbHelper.getAccessCodesCursor());
        listView.setAdapter(adapter);
    }

    @Override
    protected void onDestroy() {
        super.onDestroy();
        if (adapter != null) {
            adapter.swapCursor(null);
        }
    }

    @Override
    protected void onResume() {
        super.onResume();
        if (adapter != null) {
            adapter.swapCursor(dbHelper.getAccessCodesCursor());
        }
    }
}

