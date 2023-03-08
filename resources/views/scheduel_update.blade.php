@extends('base')

@section('title', 'Modifier un horaire')

@section('content')

    <div class="colup">
        @include('schedule_list')
        <form method="POST" action="{{ route('schedule.update', ['horaire' => $horaire->Horaire]) }}">
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
                <p>Horaire {{ $horaire->Horaire }}<p>
                <div class="my_input" style="display: inline-block">
                    <label for="jour">Jour</label>
                    <select class="form-control" id="jour" name="jour" required>
                        <option value="lundi" {{ $horaire->Jour === 'lundi' ? 'selected' : '' }}>Lundi</option>
                        <option value="mardi" {{ $horaire->Jour === 'mardi' ? 'selected' : '' }}>Mardi</option>
                        <option value="mercredi" {{ $horaire->Jour === 'mercredi' ? 'selected' : '' }}>Mercredi</option>
                        <option value="jeudi" {{ $horaire->Jour === 'jeudi' ? 'selected' : '' }}>Jeudi</option>
                        <option value="vendredi" {{ $horaire->Jour === 'vendredi' ? 'selected' : '' }}>Vendredi</option>
                        <option value="samedi" {{ $horaire->Jour === 'samedi' ? 'selected' : '' }}>Samedi</option>
                    </select>
                </div>
                <div class="my_input" style="display: inline-block">
                    <label for="heure_debut">Heure de début</label>
                    <input type="time" id="heure_debut" name="heure_debut" value="{{ $horaire->HeureDebut }}" required>
                </div>
                <div class="my_input" style="display: inline-block">
                    <label for="heure_fin">Heure de fin</label>
                    <input type="time" id="heure_fin" name="heure_fin" value="{{ $horaire->HeureFin }}" required>
                </div>
                <button type="submit">Modifier</button>
            </div>
        </form>
    </div>
@endsection
