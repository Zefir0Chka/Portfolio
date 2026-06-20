package com.example.killmeplease;

import android.content.Context;
import android.database.Cursor;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

public class ReviewAdapter extends BaseAdapter {
    private final Context context;
    private Cursor cursor;

    public ReviewAdapter(Context context, Cursor cursor) {
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
            view = LayoutInflater.from(context).inflate(R.layout.item_review, parent, false);
        }
        cursor.moveToPosition(position);
        int rating = cursor.getInt(0);
        String text = cursor.getString(1);
        String nickname = cursor.getString(2);
        int avatarRes = cursor.getInt(3);

        ((ImageView) view.findViewById(R.id.review_avatar)).setImageResource(avatarRes);
        ((TextView) view.findViewById(R.id.review_nickname)).setText(nickname);
        ((TextView) view.findViewById(R.id.review_stars)).setText(stars(rating));
        ((TextView) view.findViewById(R.id.review_text)).setText(text);
        return view;
    }

    public void swapCursor(Cursor newCursor) {
        if (cursor != null) cursor.close();
        cursor = newCursor;
        notifyDataSetChanged();
    }

    private String stars(int value) {
        StringBuilder builder = new StringBuilder();
        for (int i = 0; i < 5; i++) {
            builder.append(i < value ? "★" : "☆");
        }
        return builder.toString();
    }
}
