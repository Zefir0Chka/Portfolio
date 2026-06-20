package lesson_db;

import java.sql.SQLException;

public class Main {
    public static void main(String[] args) throws SQLException, ClassNotFoundException {
        DataBase db = new DataBase();
        db.isConnection();
        db.createTableCars();


        db.addCar(1,"Toyota Corolla", true);
        db.addCar(2,"Honda Civic", true);
        db.addCar(3,"Ford Focus", true);
       db.addCar(4,"Chevrolet Malibu", true);
       db.addCar(5,"Nissan Sentra", true);
       db.addCar(6,"Volkswagen Jetta", true);
       db.addCar(7,"Kia Forte", true);
       db.addCar(8,"Hyundai Elantra", true);
       db.addCar(9,"Mazda 3", true);
       db.addCar(10,"Subaru Impreza", true);


        System.out.println("\nВсе автомобили:");
        db.selectAllCars();

        System.out.println("\nДоступные автомобили:");
        db.selectAvailableCars();
    }
}