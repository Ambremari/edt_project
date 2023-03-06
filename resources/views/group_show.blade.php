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
@if ($errors->any())
        <div class="alert alert-warning">
            Le groupe n'a pas pu être modifié &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
<span style="font-weight: bold;">Elèves</span>
<ul id="studentList">
    @foreach ($students as $row)
    <li>
        <span>
            <form method="POST" action="{{route('remove.student.grp')}}">
                @csrf 
                <input type="hidden" value="{{ $row['IdEleve'] }}" name="idStud">
                <input type="hidden" value="{{ $group['IdGrp'] }}" name="idGrp">  
                {{ $row['NomEleve'] }} {{ $row['PrenomEleve'] }}
                <button class="list_button" type="submit">Retirer</button>
            </form>
        </span>
    </li>
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