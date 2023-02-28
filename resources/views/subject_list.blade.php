<div class="filter">
<label for="grade">Filtrer par niveau</label>
<select class="form-control" id="mySelect" onchange="filterSubject()">
    <option value="" selected>Tous</option>
    <option value="6EME">6ème</option>
    <option value="5EME">5ème</option>
    <option value="4EME">4ème</option>
    <option value="3EME">3ème</option>
</select>
</div>

<div class="myTable">
<table id="subjectTable">
  <tr class="header">
    <th>Libellé</th>
    <th>Niveau</th>
    <th>Volume horaire hebdomadaire</th>
    <th>Optionnel</th>
    <th></th>
  </tr>
  @foreach ($subjects as $row)
        <tr>
            <td>{{ $row['LibelleEns'] }}</td>
            <td>{{ $row['NiveauEns'] }}</td>
            <td>{{ $row['VolHEns'] }}</td>
            <td>
              @if($row['OptionEns'] != 0)
              X
              @endif
            </td>
            <td><a href="{{route('subject.update.form', ['idEns' => $row['IdEns']])}}">Modifier</a></td>
        </tr>
    @endforeach
</table>
</div>

<script>
function filterSubject() {
  var select, filter, table, tr, td, i, txtValue;
  select = document.getElementById("mySelect");
  filter = select.value;
  table = document.getElementById("subjectTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
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