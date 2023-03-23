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

	public boolean sameRoom(Class other) {
		return room.equals(other.getRoom());
	}

    public static void forName(String string) {
    }
}
