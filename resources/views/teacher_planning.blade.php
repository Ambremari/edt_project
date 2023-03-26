@extends('base')

@section('title', 'Mon Emploi du temps')

@section('content')
<div class="colleft-edt">
    <ul id="studentList">
        <li>
        <input class="form-check-input" type="radio" name="id" value="" id="myFilter" onclick="filterClass()" checked>
            <label class="radio-link" for="id" style="font-weight: normal;">
                Toutes mes classes
            </label>
        </li>
        @foreach ($divisions as $class)
        <li>
          <input class="form-check-input" type="radio" name="id" value="{{ $class['LibelleDiv'] }}" id="myFilter" onclick="filterClass()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $class['LibelleDiv'] }}
            </label>
        </li>
        @endforeach
        @foreach ($groups as $class)
        <li>
          <input class="form-check-input" type="radio" name="id" value="{{ $class['LibelleGrp'] }}" id="myFilter" onclick="filterClass()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $class['LibelleGrp'] }}
            </label>
        </li>
        @endforeach
    </ul>
</div>
<div class="colright-edt">
<div class="info">
        <span>Volume horaire hebdomadaire : {{ $teacher['VolHReelProf'] }}</span>
    </div>

    <div class="edt" id="myEdt">
        <div class="day-edt">
            <div>Lundi</div>
            <div>Mardi</div>
            <div>Mercredi</div>
            <div>Jeudi</div>
            <div>Vendredi</div>
            <div>Samedi</div>
        </div>
        <div class="col-edt">
            @for($i = 1; $i <= count($start_morning) ; $i++)
            <div class= "times-edt">
                <div class="start-time">{{ $start_morning[($i-1)]['HeureDebut'] }}</div>
                <p>M{{ $i }}</p>
            </div>
            @endfor
            @for($i = count($start_morning) ; $i < 5 ; $i++)
            <div style="height: 90px;">
            </div>
            @endfor
            <div style="height: 40px;">
            </div>
            @for($i = 1; $i <= count($start_afternoon) ; $i++)
            <div class= "times-edt">
                <div class="start-time">{{ $start_afternoon[($i-1)]['HeureDebut'] }}</div>
                <p>S{{ $i }}</p>
            </div>
            @endfor
        </div>
        <div id="bodyEdt">
        @foreach($planning as $time)
            <div class="{{ $time['Horaire'] }}">
                @if($time['LibelleGrp'] == null)
                <span class="{{ $time['LibelleDiv'] }}">
                @else
                <span class="{{ $time['LibelleGrp'] }}">
                @endif
                    <p style="font-weight: bold">{{ $time['LibelleEns'] }}</p>
                    <p>{{ $time['LibelleDiv'] }} {{ $time['LibelleGrp'] }}</p>
                    <p><i>{{ $time['LibelleSalle'] }}</i></p>
                </span>
            </div>
        @endforeach
        </div>
    </div>
</div>
@include("edt_position")
<script>

position();
filterClass();
</script>
@endsection
