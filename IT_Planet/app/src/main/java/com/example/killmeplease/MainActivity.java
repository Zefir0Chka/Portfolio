package com.example.killmeplease;

import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.text.TextUtils;
import android.view.View;
import android.view.animation.LinearInterpolator;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.AppCompatDelegate;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;

import com.google.android.material.button.MaterialButton;
import com.google.android.material.materialswitch.MaterialSwitch;
import com.google.android.material.navigation.NavigationView;

public class MainActivity extends AppCompatActivity {
    private DbHelper dbHelper;
    private boolean orbitStarted = false;
    private android.animation.ObjectAnimator orbitAnimator1;
    private android.animation.ObjectAnimator orbitAnimator2;
    private android.animation.ObjectAnimator orbitAnimator3;

    private View focusedPlanet = null;
    private View focusedLogo = null;
    private String focusedLanguage = null;
    private FrameLayout solarSystemBlock;
    private ImageView starsOverlay1;
    private ImageView starsOverlay2;
    private ImageView comet1;
    private ImageView comet2;
    private android.animation.ObjectAnimator starsTwinkleAnimator1;
    private android.animation.ObjectAnimator starsTwinkleAnimator2;
    private final Handler cometHandler = new Handler(Looper.getMainLooper());
    private final Handler starFlashHandler = new Handler(Looper.getMainLooper());
    private final Runnable cometLoop = new Runnable() {
        @Override
        public void run() {
            launchRandomComet();
            long nextMs = 4500L + (long) (Math.random() * 8000L);
            cometHandler.postDelayed(this, nextMs);
        }
    };
    private final Runnable starFlashLoop = new Runnable() {
        @Override
        public void run() {
            launchRandomStarFlash();
            long nextMs = 8000L + (long) (Math.random() * 9000L);
            starFlashHandler.postDelayed(this, nextMs);
        }
    };

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        UiSettings.apply(this);
        dbHelper = new DbHelper(this);

        if (!dbHelper.isLoggedIn()) {
            startActivity(new Intent(this, LoginActivity.class));
            finish();
            return;
        }

        DrawerLayout drawerLayout = findViewById(R.id.drawer_layout);
        NavigationView navigationView = findViewById(R.id.navigation_view);
        ImageButton btnMenu = findViewById(R.id.btn_menu);
        MaterialSwitch switchTheme = findViewById(R.id.switch_theme);
        LinearLayout userBlock = findViewById(R.id.user_block);
        LinearLayout bottomBar = findViewById(R.id.bottom_bar);
        ImageView avatarView = findViewById(R.id.img_avatar);
        TextView nicknameView = findViewById(R.id.txt_nickname);
        TextView headerMeta = findViewById(R.id.txt_header_meta);
        MaterialButton btnContinue = findViewById(R.id.btn_continue);
        MaterialButton btnTests = findViewById(R.id.btn_tests);
        MaterialButton btnTasks = findViewById(R.id.btn_tasks);
        ImageView centerObject = findViewById(R.id.img_center_object);
        starsOverlay1 = findViewById(R.id.img_stars_overlay_1);
        starsOverlay2 = findViewById(R.id.img_stars_overlay_2);
        comet1 = findViewById(R.id.img_comet_1);
        comet2 = findViewById(R.id.img_comet_2);
        solarSystemBlock = findViewById(R.id.solar_system_block);

        View orbit1 = findViewById(R.id.orbit_1);
        View orbit2 = findViewById(R.id.orbit_2);
        View orbit3 = findViewById(R.id.orbit_3);

        View planetJava = findViewById(R.id.planet_java);
        View planetKotlin = findViewById(R.id.planet_kotlin);
        View planetPython = findViewById(R.id.planet_python);
        View planet1c = findViewById(R.id.planet_1c);
        View planetCpp = findViewById(R.id.planet_cpp);
        View planetCsharp = findViewById(R.id.planet_csharp);

        View logoJava = findViewById(R.id.logo_java);
        View logoKotlin = findViewById(R.id.logo_kotlin);
        View logoPython = findViewById(R.id.logo_python);
        View logo1c = findViewById(R.id.logo_1c);
        View logoCpp = findViewById(R.id.logo_cpp);
        View logoCsharp = findViewById(R.id.logo_csharp);

