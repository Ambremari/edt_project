@extends('base')
@section('title')
Fiche établissement
@endsection
@section('content')
<div class="colup">
<h5>Horaires d'ouverture</h5>
    <table>
        <thead>
            <th>Jour</th>
            <th>Ouverture</th>
            <th>Fermeture</th>
        </thead>
        @foreach(["LUNDI", "MARDI", "MERCREDI", "JEUDI", "VENDREDI", "SAMEDI"] as $day)
        <tr>
            <td>{{ $day }} </td>
            <td>{{ $college_schedule['StartDay'] }}</td>
            @if(in_array(['Jour' => $day], $college_schedule['Afternoons']))
            <td>{{ $college_schedule['EndDay'] }}</td>
            @else
            <td>{{ $college_schedule['StartBreak'] }}</td>
            @endif
        </tr>
        @endforeach
    </table>
</div>
<div>
<div class="colleft">
    <div class="info">
        <span style="font-weight: bold;">Nombre d'élèves inscrits : {{ $nombreEleves }}</span>
        <span style="font-weight: bold;">Nombre d'enseignants : {{ $nombreEnseignants }}</span>
    </div>
    <h5>Nombre de divisions par niveau </h5>
    <div style="width: 20%; margin-left: auto; margin-right: auto;">
    <ul id="subjectList">
        @foreach ($nombreDivisionsParNiveau as $division)
        <li>{{ $division['NiveauDiv'] }} : {{ $division['count'] }}</li>
        @endforeach
    </ul>
    </div>
</div>
<div class="colright">
    <div style="margin-left: 20%;">
    <h5>Nombre d'infrastructures par type </h5>

    <ul id="subjectList">
        @foreach ($nombreInfrastructuresParType as $infrastructure)
        <li>{{ $infrastructure['TypeSalle'] }} : {{ $infrastructure['count'] }}</li>
        @endforeach
    </ul>
    </div>
</div>
</div>
@endsection

