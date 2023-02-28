@extends('base')

@section('title', 'Modifier une division')

@section('content')
<div class="colup">
<form method="POST" action="{{route('division.update')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            La division n'a pas pu être modifiée &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <p>Division {{ $division['IdDiv'] }}<p>
        <input type="hidden" value="{{ $division['IdDiv'] }}" name="id">
        <div class="my_input" style="display: inline-block">
            <label for="lib">Libellé</label>
            <input type="text" id="lib" name="lib" minlength="2" maxlength="15"
                aria-describedby="lib_feedback"
                value="{{ $division['LibelleDiv'] }}" required>
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
                value="{{ $division['NiveauDiv'] }}" required>
                <option value="6EME" {{ $division['NiveauDiv'] == "6EME" ? "selected" : "" }}>6ème</option>
                <option value="5EME" {{ $division['NiveauDiv'] == "5EME" ? "selected" : "" }}>5ème</option>
                <option value="4EME" {{ $division['NiveauDiv'] == "4EME" ? "selected" : "" }}>4ème</option>
                <option value="3EME" {{ $division['NiveauDiv'] == "3EME" ? "selected" : "" }}>3ème</option>
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
                value="{{ $division['EffectifPrevDiv'] }}" required>
        </div>
            @error('headcount')
        <div id="headcount_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit">Modifier</button>
</form>
</div>
<div class="coldown">
    @include('division_list')
</div>
@endsection