<div class="filter">
<label for="type">Type de salle</label>
<select class="form-control" id="mySelect"  onchange="filterDivision()" 
    name="type" minlength="2" maxlength="15"
    aria-describedby="type_feedback"
    value="{{ old('type') }}" required>
    <option value="" selected>Tous</option>
    @foreach($types as $type)
    <option value="{{ $type['TypeSalle'] }}">{{ $type['TypeSalle'] }}</option>
    @endforeach
</select>
</div>

<div class="myTable">
<table id="salleTable">
  <tr class="header">
    <th>Libellé</th>
    <th>Type de salle</th>
    <th>Capacité</th>
    <th></th>
  </tr>
  @foreach ($classrooms as $row)
        <tr>
            <td>{{ $row['LibelleSalle'] }}</td>
            <td>{{ $row['TypeSalle'] }}</td>
            <td>{{ $row['CapSalle'] }}</td>
            <td><a href="{{route('classroom.update.form', ['idSalle' => $row['IdSalle']])}}">Modifier</a></td>
        </tr>
    @endforeach
</table>
</div>

<script>
function filterDivision() {
  var select, filter, table, tr, td, i, txtValue;
  select = document.getElementById("mySelect");
  filter = select.value;
  table = document.getElementById("salleTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue == filter || filter == "") {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>