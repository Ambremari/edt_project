@extends('base')

@section('title')
Enseignement {{ $subject['LibelleEns'] }}
@endsection

@section('content')
<div class="info">
<span>Niveau : {{ $subject['NiveauEns'] }}</span>
</div>
<div class="central">
<table>
    <tr>
        <th>Enseignants</th>
    </tr>
    @foreach($teachers as $row)
    <tr>
        <td><a href="{{route('teacher.show', ['idProf' => $row['IdProf']])}}">{{ $row['NomProf'] }} {{ $row['PrenomProf'] }}</a></td>
    </tr>
    @endforeach
</table>
</div>

@endsection