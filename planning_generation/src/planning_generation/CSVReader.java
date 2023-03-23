package planning_generation;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

public class CSVReader {

	public static void main(String[] args) {
		List<Class> classes = readClassesFromCSV("data/classes.csv");

		for (Class myClass : classes) {
			System.out.println(myClass);
		}

		List<Room> rooms = readClassroomsFromCSV("data/classrooms.csv");

		for (Room room : rooms) {
			System.out.println(room);
		}

		List<Schedule> schedules = readSchedulesFromCSV("data/schedules.csv");

		for (Schedule schedule : schedules) {
			System.out.println(schedule);
		}
	}

	static List<Class> readClassesFromCSV(String fileName) {
		List<Class> classes = new ArrayList<>();

		try (BufferedReader br = new BufferedReader(new FileReader(fileName))) {
			String line = br.readLine();
			line = br.readLine();

			while (line != null) {
				String[] values = line.split(";");

				Class myClass = createClass(values);

				classes.add(myClass);

				line = br.readLine();
			}
		} catch (IOException ioe) {
			ioe.printStackTrace();
		}

		return classes;
	}

	private static Class createClass(String[] metadata) {
		String unit = metadata[0];
		String week = metadata[1];
		String scheduleId = metadata[2];
		String roomId = metadata[3];
		String roomType = metadata[4];
		String teacherId = metadata[5];
		String subjectId = metadata[6];
		String division = metadata[7];
		String group = metadata[8];

		return new Class(unit, week, scheduleId, roomId, roomType, teacherId, subjectId, division, group);
	}

	static List<Room> readClassroomsFromCSV(String fileName) {
		List<Room> rooms = new ArrayList<>();

		try (BufferedReader br = new BufferedReader(new FileReader(fileName))) {
			String line = br.readLine();
			line = br.readLine();

			while (line != null) {
				String[] values = line.split(";");

				Room room = createRoom(values);

				rooms.add(room);

				line = br.readLine();
			}
		} catch (IOException ioe) {
			ioe.printStackTrace();
		}

		return rooms;
	}

	private static Room createRoom(String[] metadata) {
		String id = metadata[0];
		String type = metadata[1];

		return new Room(id, type);
	}

	static List<Schedule> readSchedulesFromCSV(String fileName) {
		List<Schedule> schedules = new ArrayList<>();

		try (BufferedReader br = new BufferedReader(new FileReader(fileName))) {
			String line = br.readLine();
			line = br.readLine();

			while (line != null) {
				String[] values = line.split(";");

				Schedule schedule = new Schedule(values[0]);

				schedules.add(schedule);

				line = br.readLine();
			}
		} catch (IOException ioe) {
			ioe.printStackTrace();
		}

		return schedules;
	}

}