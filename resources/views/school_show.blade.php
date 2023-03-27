@extends('base')
@section('title')
Fiche établissement
@endsection
@section('content')
<div class="colleft">
    <div style="display: inline-block">
        <div class="info">
            <span style="font-weight: bold;">Nombre d'élèves inscrits : {{ $nombreEleves }}</span>
        </div>
    </div>
    <div style="display: inline-block">
        <div class="info">
            <span style="font-weight: bold;">Nombre d'enseignants : {{ $nombreEnseignants }}</span>
        </div>
    </div>
    <div class="collright" style="display: inline-block">
        <span style="font-weight: bold;">Nombre d'infrastructures par type :</span>
        <ul id="subjectList">
            @foreach ($nombreInfrastructuresParType as $infrastructure)
            <li class="whiteBackground white-text-center">{{ $infrastructure['TypeSalle'] }} : {{ $infrastructure['count'] }}</li>
            @endforeach
        </ul>
    </div>
    <div class="colleft">
        <span style="font-weight: bold;">Nombre de divisions par niveau :</span>
        <ul id="subjectList">
            @foreach ($nombreDivisionsParNiveau as $division)
            <li class="whiteBackground white-text-center">{{ $division['NiveauDiv'] }} : {{ $division['count'] }}</li>
            @endforeach
        </ul>
    </div>
</div>
<div>
    <span style="font-weight: bold;">Horaires d'ouverture :</span>
    <div class="filter">
        <label for="mySelect">Filtrer par jour</label>
        <select class="form-control" id="mySelect" onchange="filterSchedule()">
            <option value="" selected>Tous</option>
            <option value="LUNDI">LUNDI</option>
            <option value="MARDI">MARDI</option>
            <option value="MERCREDI">MERCREDI</option>
            <option value="JEUDI">JEUDI</option>
            <option value="VENDREDI">VENDREDI</option>
            <option value="SAMEDI">SAMEDI</option>
        </select>
    </div>
    <div class="table">
    <table id="horaireTable">
        <thead>
            <tr class="header">
                <th>Jour</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($horairesOuverture as $horaire)
            <tr class="{{ in_array($horaire['Jour'], ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi']) ? $horaire['Jour'] : ''}}">
                <td>{{$horaire['Jour']}}</td>
                <td>{{$horaire['HeureDebut']}}</td>
                <td>{{ $horaire['HeureFin']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<script>
function filterSchedule() {
    var select = document.getElementById("mySelect");
    var table = document.getElementById("horaireTable");
    var rows = table.getElementsByTagName("tr");
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        if (cells.length > 0) {
            var day = cells[0].innerText;
            if (select.value == "" || day == select.value) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
}
</script>
