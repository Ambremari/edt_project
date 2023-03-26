package planning_generation;

public class Schedule {
	private String id;
	private String week;
	
	public Schedule(String id, String week) {
		this.id = id;
		this.week = week;
	}
	

	public String toString() {
		return id + "Semaine : " + week + " l:" + week.length();
	}
	
	public String getId() {
		return id;
	}
	
	public String getWeek() {
		return week;
	}
	
	public void setId(String id) {
		this.id = id;
	}
	
	public void setWeek(String week) {
		this.week = week;
	}
	
	public boolean sameDuration(Schedule schedule) {
		return week.length() == schedule.getWeek().length();
	}
	
	@Override
	public boolean equals(Object obj) {
		if(obj instanceof Schedule) {
			Schedule other = (Schedule) obj;
			return this.id.equals(other.getId()) && (week.equals(other.getWeek()) || week.length() == 3 || other.getWeek().length() == 3);
		}
		return false;
	}

}
