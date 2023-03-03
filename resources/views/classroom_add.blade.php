@extends('base')

@section('title', 'Ajouter une salle')

@section('content')
<div class="colup">
<form method="POST" action="{{route('classroom.add')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            La salle n'a pas pu être ajoutée &#9785;
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
            <input type="text" id="lib" name="lib" minlength="2" maxlength="40"
                aria-describedby="lib_feedback"
                value="{{ old('lib') }}" required>
        </div>
        @error('lib')
        <div id="lib_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="type">Type de salle</label>
            <select class="form-control" id="type" name="type" minlength="2" maxlength="15"
                aria-describedby="type_feedback"
                value="{{ old('type') }}" required>
                @foreach($types as $type)
                <option value="{{ $type['TypeSalle'] }}" {{ old('type') == $type['TypeSalle'] ? "selected" : "" }}>{{ $type['TypeSalle'] }}</option>
                @endforeach
            </select>
        </div>
        @error('type')
        <div id="type_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="capacity">Capacité</label>
            <input type="number" id="capacity" name="capacity" min="1" max="100"
                aria-describedby="capacity_feedback"
                style="width:45px"
                value="{{ old('capacity') }}" required>
        </div>
            @error('capacity')
        <div id="capacity_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit">Ajouter</button>
</form>
</div>
<div class="coldown">
    @include('classroom_list')
</div>
@endsection