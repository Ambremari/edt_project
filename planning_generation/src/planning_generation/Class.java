package planning_generation;

public class Class {
	private String unit;
	private String week;
	private Schedule schedule;
	private Room room;
	private String roomType;
	private Teacher teacher;
	private Subject subject;
	private String division;
	private String group;
	
	public Class(String unit, String week, String scheduleId, String roomId, 
			String roomType, String teacherId, String subjectId, String division, String group) {
		this.unit = unit;
		this.week = week;
		this.schedule = new Schedule(scheduleId);
		this.room = new Room(roomId);
		this.roomType = roomType;
		this.teacher = new Teacher(teacherId);
		this.subject = new Subject(subjectId);
		this.division = division;
		this.group = group;	
	}
	
	public Class copyClass() {
		return new Class(unit, week, schedule.getId(), room.getId(), roomType, teacher.getId(), subject.getId(), division, group);
	}
	
	@Override
	public String toString() {
		return unit + " Horaire : " + schedule + " Salle :" + room;
	}
	
	public void setRoom(Room room) {
		this.room = room;
	}
	
	public void setSchedule(Schedule schedule) {
		this.schedule = schedule;
	}
	
	public void setWeek(String week) {
		this.week = week;
	}
	
	public String getDivision() {
		return division;
	}
	
	public String getGroup() {
		return group;
	}
	
	public String getRoomType() {
		return roomType;
	}
	
	public Subject getSubject() {
		return subject;
	}
	
	public Teacher getTeacher() {
		return teacher;
	}
	
	public String getUnit() {
		return unit;
	}
	
	public String getWeek() {
		return week;
	}
	
	public Room getRoom() {
		return room;
	}
	
	public Schedule getSchedule() {
		return schedule;
	}
	
	public boolean sameTeacher(Class other) {
		return teacher.equals(other.getTeacher());
	}
	
	public boolean sameSchedule(Class other) {
		return schedule.equals(other.getSchedule()) && week.equals(other.week);
	}
	
	public boolean sameRoom(Class other) {
		return room.equals(other.getRoom());
	}
	
	public boolean sameDivision(Class other) {
		return division.equals(other.getDivision());
	}
	
	public boolean sameGroup(Class other) {
		return group.equals(other.getGroup()) && group.length() != 3;
	}
	
	@Override
	public boolean equals(Object obj) {
		if(obj instanceof Class)
			return ((Class) obj).getUnit().equals(this.unit);
		return super.equals(obj);
	}
	
	public void permute(Class other) {
		Schedule temp = this.schedule;
		setSchedule(other.getSchedule());
		other.setSchedule(temp);
	}
	
	public void switch3(Class second, Class third) {
		Schedule temp = this.schedule;
		setSchedule(third.getSchedule());
		third.setSchedule(second.getSchedule());
		second.setSchedule(temp);
	}
}
