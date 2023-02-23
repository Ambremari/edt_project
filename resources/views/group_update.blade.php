@extends('base')

@section('title', 'Modifier un groupe')

@section('content')
<div class="colup">
<form method="POST" action="{{route('group.update')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Le groupe n'a pas pu être modifié &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <p>Groupe {{ $group['IdGrp'] }}<p>
        <input type="hidden" value="{{ $group['IdGrp'] }}" name="id">
        <div class="my_input" style="display: inline-block">
            <label for="lib">Libellé</label>
            <input type="text" id="lib" name="lib" minlength="2" maxlength="15"
                aria-describedby="lib_feedback"
                value="{{ $group['LibelleGrp'] }}" required>
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
                value="{{ $group['NiveauGrp'] }}" required>
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
                value="{{ $group['EffectifPrevGrp'] }}" required>
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
    @include('group_list')
</div>
@endsection