package planning_generation;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class Planning {
	private List<Class> classes;
	private List<Class> classesToMove;
	private List<Class> teachersToMove;
	private List<Class> divisionsToMove;
	private List<Class> groupsToMove;
	private List<GroupLink> groupsIncompatibility;
	private List<SubjectsCouple> subjectsIncompatibility;
	private int primaryCost;
	private int secondaryCost;
	private int tertiaryCost;

	public Planning(List<Class> classes, List<GroupLink> groupsIncompatibility, List<SubjectsCouple> subjectsIncompatibility) {
		this.classes = new ArrayList<>(classes);
		this.groupsIncompatibility = new ArrayList<>(groupsIncompatibility);
		this.subjectsIncompatibility = new ArrayList<>(subjectsIncompatibility);
		init();
		evaluatePrimaryCost();
		this.secondaryCost = 0;
		this.tertiaryCost = 0;
	}

	private void init() {
		classesToMove = new ArrayList<>();
		teachersToMove = new ArrayList<>();
		divisionsToMove = new ArrayList<>();
		groupsToMove = new ArrayList<>();
	}
	
	public Planning(Planning planning) {
		this.classes = new ArrayList<>();
		for(Class myClass : planning.getClasses()) {
			Class newClass = myClass.copyClass();
			this.classes.add(newClass);
		}
		this.groupsIncompatibility = new ArrayList<>(planning.getGroupsIncompatibility());
		this.subjectsIncompatibility = new ArrayList<>(planning.getSubjectsIncompatibility());
		init();
		evaluatePrimaryCost();
		this.secondaryCost = 0;
		this.tertiaryCost = 0;
	}
	
	public void update(Planning planning) {
		this.classes = new ArrayList<>();
		for(Class myClass : planning.getClasses()) {
			Class newClass = myClass.copyClass();
			this.classes.add(newClass);
		}
	}
	
	@Override
	public String toString() {
		return "\nCout Primaire : " + primaryCost;
	}
	
	public List<GroupLink> getGroupsIncompatibility() {
		return groupsIncompatibility;
	}
	
	public List<SubjectsCouple> getSubjectsIncompatibility() {
		return subjectsIncompatibility;
	}
	
	public List<Class> getClasses() {
		return classes;
	}

	public int getPrimaryCost() {
		evaluatePrimaryCost();
		return primaryCost;
	}

	public void evaluatePrimaryCost() {
		init();
		primaryCost = 0;
		primaryCost += incompatibleClasses();
	}
	
	public boolean primaryViolation(Class class1, Class class2) {
		if(class1.equals(class2))
			return false;
		if(!class1.sameSchedule(class2))
			return false;
		if(class1.getWeek() == "A" && class2.getWeek() == "A" ) {
			class1.setWeek("B");
			return false;
		}
		if(class1.getWeek() == "B" && class2.getWeek() == "B" ) {
			class1.setWeek("A");
			return false;
		}
		if(class1.sameTeacher(class2)) {
			if(!teachersToMove.contains(class1))
				addTeacherToMove(class1);
			return true;
		}
		if(class1.sameDivision(class2)) {
			if(!divisionsToMove.contains(class1))
				addDivisionToMove(class1);
			return true;
		}
		if(class1.sameGroup(class2)) {
			if(!groupsToMove.contains(class1))
				addGroupToMove(class1);
			return true;
		}
		if(groupsIncompatibility.contains(new GroupLink(class1.getDivision(), class2.getGroup())))
			return true;
		if(subjectsIncompatibility.contains(new SubjectsCouple(class1.getSubject().getId(), class2.getSubject().getId())))
			return true;
		return false;
	}

	public int incompatibleClasses() {
		for (Class class1 : classes) {
			for (Class class2 : classes)
				if (primaryViolation(class1, class2)) {
					if(!classesToMove.contains(class1))
						addClassToMove(class1);
				}
		}
		return classesToMove.size();
	}

	
	public void addClassToMove(Class myClass) {
		classesToMove.add(myClass);
	}
	
	public void addTeacherToMove(Class myClass) {
		teachersToMove.add(myClass);
	}
	
	public void addDivisionToMove(Class myClass) {
		divisionsToMove.add(myClass);
	}
	
	public void addGroupToMove(Class myClass) {
		groupsToMove.add(myClass);
	}


	public List<Class> getClassesSameSchedule(Class other) {
		List<Class> res = new ArrayList<>();
		for (Class myClass : classes)
			if (myClass.sameSchedule(other) && !myClass.equals(other))
				res.add(myClass);
		return res;
	}
	
	public List<Class> getClassesIncompatible(Class myClass) {
		List<Class> res = new ArrayList<>();
		for (Class other : classes)
			if (primaryViolation(myClass, other))
				res.add(other);
		return res;
	}
	
	public  boolean primaryCheck(List<Class> incompatible, List<Class> planned) {
		for (Class myClass : planned)
			if (incompatible.contains(myClass))
				return false;
		return true;
	}
	

	public boolean teacherInClasses(Class teacher, Class other) {
		List<Class> toCheck = getClassesSameSchedule(other);
		for (Class myClass : toCheck)
			if (myClass.sameTeacher(teacher))
				return true;
		return false;
	}

	public boolean divisionInClasses(Class division, Class other) {
		List<Class> toCheck = getClassesSameSchedule(other);
		for (Class myClass : toCheck)
			if (myClass.sameDivision(division))
				return true;
		return false;
	}
	public boolean groupInClasses(Class group, Class other) {
		List<Class> toCheck = getClassesSameSchedule(other);
		for (Class myClass : toCheck)
			if (myClass.sameGroup(group))
				return true;
		return false;
	}
	
	public boolean teachersChecks(Class class1, Class class2) {
		if (class1.sameTeacher(class2))
			return false;
		if (class1.sameSchedule(class2))
			return false;
		//Teacher1 already class at schedule 2
		if (teacherInClasses(class1, class2))
			return false;
		//Teacher2 already class at schedule 1
		if (teacherInClasses(class2, class1))
			return false;
		//division1 already class at schedule 2 and not same division
		if (divisionInClasses(class1, class2) && !class1.sameDivision(class2))
			return false;
		//division2 already class at schedule 1 and not same division
		if (divisionInClasses(class2, class1) && !class1.sameDivision(class2))
			return false;
		return true;
	}
	
	public boolean divisionsChecks(Class class1, Class class2) {
		if (class1.sameDivision(class2))
			return false;
		if (class1.sameSchedule(class2))
			return false;
		if (teacherInClasses(class1, class2) && !class1.sameTeacher(class2))
			return false;
		if (teacherInClasses(class2, class1) && !class1.sameTeacher(class2))
			return false;
		if (divisionInClasses(class1, class2))
			return false;
		if (divisionInClasses(class2, class1))
			return false;
		return true;
	}
	
	public boolean groupChecks(Class class1, Class class2) {
		if (class1.sameGroup(class2))
			return false;
		if (class1.sameSchedule(class2))
			return false;
		if (teacherInClasses(class1, class2) && !class1.sameTeacher(class2))
			return false;
		if (teacherInClasses(class2, class1) && !class1.sameTeacher(class2))
			return false;
		if (groupInClasses(class1, class2))
			return false;
		if (groupInClasses(class2, class1))
			return false;
		return true;
	}
	
	public void permuteGroups() {
		Class class1;
		Class class2;
		int count = 0;
		Random random = new Random();
		boolean check = true;
		while (check && groupsToMove.size() > 1) {
			class1 = groupsToMove.get(random.nextInt(groupsToMove.size()));
			int index = 0;
			do {
				class2 = classes.get(index);
				check = groupChecks(class1, class2);
				index++;
			} while (!check && index < classes.size() - 1);
			if(check) {
				class1.permute(class2);
				count++;
				groupsToMove.remove(class2);
				groupsToMove.remove(class1);
			}
		}
	}

	public void permuteDivisions() {
		Class class1;
		Class class2;
		Random random = new Random();
		boolean check = true;
		while (check && divisionsToMove.size() > 1) {
			class1 = divisionsToMove.get(random.nextInt(divisionsToMove.size()));
			int index = 0;
			do {
				class2 = classes.get(index);
				check = divisionsChecks(class1, class2);
				index++;
			} while (!check && index < classes.size() - 1);
			if(check) {
				class1.permute(class2);
				divisionsToMove.remove(class2);
				divisionsToMove.remove(class1);
			}
		}
	}
	
	public void permuteTeachers() {
		Class class1;
		Class class2;
		Random random = new Random();
		boolean check = true;
		while (check && teachersToMove.size() > 1) {
			class1 = teachersToMove.get(random.nextInt(teachersToMove.size()));
			int index = 0;
			do {
				class2 = classes.get(index);
				check = teachersChecks(class1, class2);
				index++;
			} while (!check && index < classes.size() - 1);
			if(check) {
				class1.permute(class2);
				teachersToMove.remove(class2);
				teachersToMove.remove(class1);
			}
		}
	}
	

	public boolean permuteClasses() {
		Class class1;
		Class class2;
		Random random = new Random();
		boolean check;
		class1 = classesToMove.get(random.nextInt(classesToMove.size()));
		List<Class> incompatible = getClassesIncompatible(class1);
		int index = 0;
		do {
			class2 = classes.get(index);
			check = primaryCheck(incompatible, getClassesSameSchedule(class2));
			if(check) {
				List<Class> incompatible2 = getClassesIncompatible(class2);
				check = primaryCheck(incompatible2, getClassesSameSchedule(class1));
			}
			index++;
		} while (!check && index < classes.size() - 1);
		if(check) {
			class1.permute(class2);
			return true;
		}
		return false;
	}
	
	public void randomPermuteClasses() {
		Class class1;
		Class class2;
		Random random = new Random();
		class1 = classes.get(random.nextInt(classes.size()));
		do{ 
			class2 = classes.get(random.nextInt(classes.size()));
		} while (class1.equals(class2) && class1.sameSchedule(class2));
		class1.permute(class2);
	}
	
	public void randomSwitchClasses() {
		Class class1;
		Class class2;
		Class class3;
		Random random = new Random();
		class1 = classes.get(random.nextInt(classes.size()));
		do{ 
			class2 = classes.get(random.nextInt(classes.size()));
		} while (class1.equals(class2) && class1.sameSchedule(class2));
		do{ 
			class3 = classes.get(random.nextInt(classes.size()));
		} while (class1.equals(class3) && class1.sameSchedule(class3) && class2.equals(class3) && class2.sameSchedule(class3));
		class1.switch3(class2, class3);
	}
	
	
	public boolean switchClasses() {
		Class class1;
		Class class2;
		Class class3;
		Random random = new Random();
		boolean check;
		class1 = classesToMove.get(random.nextInt(classesToMove.size()));
		List<Class> compatible = compatibles(class1);
		int index = 0;
		do {
			class2 = compatible.get(index);
			List<Class> compatible2 = compatibles(class2);
			int index2 = 0;
			do {
				class3 = compatible2.get(index2);
				List<Class> incompatible = getClassesIncompatible(class3);
				check = primaryCheck(incompatible, getClassesSameSchedule(class1));
				index2++;
			} while(!check && index < compatible2.size() - 1);
			index++;
		} while(!check && index < compatible.size() - 1);
		if(check) {
			class1.switch3(class2, class3);
			return true;
		}
		return false;
	}
	
	public List<Class> compatibles(Class class1) {
		List<Class> incompatible = getClassesIncompatible(class1);
		List<Class> res = new ArrayList<>();
		for(Class class2 : classes) {
			if(primaryCheck(incompatible, getClassesSameSchedule(class2)));
				res.add(class2);
		}
		return res;
	}
}
