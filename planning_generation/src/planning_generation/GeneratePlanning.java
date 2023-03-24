package planning_generation;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class GeneratePlanning {

	public static void main(String[] args) {
		List<Class> classes = CSVReader.readClassesFromCSV("data/classes.csv");
		List<Room> rooms = CSVReader.readClassroomsFromCSV("data/classrooms.csv");
		List<Schedule> schedules = CSVReader.readSchedulesFromCSV("data/schedules.csv");
		List<GroupLink> groups = CSVReader.readGroupsFromCSV("data/groups.csv");
		List<SubjectsCouple> subjects = CSVReader.readSubjectsFromCSV("data/subjects.csv");
		
		setSchedule(classes, schedules);
		setClassroom(classes, rooms);
		
		Planning randomPlanning = new Planning(classes, groups, subjects);
		System.out.println(randomPlanning);
		
		Planning bestPlanning = new Planning(randomPlanning);		
		
		for(int i = 0 ; i < 100 ; i++) {
			Planning copyPlanning = new Planning(bestPlanning);
			copyPlanning.permuteTeachers();
			evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			copyPlanning.permuteDivisions();
			evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			if(copyPlanning.permuteClasses())
				evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			if(copyPlanning.switchClasses())
				evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			copyPlanning.randomPermuteClasses();
			evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			copyPlanning.randomSwitchClasses();
			evaluate(copyPlanning, bestPlanning);
		}
		System.out.println(bestPlanning);
	}
	
	public static void evaluate(Planning newPlanning, Planning bestPlanning) {
		int newCost = newPlanning.getPrimaryCost();
		int bestCost = bestPlanning.getPrimaryCost();
		System.out.println(newCost);
		if(newCost < bestCost) {
			bestPlanning.update(newPlanning);
			System.out.println("Mouvement");
		}
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