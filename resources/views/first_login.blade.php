@extends('base')

@section('title', 'Première connexion')

@section('content')
<div class="colleft">
    <button class="tablink" href="#">Elèves</button>
    <button class="tablink" onclick="openPage('Prof', this)">Enseignants</button>
    <button class="tablink" href="#">Parents</button>
</div>
<div class="colright">
    <div id="Prof" class="tabcontent">
        <form method="POST" action="{{route('first.teacher')}}">
        @csrf
        @include('first_login_form')
        </form>
    </div>
</div>
@endsection