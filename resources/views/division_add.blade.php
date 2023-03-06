@extends('base')

@section('title', 'Ajouter une division')

@section('content')
<div class="colup">
<form method="POST" action="{{route('division.add')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            La division n'a pas pu être ajoutée &#9785;
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
                <option value=""></option>
                <option value="6EME" {{ old('grade') == "6EME" ? "selected" : "" }}>6ème</option>
                <option value="5EME" {{ old('grade') == "5EME" ? "selected" : "" }}>5ème</option>
                <option value="4EME" {{ old('grade') == "4EME" ? "selected" : "" }}>4ème</option>
                <option value="3EME" {{ old('grade') == "3EME" ? "selected" : "" }}>3ème</option>
            </select>
        </div>
        @error('grade')
        <div id="grade_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="headcount">Effectif prévu</label>
            <input type="number" id="headcount" name="headcount" min="1" max="35"
                aria-describedby="headcount_feedback"
                style="width:45px"
                value="{{ old('headcount') }}" required>
        </div>
            @error('headcount')
        <div id="headcount_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label class="form-check-label" for="group">Créer 2 groupes</label>
            <input class="form-check-input" type="checkbox" value="group" id="group" name="group">
        </div>
        @error('group')
        <div id="group_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit">Ajouter</button>
</form>
</div>
<div class="coldown">
    @include('division_list')
</div>
@endsection