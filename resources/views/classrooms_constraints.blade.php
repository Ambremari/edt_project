@extends('base')

@section('title','Contraintes matérielles des enseignements')

@section('content')

<form method="POST" action="{{ route('constraints.classrooms') }}">
    @csrf
    <div style="display: inline-block">
        <div>
            <label for="subject">Enseignement</label>
            <input type="text" class="form-control" id="subject" placeholder="Rechercher un enseignement" onkeyup="searchSubject()">
        </div>
    </div>
    <div style="display: inline-block">
        <div>
            <label for="volume">Volume horaire hebdomadaire</label>
            <input type="text" class="form-control" id="volume" name="volume" value="" disabled>
        </div>
    </div>
    <div style="display: inline-block">
        <div class="col-12">
            <div>
                @csrf
            <button type="button" class="btn btn-primary" onclick="showForm()">Spécifier une salle</button>
            </div>
        </div>
    </div>
    <div id="form" style="display:none">
        <div>
            <div>
                <label for="type">Type de salle</label>
                <select class="form-control" id="type" name="type">
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom['TypeSalle'] }}">{{ $classroom['TypeSalle'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div style="display: inline-block">
            <div>
                <label for="volume-infrastructure">Volume horaire hebdomadaire pour cette salle</label>
                <input type="text" class="form-control" id="volume-infrastructure" name="volume_infrastructure">
            </div>
        </div>
        <div>
            <div>
                @csrf
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
