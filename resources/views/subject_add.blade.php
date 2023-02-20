@extends('base')

@section('title', 'Ajouter un enseignement')

@section('content')
<div class="colup">
<form method="POST" action="{{route('subject.add')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            L'enseignement n'a pas pu être ajouté &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <div class="my_input" style="display: inline-block">
            <label for="lib">Libellé</label>
            <input type="text" id="lib" name="lib" minlength="2" maxlength="15"
                aria-describedby="lib_feedback"
                value="{{ old('lib') }}" required>
        </div>
        @error('lib')
        <div id="lib_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="grade">Niveau</label>
            <select class="form-control" id="grade" name="grade" minlength="2" maxlength="15"
                aria-describedby="grade_feedback"
                value="{{ old('grade') }}" required>
                <option value="6EME">6ème</option>
                <option value="5EME">5ème</option>
                <option value="4EME">4ème</option>
                <option value="3EME">3ème</option>
            </select>
        </div>
        @error('grade')
        <div id="grade_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="timeamount">Volume horaire hebdomadaire</label>
            <input type="number" id="timeamount" name="timeamount" min="0.5" max="10"
                step=".5"
                aria-describedby="timeamount_feedback"
                style="width:45px"
                value="{{ old('timeamount') }}" required>
        </div>
            @error('timeamount')
        <div id="timeamount_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="mintime">Durée minimale</label>
            <input type="number" id="mintime" name="mintime" min="1" max="4"
                aria-describedby="mintime_feedback"
                style="width:30px"
                value="{{ old('mintime') }}" required>
        </div>
        @error('mintime')
        <div id="mintime_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label class="form-check-label" for="option">Optionnel</label>
            <input class="form-check-input" type="checkbox" value="option" id="option" name="option">
        </div>
        @error('option')
        <div id="option_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit">Ajouter</button>
</form>
</div>
<div class="coldown">
    @include('subject_list')
</div>
@endsection