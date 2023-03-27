@extends('base')

@section('title','Contraintes matérielles des enseignements')

@section('content')
<div class="colup">
    <div class="colup">
        <form method="POST" action="{{ route('constraints.classrooms.add') }}">
            @csrf
            @method('POST')
    @if ($errors->any())
        <div class="alert alert-warning">
            La contrainte n'a pas pu être ajoutée &#9785;
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <input type="hidden" id="course_id" name="course_id" value="">
    <div class="colleft">
        <div>
            <label for="subject">Enseignement</label>
            <select class="form-control" id="subject" name="subject" onchange="getSubjectVolume()">
                <option value="" selected>Tous</option>
                @foreach ($subjects as $row)
                    <option value="{{ $row['LibelleEns'] }}">{{ $row['LibelleEns'] }}  ({{$row['NiveauEns']}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="colright">
        <div>
            <label for="volume">Volume horaire hebdomadaire</label>
            <input type="text" class="form-control" id="volume" name="volume" value="" disabled>
        </div>
    </div>
    <div class="central">
        <div class="col-12">
            <div>
                @csrf
                <button type="button" class="btn btn-primary" onclick="showForm()">Spécifier une salle</button>
            </div>
        </div>
    </div>
    <div id="form" style="display:none">
        <div class="colleft">
            <div>
                <label for="type">Salle</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="" selected disabled hidden>Choisir une salle</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom['LibelleSalle'] }}">{{ $classroom['LibelleSalle'] }} ({{ $classroom['TypeSalle'] }})</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="colright">
            <div>
                <label for="volume-infrastructure">Volume horaire hebdomadaire pour cette salle</label>
                <input type="text" class="form-control" id="volume-infrastructure" name="volume_infrastructure" required>
            </div>
        </div>
        <div class="central">
            <div>
                @csrf
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
</div>
</form>
<div class="coldown">
    <div class="filter">
    <label for="grade">Filtrer par type de salle</label>
    <select class="form-control" id="mySelect" onchange="filterClassrooms()">
        <option value="" selected>Tous</option>
        <option value="Cours">Cours</option>
        <option value="TP">TP</option>
        <option value="Arts Plastiques">Arts Plastiques</option>
        <option value="Musique">Musique</option>
        <option value="Sport">Sport</option>
    </select>
    <label for="grade">Filtrer par volume horaire</label>
    <select class="form-control" id="selectLib" onchange="filterScheduels()">
        <option value="" selected>Tous</option>
        <option value="0.5">0.5</option>
        <option value="1.0">1.0</option>
        <option value="1.5">1.5</option>
        <option value="2.0">2.0</option>
        <option value="2.5">2.5</option>
        <option value="3.0">3.0</option>
        <option value="3.5">3.5</option>
        <option value="4.0">4.0</option>
        <option value="4.5">4.5</option>
    </select>
    </div>
@if (count($constraints) > 0)
<div>
    <label>Contraintes : </label>
    <table class="table">
        <thead>
            <tr>
                <th>Identifiant contrainte</th>
                <th>Type de salle</th>
                <th>Identifiant cours</th>
                <th>Volume horaire</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($constraints as $constraint)
                <tr>
                    <td>{{ $constraint['IdContSalle'] }}</td>
                    <td>{{ $constraint['TypeSalle'] }}</td>
                    <td>{{ $constraint['IdCours'] }}</td>
                    <td>{{ $constraint['VolHSalle'] }} heures</td>
                    <td><a href="{{ route('constraints.classrooms.update.form', ['IdContSalle' => $constraint['IdContSalle']]) }}">Modifier</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
<script>
function filterClassrooms() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("mySelect");
    filter = input.value.toUpperCase();
    table = document.getElementsByTagName("table")[0];
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[1];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

function filterScheduels() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("selectLib");
    filter = input.value.toUpperCase();
    table = document.getElementsByTagName("table")[0];
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

    function getSubjectVolume() {
        var subject = document.getElementById("subject").value;
        var volumeInput = document.getElementById("volume");
        var subjects = @json($subjects);
        for (var i = 0; i < subjects.length; i++) {
            if (subjects[i].LibelleEns === subject) {
                volumeInput.value = subjects[i].VolHEns;
                break;
            }
        }
    }
    function showForm() {
    document.getElementById("form").style.display = "block";
}

</script>
@endsection




