package planning_generation;

public class Schedule {
	private String id;
	
	public Schedule(String id) {
		this.id = id;
	}
	

	public String toString() {
		return id;
	}
	
	public String getId() {
		return id;
	}
	
	@Override
	public boolean equals(Object obj) {
		if(obj instanceof Schedule)
			return this.id.equals(((Schedule) obj).getId());
		return false;
	}

}
