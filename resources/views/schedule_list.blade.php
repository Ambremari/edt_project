<div class="filter">
    <label for="jour">Jour</label>
    <select class="form-control" id="mySelect" onchange="filterSchedule()" name="jour" required>
        <option value="" selected>Tous</option>
        <option value="lundi">Lundi</option>
        <option value="mardi">Mardi</option>
        <option value="mercredi">Mercredi</option>
        <option value="jeudi">Jeudi</option>
        <option value="vendredi">Vendredi</option>
        <option value="samedi">Samedi</option>
    </select>
</div>
<div class="myTable">
    <table id="horaireTable">
        <tr class="header">
            <th>Horaire</th>
            <th>Jour</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
            <th></th>
        </tr>
        @foreach($scheduel as $row)
            <tr>
                <td>{{ $row['Horaire'] }}</td>
                <td>{{ $row['Jour'] }}</td>
                <td>{{ $row['HeureDebut'] }}</td>
                <td>{{ $row['HeureFin'] }}</td>
                <td><a href="{{route('schedule.update.form', ['horaire' => $row['Horaire']])}}">Modifier</a></td>
            </tr>
        @endforeach
    </table>
</div>
<script>
function filterSchedule() {
    var select, filter, table, tr, td, i, txtValue;
    select = document.getElementById("mySelect");
    filter = select.value;
    table = document.getElementById("horaireTable");
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
