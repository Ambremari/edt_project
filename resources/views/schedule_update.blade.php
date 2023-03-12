@extends('base')

@section('title', 'Modifier un horaire')

@section('content')
<div class="colup">
    <form method="POST" action="{{ route('schedule.update') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
                L'horaire n'a pas pu être modifié &#9785;
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div>
            <p>Horaire {{ $schedule['Horaire'] }}</p>
            <input type="hidden" value="{{ $schedule['Horaire'] }}" name="horaire">
            <div class="my_input" style="display: inline-block">
                <label for="heure_debut">Heure de début</label>
                <input type="time" id="heure_debut" name="heure_debut" value="{{ $schedule['HeureDebut'] }}" required>
            </div>
            <div class="my_input" style="display: inline-block">
                <label for="heure_fin">Heure de fin</label>
                <input type="time" id="heure_fin" name="heure_fin" value="{{ $schedule['HeureFin'] }}" required>
            </div>
            @csrf
            <button type="submit">Modifier</button>
        </div>
    </form>
</div>
<div class="coldown">
    @include('schedule_list')
</div>
@endsection
