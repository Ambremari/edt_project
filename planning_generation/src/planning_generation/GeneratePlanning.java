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
		List<String> durationConstraints = CSVReader.readStringFromCSV("data/duration.csv");
		
		Planning randomPlanning = new Planning(classes, schedules, rooms, groups, subjects, durationConstraints);
		randomPlanning.mostContraints();
		
		//Positioning classes with the most constraints 
		 Planning firstSetPlanning = new Planning(randomPlanning.getFirstSet(), schedules, rooms, groups, subjects, durationConstraints);
		firstSetPlanning.setRandomSchedule();
		System.out.println(firstSetPlanning);
		
		firstSetPlanning.associateClasses();
		System.out.println(firstSetPlanning);
		
		firstOptim(firstSetPlanning);
		int i = 0;
		while(firstSetPlanning.getPrimaryCost() > 0) {
			i++;
			secondOptim(firstSetPlanning);
		}
		System.out.println(firstSetPlanning);
		
		Planning bestPlanning = new Planning(firstSetPlanning);
		bestPlanning.addClasses(classes);
		System.out.println(bestPlanning);
		
		firstOptim(bestPlanning);
		i = 0;
		while(bestPlanning.getPrimaryCost() > 0 && i < 6000) {
			i++;
			System.out.println("itération : " + i);
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
		if(copyPlanning.permuteTeachers()) {
			evaluate(copyPlanning, bestPlanning);
			copyPlanning = new Planning(bestPlanning);
		}
		
		if(copyPlanning.permuteDivisions()){
			evaluate(copyPlanning, bestPlanning);
			copyPlanning = new Planning(bestPlanning);
		}
		
		if(copyPlanning.permuteSubjects()){
			evaluate(copyPlanning, bestPlanning);
			copyPlanning = new Planning(bestPlanning);
		}
		
		if(copyPlanning.permuteDivisionsGroups()){
			evaluate(copyPlanning, bestPlanning);
			copyPlanning = new Planning(bestPlanning);
		}
		
		if(copyPlanning.permuteClasses()){
			evaluate(copyPlanning, bestPlanning);
			copyPlanning = new Planning(bestPlanning);
		}
		
		if(copyPlanning.permuteClassesToMove()){
			evaluate(copyPlanning, bestPlanning);
			copyPlanning = new Planning(bestPlanning);
		}
		 
		if(copyPlanning.switchClasses()){
			evaluate(copyPlanning, bestPlanning);
			copyPlanning = new Planning(bestPlanning);
		}
		
		copyPlanning = new Planning(bestPlanning);
		copyPlanning.randomPermuteClasses();
		evaluate(copyPlanning, bestPlanning);
		
		copyPlanning = new Planning(bestPlanning);
		copyPlanning.randomSwitchClasses();
		evaluate(copyPlanning, bestPlanning);
			
		copyPlanning = new Planning(bestPlanning);
		copyPlanning.randomPermuteClasses();
		evaluateRandom(copyPlanning, bestPlanning);
		
		copyPlanning = new Planning(bestPlanning);
		copyPlanning.randomSwitchClasses();
		evaluateRandom(copyPlanning, bestPlanning);
		
		copyPlanning = new Planning(bestPlanning);
		copyPlanning.available();
		evaluateRandom(copyPlanning, bestPlanning);
	}
	
	public static void firstOptim(Planning planning) {
		planning.available();
		planning.evaluateCost();
		System.out.println(planning);	
		if(planning.getPrimaryCost() > 0) {
			planning.countIncompatible();
			planning.evaluateCost();
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
	
	public static void evaluateRandom(Planning newPlanning, Planning bestPlanning) {
		int newCost = newPlanning.getPrimaryCost();
		int bestCost = bestPlanning.getPrimaryCost();
		int newBonus = newPlanning.getBonus();
		int oldBonus = bestPlanning.getBonus();
		System.out.println(newCost);
		if(newCost < bestCost || (newCost <= bestCost && newBonus > oldBonus)) {
			bestPlanning.update(newPlanning);
			System.out.println("Mouvement");
		}
	}
	
	
	
	
}