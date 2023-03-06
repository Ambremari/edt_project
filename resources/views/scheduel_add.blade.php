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
        <div class="form-group">
            <label for="horaire">Horaire</label>
            <input type="text" name="horaire" id="horaire" class="form-control" required>
            @error('horaire')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="jour">Jour</label>
            <select name="jour" id="jour" class="form-control" required>
                <option value="">-- Sélectionnez un jour --</option>
                <option value="lundi">Lundi</option>
                <option value="mardi">Mardi</option>
                <option value="mercredi">Mercredi</option>
                <option value="jeudi">Jeudi</option>
                <option value="vendredi">Vendredi</option>
                <option value="samedi">Samedi</option>
            </select>
            @error('jour')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="heure_debut">Heure de début</label>
            <input type="time" name="heure_debut" id="heure_debut" class="form-control" required>
            @error('heure_debut')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="heure_fin">Heure de fin</label>
            <input type="time" name="heure_fin" id="heure_fin" class="form-control" required>
            @error('heure_fin')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection
