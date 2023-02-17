@extends('base')

@section('title', 'Se connecter')

@section('content')
<div class="colleft">
    <button class="tablink" onclick="openPage('Dir', this)">Chefs d'établissement</button>
    <button class="tablink" href="#">Elèves</button>
    <button class="tablink" href="#">Enseignants</button>
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
</div>
@endsection