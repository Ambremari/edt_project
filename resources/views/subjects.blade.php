@extends('base')

@section('title', 'Enseignements')

@section('content')
<div class="colup">
<a href="{{route('subjects.form')}}">Ajouter un enseignement</a>
</div>
<div class="coldown">
    @include('subject_list')
</div>
@endsection