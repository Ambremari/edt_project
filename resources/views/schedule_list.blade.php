<div class="filter">
    <label for="jour">Filtrer par Jour</label>
    <select class="form-control" id="mySelect" onchange="filterSchedule()">
        <option value="" selected>Tous</option>
        <option value="Lundi">Lundi</option>
        <option value="Mardi">Mardi</option>
        <option value="Mercredi">Mercredi</option>
        <option value="Jeudi">Jeudi</option>
        <option value="Vendredi">Vendredi</option>
        <option value="Vendredi">Samedi</option>
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
        @foreach($schedules as $row)
            @php
                $jour = $row['Jour'];
            @endphp
            <tr class="{{ in_array($jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']) ? $jour : ''}}">
                <td>{{ $row['Horaire'] }}</td>
                <td>{{ $jour }}</td>
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
        pattern = new RegExp(filter, 'i');
        table = document.getElementById("horaireTable");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (pattern.test(txtValue) || filter == "") {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
