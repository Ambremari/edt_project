package planning_generation;

public class Room {
	private String id;
	private String type;
	
	public Room(String id) {
		this.id = id;
		this.type = null;
	}
	
	public Room(String id, String type) {
		this(id);
		this.type = type;
	}
	
	public String getId() {
		return id;
	}
	
	@Override
	public String toString() {
		return id + " " + type;
	}
	
	public void setType(String type) {
		this.type = type;
	}
	
	public boolean isOfType(String type) {
		return this.type.equals(type);
	}
	
	public boolean equals(Object obj) {
		if(obj instanceof Room)
			return this.id.equals(((Room) obj).getId());
		return false;
	}

}