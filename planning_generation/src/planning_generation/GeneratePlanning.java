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
		

//		setClassroom(classes, rooms);
		
		Planning randomPlanning = new Planning(classes, schedules, groups, subjects);
		randomPlanning.mostContraints();
		
		
		//Positioning classes with the most constraints
		Planning firstSetPlanning = new Planning(randomPlanning.getFirstSet(), schedules, groups, subjects);
		firstSetPlanning.setRandomSchedule();
		System.out.println(firstSetPlanning);
		
		firstOptim(firstSetPlanning);
		
		Planning bestPlanning = new Planning(firstSetPlanning);
		bestPlanning.addClasses(classes);
		bestPlanning.evaluatePrimaryCost();
		System.out.println(bestPlanning);
		
		firstOptim(bestPlanning);
		int i = 0;
		while(bestPlanning.getPrimaryCost() > 0 && i < 200) {
			i++;
			Planning copyPlanning = new Planning(bestPlanning);
			copyPlanning.permuteTeachers();
			evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			copyPlanning.permuteDivisions();
			evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			copyPlanning.permuteDivisionsGroups();
			evaluate(copyPlanning, bestPlanning); 
			
			copyPlanning = new Planning(bestPlanning);
			if(copyPlanning.permuteClasses())
				evaluate(copyPlanning, bestPlanning);
			
//			copyPlanning = new Planning(bestPlanning);
//			if(copyPlanning.switchClasses())
//				evaluate(copyPlanning, bestPlanning);
//			
			copyPlanning = new Planning(bestPlanning);
			copyPlanning.randomPermuteClasses();
			evaluate(copyPlanning, bestPlanning);
			
			copyPlanning = new Planning(bestPlanning);
			copyPlanning.randomSwitchClasses();
			evaluate(copyPlanning, bestPlanning);
		}
		
		for (Class myClass : bestPlanning.getClassesToMove()) {
			System.out.println(myClass);
		}
		System.out.println("Nb itération : " + i);
		System.out.println(bestPlanning);
		
	}
	
	public static void firstOptim(Planning planning) {
		planning.available();
		planning.evaluatePrimaryCost();
		if(planning.getPrimaryCost() > 0) {
			planning.countIncompatible();
			planning.evaluatePrimaryCost();
		}
		System.out.println(planning);	
		}
	
	public static void evaluate(Planning newPlanning, Planning bestPlanning) {
		int newCost = newPlanning.getPrimaryCost();
		int bestCost = bestPlanning.getPrimaryCost();
		System.out.println(newCost);
		if(newCost <= bestCost) {
			bestPlanning.update(newPlanning);
			System.out.println("Mouvement");
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