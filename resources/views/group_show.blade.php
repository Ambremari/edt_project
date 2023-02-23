@extends('base')

@section('title')
Groupe {{ $group['LibelleGrp'] }}
@endsection

@section('content')
<div class="info">
<span>Effectif Prévu : {{ $group['EffectifPrevGrp'] }}</span>
<span>Effectif Réel : {{ $group['EffectifReelGrp'] }}</span>
</div>
<div class="colleft">
<span style="font-weight: bold;">Elèves</span>
<ul id="studentList">
    @foreach ($students as $row)
    <li>{{ $row['NomEleve'] }} {{ $row['PrenomEleve'] }}</li>
    @endforeach
</ul>
</div>
<div class="colright">
<span style="font-weight: bold;">Divisions associées</span>
<div id="divisionList">
    @foreach ($group_div as $row)
    <span>{{ $row['LibelleDiv'] }}</span>
    @endforeach
</div>
<table>
    <tr>
        <th>Enseignements</th>
        <th>Enseignants</th>
    </tr>
    @foreach($lessons as $row)
    <tr>
        <td>{{ $row['LibelleEns'] }}</td>
        <td>{{ $row['NomProf'] }} {{ $row['PrenomProf'] }}</td>
    </tr>
    @endforeach
</table>
</div>

@endsection