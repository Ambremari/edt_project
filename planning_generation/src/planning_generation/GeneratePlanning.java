package planning_generation;

import com.opencsv.CSVWriter;
import com.opencsv.CSVWriterBuilder;
import com.opencsv.ICSVWriter;

import java.io.FileWriter;
import java.io.File;
import java.io.IOException;
import java.io.PrintWriter;
import java.util.ArrayList;
import java.util.List;
import java.util.Random;
import java.util.stream.Collectors;
import java.util.stream.Stream;

public class GeneratePlanning {

	public static void main(String[] args) throws IOException {
		List<Class> classes = CSVReader.readClassesFromCSV("data/classes.csv");
		List<Room> rooms = CSVReader.readClassroomsFromCSV("data/classrooms.csv");
		List<Schedule> schedules = CSVReader.readSchedulesFromCSV("data/schedules.csv");
		List<GroupLink> groups = CSVReader.readGroupsFromCSV("data/groups.csv");
		List<SubjectsCouple> subjects = CSVReader.readSubjectsFromCSV("data/subjects.csv");
		
		Planning randomPlanning = new Planning(classes, schedules, rooms, groups, subjects);
		randomPlanning.mostContraints();
		
		
		//Positioning classes with the most constraints
		Planning firstSetPlanning = new Planning(randomPlanning.getFirstSet(), schedules, rooms, groups, subjects);
		firstSetPlanning.setRandomSchedule();
		System.out.println(firstSetPlanning);
		
		firstOptim(firstSetPlanning);
		int i = 0;
		while(firstSetPlanning.getPrimaryCost() > 0 && i < 1500) {
			i++;
			secondOptim(firstSetPlanning);
		}
		System.out.println(firstSetPlanning);
		
		Planning bestPlanning = new Planning(firstSetPlanning);
		bestPlanning.addClasses(classes);
		System.out.println(bestPlanning);
		
		firstOptim(bestPlanning);
		i = 0;
		while(bestPlanning.getPrimaryCost() > 0 && i < 200) {
			i++;
			secondOptim(bestPlanning);
		}
		
		for (Class myClass : bestPlanning.getClassesToMove()) {
			System.out.println(myClass);
		}
		System.out.println("Nb itération : " + i);
		
		bestPlanning.setClassroom();
		System.out.println(bestPlanning);
		
		//export planning
		List<String[]> dataToExport = new ArrayList<>();
		for(Class myClass : bestPlanning.getClasses())
			dataToExport.add(myClass.getLineToExport());
		
		 try (ICSVWriter writer = new CSVWriterBuilder(
		          new FileWriter("planning.csv"))
		          .withSeparator(';')
		          .build()) {
		      writer.writeAll(dataToExport);
		  }
		
	}

	private static void secondOptim(Planning bestPlanning) {
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
	
	public static void firstOptim(Planning planning) {
		planning.available();
		planning.evaluatePrimaryCost();
		System.out.println(planning);	
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
	
	
	
	
}