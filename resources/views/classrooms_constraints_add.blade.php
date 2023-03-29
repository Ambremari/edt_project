@extends('base')

@section('title','Contraintes matérielles des enseignements')

@section('content')
<div class="colup">
    <form method="POST" action="{{ route('constraints.classrooms.add') }}">
        @csrf
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
    <div>
        <div class="my_input" style="display: inline-block">
            <label for="subject">Enseignement</label>
            <select class="form-control" id="subject" name="subject" onchange="getSubjectVolume()">
                <option value="" selected>Tous</option>
                @foreach ($subjects as $row)
                    <option value="{{ $row['IdEns'] }}">{{ $row['LibelleEns'] }}  ({{$row['NiveauEns']}})</option>
                @endforeach
            </select>
        </div>
    
        <div class="my_input" style="display: inline-block">
            <label for="volume">Volume horaire hebdomadaire</label>
            <input type="text" class="form-control" id="volume" name="volume" value="" style="width:45px" disabled>
        </div>
    </div>
        <button type="button" onclick="showForm()">Spécifier une salle</button>
    <div id="form" style="display:none">
        <div>
            <div class="my_input" style="display: inline-block">
                <label for="type">Salle</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="" selected disabled hidden>Choisir un type de salle</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom['TypeSalle'] }}">{{ $classroom['TypeSalle'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="my_input" style="display: inline-block">
                <label for="volume-infrastructure">Volume horaire hebdomadaire </label>
                <input type="number" style="width:45px"  step=".5" class="form-control" id="volume-infrastructure" name="timeamount" required>
            </div>
            <div class="my_input" style="display: inline-block">
                <label for="mintime">Durée minimale d'un cours</label>
                <input type="number" style="width:45px" class="form-control" id="mintime" name="mintime" required>
            </div>    
            <div class="my_input" style="display: inline-block">
                <label for="group">Classe entière</label>
            <input type="radio" value="0" class="form-control" name="group" checked>
            </div>  
            <div class="my_input" style="display: inline-block">
                <label for="group">Groupes</label>
            <input type="radio" value="1" class="form-control" name="group">
            </div>        
        </div>
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
        @foreach($classrooms as $type)
        <option value="{{ $type['TypeSalle'] }}">{{ $type['TypeSalle'] }}</option>
       @endforeach
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
<div>
    <table class="table">
        <thead>
            <tr>
                <th>Enseignement</th>
                <th>Niveau</th>
                <th>Type de salle</th>
                <th>Pour</th>
                <th>Volume horaire</th>
                <th>Durée minimale</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($constraints_div as $constraint)
                <tr>
                <form method="POST" action="{{ route('constraints.classrooms.delete') }}">
                    @csrf
                    <input type="hidden" value="{{ $constraint['IdEns'] }}" name="subject">
                    <td>{{ $constraint['LibelleEns'] }}</td>
                    <td>{{ $constraint['NiveauEns'] }}</td>
                    <input type="hidden" value="{{ $constraint['TypeSalle'] }}" name="type">
                    <td>{{ $constraint['TypeSalle'] }}</td>
                    <input type="hidden" value="0" name="group">
                    <td>Classe entière</td>
                    <input type="hidden" value="{{ $constraint['VolHSalle'] }}" name="timeamount">
                    <td>{{ $constraint['VolHSalle'] }} heures</td>
                    <input type="hidden" value="{{ $constraint['DureeMinSalle'] }}" name="mintime">
                    <td>{{ $constraint['DureeMinSalle'] }}</td>
                    <td><button type="submit" style="margin: 0">Supprimer</button></td>
                </form>
                </tr>
            @endforeach
            @foreach ($constraints_grp as $constraint)
                <tr>
                <form method="POST" action="{{ route('constraints.classrooms.delete') }}">
                    @csrf
                    <input type="hidden" value="{{ $constraint['IdEns'] }}" name="subject">
                    <td>{{ $constraint['LibelleEns'] }}</td>
                    <td>{{ $constraint['NiveauEns'] }}</td>
                    <input type="hidden" value="{{ $constraint['TypeSalle'] }}" name="type">
                    <td>{{ $constraint['TypeSalle'] }}</td>
                    <input type="hidden" value="1" name="group">
                    <td>Groupe</td>
                    <input type="hidden" value="{{ $constraint['VolHSalle'] }}" name="timeamount">
                    <td>{{ $constraint['VolHSalle'] }} heures</td>
                    <input type="hidden" value="{{ $constraint['DureeMinSalle'] }}" name="mintime">
                    <td>{{ $constraint['DureeMinSalle'] }}</td>
                    <td><button type="submit" style="margin: 0">Supprimer</button></td>
                </form>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
function filterClassrooms() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("mySelect");
    filter = input.value.toUpperCase();
    table = document.getElementsByTagName("table")[0];
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
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
        td = tr[i].getElementsByTagName("td")[4];
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
            if (subjects[i].IdEns === subject) {
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




