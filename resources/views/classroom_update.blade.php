@extends('base')

@section('title', 'Modifier une salle')

@section('content')
<div class="colup">
<form method="POST" action="{{route('classroom.update')}}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
            La salle n'a pas pu être modifiée &#9785;
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div>
        <p>Salle {{ $classroom['IdSalle'] }}<p>
        <input type="hidden" value="{{ $classroom['IdSalle'] }}" name="id">
            <div class="my_input" style="display: inline-block">
            <label for="lib">Libellé</label>
            <input type="text" id="lib" name="lib" minlength="2" maxlength="15"
                aria-describedby="lib_feedback"
                value="{{ $classroom['LibelleSalle'] }}" required>
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
                value="{{ $classroom['TypeSalle'] }}" required>
                @foreach($types as $type)
                @if($type['TypeSalle'] == $classroom['TypeSalle'])
                <option value="{{ $type['TypeSalle'] }}" selected>{{ $type['TypeSalle'] }}</option>
                @else
                <option value="{{ $type['TypeSalle'] }}">{{ $type['TypeSalle'] }}</option>
                @endif
                @endforeach
            </select>
            </div>
        @error('grade')
        <div id="grade_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
            <div class="my_input" style="display: inline-block">
        <label for="capacity">Capacité</label>
            <input type="number" id="capacity" name="capacity" min="1" max="100"
                aria-describedby="capacity_feedback"
                style="width:45px"
                value="{{ $classroom['CapSalle'] }}" required>
            </div>
            @error('capacity')
        <div id="capacity_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
            <button type="submit">Modifier</button>
    </form>
</div>
<div class="coldown">
    @include('classroom_list')
</div>
@endsection
