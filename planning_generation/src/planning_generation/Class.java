package planning_generation;

public class Class {
	private String unit;
	private Schedule schedule;
	private String week;
	private Room room;
	private String roomType;
	private Teacher teacher;
	private Subject subject;
	private String division;
	private String group;
	private String constraint;
	private Class associated;
	
	public Class(String unit, String week, String scheduleId, String roomId, 
			String roomType, String teacherId, String subjectId, String division, String group, String constraint) {
		this.unit = unit;
		this.schedule = new Schedule(scheduleId);
		this.week = week;
		this.room = new Room(roomId);
		this.roomType = roomType;
		this.teacher = new Teacher(teacherId);
		this.subject = new Subject(subjectId);
		this.division = division;
		this.group = group;	
		this.constraint = constraint;	
		this.associated = null;
	}
	
	public Class copyClass() {
		return new Class(unit, week, schedule.getId(), room.getId(), roomType, teacher.getId(), subject.getId(), division, group, constraint);
	}
	
	@Override
	public String toString() {
		return unit + " Horaire : " + schedule + " s" + week + " Salle " + room + "Classe :" + division + " matière " + subject.getId();
	}
	
	public String[] getLineToExport() {
		String [] res = {unit, week, schedule.getId(), room.getId()};
		return res;
	}
	
	public void setRoom(Room room) {
		this.room = room;
	}
	
	public Class getAssociated() {
		return associated;
	}
	
	public String getConstraint() {
		return constraint;
	}
	
	public void setSchedule(Schedule schedule) {
		this.schedule = schedule;
	}
	
	public void setBothSchedule(Schedule schedule) {
		setSchedule(schedule);
		if(associated != null)
			associated.setSchedule(schedule);
	}
	
	public void associate(Class other) {
		this.associated = other;
		setSchedule(associated.getSchedule());
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
	
	public boolean isAssociated() {
		return associated != null;
	}
	
	public boolean sameSchedule(Class other) {
		if(other.equals(associated))
			return false;
		if(isAssociated() || other.isAssociated())
			return schedule.equals(other.getSchedule());
		return schedule.equals(other.getSchedule()) && (week.length() == 3 || other.getWeek().length() == 3 || week.equals(other.getWeek()));
	}
	
	public boolean sameRoom(Class other) {
		return room.equals(other.getRoom());
	}
	
	public boolean sameSubject(Class other) {
		return subject.equals(other.getSubject());
	}
	
	public boolean associatedWith(Class other) {
		return other.equals(associated);
	}
	
	public boolean sameConstraint(Class other) {
		return constraint.equals(other.getConstraint());
	}
	
	public boolean sameDivision(Class other) {
		return division.equals(other.getDivision()) && division.length() != 3;
	}
	
	public boolean sameWeek(Class other) {
		return week.equals(other.getWeek());
	}
	
	public boolean sameDay(Class other) {
		return schedule.getDay().equals(other.getSchedule().getDay());
	}
	
	public boolean sameHalf(Class other) {
		return schedule.getHalf().equals(other.getSchedule().getHalf());
	}
	
	public boolean consecutive(Class other) {
		return sameDay(other) && sameHalf(other) && 
				(schedule.getHour() == other.getSchedule().getHour() + 1 || schedule.getHour() == other.getSchedule().getHour() - 1);
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
		Schedule temp = schedule;
		setBothSchedule(other.getSchedule());
		other.setBothSchedule(temp);
	}
	
	public void switch3(Class second, Class third) {
		Schedule temp = schedule;
		setBothSchedule(third.getSchedule());
		third.setBothSchedule(second.getSchedule());
		second.setBothSchedule(temp);
	}
	
	public boolean noRoom() {
		return room.getId().length() == 3;
	}

}
