<div class="filter">
<label for="grade">Filtrer par niveau</label>
<select class="form-control" id="grade" onselect="filterSubject()">
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
    <th>Durée minimale</th>
    <th>Optionnel</th>
    <th></th>
  </tr>
  @foreach ($subjects as $row)
        <tr>
            <td>{{ $row['LibelleEns'] }}</td>
            <td>{{ $row['NiveauEns'] }}</td>
            <td>{{ $row['VolHEns'] }}</td>
            <td>{{ $row['DureeMinEns'] }}</td>
            <td>{{ $row['OptionEns'] }}</td>
            <td><a href="#">Modifier</a></td>
        </tr>
    @endforeach
</table>
</div>