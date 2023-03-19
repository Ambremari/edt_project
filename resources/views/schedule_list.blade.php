<div class="filter">
    <label for="mySelect">Filtrer par jour</label>
    <select class="form-control" id="mySelect" onchange="filterSchedule()">
        <option value="" selected>Tous</option>
        <option value="Lundi">Lundi</option>
        <option value="Mardi">Mardi</option>
        <option value="Mercredi">Mercredi</option>
        <option value="Jeudi">Jeudi</option>
        <option value="Vendredi">Vendredi</option>
    </select>
</div>
<div class="myTable">
    <table id="horaireTable">
        <thead>
            <tr class="header">
                <th>Horaire</th>
                <th>Jour</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $row)
            <tr class="{{ in_array($row['Jour'], ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi']) ? $row['Jour'] : ''}}">
                <td>{{ $row['Horaire'] }}</td>
                <td>{{ $row['Jour']}}</td>
                <td>{{ $row['HeureDebut'] }}</td>
                <td>{{ $row['HeureFin'] }}</td>
                <td><a href="{{route('schedule.update.form', ['horaire' => $row['Horaire']])}}">Modifier</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
function filterSchedule() {
    var select, filter, table, tr, td, i, txtValue;
    select = document.getElementById("mySelect");
    filter = select.value.toUpperCase();
    table = document.getElementById("horaireTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1 || filter == "") {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
</script>
