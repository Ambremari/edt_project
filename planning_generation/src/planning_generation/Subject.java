package planning_generation;

import java.util.Vector;

public class Subject {
	private String id;
	private Vector<Schedule> constraints;
	
	public Subject(String id) {
		this.id = id;
		this.constraints = new Vector<Schedule>();
	}
	
	@Override
	public String toString() {
		return getId();
	}
	
	public String getId() {
		return id;
	}
	
	public boolean equals(Object obj) {
		if(obj instanceof Subject)
			return this.id.equals(((Subject) obj).getId());
		return false;
	}
	
	public void addConstraint(Schedule schedule) {
		constraints.add(schedule);
	}
}
