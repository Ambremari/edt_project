@extends('base')

@section('title')
Division {{ $division['LibelleDiv'] }}
@endsection

@section('content')
<div class="info">
<span>Effectif Prévu : {{ $division['EffectifPrevDiv'] }}</span>
<span>Effectif Réel : {{ $division['EffectifReelDiv'] }}</span>
</div>
<div class="colleft">
<span style="font-weight: bold;">Elèves</span>
<ul id="studentList">
    @foreach ($students as $row)
    <li>
        <span>{{ $row['NomEleve'] }} {{ $row['PrenomEleve'] }}</span>
    </li>
    @endforeach
</ul>
</div>
<div class="colright">
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