        DbHelper.Profile profile = dbHelper.getProfile();
        if ("admin".equals(profile.role)) {
            startActivity(new Intent(this, AdminActivity.class));
            finish();
            return;
        }
        nicknameView.setText(profile.nickname);
        headerMeta.setText("Курс: " + profile.selectedLanguage + " | " + profile.coins + " монет");
        if (!TextUtils.isEmpty(profile.avatarUri)) {
            avatarView.setImageURI(Uri.parse(profile.avatarUri));
        } else {
            avatarView.setImageResource(profile.avatarRes);
        }

        btnMenu.setOnClickListener(v -> drawerLayout.openDrawer(GravityCompat.START));

        switchTheme.setOnCheckedChangeListener(null);
        switchTheme.setChecked(AppCompatDelegate.getDefaultNightMode() == AppCompatDelegate.MODE_NIGHT_YES);
        switchTheme.setOnCheckedChangeListener((buttonView, isChecked) -> {
            int target = isChecked ? AppCompatDelegate.MODE_NIGHT_YES : AppCompatDelegate.MODE_NIGHT_NO;
            if (AppCompatDelegate.getDefaultNightMode() != target) {
                AppCompatDelegate.setDefaultNightMode(target);
            }
        });

        userBlock.setOnClickListener(v -> openProfileByRole());

        // Center object changes by theme (sun vs black hole)
        boolean dark = AppCompatDelegate.getDefaultNightMode() == AppCompatDelegate.MODE_NIGHT_YES;
        centerObject.setImageResource(dark ? R.drawable.ic_black_hole : R.drawable.ic_sun);
        centerObject.setOnClickListener(v -> playCenterObjectClick(centerObject));

        // Planet clicks open courses
        planetJava.setOnClickListener(v -> handlePlanetClick("Java", planetJava, logoJava));
        planetKotlin.setOnClickListener(v -> handlePlanetClick("Kotlin", planetKotlin, logoKotlin));
        planetPython.setOnClickListener(v -> handlePlanetClick("Python", planetPython, logoPython));
        planet1c.setOnClickListener(v -> handlePlanetClick("1C", planet1c, logo1c));
        planetCpp.setOnClickListener(v -> handlePlanetClick("C++", planetCpp, logoCpp));
        planetCsharp.setOnClickListener(v -> handlePlanetClick("C#", planetCsharp, logoCsharp));

        // Start orbit animation (rotate orbit containers, planets stay 'on top' of ring)
        startOrbitIfNeeded(orbit1, orbit2, orbit3);
        startStarsTwinkleIfNeeded();
        startCometLoop();
        startStarFlashLoop();

        btnContinue.setOnClickListener(v -> openCourses(true));
        btnTests.setOnClickListener(v -> startActivity(new Intent(this, TestsActivity.class)));
        btnTasks.setOnClickListener(v -> startActivity(new Intent(this, CourseSelectActivity.class)
                .putExtra(CourseSelectActivity.EXTRA_MODE, CourseSelectActivity.MODE_TASKS)));

        navigationView.setNavigationItemSelectedListener(item -> {
            handleDrawerClick(item.getItemId());
            drawerLayout.closeDrawer(GravityCompat.START);
            return true;
        });

