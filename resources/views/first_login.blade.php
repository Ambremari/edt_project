@extends('base')

@section('title', 'Première connexion')

@section('content')
<div class="colleft">
    <button class="tablink" onclick="openPage('Student', this)">Elèves</button>
    <button class="tablink" onclick="openPage('Prof', this)">Enseignants</button>
    <button class="tablink" href="#">Parents</button>
</div>
<div class="colright">
    <div id="Prof" class="tabcontent">
        <form method="POST" action="{{route('first.teacher')}}">
        @csrf
        @if ($errors->any())
        <div class="alert alert-warning">
            La connexion a échouée;
        </div>  
            @endif
            <div class="my_input">
                <p><label for="id" >Identifiant</label></p>
                <input type="text" id="id" name="id" minlength="2" maxlength="10"
                    aria-describedby="id_feedback"
                    style="width:200px"
                    value="{{ old('id') }}" required>
            </div>
            @error('id')
            <div id="id_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <div class="my_input">
                <p><label for="email">Adresse mail</label></p>
                <input type="email" id="email" name="email" minlength="2"
                    aria-describedby="email_feedback"
                    style="width:200px"
                    value="{{ old('email') }}" required>
            </div>
            @error('password')
            <div id="password_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <div class="my_input">
                <p><label for="password">Mot de passe</label></p>
                <input type="password" id="password" name="password" minlength="2"
                    aria-describedby="password_feedback"
                    style="width:200px"
                    value="{{ old('password') }}" required>
            </div>
            @error('password')
            <div id="password_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <button type="submit">Connexion</button>
        </form>
    </div>
    <div id="Student" class="tabcontent">
        <form method="POST" action="{{route('first.student')}}">
        @csrf
        @if ($errors->any())
        <div class="alert alert-warning">
            La connexion a échouée;
        </div>  
            @endif
            <div class="my_input">
                <p><label for="id" >Identifiant</label></p>
                <input type="text" id="id" name="id" minlength="2" maxlength="10"
                    aria-describedby="id_feedback"
                    style="width:200px"
                    value="{{ old('id') }}" required>
            </div>
            @error('id')
            <div id="id_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <div class="my_input">
                <p><label for="password">Mot de passe</label></p>
                <input type="password" id="password" name="password" minlength="2"
                    aria-describedby="password_feedback"
                    style="width:200px"
                    value="{{ old('password') }}" required>
            </div>
            @error('password')
            <div id="password_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <button type="submit">Connexion</button>
        </form>
    </div>
</div>
@endsection