package com.example.killmeplease;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;
import android.graphics.Color;

import java.util.List;

public class TopicAdapter extends BaseAdapter {
    private final Context context;
    private final List<TopicItem> topics;
    private final int currentTopic;

    public TopicAdapter(Context context, List<TopicItem> topics, int currentTopic) {
        this.context = context;
        this.topics = topics;
        this.currentTopic = currentTopic;
    }

    @Override
    public int getCount() {
        return topics.size();
    }

    @Override
    public Object getItem(int position) {
        return topics.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View view = convertView;
        if (view == null) {
            view = LayoutInflater.from(context).inflate(R.layout.item_topic, parent, false);
        }

        TopicItem item = topics.get(position);
        TextView titleView = view.findViewById(R.id.topic_title);
        TextView statusView = view.findViewById(R.id.topic_status);
        ImageView decor = view.findViewById(R.id.topic_decor);

        titleView.setText((position + 1) + ". " + item.title);

        if (position <= currentTopic) {
            statusView.setText("Статус: Пройдено");
            statusView.setTextColor(Color.parseColor("#1B8E3E"));
        } else {
            statusView.setText("Статус: Не начат");
            statusView.setTextColor(Color.WHITE);
        }

        int[] icons = new int[]{
                R.drawable.decor_star,
                R.drawable.avatar_rocket,
                R.drawable.avatar_planet,
                R.drawable.planet_cpp
        };
        decor.setImageResource(icons[position % icons.length]);

        return view;
    }
}
