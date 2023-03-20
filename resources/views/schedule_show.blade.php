@extends('base')

@section('title', "Horaires de l'établissement")

@section('content')

<div class="colup">
    <form method="POST" action="{{ route('schedule.generate') }}">
        @csrf
        @if ($errors->any())
            <div class="alert alert-warning">
                Les horaires n'ont pas pu être générés &#9785;
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="schedule">
        <table>
            <thead>
                <th></th>
                <th>Pause méridienne</th>
                <th>Inter-classe</th>
            </thead>
            <tr>
                <td>
                    <div class="my_input" style="display: inline-block">
                        <label for="start_day">Ouverture</label>
                        <input type="time" name="start_day" id="start_day" class="form-control" 
                        value="{{ $college_schedule['StartDay'] }}" required>
                        @error('start_day')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="my_input" style="display: inline-block">
                        <label for="end_day">Fermeture</label>
                        <input type="time" name="end_day" id="end_day" class="form-control" 
                        value="{{ $college_schedule['EndDay'] }}"required>
                        @error('end_day')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </td>
                <td>
                    <div class="my_input" style="display: inline-block">
                        <label for="start_break">Début</label>
                        <input type="time" name="start_break" id="start_break" class="form-control" 
                        value="{{ $college_schedule['StartBreak'] }}" required>
                        @error('start_break')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="my_input" style="display: inline-block">
                        <label for="end_break">Fin</label>
                        <input type="time" name="end_break" id="end_break" class="form-control" 
                        value="{{ $college_schedule['EndBreak'] }}" required>
                        @error('end_break')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </td>   
                <td>
                    <div class="my_input" style="display: inline-block">
                        <label for="interval">Durée (min)</label>
                        <input type="number" name="interval" id="interval" class="form-control" style="width: 40px" required>
                        @error('interval')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </td>
            </tr>
        </table>
        <p>Jours d'ouverture</p>
        <table>
            <thead>
                <th></th>
                <th>Lundi</th>
                <th>Mardi</th>
                <th>Mercredi</th>
                <th>Jeudi</th>
                <th>Vendredi</th>
                <th>Samedi</th>
            </thead>
            <tr>
                <th>Matin</th>
                @foreach(["LUNDI", "MARDI", "MERCREDI", "JEUDI", "VENDREDI", "SAMEDI"] as $day)
                <td>
                    @if(in_array(['Jour' => $day], $college_schedule['Mornings']))
                        <input type="checkbox" name="mornings[]" value="{{ $day }}" checked>
                    @else
                        <input type="checkbox" name="mornings[]" value="{{ $day }}">
                    @endif
                </td>
                @endforeach
            </tr>
            <tr>
                <th>Après-midi</th>
                @foreach(["LUNDI", "MARDI", "MERCREDI", "JEUDI", "VENDREDI", "SAMEDI"] as $day)
                <td>
                @if(in_array(['Jour' => $day], $college_schedule['Afternoons']))
                        <input type="checkbox" name="afternoons[]" value="{{ $day }}" checked>
                    @else
                        <input type="checkbox" name="afternoons[]" value="{{ $day }}">
                    @endif
                </td>
                @endforeach
            </tr>
        </table>
        </div>
        <button type="submit">Générer les horaires automatiquement</button>
    </form>
    <a href="{{ route('schedule.form') }}">Ajouter un horaire manuellement</a>
</div>
<div class="coldown">
    @include('schedule_list')
</div>
@endsection
