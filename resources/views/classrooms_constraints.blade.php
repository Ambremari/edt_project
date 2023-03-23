@extends('base')

@section('title','Contraintes matérielles des enseignements')

@section('content')

<form method="POST" action="{{ route('constraints.classrooms.update') }}">
    @csrf
    <div class="colleft">
        <div>
            <label for="subject">Enseignement</label>
            <select class="form-control" id="subject" name="subject" onchange="getSubjectVolume()">
                @foreach ($subjects as $row)
                    <option value="{{ $row['LibelleEns'] }}">{{ $row['LibelleEns'] }}</option>
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
                <select class="form-control" id="type" name="type">
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom['LibelleSalle'] }}">{{ $classroom['LibelleSalle'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="colright">
            <div>
                <label for="volume-infrastructure">Volume horaire hebdomadaire pour cette salle</label>
                <input type="text" class="form-control" id="volume-infrastructure" name="volume_infrastructure">
            </div>
        </div>
        <div class="central">
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
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if (session('fail'))
    <div class="alert alert-warning">
        {{ session('fail') }}
    </div>
@endif
@endsection




