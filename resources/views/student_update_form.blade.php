@extends('base')

@section('title', 'Modification d\'un élève')

@section('content')
<div class="colleft">
    @include('student_list')
</div>
<input type="text" id="studentInput" onkeyup="searchStudent()" placeholder="Rechercher un élève...">
<ul id="studentList">
    @foreach ($students as $row)
        <li><a href="{{route('student.update.form', ['id' => $row['IdEleve']])}}">{{ $row['NomEleve'] }} {{ $row['PrenomEleve'] }}</a></li>
    @endforeach
</ul>
<div class="colright">
    <form method="POST" action="{{ route('student.update', ['id' => $student['IdEleve']]) }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
                Les modifications n'ont pas été prises en compte &#9785;
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div>
            <p>Élève {{ $student['IdEleve'] }}<p>
            <input type="hidden" value="{{ $student['IdEleve'] }}" name="id">
            <div class="my_input" style="display: inline-block">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" minlength="2" maxlength="15"
                    aria-describedby="name_feedback"
                    value="{{ $student['NomEleve'] }}" required>
            </div>
            @error('name')
            <div id="name_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <div class="my_input" style="display: inline-block">
                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" name="firstname" minlength="2" maxlength="15"
                    aria-describedby="firstname_feedback"
                    value="{{ $student['PrenomEleve'] }}" required>
            </div>
            @error('firstname')
            <div id="firstname_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <div class="my_input">
                <label for="birthdate">Date de naissance</label>
                <input type="date" id="birthdate" name="birthdate"
                    aria-describedby="birthdate_feedback"
                    value="{{ $student['AnneeNaisEleve'] }}" required>
            </div>
            @error('birthdate')
            <div id="birthdate_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <button type="submit">Modifier</button>
        </div>
    </form>
</div>
@endsection
