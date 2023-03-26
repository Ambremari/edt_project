package planning_generation;

public class Class {
	private String unit;
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
		this.schedule = new Schedule(scheduleId, week);
		this.room = new Room(roomId);
		this.roomType = roomType;
		this.teacher = new Teacher(teacherId);
		this.subject = new Subject(subjectId);
		this.division = division;
		this.group = group;	
	}
	
	public Class copyClass() {
		return new Class(unit, schedule.getWeek(), schedule.getId(), room.getId(), roomType, teacher.getId(), subject.getId(), division, group);
	}
	
	@Override
	public String toString() {
		return unit + " Horaire : " + schedule + " Salle " + room + "Classe :" + division + " matière " + subject.getId();
	}
	
	public String[] getLineToExport() {
		String [] res = {unit, schedule.getWeek(), schedule.getId(), room.getId()};
		return res;
	}
	
	public void setRoom(Room room) {
		this.room = room;
	}
	
	public void setSchedule(Schedule schedule) {
		this.schedule.setId(schedule.getId());
	}
	
	public void setRandomSchedule(Schedule schedule) {
		this.schedule.setId(schedule.getId());
		this.schedule.setWeek(schedule.getWeek());
	}
	
	public void setWeek(String week) {
		schedule = new Schedule(schedule.getId(), week);
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
		return schedule.getWeek();
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
		return schedule.equals(other.getSchedule());
	}
	
	public boolean sameRoom(Class other) {
		return room.equals(other.getRoom());
	}
	
	public boolean sameDivision(Class other) {
		return division.equals(other.getDivision()) && division.length() != 3;
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
		Schedule temp = new Schedule(schedule.getId(), schedule.getWeek());
		setSchedule(other.getSchedule());
		other.setSchedule(temp);
	}
	
	public void switch3(Class second, Class third) {
		Schedule temp = new Schedule(schedule.getId(), schedule.getWeek());
		setSchedule(third.getSchedule());
		third.setSchedule(second.getSchedule());
		second.setSchedule(temp);
	}
	
	public boolean noRoom() {
		return room.getId().length() == 3;
	}
	
	public boolean sameDuration(Class other) {
		return schedule.sameDuration(other.getSchedule());
	}
}
