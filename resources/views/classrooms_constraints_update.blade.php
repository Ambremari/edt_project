@extends('base')

@section('title', 'Modifier Contraintes matérielles des enseignements')

@section('content')
<div class="colup">
    <form method="POST" action="{{ route('constraints.classrooms.update',['IdContSalle'=> $constraint['IdContSalle']]) }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
                La contrainte n'a pas pu être modifiée &#9785;
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="my_input">
            <label for="subject">Enseignement</label>
            <input type="text" class="form-control" id="subject" name="subject" value="{{ $constraint->subject_id }}" readonly>
        </div>
        <div class="my_input">
            <label for="volume">Volume horaire hebdomadaire</label>
            <input type="text" class="form-control" id="volume" name="volume" value="{{ $constraint->weekly_volume }}">
            @error('volume')
            <div id="volume_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Valider</button>
    </form>
</div>
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
