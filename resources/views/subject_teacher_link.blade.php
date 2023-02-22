@extends('base')

@section('title', 'Affecter des enseignements à un enseignant')

@section('content')
<div class="colleft">
@include('teacher_link_list')
</div>
<div class="colright">
<form method="POST" action="{{route('link.subject')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            L'affectation n'a pas été prise en compte &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <p>Enseignant {{ $teacher['PrenomProf'] }} {{ $teacher['NomProf'] }}<p>
        <input type="hidden" value="{{ $teacher['IdProf'] }}" name="id">
        <div class="my_input" style="display: inline-block">
            <label for="subject">Nouvel Enseignement</label>
            <select class="form-control" id="subject" name="subject" minlength="2" maxlength="15"
                aria-describedby="subject_feedback"
                value="{{ old('subject') }}" required>
                @foreach($subjects as $row)
                <option value="{{ $row['IdEns'] }}">{{ $row['LibelleEns'] }} {{ $row['NiveauEns'] }}</option>
                @endforeach
            </select>
        </div>
        @error('subject')
        <div id="subject_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit">Affecter</button>
</form>
<div class="myList">
<ul>
@foreach($teacher_subjects as $row)
<form method="POST" action="{{ route('link.subject.remove') }}">
    @csrf
        <input type="hidden" value="{{ $teacher['IdProf'] }}" name="id">
        <input type="hidden" value="{{ $row['IdEns'] }}" name="subject">
    <li>
    {{ $row['LibelleEns'] }} {{ $row['NiveauEns'] }}
    <button type="submit" class="suppr">Supprimer l'affectation</button>
    </li>
</form>
<form method="POST" action="{{ route('link.division', ['idProf' => $teacher['IdProf']]) }}">
    @csrf
    <div>
        <input type="hidden" value="{{ $teacher['IdProf'] }}" name="id">
        <input type="hidden" value="{{ $row['IdEns'] }}" name="subject">
        @foreach($classes as $class)
        @if($class['NiveauClasse'] == $row['NiveauEns'])
        <div class="my_input" style="display: inline-block">
        @if(in_array(['IdProf' => $teacher['IdProf'], 'IdEns' => $row['IdEns'], 'IdDiv' => $class['IdClasse']], $teacher_lessons))
        <input class="form-check-input" type="checkbox" name="classes[]" value="{{ $class['IdClasse'] }}" id="option" checked>
        @else
            <input class="form-check-input" type="checkbox" name="classes[]" value="{{ $class['IdClasse'] }}" id="option">
        @endif
            <label class="form-check-label" for="option">
            {{ $class['LibelleClasse'] }}
            </label>
        </div>
        @endif
        @error('subject')
        <div id="option_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        @endforeach
    </div>
    <button type="submit">Affecter les divisions</button>
</form>
@endforeach
</ul>
</div>
</div>
@endsection