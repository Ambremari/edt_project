@extends('base')

@section('title', 'Ajouter une division')

@section('content')
<div class="colup">
<form method="POST" action="{{route('division.add')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            La division n'a pas pu être ajouté &#9785;
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
    </div>
    <button type="submit">Ajouter</button>
</form>
</div>
<div class="coldown">
    @include('division_list')
</div>
@endsection