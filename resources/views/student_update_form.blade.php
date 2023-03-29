@extends('base')

@section('title', 'Modification d\'un élève')

@section('content')
<div class="colleft">
    @include('student_list')
</div>
<div class="colright">
    <form method="POST" action="{{ route('student.update.form', ['IdEleve' => $student['IdEleve']]) }}">
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
                <label for="birthdate">Année de naissance</label>
                <input type="number" id="birthdate" name="birthdate"
                    aria-describedby="birthdate_feedback"
                    value="{{ $student['AnneeNaisEleve'] }}" required>
            </div>
            @error('birthdate')
            <div id="birthdate_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <div class="my_input">
                <label for="level">Niveau</label>
                <input type="text" id="level" name="level"
                    aria-describedby="level_feedback"
                    value="{{ $student['NiveauEleve'] }}" required>
            </div>
            @error('level')
            <div id="level_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <div class="my_input">
                <label for="division">Division</label>
                <select id="division" name="division" aria-describedby="division_feedback">
                    @foreach ($divisions as $row)
                        <option value="{{ $row['IdDiv'] }}" @if($student['IdDiv'] == $row['IdDiv']) selected @endif>{{ $row['LibelleDiv'] }} ({{ $row['NiveauDiv'] }})</option>
                    @endforeach
                </select>
            </div>
            @error('division')
            <div id="division_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            <button type="submit">Modifier</button>
        </div>
    </form>
</div>
@endsection
