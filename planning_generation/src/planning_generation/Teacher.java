package planning_generation;

import java.util.Vector;

public class Teacher {
	private String id;
	private Vector<Schedule> constraints;
	
	public Teacher(String id) {
		this.id = id;
		this.constraints = new Vector<Schedule>();
	}
	
	public String getId() {
		return id;
	}
	
	public boolean equals(Object obj) {
		if(obj instanceof Teacher)
			return this.id.equals(((Teacher) obj).getId());
		return false;
	}
	
	public void addConstraint(Schedule schedule) {
		constraints.add(schedule);
	}
}
