package planning_generation;

public class GroupLink {
	private String division;
	private String group;
	
	public GroupLink(String division, String group) {
		this.division = division;
		this.group = group;
	}
	
	public String getDivision() {
		return division;
	}
	
	public String getGroup() {
		return group;
	}
	
	@Override
	public String toString() {
		return getDivision() + " " + getGroup();
	}
	
	@Override
	public boolean equals(Object obj) {
		if(obj instanceof GroupLink) {
			GroupLink couple = (GroupLink) obj;
			return division.equals(couple.getDivision()) && group.equals(couple.getGroup());
		}
		return false;
	}

}
