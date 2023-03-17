@extends('base')

@section('title', 'Ajouter un nouvel horaire')

@section('content')

<div class="colup">
    <form method="POST" action="{{ route('schedule.add') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
                L'horaire n'a pas pu être ajouté &#9785;
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="my_input" style="display: inline-block">
            <label for="horaire">Horaire</label>
            <input type="text" name="horaire" id="horaire" class="form-control" required>
            @error('horaire')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="my_input" style="display: inline-block">
            <label for="jour">Jour</label>
            <select name="jour" id="jour" class="form-control" required>
                <option value="">-- Sélectionnez un jour --</option>
                <option value="Lundi">Lundi</option>
                <option value="Mardi">Mardi</option>
                <option value="Mercredi">Mercredi</option>
                <option value="Jeudi">Jeudi</option>
                <option value="Vendredi">Vendredi</option>
                <option value="Samedi">Samedi</option>
            </select>
            @error('jour')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="my_input" style="display: inline-block">
            <label for="heure_debut">Heure de début</label>
            <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
            @error('heure_debut')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="my_input" style="display: inline-block">
            <label for="heure_fin">Heure de fin</label>
            <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
            @error('heure_fin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </form>
    <button type="submit">Ajouter</button>
</div>
<div class="coldown">
    @include('schedule_list')
</div>
@endsection
