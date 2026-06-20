package lesson_db;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

public class DataBase {
    private final String host = "localhost";
    private final String port = "5432";
    private final String dbName = "Car";
    private final String login = "postgres";
    private final String password = "";

    private Connection dbCon; // подключение к бд

    private Connection getDBConnection() {
        String str = "jdbc:postgresql://" + host + ":" + port + "/" + dbName;
        try {
            Class.forName("org.postgresql.Driver");
            dbCon = DriverManager.getConnection(str, login, password);
            System.out.println("Соединение установлено");
        } catch (ClassNotFoundException e) {
            System.out.println(" не найден.");
        } catch (SQLException e) {
            System.out.println("Неверный путь (логин и пароль)");
        }
        return dbCon;
    }

    public void isConnection() throws SQLException, ClassNotFoundException {
        dbCon = getDBConnection();
        System.out.println(dbCon.isValid(1000));
    }

    public void createTableCars() {
        String sql = "CREATE TABLE IF NOT EXISTS arenda " +
                "(id int PRIMARY KEY, name VARCHAR(100))";

        try {
            Statement statement = getDBConnection().createStatement();
            statement.executeUpdate(sql);
            System.out.println("Таблица автомобилей создана");
        } catch (SQLException e) {
            throw new RuntimeException(e);
        }
    }

    public void addCar(int id, String name, boolean available) {
        String sql = "INSERT INTO arenda (id, name, available) VALUES ( '" + id + "','" + name + "','" + available + "');";
        try {
            Statement statement = getDBConnection().createStatement();
            int rows = statement.executeUpdate(sql);
            System.out.printf("Добавлено %d строк\n", rows);
        } catch (SQLException e) {
            System.out.println("Не удалось добавить автомобиль");
        }
    }

    public void selectAllCars() throws SQLException {
        Statement statement = getDBConnection().createStatement();
        ResultSet resultSet = statement.executeQuery("SELECT * FROM arenda");
        while (resultSet.next()) {
            int id = resultSet.getInt(1);
            String name = resultSet.getString(2);
            boolean available = resultSet.getBoolean(3);
            System.out.printf("%d. %s. Доступен: %s\n", id, name, available ? "Да" : "Нет");
        }
    }

    public void selectAvailableCars() throws SQLException {
        Statement statement = getDBConnection().createStatement();
        ResultSet resultSet = statement.executeQuery("SELECT * FROM arenda WHERE available = true");
        while (resultSet.next()) {
            int id = resultSet.getInt(1);
            String name = resultSet.getString(2);
            System.out.printf("%d. %s. Доступен: Да\n", id, name);
        }
    }
}
