package planning_generation;
import java.sql.*;
public class tableGetters {
    public static void main(String[] args) {
        String url = "jdbc:mariadb://localhost:3306/college_databse";
        String user = "test";
        String password = "test";

        try {
            Connection connection = DriverManager.getConnection(url, user, password);
            DatabaseMetaData metaData = connection.getMetaData();
            ResultSet tables = metaData.getTables(null, null, "%", new String[]{"Horaires"});

            while (tables.next()) {
                String tableName = tables.getString("Horaires");
                System.out.println(tableName);
            }

            tables.close();
            connection.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
