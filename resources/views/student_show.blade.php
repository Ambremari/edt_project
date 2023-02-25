@extends('base')

@section('title')
Elève {{ $student['PrenomEleve'] }} {{ $student['NomEleve'] }}
@endsection

@section('content')
<div class="colleft">
@include('student_info_list')
</div>
<div class="colright">
    <div class="info">
        <span>Niveau : {{ $student['NiveauEleve'] }}</span>
        <span>Division : {{ $student['LibelleDiv'] }}</span>
    </div>
    <span style="font-weight: bold;">Options</span>
    <div id="divisionList">
            @foreach ($options as $row)
                <span>{{ $row['LibelleEns'] }}</span>
            @endforeach
    </div>
    <span style="font-weight: bold;">Enseignements</span>
    <ul id="subjectList">
        <li>
                {{ $student['LibelleDiv'] }} 
            <div id="divisionList">
                @foreach ($lessons as $row)
                    @if ($row['IdDiv'] == $student['IdDiv'])
                    <span>{{ $row['LibelleEns'] }}</span>
                    @endif
                @endforeach
            </div>
        </li>
        @foreach ($groups as $group)
        <li>
            {{ $group['LibelleGrp'] }} 
        <div id="divisionList">
            @foreach ($lessons as $row)
                @if ($row['IdGrp'] == $group['IdGrp'])
                <span>{{ $row['LibelleEns'] }}</span>
                @endif
            @endforeach
        </div>
        </li>
        @endforeach
    </ul>
</div>

@endsection