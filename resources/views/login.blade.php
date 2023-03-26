@extends('base')

@section('title', 'Se connecter')

@section('content')
<div class="colleft">
    <button class="tablink" onclick="openPage('Dir', this)">Chefs d'établissement</button>
    <button class="tablink" onclick="openPage('Student', this)">Elèves</button>
    <button class="tablink" onclick="openPage('Prof', this)">Enseignants</button>
    <button class="tablink" href="#">Parents</button>
    <button class="tablink" href="#">Vie scolaire</button>
</div>
<div class="colright">
    <div id="Dir" class="tabcontent">
        <form method="POST" action="{{route('login.dir')}}">
        @csrf
        @include('login_form')
        </form>
    </div>
    <div id="Prof" class="tabcontent">
        <form method="POST" action="{{route('login.teacher')}}">
        @csrf
        @include('login_form')
        </form>
        <a href="/firstlogin">Première connexion</a>
    </div>
    <div id="Student" class="tabcontent">
        <form method="POST" action="{{route('login.student')}}">
        @csrf
        @include('login_form')
        </form>
        <a href="/firstlogin">Première connexion</a>
    </div>
</div>
@endsection