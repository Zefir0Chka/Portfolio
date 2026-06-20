package com.example.killmeplease;

import android.content.Context;
import android.database.Cursor;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

public class AccessCodesAdapter extends BaseAdapter {
    private final Context context;
    private Cursor cursor;

    public AccessCodesAdapter(Context context, Cursor cursor) {
        this.context = context;
        this.cursor = cursor;
    }

    @Override
    public int getCount() {
        return cursor == null ? 0 : cursor.getCount();
    }

    @Override
    public Object getItem(int position) {
        return position;
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View view = convertView;
        if (view == null) {
            view = LayoutInflater.from(context).inflate(R.layout.item_access_code, parent, false);
        }
        cursor.moveToPosition(position);
        String code = cursor.getString(0);
        boolean used = !cursor.isNull(1);

        TextView codeView = view.findViewById(R.id.txt_access_code_value);
        TextView statusView = view.findViewById(R.id.txt_access_code_status);

        codeView.setText(code);
        if (used) {
            statusView.setText("Код доступа занят");
            statusView.setTextColor(Color.parseColor("#D32F2F"));
        } else {
            statusView.setText("Свободный код доступа");
            statusView.setTextColor(Color.parseColor("#2E7D32"));
        }
        return view;
    }

    public void swapCursor(Cursor newCursor) {
        if (cursor != null) cursor.close();
        cursor = newCursor;
        notifyDataSetChanged();
    }
}

