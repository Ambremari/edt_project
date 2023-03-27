package planning_generation;

public class Schedule {
	private String id;
	private String day;
	private String half;
	private int hour;
	
	public Schedule(String id) {
		this.id = id;
		if(!id.equals("999")) {
			this.day = id.substring(0,2);
			this.half = id.substring(2,3);
			this.hour = Integer.parseInt(id.substring(3));
		} else {
			this.day = "999";
			this.half = "999";
			this.hour = 999;
		}
	}
	
	public String getDay() {
		return day;
	}
	
	public String getHalf() {
		return half;
	}
	
	public int getHour() {
		return hour;
	}
	

	public String toString() {
		return id + "Jour : " + day + " Half : " + half + " Hour " + hour;
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
