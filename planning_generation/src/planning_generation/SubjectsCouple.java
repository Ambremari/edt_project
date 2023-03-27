package planning_generation;

public class SubjectsCouple{
	private Subject subject1;
	private Subject subject2;
	
	public SubjectsCouple(String id1, String id2) {
		this.subject1 = new Subject(id1);
		this.subject2 = new Subject(id2);
	}
	
	public Subject getSubject1() {
		return subject1;
	}
	
	public Subject getSubject2() {
		return subject2;
	}
	
	@Override
	public String toString() {
		return subject1.getId() + " " + subject2.getId();
	}
	
	public boolean equals(Object obj) {
		if(obj instanceof SubjectsCouple) {
			SubjectsCouple couple = (SubjectsCouple) obj;
			return subject1.equals(couple.getSubject1()) && subject2.equals(couple.getSubject2());
		}
		return false;
	}
}