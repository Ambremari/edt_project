@extends('base')

@section('title')
Enseignant {{ $teacher['PrenomProf'] }} {{ $teacher['NomProf'] }}
@endsection

@section('content')
<div class="colleft">
@include('teacher_info_list')
</div>
<div class="colright">
<div class="info">
Volume horaire hebdomadaire
<span>Cible : {{ $teacher['VolHProf'] }}</span>
<span>Réel : {{ $teacher['VolHReelProf'] }}</span>
</div>
<span style="font-weight: bold;">Enseignements</span>
<ul id="subjectList">
@foreach ($subjects as $subject)
    <li>
        {{ $subject['LibelleEns'] }} {{ $subject['NiveauEns'] }}
    <div id="divisionList">
        @foreach ($lessons as $row)
            @if ($row['IdEns'] == $subject['IdEns'])
            <span>{{ $row['LibelleDiv'] }} {{ $row['LibelleGrp'] }}</span>
            @endif
        @endforeach
    </div>
    </li>
@endforeach
</ul>
</div>

@endsection