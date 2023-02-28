@extends('base')

@section('title')
Scolarité de l'élève {{ $student['PrenomEleve']}} {{ $student['NomEleve']}}
@endsection

@section('content')
<div class="colleft">
@include('student_opt_list')
</div>
<div class="colright">
<div class="info">
<span>Niveau {{ $student['NiveauEleve'] }}</span>
<span>Division {{ $student['LibelleDiv'] }}</span>
</div>
<div class="myList">
<ul>

<form method="POST" action="{{ route('student.option.add', ['idEleve' => $student['IdEleve']]) }}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Les options n'ont pas été modifiées &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <input type="hidden" value="{{ $student['IdEleve'] }}" name="id">
        @foreach($subjects as $row)
            @if($student['NiveauEleve'] == $row['NiveauEns'])
                <div class="my_input" style="display: block">
                @if(in_array(['IdEleve' => $student['IdEleve'], 'IdEns' => $row['IdEns']], $student_options))
                    <input class="form-check-input" type="checkbox" name="options[]" value="{{ $row['IdEns'] }}" id="option" checked>
                @else
                    <input class="form-check-input" type="checkbox" name="options[]" value="{{ $row['IdEns'] }}" id="option">
                @endif
                <label class="form-check-label" for="option">
                {{ $row['LibelleEns'] }}
                </label>
                </div>
            @endif
        @endforeach
    </div>
    <button type="submit">Ajouter les options</button>
</form>
</ul>
</div>
</div>
@endsection