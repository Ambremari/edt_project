package planning_generation;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class Planning {

	public static void main(String[] args) {
		List<Class> classes = CSVReader.readClassesFromCSV("data/classes.csv");
		List<Room> rooms = CSVReader.readClassroomsFromCSV("data/classrooms.csv");
		List<Schedule> schedules = CSVReader.readSchedulesFromCSV("data/schedules.csv");
		
		setSchedule(classes, schedules);
		setClassroom(classes, rooms);
		
		for(Class myClass : classes)
			System.out.println(myClass);
	}
	
	public static void setSchedule(List<Class> classes, List<Schedule> schedules) {
		Random random = new Random(); 
		for(Class myClass : classes) {
			int randomSchedule = random.nextInt(schedules.size());
			myClass.setSchedule(schedules.get(randomSchedule));
		}
	}
	
	public static void setClassroom(List<Class> classes, List<Room> rooms) {
		Random random = new Random(); 
		for(Class myClass : classes) {
			List<Room> roomsAvailable = availableRooms(classes, rooms, myClass.getSchedule());
			List<Room> roomsOfType = roomsOfType(roomsAvailable, myClass.getRoomType());
			int randomRoom = random.nextInt(roomsOfType.size());
			myClass.setRoom(roomsOfType.get(randomRoom));
		}
	}
	
	public static List<Class> classesPlanned(List<Class> classes, Schedule schedule){
		List<Class> res = new ArrayList<>();
		for(Class myClass : classes) {
			if(myClass.getSchedule().equals(schedule))
				res.add(myClass);
		}
		return res;
	}
	
	public static List<Room> availableRooms(List<Class> classes, List<Room> rooms, Schedule schedule){
		List<Class> planned = classesPlanned(classes, schedule);
		List<Room> roomsAvailable = new ArrayList<>(rooms);
		for(Class myClass : planned) {
			Room room = myClass.getRoom();
			if(roomsAvailable.contains(room))
				roomsAvailable.remove(room);
		}
		return roomsAvailable;
	}
	
	public static List<Room> roomsOfType(List<Room> rooms, String type){
		List<Room> roomsOfType = new ArrayList<>();
		for(Room room : rooms) {
			if(room.isOfType(type))
				roomsOfType.add(room);
		}
		return roomsOfType;
	}
}