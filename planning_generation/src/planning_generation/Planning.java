package planning_generation;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class Planning {
	private List<Class> classes;
	private List<Class> teachersToMove;
	private List<Class> divisionsToMove;
	private List<Class> groupsToMove;
	private int primaryCost;
	private int secondaryCost;
	private int tertiaryCost;

	public Planning(List<Class> classes) {
		this.classes = classes;
		teachersToMove = new ArrayList<>();
		divisionsToMove = new ArrayList<>();
		groupsToMove = new ArrayList<>();
		evaluatePrimaryCost();
		this.secondaryCost = 0;
		this.tertiaryCost = 0;
	}
	
	@Override
	public String toString() {
		String res = "Cout prof : " + teachersToMove.size();
		res += "\nCout div : " + divisionsToMove.size();
		res += "\nCout grp : " + groupsToMove.size();
		res += "\nCout Primaire : " + primaryCost;
		return res;
	}
	
	public List<Class> getClasses() {
		return classes;
	}

	public int getPrimaryCost() {
		evaluatePrimaryCost();
		return primaryCost;
	}

	public void evaluatePrimaryCost() {
		primaryCost = 0;
		primaryCost += teacherClassesSameTime();
		primaryCost += divisionClassesSameTime();
		primaryCost += groupClassesSameTime();
	}

	public int teacherClassesSameTime() {
		for (Class class1 : classes) {
			for (Class class2 : classes)
				if (!class1.equals(class2) && class1.sameTeacher(class2) && class1.sameSchedule(class2)) {
					if(!teachersToMove.contains(class1))
						addTeacherToMove(class1);
				}
		}
		return teachersToMove.size();
	}

	public int divisionClassesSameTime() {
		for (Class class1 : classes) {
			for (Class class2 : classes)
				if (!class1.equals(class2) && class1.sameDivision(class2) && class1.sameSchedule(class2)) {
					if(!divisionsToMove.contains(class1))
						addDivisionToMove(class1);
				}
		}
		return divisionsToMove.size();
	}

	public int groupClassesSameTime() {
		for (Class class1 : classes) {
			for (Class class2 : classes)
				if (!class1.equals(class2) && class1.sameGroup(class2) && class1.sameSchedule(class2))
					if(!groupsToMove.contains(class1))
						addGroupToMove(class1);
		}
		return groupsToMove.size();
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
		if (teacherInClasses(class1, class2))
			return false;
		if (teacherInClasses(class2, class1))
			return false;
		if (divisionInClasses(class1, class2) && !class1.sameDivision(class2))
			return false;
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
		System.out.println("Nb de permutations : " + count);
	}

	public void permuteDivisions() {
		Class class1;
		Class class2;
		int count = 0;
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
				count++;
				divisionsToMove.remove(class2);
				divisionsToMove.remove(class1);
			}
		}
		System.out.println("Nb de permutations : " + count);
	}

	public void permuteTeachers() {
		Class class1;
		Class class2;
		int count = 0;
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
				count++;
				teachersToMove.remove(class2);
				teachersToMove.remove(class1);
			}
		}
		System.out.println("Nb de permutations : " + count);
	}
}
