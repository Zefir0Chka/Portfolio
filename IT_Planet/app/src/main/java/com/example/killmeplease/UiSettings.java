package com.example.killmeplease;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;
import android.content.res.ColorStateList;
import android.graphics.Color;
import android.util.TypedValue;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.TextView;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.materialswitch.MaterialSwitch;

public final class UiSettings {
    private static final String PREFS = "ui_settings";
    private static final String KEY_TEXT_SCALE = "text_scale";
    private static final String KEY_ACCENT = "accent_color";
    private static final String KEY_READING_MODE = "reading_mode";

    private UiSettings() {
    }

    public static float getTextScale(Context context) {
        return prefs(context).getFloat(KEY_TEXT_SCALE, 1.0f);
    }

    public static void setTextScale(Context context, float scale) {
        prefs(context).edit().putFloat(KEY_TEXT_SCALE, clamp(scale, 0.85f, 1.35f)).apply();
    }

    public static int getAccentColor(Context context) {
        return prefs(context).getInt(KEY_ACCENT, Color.parseColor("#5B8CFF"));
    }

    public static void setAccentColor(Context context, int color) {
        prefs(context).edit().putInt(KEY_ACCENT, color).apply();
    }

    public static boolean isReadingMode(Context context) {
        return prefs(context).getBoolean(KEY_READING_MODE, false);
    }

    public static void setReadingMode(Context context, boolean enabled) {
        prefs(context).edit().putBoolean(KEY_READING_MODE, enabled).apply();
    }

    public static void apply(Activity activity) {
        FrameLayout content = activity.findViewById(android.R.id.content);
        if (content == null || content.getChildCount() == 0) return;

        View root = content.getChildAt(0);
        float scale = getTextScale(activity);
        int accent = getAccentColor(activity);
        applyRecursive(root, scale, accent);
        applyReadingOverlay(activity, content, isReadingMode(activity));
    }

    private static void applyRecursive(View view, float textScale, int accent) {
        if (view instanceof TextView) {
            TextView tv = (TextView) view;
            Object base = tv.getTag(R.id.tag_text_size_base);
            float baseSizePx;
            if (base instanceof Float) {
                baseSizePx = (Float) base;
            } else {
                baseSizePx = tv.getTextSize();
                tv.setTag(R.id.tag_text_size_base, baseSizePx);
            }
            tv.setTextSize(TypedValue.COMPLEX_UNIT_PX, baseSizePx * textScale);
        }

        if (view instanceof MaterialButton) {
            MaterialButton b = (MaterialButton) view;
            b.setBackgroundTintList(ColorStateList.valueOf(accent));
        } else if (view instanceof MaterialSwitch) {
            MaterialSwitch s = (MaterialSwitch) view;
            s.setThumbTintList(ColorStateList.valueOf(lighten(accent, 0.2f)));
            s.setTrackTintList(ColorStateList.valueOf(withAlpha(accent, 110)));
        }

        if (view instanceof ViewGroup) {
            ViewGroup vg = (ViewGroup) view;
            for (int i = 0; i < vg.getChildCount(); i++) {
                applyRecursive(vg.getChildAt(i), textScale, accent);
            }
        }
    }

    private static void applyReadingOverlay(Context context, FrameLayout content, boolean enabled) {
        View overlay = content.findViewById(R.id.reading_overlay);
        if (enabled) {
            if (overlay == null) {
                overlay = new View(context);
                overlay.setId(R.id.reading_overlay);
                overlay.setLayoutParams(new FrameLayout.LayoutParams(
                        ViewGroup.LayoutParams.MATCH_PARENT,
                        ViewGroup.LayoutParams.MATCH_PARENT
                ));
                overlay.setClickable(false);
                overlay.setFocusable(false);
                content.addView(overlay);
            }
            overlay.setBackgroundColor(Color.parseColor("#2AFFC778"));
            overlay.setVisibility(View.VISIBLE);
            overlay.bringToFront();
        } else if (overlay != null) {
            overlay.setVisibility(View.GONE);
        }
    }

    private static int lighten(int color, float amount) {
        int r = Color.red(color);
        int g = Color.green(color);
        int b = Color.blue(color);
        r = (int) (r + (255 - r) * amount);
        g = (int) (g + (255 - g) * amount);
        b = (int) (b + (255 - b) * amount);
        return Color.rgb(clampColor(r), clampColor(g), clampColor(b));
    }

    private static int withAlpha(int color, int alpha) {
        return Color.argb(clampColor(alpha), Color.red(color), Color.green(color), Color.blue(color));
    }

    private static int clampColor(int x) {
        return Math.max(0, Math.min(255, x));
    }

    private static float clamp(float v, float min, float max) {
        return Math.max(min, Math.min(max, v));
    }

    private static SharedPreferences prefs(Context context) {
        return context.getSharedPreferences(PREFS, Context.MODE_PRIVATE);
    }
}
