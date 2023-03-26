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

	
	public void setId(String id) {
		this.id = id;
	}
	
	
	@Override
	public boolean equals(Object obj) {
		if(obj instanceof Schedule) {
			Schedule other = (Schedule) obj;
			return this.id.equals(other.getId());
		}
		return false;
	}

}
