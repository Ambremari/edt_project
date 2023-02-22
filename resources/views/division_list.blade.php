<div class="filter">
<label for="grade">Filtrer par niveau</label>
<select class="form-control" id="mySelect" onchange="filterDivision()">
    <option value="" selected>Tous</option>
    <option value="6EME">6ème</option>
    <option value="5EME">5ème</option>
    <option value="4EME">4ème</option>
    <option value="3EME">3ème</option>
</select>
</div>

<div class="myTable">
<table id="divisionTable">
  <tr class="header">
    <th>Libellé</th>
    <th>Niveau</th>
    <th>Effectif prévu</th>
    <th>Effectif réel</th>
    <th></th>
  </tr>
  @foreach ($divisions as $row)
        <tr>
            <td>{{ $row['LibelleDiv'] }}</td>
            <td>{{ $row['NiveauDiv'] }}</td>
            <td>{{ $row['EffectifPrevDiv'] }}</td>
            <td></td>
            <td><a href="{{route('division.update.form', ['idDiv' => $row['IdDiv']])}}">Modifier</a></td>
        </tr>
    @endforeach
</table>
</div>

<script>
function filterDivision() {
  var select, filter, table, tr, td, i, txtValue;
  select = document.getElementById("mySelect");
  filter = select.value;
  table = document.getElementById("divisionTable");
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