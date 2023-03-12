@extends('base')

@section('title')
Contraintes matérielles des enseignements
@endsection

@section('content')
<form method="POST" action="{{ route('constraints.classrooms') }}">
    @csrf
    <div class="row mb-3">
        <div class="col-12">
            <label for="subject">Enseignement</label>
            <input type="text" class="form-control" id="subject" placeholder="Rechercher un enseignement" onkeyup="searchSubject()">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <label for="volume">Volume horaire hebdomadaire</label>
            <input type="text" class="form-control" id="volume" name="volume" value="{{ $subject['volume'] }}" disabled>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <button type="button" class="btn btn-primary" onclick="showForm()">Spécifier une salle</button>
        </div>
    </div>
    <div id="form" style="display:none">
        <div class="row mb-3">
            <div class="col-12">
                <label for="type">Type de salle</label>
                <select class="form-control" id="type" name="type">
                    @foreach ($classrooms as $classrom)
                        <option value="{{ $classrom['id'] }}">{{ $classrom['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label for="volume-infrastructure">Volume horaire hebdomadaire pour cette salle</label>
                <input type="text" class="form-control" id="volume-infrastructure" name="volume_infrastructure">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Valider</button>
            </div>
        </div>
    </div>
</form>

@if (count($constraints) > 0)
    <h3>Contraintes pour cet enseignement</h3>
    <ul>
        @foreach ($constraints as $constraint)
            <li>{{ $constraint['TypeSalle'] }} - {{ $constraint['VolHSalle'] }} heures</li>
        @endforeach
    </ul>
@endif

<script>
    function searchSubject() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("subject");
        filter = input.value.toUpperCase();
        ul = document.getElementById("subject-list");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }

    function showForm() {
        document.getElementById("form").style.display = "block";
    }
</script>

@endsection
