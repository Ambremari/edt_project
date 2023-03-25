package planning_generation;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

public class Planning {
	private List<Class> classes;
	private List<Class> firstSet;
	private List<Schedule> schedules;
	private List<Room> rooms;
	private List<Class> classesToMove;
	private List<Class> teachersToMove;
	private List<Class> divisionsToMove;
	private List<Class> groupsToMove;
	private List<GroupLink> groupsIncompatibility;
	private List<SubjectsCouple> subjectsIncompatibility;
	private int primaryCost;
	private int missingClassrooms;
	private int secondaryCost;
	private int tertiaryCost;

	public Planning(List<Class> classes, List<Schedule> schedules, List<Room> rooms,
			List<GroupLink> groupsIncompatibility, List<SubjectsCouple> subjectsIncompatibility) {
		this.classes = new ArrayList<>(classes);
		this.schedules = new ArrayList<>(schedules);
		this.rooms = new ArrayList<>(rooms);
		this.firstSet = new ArrayList<>();
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
		this.missingClassrooms = classes.size();
	}
	
	public Planning(Planning planning) {
		this.classes = new ArrayList<>();
		for(Class myClass : planning.getClasses()) {
			Class newClass = myClass.copyClass();
			this.classes.add(newClass);
		}
		this.schedules = new ArrayList<>(planning.getSchedules());
		this.rooms = new ArrayList<>(planning.getRooms());
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
	
	public void setRandomSchedule() {
		Random random = new Random(); 
		for(Class myClass : classes) {
			int randomSchedule = random.nextInt(schedules.size());
			myClass.setSchedule(schedules.get(randomSchedule));
		}
	}
	public void addClasses(List<Class> classes) {
		Random random = new Random();
		for(Class newClass : classes)
			if(!this.classes.contains(newClass)) {
				this.classes.add(newClass);
				int randomSchedule = random.nextInt(schedules.size());
				newClass.setSchedule(schedules.get(randomSchedule));
			}
		}
	
	@Override
	public String toString() {
		String res = "\nCout Primaire : " + getPrimaryCost();
		res += "\nSalles manquantes : " + getMissingClassrooms();
		return res;
	}
	
	public List<Room> getRooms() {
		return rooms;
	}
	
	public List<Class> getFirstSet() {
		return firstSet;
	}
	
	public List<Schedule> getSchedules() {
		return schedules;
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
	
	public int getMissingClassrooms() {
		checkClassrooms();
		return missingClassrooms;
	}

	public void evaluatePrimaryCost() {
		init();
		primaryCost = 0;
		primaryCost += incompatibleClasses();
	}
	
	public List<Class> getClassesToMove() {
		return classesToMove;
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
		if(groupsIncompatibility.contains(new GroupLink(class1.getDivision(), class2.getGroup())) || 
				groupsIncompatibility.contains(new GroupLink(class2.getDivision(), class1.getGroup()))) {
			if(!groupsToMove.contains(class1))
				addGroupToMove(class1);
			return true;
		}
		if(subjectsIncompatibility.contains(new SubjectsCouple(class1.getSubject().getId(), class2.getSubject().getId())))
			return true;
		return false;
	}
	
	public boolean incompatible(Class class1, Class class2) {
		if(class1.equals(class2))
			return false;
		if(class1.sameTeacher(class2)) 
			return true;
		if(class1.sameDivision(class2)) 
			return true;
		if(class1.sameGroup(class2)) 
			return true;
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
			if (incompatible(myClass, other))
				res.add(other);
		return res;
	}
	
	public void mostContraints() {
		for(Class myClass : classes) {
			List<Class> incompatible = getClassesIncompatible(myClass);
//			System.out.println(incompatible.size());
			if(incompatible.size() > 40)
				firstSet.add(myClass);
		}
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
	
	public boolean incompatibleGroupInClasses(Class group, Class other) {
		List<Class> toCheck = getClassesSameSchedule(other);
		for (Class myClass : toCheck) {
			if (groupsIncompatibility.contains(new GroupLink(group.getDivision(), myClass.getGroup())))
				return true;
			if (groupsIncompatibility.contains(new GroupLink(myClass.getDivision(), group.getGroup())))
				return true;
		}
		return false;
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
		if(incompatibleGroupInClasses(class1, class2))
			return false;
		if(incompatibleGroupInClasses(class1, class2)) 
			return false;
		return true;
	}

	public boolean permuteDivisions() {
		Class class1;
		Class class2;
		Random random = new Random();
		boolean check = true;
		if(divisionsToMove.size() > 0) {
			class1 = divisionsToMove.get(random.nextInt(divisionsToMove.size()));
			int index = 0;
			do {
				class2 = classes.get(random.nextInt(classes.size()));
				check = divisionsChecks(class1, class2);
				index++;
			} while (!check && index < classes.size() - 1);
			if(check) {
				class1.permute(class2);
				divisionsToMove.remove(class2);
				divisionsToMove.remove(class1);
				return true;
			}
		}
		return false;
	}
	
	public boolean divisionsGroupsChecks(Class class1, Class class2) {
		if (class1.sameDivision(class2))
			return false;
		if (class1.sameGroup(class2))
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
		if (groupInClasses(class1, class2))
			return false;
		if (groupInClasses(class2, class1))
			return false;
		if(incompatibleGroupInClasses(class1, class2))
			return false;
		if(incompatibleGroupInClasses(class1, class2)) 
			return false;
		return true;
	}

	public boolean permuteDivisionsGroups() {
		Class class1;
		Class class2;
		Random random = new Random();
		boolean check = true;
		if(groupsToMove.size() > 0) {
			class1 = groupsToMove.get(random.nextInt(groupsToMove.size()));
			int index = 0;
			do {
				class2 = classes.get(random.nextInt(classes.size()));
				check = divisionsGroupsChecks(class1, class2);
				index++;
			} while (!check && index < classes.size() - 1);
			if(check) {
				class1.permute(class2);
				groupsToMove.remove(class2);
				groupsToMove.remove(class1);
				return true;
			}
		}
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
		if(incompatibleGroupInClasses(class1, class2))
			return false;
		if(incompatibleGroupInClasses(class1, class2)) 
			return false;
		return true;
	}
	
	public boolean permuteTeachers() {
		Class class1;
		Class class2;
		Random random = new Random();
		boolean check;
		if(teachersToMove.size() > 0) {
			class1 = teachersToMove.get(random.nextInt(teachersToMove.size()));
			int index = 0;
			do {
				class2 = classes.get(random.nextInt(classes.size()));
				check = teachersChecks(class1, class2);
				index++;
			} while (!check && index < classes.size() - 1);
			if(check) {
				class1.permute(class2);
				teachersToMove.remove(class2);
				teachersToMove.remove(class1);
				return true;
			}
		}
		return false;
	}
	

	public boolean permuteClasses() {
		Class class1;
		Class class2;
		Random random = new Random();
		boolean check;
		if(classesToMove.size() > 0) {
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
			} while(!check && index2 < compatible2.size() - 1);
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
	
	public List<Class> getScheduleClasses(Schedule schedule){
		List<Class> res = new ArrayList<>();
		for(Class myClass : classes) {
			if(myClass.getSchedule().equals(schedule))
				res.add(myClass);
		}
		return res;
	}
	
	
	public void available() {
		Random random = new Random();
		for(Class class1 : classesToMove) {
			List<Class> incompatible = getClassesIncompatible(class1);
			List<Schedule> res = new ArrayList<>();
			for(Schedule schedule : schedules) {
				List<Class> toTest = getScheduleClasses(schedule);
				if(primaryCheck(incompatible, toTest))
					res.add(schedule);
			}
			if(res.size() > 0)
				class1.setSchedule(res.get(random.nextInt(res.size())));
		}
	}
	
	public void countIncompatible() {
		Class toExchange = null;
		for(Class class1 : classes) {
			for(Schedule schedule : schedules) {
				int count = 0;
				if(!class1.getSchedule().equals(schedule)) {
					List<Class> toTest = getScheduleClasses(schedule);
					for(Class class2 : toTest) {
						if(incompatible(class1, class2)) {
							toExchange = class2;
							count++;
						}
					}
				}
				if(count == 1) {
					List<Class> incompatible = getClassesIncompatible(toExchange);
					if(primaryCheck(incompatible, getClassesSameSchedule(class1))) {
						int oldCost = getPrimaryCost();
						class1.permute(toExchange);
						int newCost = getPrimaryCost();
						if(newCost >= oldCost)
							class1.permute(toExchange);
					}
				}
			}
		}
	}
	
	
	
	public void setClassroom() {
		Random random = new Random(); 
		for(Class myClass : classes) {
			List<Room> roomsAvailable = availableRooms(myClass);
			List<Room> roomsOfType = roomsOfType(roomsAvailable, myClass.getRoomType());
			if(roomsOfType.size() > 0) {
				int randomRoom = random.nextInt(roomsOfType.size());
				myClass.setRoom(roomsOfType.get(randomRoom));
			}
		}
	}
	
	public List<Room> availableRooms(Class myClass){
		List<Class> planned = getClassesSameSchedule(myClass);
		List<Room> roomsAvailable = new ArrayList<>(rooms);
		for(Class other : planned) {
			Room room = other.getRoom();
			if(roomsAvailable.contains(room))
				roomsAvailable.remove(room);
		}
		return roomsAvailable;
	}
	
	public List<Room> roomsOfType(List<Room> rooms, String type){
		List<Room> roomsOfType = new ArrayList<>();
		for(Room room : rooms) {
			if(room.isOfType(type))
				roomsOfType.add(room);
		}
		return roomsOfType;
	}
	
	public void checkClassrooms() {
		missingClassrooms = 0;
		for(Class myClass : classes)
			if(myClass.noRoom())
				missingClassrooms++;
	}
}
