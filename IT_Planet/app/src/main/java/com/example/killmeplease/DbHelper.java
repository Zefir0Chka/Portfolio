package com.example.killmeplease;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

import java.util.Random;

public class DbHelper extends SQLiteOpenHelper {
    private static final String DB_NAME = "learning.db";
    private static final int DB_VERSION = 5;

    private static final String TABLE_USERS = "users";
    private static final String TABLE_LANGUAGE_PROGRESS = "language_progress";
    private static final String TABLE_SESSION = "session";
    private static final String TABLE_REVIEWS = "reviews";
    private static final String TABLE_SOLVED_TASKS = "solved_tasks";
    private static final String TABLE_ACCESS_CODES = "access_codes";
    private static final String[] BASE_LANGUAGES = {"Java", "Kotlin", "Python", "1C", "C++", "C#"};
    private static final String ADMIN_LOGIN_CODE = "111100001111";
    private static final String STUDENT_ACCESS_STATUS = "Ученик ижорского Политехнического Коллкджа";
    private static final int ACCESS_CODE_LENGTH = 12;

    public DbHelper(Context context) {
        super(context, DB_NAME, null, DB_VERSION);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL("CREATE TABLE " + TABLE_USERS + " (" +
                "id INTEGER PRIMARY KEY AUTOINCREMENT, " +
                "nickname TEXT NOT NULL, " +
                "email TEXT, " +
                "phone TEXT, " +
                "password TEXT NOT NULL, " +
                "avatar_res INTEGER NOT NULL, " +
                "avatar_uri TEXT, " +
                "role TEXT NOT NULL, " +
                "status TEXT NOT NULL, " +
                "is_donor INTEGER NOT NULL DEFAULT 0, " +
                "coins INTEGER NOT NULL DEFAULT 5, " +
                "selected_language TEXT NOT NULL, " +
                "tasks_done INTEGER NOT NULL)");

        db.execSQL("CREATE TABLE " + TABLE_SESSION + " (" +
                "id INTEGER PRIMARY KEY CHECK(id = 1), " +
                "current_user_id INTEGER)");

        db.execSQL("CREATE TABLE " + TABLE_LANGUAGE_PROGRESS + " (" +
                "user_id INTEGER NOT NULL, " +
                "language TEXT NOT NULL, " +
                "current_topic INTEGER NOT NULL DEFAULT -1, " +
                "completed INTEGER NOT NULL DEFAULT 0, " +
                "PRIMARY KEY(user_id, language))");

        db.execSQL("CREATE TABLE " + TABLE_REVIEWS + " (" +
                "id INTEGER PRIMARY KEY AUTOINCREMENT, " +
                "user_id INTEGER NOT NULL, " +
                "rating INTEGER NOT NULL, " +
                "review_text TEXT NOT NULL)");

        db.execSQL("CREATE TABLE " + TABLE_ACCESS_CODES + " (" +
                "id INTEGER PRIMARY KEY AUTOINCREMENT, " +
                "code TEXT NOT NULL UNIQUE, " +
                "created_by_user_id INTEGER NOT NULL, " +
                "used_by_user_id INTEGER, " +
                "created_at INTEGER NOT NULL, " +
                "used_at INTEGER)");

        db.execSQL("CREATE TABLE " + TABLE_SOLVED_TASKS + " (" +
                "user_id INTEGER NOT NULL, " +
                "language TEXT NOT NULL, " +
                "topic_index INTEGER NOT NULL, " +
                "PRIMARY KEY(user_id, language, topic_index))");

        ContentValues session = new ContentValues();
        session.put("id", 1);
        db.insert(TABLE_SESSION, null, session);
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_REVIEWS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_SOLVED_TASKS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_ACCESS_CODES);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_LANGUAGE_PROGRESS);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_SESSION);
        db.execSQL("DROP TABLE IF EXISTS " + TABLE_USERS);
        onCreate(db);
    }

    public boolean loginAdminByCode(String code) {
        if (!ADMIN_LOGIN_CODE.equals(code)) {
            return false;
        }
        int adminId = ensureAdminUser();
        setSessionUser(adminId);
        ensureLanguageRows(adminId);
        return true;
    }

    private int ensureAdminUser() {
        SQLiteDatabase db = getWritableDatabase();
        Cursor cursor = db.rawQuery("SELECT id FROM " + TABLE_USERS + " WHERE role = 'admin' LIMIT 1", null);
        int adminId;
        if (cursor.moveToFirst()) {
            adminId = cursor.getInt(0);
            cursor.close();
            return adminId;
        }
        cursor.close();
        ContentValues values = new ContentValues();
        values.put("nickname", "Администратор");
        values.put("email", "");
        values.put("phone", "");
        values.put("password", "admin");
        values.put("avatar_res", android.R.drawable.star_big_on);
        values.putNull("avatar_uri");
        values.put("role", "admin");
        values.put("status", "Администратор");
        values.put("coins", 999);
        values.put("selected_language", "Java");
        values.put("tasks_done", 0);
        return (int) db.insert(TABLE_USERS, null, values);
    }

    public boolean registerUserByIdentifier(String identifier, String password) {
        String email = looksLikeEmail(identifier) ? identifier : "";
        String phone = looksLikeEmail(identifier) ? "" : identifier;
        String nickname = deriveNickname(identifier);
        return registerUser(nickname, email, phone, password);
    }

    public enum AccessCodeRegisterResult {
        OK,
        CODE_NOT_FOUND,
        CODE_ALREADY_USED,
        IDENTIFIER_ALREADY_EXISTS,
        ERROR
    }

    public AccessCodeRegisterResult registerUserByIdentifierWithAccessCode(String identifier, String password, String accessCode) {
        String email = looksLikeEmail(identifier) ? identifier : "";
        String phone = looksLikeEmail(identifier) ? "" : identifier;
        SQLiteDatabase db = getWritableDatabase();

        if (identifierExists(db, email, phone)) {
            return AccessCodeRegisterResult.IDENTIFIER_ALREADY_EXISTS;
        }

        Cursor codeCursor = db.rawQuery(
                "SELECT id, used_by_user_id FROM " + TABLE_ACCESS_CODES + " WHERE code = ? LIMIT 1",
                new String[]{accessCode});
        if (!codeCursor.moveToFirst()) {
            codeCursor.close();
            return AccessCodeRegisterResult.CODE_NOT_FOUND;
        }
        int codeId = codeCursor.getInt(0);
        boolean alreadyUsed = !codeCursor.isNull(1);
        codeCursor.close();

        if (alreadyUsed) {
            return AccessCodeRegisterResult.CODE_ALREADY_USED;
        }

        db.beginTransaction();
        try {
            ContentValues values = new ContentValues();
            values.put("nickname", deriveNickname(identifier));
            values.put("email", email);
            values.put("phone", phone);
            values.put("password", password);
            values.put("avatar_res", android.R.drawable.sym_def_app_icon);
            values.putNull("avatar_uri");
            values.put("role", "student");
            values.put("status", STUDENT_ACCESS_STATUS);
            values.put("coins", 5);
            values.put("selected_language", "Java");
            values.put("tasks_done", 0);
            long userIdLong = db.insert(TABLE_USERS, null, values);
            if (userIdLong == -1) {
                return AccessCodeRegisterResult.ERROR;
            }
            int userId = (int) userIdLong;

            ContentValues codeUpdate = new ContentValues();
            codeUpdate.put("used_by_user_id", userId);
            codeUpdate.put("used_at", System.currentTimeMillis());
            int updated = db.update(TABLE_ACCESS_CODES, codeUpdate, "id = ? AND used_by_user_id IS NULL",
                    new String[]{String.valueOf(codeId)});
            if (updated != 1) {
                return AccessCodeRegisterResult.CODE_ALREADY_USED;
            }

            setSessionUser(userId);
            ensureLanguageRows(userId);
            db.setTransactionSuccessful();
            return AccessCodeRegisterResult.OK;
        } catch (Exception e) {
            return AccessCodeRegisterResult.ERROR;
        } finally {
            if (db.inTransaction()) {
                db.endTransaction();
            }
        }
    }

    public boolean loginByIdentifier(String identifier, String password) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT id, password FROM " + TABLE_USERS +
                        " WHERE (email = ? OR phone = ?)",
                new String[]{identifier, identifier});

        boolean logged = false;
        if (cursor.moveToFirst()) {
            int userId = cursor.getInt(0);
            String dbPassword = cursor.getString(1);
            if (dbPassword.equals(password)) {
                setSessionUser(userId);
                ensureLanguageRows(userId);
                logged = true;
            }
        }
        cursor.close();
        return logged;
    }

    public String createAccessCodeForAdmin() {
        int userId = getCurrentUserId();
        if (userId == -1) return null;
        if (!"admin".equals(getProfile().role)) return null;

        SQLiteDatabase db = getWritableDatabase();
        Random random = new Random();
        for (int attempt = 0; attempt < 25; attempt++) {
            String code = randomNumericCode(random, ACCESS_CODE_LENGTH);
            ContentValues values = new ContentValues();
            values.put("code", code);
            values.put("created_by_user_id", userId);
            values.putNull("used_by_user_id");
            values.put("created_at", System.currentTimeMillis());
            values.putNull("used_at");
            long id = db.insert(TABLE_ACCESS_CODES, null, values);
            if (id != -1) {
                return code;
            }
        }
        return null;
    }

    public Cursor getAccessCodesCursor() {
        SQLiteDatabase db = getReadableDatabase();
        return db.rawQuery("SELECT code, used_by_user_id FROM " + TABLE_ACCESS_CODES + " ORDER BY created_at DESC", null);
    }

    public static class AccessCodeInfo {
        public final String code;
        public final boolean used;

        public AccessCodeInfo(String code, boolean used) {
            this.code = code;
            this.used = used;
        }
    }

    public AccessCodeInfo getLastAccessCodeCreatedByCurrentAdmin() {
        int userId = getCurrentUserId();
        if (userId == -1) return null;
        if (!"admin".equals(getProfile().role)) return null;

        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery(
                "SELECT code, used_by_user_id FROM " + TABLE_ACCESS_CODES +
                        " WHERE created_by_user_id = ? ORDER BY created_at DESC LIMIT 1",
                new String[]{String.valueOf(userId)});
        AccessCodeInfo info = null;
        if (cursor.moveToFirst()) {
            String code = cursor.getString(0);
            boolean used = !cursor.isNull(1);
            info = new AccessCodeInfo(code, used);
        }
        cursor.close();
        return info;
    }

    public boolean isAccessCodeUsed(String code) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT used_by_user_id FROM " + TABLE_ACCESS_CODES + " WHERE code = ? LIMIT 1",
                new String[]{code});
        boolean used = false;
        if (cursor.moveToFirst()) {
            used = !cursor.isNull(0);
        }
        cursor.close();
        return used;
    }

    public boolean registerUser(String nickname, String email, String phone, String password) {
        SQLiteDatabase db = getWritableDatabase();
        if (!email.isEmpty()) {
            Cursor emailCursor = db.rawQuery("SELECT id FROM " + TABLE_USERS + " WHERE email = ?",
                    new String[]{email});
            boolean emailExists = emailCursor.moveToFirst();
            emailCursor.close();
            if (emailExists) {
                return false;
            }
        }
        if (!phone.isEmpty()) {
            Cursor phoneCursor = db.rawQuery("SELECT id FROM " + TABLE_USERS + " WHERE phone = ?",
                    new String[]{phone});
            boolean phoneExists = phoneCursor.moveToFirst();
            phoneCursor.close();
            if (phoneExists) {
                return false;
            }
        }

        ContentValues values = new ContentValues();
        values.put("nickname", nickname);
        values.put("email", email);
        values.put("phone", phone);
        values.put("password", password);
        values.put("avatar_res", android.R.drawable.sym_def_app_icon);
        values.put("role", "student");
        values.put("status", "Ученик");
        values.put("coins", 5);
        values.put("selected_language", "Java");
        values.put("tasks_done", 0);
        long userId = db.insert(TABLE_USERS, null, values);
        if (userId == -1) {
            return false;
        }

        setSessionUser((int) userId);
        ensureLanguageRows((int) userId);
        return true;
    }

    public boolean login(String identifier, String password, String nickname) {
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT id, password FROM " + TABLE_USERS +
                        " WHERE (email = ? OR phone = ?) AND nickname = ?",
                new String[]{identifier, identifier, nickname});

        boolean logged = false;
        if (cursor.moveToFirst()) {
            int userId = cursor.getInt(0);
            String dbPassword = cursor.getString(1);
            if (dbPassword.equals(password)) {
                setSessionUser(userId);
                ensureLanguageRows(userId);
                logged = true;
            }
        }
        cursor.close();
        return logged;
    }

    public void logout() {
        setSessionUser(null);
    }

    public boolean isLoggedIn() {
        return getCurrentUserId() != -1;
    }

    public Profile getProfile() {
        int userId = getCurrentUserId();
        if (userId == -1) {
            return new Profile("Гость", "", "", "Новый", "student", 0, 0,
                    android.R.drawable.sym_def_app_icon, "", "Java", 0);
        }
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT nickname, email, phone, status, role, is_donor, coins, avatar_res, avatar_uri, selected_language, tasks_done " +
                "FROM " + TABLE_USERS + " WHERE id = ?", new String[]{String.valueOf(userId)});
        Profile profile = new Profile("Гость", "", "", "Новый", "student", 0, 0,
                android.R.drawable.sym_def_app_icon, "", "Java", 0);
        if (cursor.moveToFirst()) {
            profile.nickname = cursor.getString(0);
            profile.email = nullToEmpty(cursor.getString(1));
            profile.phone = nullToEmpty(cursor.getString(2));
            profile.status = nullToEmpty(cursor.getString(3));
            profile.role = cursor.getString(4);
            profile.isDonor = cursor.getInt(5);
            profile.coins = cursor.getInt(6);
            profile.avatarRes = cursor.getInt(7);
            profile.avatarUri = nullToEmpty(cursor.getString(8));
            profile.selectedLanguage = cursor.getString(9);
            profile.tasksDone = cursor.getInt(10);
        }
        cursor.close();
        return profile;
    }

    public void updateProfile(String nickname, String email, String phone, int avatarRes) {
        updateProfile(nickname, email, phone, avatarRes, null);
    }

    public void updateProfile(String nickname, String email, String phone, int avatarRes, String avatarUri) {
        int userId = getCurrentUserId();
        if (userId == -1) {
            return;
        }
        Profile current = getProfile();
        SQLiteDatabase db = getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put("nickname", nickname);
        values.put("email", email);
        values.put("phone", phone);
        values.put("status", "admin".equals(current.role) ? "Администратор" : "Ученик");
        values.put("avatar_res", avatarRes);
        if (avatarUri == null) {
            // keep existing
        } else if (avatarUri.isEmpty()) {
            values.putNull("avatar_uri");
        } else {
            values.put("avatar_uri", avatarUri);
        }
        db.update(TABLE_USERS, values, "id = ?", new String[]{String.valueOf(userId)});
    }

    public void markCurrentUserAsDonor() {
        int userId = getCurrentUserId();
        if (userId == -1) return;
        SQLiteDatabase db = getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put("is_donor", 1);
        db.update(TABLE_USERS, values, "id = ?", new String[]{String.valueOf(userId)});
    }

    public int getRegisteredUsersCount() {
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT COUNT(*) FROM " + TABLE_USERS + " WHERE role = 'student'", null);
        int count = 0;
        if (cursor.moveToFirst()) count = cursor.getInt(0);
        cursor.close();
        return count;
    }

    public int getDonorsCount() {
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT COUNT(*) FROM " + TABLE_USERS + " WHERE is_donor = 1", null);
        int count = 0;
        if (cursor.moveToFirst()) count = cursor.getInt(0);
        cursor.close();
        return count;
    }

    public void addReview(int rating, String text) {
        int userId = getCurrentUserId();
        if (userId == -1) return;
        SQLiteDatabase db = getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put("user_id", userId);
        values.put("rating", rating);
        values.put("review_text", text);
        db.insert(TABLE_REVIEWS, null, values);
    }

    public Cursor getReviewsCursor() {
        SQLiteDatabase db = getReadableDatabase();
        return db.rawQuery("SELECT r.rating, r.review_text, u.nickname, u.avatar_res " +
                "FROM " + TABLE_REVIEWS + " r JOIN " + TABLE_USERS + " u ON u.id = r.user_id " +
                "ORDER BY r.id DESC", null);
    }

    public boolean awardCoinsForTask(String language, int topicIndex, int amount) {
        int userId = getCurrentUserId();
        if (userId == -1) return false;
        SQLiteDatabase db = getWritableDatabase();
        Cursor cursor = db.rawQuery("SELECT topic_index FROM " + TABLE_SOLVED_TASKS +
                        " WHERE user_id = ? AND language = ? AND topic_index = ?",
                new String[]{String.valueOf(userId), language, String.valueOf(topicIndex)});
        boolean alreadySolved = cursor.moveToFirst();
        cursor.close();
        if (alreadySolved) return false;

        ContentValues solved = new ContentValues();
        solved.put("user_id", userId);
        solved.put("language", language);
        solved.put("topic_index", topicIndex);
        db.insert(TABLE_SOLVED_TASKS, null, solved);

        int currentCoins = getProfile().coins;
        ContentValues values = new ContentValues();
        values.put("coins", currentCoins + amount);
        db.update(TABLE_USERS, values, "id = ?", new String[]{String.valueOf(userId)});
        return true;
    }

    public String getSelectedLanguage() {
        return getProfile().selectedLanguage;
    }

    public void setSelectedLanguage(String language) {
        int userId = getCurrentUserId();
        if (userId == -1) {
            return;
        }
        SQLiteDatabase db = getWritableDatabase();
        ContentValues values = new ContentValues();
        values.put("selected_language", language);
        db.update(TABLE_USERS, values, "id = ?", new String[]{String.valueOf(userId)});
        ensureLanguageRow(userId, language);
    }

    public int getCurrentTopic(String language) {
        int userId = getCurrentUserId();
        if (userId == -1) {
            return -1;
        }
        ensureLanguageRow(userId, language);
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT current_topic FROM " + TABLE_LANGUAGE_PROGRESS +
                        " WHERE user_id = ? AND language = ?",
                new String[]{String.valueOf(userId), language});
        int value = -1;
        if (cursor.moveToFirst()) {
            value = cursor.getInt(0);
        }
        cursor.close();
        return value;
    }

    public void markTopicAsCompleted(String language, int topicIndex) {
        int userId = getCurrentUserId();
        if (userId == -1) {
            return;
        }
        ensureLanguageRow(userId, language);
        SQLiteDatabase db = getWritableDatabase();
        int current = getCurrentTopic(language);

        if (topicIndex > current) {
            ContentValues progressValues = new ContentValues();
            progressValues.put("current_topic", topicIndex);
            if (topicIndex >= 29) {
                progressValues.put("completed", 1);
            }
            db.update(TABLE_LANGUAGE_PROGRESS, progressValues, "user_id = ? AND language = ?",
                    new String[]{String.valueOf(userId), language});

            ContentValues profileValues = new ContentValues();
            profileValues.put("tasks_done", getProfile().tasksDone + 1);
            db.update(TABLE_USERS, profileValues, "id = ?", new String[]{String.valueOf(userId)});
        }
    }

    public int getCompletedCoursesCount() {
        int userId = getCurrentUserId();
        if (userId == -1) {
            return 0;
        }
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT COUNT(*) FROM " + TABLE_LANGUAGE_PROGRESS +
                        " WHERE user_id = ? AND completed = 1",
                new String[]{String.valueOf(userId)});
        int count = 0;
        if (cursor.moveToFirst()) {
            count = cursor.getInt(0);
        }
        cursor.close();
        return count;
    }

    private void ensureLanguageRows(int userId) {
        for (String language : BASE_LANGUAGES) {
            ensureLanguageRow(userId, language);
        }
    }

    private void ensureLanguageRow(int userId, String language) {
        SQLiteDatabase db = getWritableDatabase();
        Cursor cursor = db.rawQuery("SELECT language FROM " + TABLE_LANGUAGE_PROGRESS +
                        " WHERE user_id = ? AND language = ?",
                new String[]{String.valueOf(userId), language});
        boolean exists = cursor.moveToFirst();
        cursor.close();
        if (!exists) {
            ContentValues values = new ContentValues();
            values.put("user_id", userId);
            values.put("language", language);
            values.put("current_topic", -1);
            values.put("completed", 0);
            db.insert(TABLE_LANGUAGE_PROGRESS, null, values);
        }
    }

    private int getCurrentUserId() {
        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.rawQuery("SELECT current_user_id FROM " + TABLE_SESSION + " WHERE id = 1", null);
        int userId = -1;
        if (cursor.moveToFirst() && !cursor.isNull(0)) {
            userId = cursor.getInt(0);
        }
        cursor.close();
        return userId;
    }

    private void setSessionUser(Integer userId) {
        SQLiteDatabase db = getWritableDatabase();
        ContentValues values = new ContentValues();
        if (userId == null) {
            values.putNull("current_user_id");
        } else {
            values.put("current_user_id", userId);
        }
        db.update(TABLE_SESSION, values, "id = 1", null);
    }

    private String nullToEmpty(String value) {
        return value == null ? "" : value;
    }

    public static class Profile {
        public String nickname;
        public String email;
        public String phone;
        public String status;
        public String role;
        public int isDonor;
        public int coins;
        public int avatarRes;
        public String avatarUri;
        public String selectedLanguage;
        public int tasksDone;

        public Profile(String nickname, String email, String phone, String status, String role, int isDonor, int coins,
                       int avatarRes, String avatarUri, String selectedLanguage, int tasksDone) {
            this.nickname = nickname;
            this.email = email;
            this.phone = phone;
            this.status = status;
            this.role = role;
            this.isDonor = isDonor;
            this.coins = coins;
            this.avatarRes = avatarRes;
            this.avatarUri = avatarUri;
            this.selectedLanguage = selectedLanguage;
            this.tasksDone = tasksDone;
        }
    }

    private boolean looksLikeEmail(String value) {
        return value != null && value.contains("@");
    }

    private boolean identifierExists(SQLiteDatabase db, String email, String phone) {
        if (email != null && !email.isEmpty()) {
            Cursor emailCursor = db.rawQuery("SELECT id FROM " + TABLE_USERS + " WHERE email = ? LIMIT 1",
                    new String[]{email});
            boolean exists = emailCursor.moveToFirst();
            emailCursor.close();
            if (exists) return true;
        }
        if (phone != null && !phone.isEmpty()) {
            Cursor phoneCursor = db.rawQuery("SELECT id FROM " + TABLE_USERS + " WHERE phone = ? LIMIT 1",
                    new String[]{phone});
            boolean exists = phoneCursor.moveToFirst();
            phoneCursor.close();
            return exists;
        }
        return false;
    }

    private String deriveNickname(String identifier) {
        if (identifier == null) return "Пользователь";
        String v = identifier.trim();
        if (v.isEmpty()) return "Пользователь";
        int at = v.indexOf('@');
        if (at > 0) return v.substring(0, at);
        if (v.length() <= 4) return v;
        return "User" + v.substring(v.length() - 4);
    }

    private String randomNumericCode(Random random, int length) {
        StringBuilder sb = new StringBuilder(length);
        for (int i = 0; i < length; i++) {
            sb.append(random.nextInt(10));
        }
        return sb.toString();
    }
}
