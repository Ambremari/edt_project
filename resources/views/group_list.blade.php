<div class="filter">
<label for="grade">Filtrer par niveau</label>
<select class="form-control" id="mySelect" onchange="filterGroup()">
    <option value="" selected>Tous</option>
    <option value="6EME">6ème</option>
    <option value="5EME">5ème</option>
    <option value="4EME">4ème</option>
    <option value="3EME">3ème</option>
</select>
</div>

<div class="myTable">
<table id="groupTable">
  <tr class="header">
    <th>Libellé</th>
    <th>Niveau</th>
    <th>Effectif prévu</th>
    <th>Effectif réel</th>
    <th></th>
    <th></th>
  </tr>
  @foreach ($groups as $row)
        <tr>
            <td>{{ $row['LibelleGrp'] }}</td>
            <td>{{ $row['NiveauGrp'] }}</td>
            <td>{{ $row['EffectifPrevGrp'] }}</td>
            <td>{{ $row['EffectifReelGrp'] }}</td>
            <td><a href="{{route('group.update.form', ['idGrp' => $row['IdGrp']])}}">Modifier</a></td>
            <td><a href="{{route('group.show', ['idGrp' => $row['IdGrp']])}}">Fiche</a></td>
        </tr>
    @endforeach
</table>
</div>

<script>
function filterGroup() {
  var select, filter, table, tr, td, i, txtValue;
  select = document.getElementById("mySelect");
  filter = select.value;
  table = document.getElementById("groupTable");
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