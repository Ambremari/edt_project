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
<span>Division : {{ $student['IdDiv'] }}</span>
</div>
<span style="font-weight: bold;">Enseignements</span>

</div>

@endsection