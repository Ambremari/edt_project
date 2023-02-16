@extends('base')

@section('title', 'Saisie d\'un enseignant')

@section('content')
<form method="POST" action="{{route('teacher.add')}}">
    <div>
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" minlength="2" maxlength="15"
            aria-describedby="name_feedback"
            value="{{ old('name') }}" required>
        @error('name')
        <div id="name_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" name="firstname" minlength="2" maxlength="15"
            aria-describedby="firstname_feedback"
            value="{{ old('firstname') }}" required>
        @error('firstname')
        <div id="firstname_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

        <label for="email">Mail</label>
        <input type="text" id="email" name="email" minlength="2" maxlength="40"
            aria-describedby="email_feedback"
            value="{{ old('email') }}" required>
        @error('email')
        <div id="email_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror

        <label for="timeamount">Volume horaire hebdomadaire</label>
        <input type="number" id="timeamount" name="timeamount" min="1" max="50"
            aria-describedby="timeamount_feedback"
            value="{{ old('timeamount') }}" required>
        @error('timeamount')
        <div id="timeamount_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit">Ajouter</button>
</form>
@endsection