        applyPressFeedback(btnTests);
        applyPressFeedback(btnTasks);
        applyPressFeedback(btnContinue);
        applyPressFeedback(centerObject);
        applyPressFeedback(planetJava);
        applyPressFeedback(planetKotlin);
        applyPressFeedback(planetPython);
        applyPressFeedback(planet1c);
        applyPressFeedback(planetCpp);
        applyPressFeedback(planetCsharp);
        playIntroAnimations(userBlock, bottomBar);
    }

    @Override
    protected void onResume() {
        super.onResume();
        UiSettings.apply(this);
        startCometLoop();
        startStarFlashLoop();
        DbHelper.Profile profile = dbHelper.getProfile();
        ((TextView) findViewById(R.id.txt_nickname)).setText(profile.nickname);
        ((TextView) findViewById(R.id.txt_header_meta))
                .setText("Курс: " + profile.selectedLanguage + " | " + profile.coins + " монет");
        ImageView avatar = findViewById(R.id.img_avatar);
        if (!TextUtils.isEmpty(profile.avatarUri)) {
            avatar.setImageURI(Uri.parse(profile.avatarUri));
        } else {
            avatar.setImageResource(profile.avatarRes);
        }
    }

    private void startOrbitIfNeeded(View orbit1, View orbit2, View orbit3) {
        if (orbitStarted) return;
        orbitStarted = true;

        if (orbitAnimator1 != null) orbitAnimator1.cancel();
        if (orbitAnimator2 != null) orbitAnimator2.cancel();
        if (orbitAnimator3 != null) orbitAnimator3.cancel();

        orbit1.setRotation(0f);
        orbit2.setRotation(0f);
        orbit3.setRotation(0f);

        orbitAnimator1 = android.animation.ObjectAnimator.ofFloat(orbit1, View.ROTATION, 0f, 360f);
        orbitAnimator1.setDuration(18000);
        orbitAnimator1.setInterpolator(new LinearInterpolator());
        orbitAnimator1.setRepeatCount(android.animation.ValueAnimator.INFINITE);
        orbitAnimator1.setRepeatMode(android.animation.ValueAnimator.RESTART);
        orbitAnimator1.start();

        orbitAnimator2 = android.animation.ObjectAnimator.ofFloat(orbit2, View.ROTATION, 0f, -360f);
        orbitAnimator2.setDuration(26000);
        orbitAnimator2.setInterpolator(new LinearInterpolator());
        orbitAnimator2.setRepeatCount(android.animation.ValueAnimator.INFINITE);
        orbitAnimator2.setRepeatMode(android.animation.ValueAnimator.RESTART);
        orbitAnimator2.start();

        orbitAnimator3 = android.animation.ObjectAnimator.ofFloat(orbit3, View.ROTATION, 0f, 360f);
        orbitAnimator3.setDuration(34000);
        orbitAnimator3.setInterpolator(new LinearInterpolator());
        orbitAnimator3.setRepeatCount(android.animation.ValueAnimator.INFINITE);
        orbitAnimator3.setRepeatMode(android.animation.ValueAnimator.RESTART);
        orbitAnimator3.start();
    }

    private void openCourses(boolean continueMode) {
        openCourses(dbHelper.getSelectedLanguage(), continueMode);
    }

    private void openCourses(String language, boolean continueMode) {
        dbHelper.setSelectedLanguage(language);
        Intent intent = new Intent(this, CoursesActivity.class);
        intent.putExtra(CoursesActivity.EXTRA_LANGUAGE, language);
        intent.putExtra(CoursesActivity.EXTRA_CONTINUE_MODE, continueMode);
        startActivity(intent);
    }

    private void handlePlanetClick(String language, View planetView, View logoView) {
        if (focusedPlanet == planetView) {
            // second tap -> open course
            openCourses(language, false);
            return;
        }
        if (focusedPlanet != null) {
            animateToDefault(() -> focusPlanet(language, planetView, logoView));
        } else {
            focusPlanet(language, planetView, logoView);
        }
    }

    private void focusPlanet(String language, View planetView, View logoView) {
        focusedLanguage = language;
        focusedPlanet = planetView;

        if (focusedLogo != null) {
            focusedLogo.animate().alpha(0f).setDuration(140).start();
        }
        focusedLogo = logoView;

        // Use absolute screen coordinates, including orbit rotation transforms.
        int[] blockPos = new int[2];
        int[] planetPos = new int[2];
        solarSystemBlock.getLocationOnScreen(blockPos);
        planetView.getLocationOnScreen(planetPos);

        float blockCenterX = blockPos[0] + solarSystemBlock.getWidth() / 2f;
        float blockCenterY = blockPos[1] + solarSystemBlock.getHeight() / 2f;
        float planetCenterX = planetPos[0] + planetView.getWidth() / 2f;
        float planetCenterY = planetPos[1] + planetView.getHeight() / 2f;
        float dx = blockCenterX - planetCenterX;
        float dy = blockCenterY - planetCenterY;

        solarSystemBlock.animate()
                .scaleX(1.18f)
                .scaleY(1.18f)
                .translationX(dx)
                .translationY(dy)
                .setDuration(420)
                .setInterpolator(new android.view.animation.DecelerateInterpolator())
                .withEndAction(() -> {
                    animateStarsParallax(true, dx, dy);
                    if (logoView != null) {
                        logoView.animate()
                                .alpha(1f)
                                .scaleX(1.08f)
                                .scaleY(1.08f)
                                .setDuration(260)
                                .setInterpolator(new android.view.animation.OvershootInterpolator())
                                .start();
                    }
                })
                .start();
    }

    private void playCenterObjectClick(ImageView centerObject) {
        boolean dark = AppCompatDelegate.getDefaultNightMode() == AppCompatDelegate.MODE_NIGHT_YES;
        android.animation.AnimatorSet set = new android.animation.AnimatorSet();
        android.animation.ObjectAnimator sX;
        android.animation.ObjectAnimator sY;
        android.animation.ObjectAnimator rot;
        android.animation.ObjectAnimator alpha;

        if (dark) {
            sX = android.animation.ObjectAnimator.ofFloat(centerObject, View.SCALE_X, 1f, 0.92f, 1.12f, 1f);
            sY = android.animation.ObjectAnimator.ofFloat(centerObject, View.SCALE_Y, 1f, 0.92f, 1.12f, 1f);
            rot = android.animation.ObjectAnimator.ofFloat(centerObject, View.ROTATION, centerObject.getRotation(), centerObject.getRotation() - 32f);
            alpha = android.animation.ObjectAnimator.ofFloat(centerObject, View.ALPHA, 1f, 0.82f, 1f);
        } else {
            sX = android.animation.ObjectAnimator.ofFloat(centerObject, View.SCALE_X, 1f, 1.15f, 1f);
            sY = android.animation.ObjectAnimator.ofFloat(centerObject, View.SCALE_Y, 1f, 1.15f, 1f);
            rot = android.animation.ObjectAnimator.ofFloat(centerObject, View.ROTATION, centerObject.getRotation(), centerObject.getRotation() + 18f);
            alpha = android.animation.ObjectAnimator.ofFloat(centerObject, View.ALPHA, 1f, 0.9f, 1f);
        }
        set.playTogether(sX, sY, rot, alpha);
        set.setDuration(420);
        set.setInterpolator(new android.view.animation.DecelerateInterpolator());
        set.start();
        animateToDefault(null);
    }

    private void animateToDefault(Runnable endAction) {
        if (focusedLogo != null) {
            focusedLogo.animate().alpha(0f).scaleX(1f).scaleY(1f).setDuration(140).start();
        }
        focusedPlanet = null;
        focusedLanguage = null;
        animateStarsParallax(false, 0f, 0f);
        solarSystemBlock.animate()
                .scaleX(1f)
                .scaleY(1f)
                .translationX(0f)
                .translationY(0f)
                .setDuration(360)
                .setInterpolator(new android.view.animation.DecelerateInterpolator())
                .withEndAction(endAction)
                .start();
    }

    private void startStarsTwinkleIfNeeded() {
        if (starsOverlay1 != null && (starsTwinkleAnimator1 == null || !starsTwinkleAnimator1.isStarted())) {
            starsTwinkleAnimator1 = android.animation.ObjectAnimator.ofFloat(starsOverlay1, View.ALPHA, 0.35f, 0.78f, 0.42f, 0.9f, 0.35f);
            starsTwinkleAnimator1.setDuration(4800);
            starsTwinkleAnimator1.setRepeatCount(android.animation.ValueAnimator.INFINITE);
            starsTwinkleAnimator1.setRepeatMode(android.animation.ValueAnimator.RESTART);
            starsTwinkleAnimator1.setInterpolator(new android.view.animation.AccelerateDecelerateInterpolator());
            starsTwinkleAnimator1.start();
            startNebulaDrift(starsOverlay1, 16f, 14f, 18000);
        }
        if (starsOverlay2 != null && (starsTwinkleAnimator2 == null || !starsTwinkleAnimator2.isStarted())) {
            starsTwinkleAnimator2 = android.animation.ObjectAnimator.ofFloat(starsOverlay2, View.ALPHA, 0.15f, 0.45f, 0.2f, 0.52f, 0.15f);
            starsTwinkleAnimator2.setDuration(7300);
            starsTwinkleAnimator2.setRepeatCount(android.animation.ValueAnimator.INFINITE);
            starsTwinkleAnimator2.setRepeatMode(android.animation.ValueAnimator.RESTART);
            starsTwinkleAnimator2.setInterpolator(new android.view.animation.AccelerateDecelerateInterpolator());
            starsTwinkleAnimator2.start();
            startNebulaDrift(starsOverlay2, -18f, -12f, 24000);
        }
    }

    private void startNebulaDrift(View v, float toX, float toY, long duration) {
        if (v == null) return;
        android.animation.ObjectAnimator driftX = android.animation.ObjectAnimator.ofFloat(v, View.TRANSLATION_X, 0f, toX, 0f);
        android.animation.ObjectAnimator driftY = android.animation.ObjectAnimator.ofFloat(v, View.TRANSLATION_Y, 0f, toY, 0f);
        driftX.setDuration(duration);
        driftY.setDuration(duration);
        driftX.setRepeatCount(android.animation.ValueAnimator.INFINITE);
        driftY.setRepeatCount(android.animation.ValueAnimator.INFINITE);
        driftX.setInterpolator(new android.view.animation.AccelerateDecelerateInterpolator());
        driftY.setInterpolator(new android.view.animation.AccelerateDecelerateInterpolator());
        driftX.start();
        driftY.start();
    }

    private void applyPressFeedback(View view) {
        if (view == null) return;
        view.setOnTouchListener((v, event) -> {
            switch (event.getAction()) {
                case android.view.MotionEvent.ACTION_DOWN:
                    v.animate().scaleX(0.96f).scaleY(0.96f).setDuration(90).start();
                    break;
                case android.view.MotionEvent.ACTION_UP:
                case android.view.MotionEvent.ACTION_CANCEL:
                    v.animate().scaleX(1f).scaleY(1f).setDuration(120).start();
                    break;
            }
            return false;
        });
    }

    private void playIntroAnimations(View header, View bottomBar) {
        if (header != null) {
            header.setAlpha(0f);
            header.setTranslationY(-26f);
            header.animate().alpha(1f).translationY(0f).setDuration(480)
                    .setInterpolator(new android.view.animation.DecelerateInterpolator()).start();
        }
        if (bottomBar != null) {
            bottomBar.setAlpha(0f);
            bottomBar.setTranslationY(36f);
            bottomBar.animate().alpha(1f).translationY(0f).setDuration(520)
                    .setInterpolator(new android.view.animation.DecelerateInterpolator()).start();
        }
    }

    private void animateStarsParallax(boolean focused, float dx, float dy) {
        if (starsOverlay1 != null) {
            starsOverlay1.animate()
                    .translationX(focused ? -dx * 0.10f : 0f)
                    .translationY(focused ? -dy * 0.10f : 0f)
                    .scaleX(focused ? 1.03f : 1f)
                    .scaleY(focused ? 1.03f : 1f)
                    .setDuration(420)
                    .setInterpolator(new android.view.animation.DecelerateInterpolator())
                    .start();
        }
        if (starsOverlay2 != null) {
            starsOverlay2.animate()
                    .translationX(focused ? -dx * 0.16f : 0f)
                    .translationY(focused ? -dy * 0.16f : 0f)
                    .scaleX(focused ? 1.05f : 1f)
                    .scaleY(focused ? 1.05f : 1f)
                    .setDuration(460)
                    .setInterpolator(new android.view.animation.DecelerateInterpolator())
                    .start();
        }
    }

    private void startCometLoop() {
        cometHandler.removeCallbacks(cometLoop);
        cometHandler.postDelayed(cometLoop, 2200);
    }

    private void startStarFlashLoop() {
        starFlashHandler.removeCallbacks(starFlashLoop);
        starFlashHandler.postDelayed(starFlashLoop, 5000);
    }

    private void launchRandomStarFlash() {
        ImageView target = Math.random() > 0.5 ? starsOverlay1 : starsOverlay2;
        if (target == null) return;
        float base = target.getAlpha();
        android.animation.ObjectAnimator flash = android.animation.ObjectAnimator.ofFloat(
                target,
                View.ALPHA,
                base,
                Math.min(1f, base + 0.22f),
                Math.min(1f, base + 0.1f),
                base
        );
        flash.setDuration(1100);
        flash.setInterpolator(new android.view.animation.AccelerateDecelerateInterpolator());
        flash.start();
    }

    private void launchRandomComet() {
        if (solarSystemBlock == null || solarSystemBlock.getWidth() <= 0 || solarSystemBlock.getHeight() <= 0) return;
        ImageView comet = Math.random() > 0.5 ? comet1 : comet2;
        if (comet == null) return;

        int w = solarSystemBlock.getWidth();
        int h = solarSystemBlock.getHeight();
        float startX = -100f;
        float startY = (float) (20 + Math.random() * Math.max(80, h * 0.55f));
        float endX = w + 130f;
        float endY = startY + (float) (-45 + Math.random() * 210f);

        // Small parabolic trajectory: up/down + side deviation.
        float controlX = (startX + endX) / 2f + (float) (-80 + Math.random() * 160f);
        float controlY = (startY + endY) / 2f + (float) (-90 + Math.random() * 180f);

        comet.setVisibility(View.VISIBLE);
        comet.setAlpha(0f);
        comet.setTranslationX(startX);
        comet.setTranslationY(startY);
        comet.setRotation(12f + (float) (Math.random() * 22f));

        long duration = 1200 + (long) (Math.random() * 1000);
        android.animation.ValueAnimator path = android.animation.ValueAnimator.ofFloat(0f, 1f);
        path.setDuration(duration);
        path.setInterpolator(new LinearInterpolator());
        path.addUpdateListener(anim -> {
            float t = (float) anim.getAnimatedValue();
            float oneMinusT = 1f - t;
            float x = oneMinusT * oneMinusT * startX + 2f * oneMinusT * t * controlX + t * t * endX;
            float y = oneMinusT * oneMinusT * startY + 2f * oneMinusT * t * controlY + t * t * endY;
            comet.setTranslationX(x);
            comet.setTranslationY(y);
        });

        android.animation.ObjectAnimator a = android.animation.ObjectAnimator.ofFloat(comet, View.ALPHA, 0f, 1f, 0.9f, 0f);
        a.setDuration(duration);

        android.animation.AnimatorSet set = new android.animation.AnimatorSet();
        set.playTogether(path, a);
        set.addListener(new android.animation.AnimatorListenerAdapter() {
            @Override
            public void onAnimationEnd(android.animation.Animator animation) {
                comet.setVisibility(View.GONE);
            }
        });
        set.start();

        // Sometimes launch a second comet shortly after first.
        if (Math.random() > 0.62) {
            cometHandler.postDelayed(this::launchRandomComet, 450 + (long) (Math.random() * 700));
        }
    }

    @Override
    protected void onPause() {
        super.onPause();
        cometHandler.removeCallbacks(cometLoop);
        starFlashHandler.removeCallbacks(starFlashLoop);
    }

    private void handleDrawerClick(int itemId) {
        if (itemId == R.id.nav_profile) {
            openProfileByRole();
        } else if (itemId == R.id.nav_courses_group) {
            // Parent item expands/collapses its submenu automatically
        } else if (itemId == R.id.nav_settings) {
            startActivity(new Intent(this, SettingsActivity.class));
        } else if (itemId == R.id.nav_reviews) {
            startActivity(new Intent(this, ReviewsActivity.class));
        } else if (itemId == R.id.nav_tasks) {
            startActivity(new Intent(this, CourseSelectActivity.class)
                    .putExtra(CourseSelectActivity.EXTRA_MODE, CourseSelectActivity.MODE_TASKS));
        } else if (itemId == R.id.nav_tests) {
            startActivity(new Intent(this, TestsActivity.class));
        } else if (itemId == R.id.nav_donate) {
            dbHelper.markCurrentUserAsDonor();
            Toast.makeText(this, "Спасибо за донат. Вы в статистике донатов.", Toast.LENGTH_SHORT).show();
        } else if (itemId == R.id.nav_course_java) {
            openCourses("Java", false);
        } else if (itemId == R.id.nav_course_kotlin) {
            openCourses("Kotlin", false);
        } else if (itemId == R.id.nav_course_python) {
            openCourses("Python", false);
        } else if (itemId == R.id.nav_course_1c) {
            openCourses("1C", false);
        } else if (itemId == R.id.nav_course_cpp) {
            openCourses("C++", false);
        } else if (itemId == R.id.nav_course_csharp) {
            openCourses("C#", false);
        }
    }

    private void openProfileByRole() {
        if ("admin".equals(dbHelper.getProfile().role)) {
            startActivity(new Intent(this, AdminActivity.class));
        } else {
            startActivity(new Intent(this, ProfileActivity.class));
        }
    }

    // Dialog menu removed: drawer submenu is used.
}