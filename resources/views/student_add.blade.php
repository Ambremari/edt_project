@extends('base')

@section('title', 'Saisie d\'un élève')

@section('content')
    <div class="central">
        <form method="POST" action="{{ route('student.add') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-warning">
                    L'élève n'a pas pu être ajouté &#9785;
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div>
                <div class="my_input" style="display: inline-block">
                    <label for="name">Nom</label>
                    <input type="text" id="name" name="name" minlength="2" maxlength="15"
                        aria-describedby="name_feedback"
                        value="{{ old('name') }}" required>
                </div>
                @error('name')
                <div id="name_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <div class="my_input" style="display: inline-block">
                    <label for="firstname">Prénom</label>
                    <input type="text" id="firstname" name="firstname" minlength="2" maxlength="15"
                        aria-describedby="firstname_feedback"
                        value="{{ old('firstname') }}" required>
                </div>
                @error('firstname')
                <div id="firstname_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <div class="my_input">
                    <label for="birthdate">Année de naissance</label>
                    <input type="number" id="birthdate" name="birthdate" aria-describedby="birthdate_feedback"
                    min="2000" max="2100" value="{{ old('birthdate') }}" required>
                </div>
                @error('birthdate')
                <div id="birthdate_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <div class="my_input">
                    <label for="level">Niveau</label>
                    <input type="text" id="level" name="level" aria-describedby="level_feedback"
                     value="{{ old('level') }}" required>
                </div>
                @error('level')
                <div id="level_feedback" class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </div>
@endsection
