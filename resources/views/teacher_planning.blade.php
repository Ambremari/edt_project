@extends('base')

@section('title', 'Mon Emploi du temps')

@section('content')
<div class="colleft-edt">
    <ul id="studentList" style="margin: 20%">
        <li style="padding-left: 10%">
        <input class="form-check-input" type="radio" name="id" value="" id="myFilter" onclick="filterClass()" checked>
            <label class="radio-link" for="id" style="font-weight: normal;">
                Toutes mes classes
            </label>
        </li>
        @foreach ($divisions as $class)
        <li style="padding-left: 10%">
          <input class="form-check-input" type="radio" name="id" value="{{ $class['LibelleDiv'] }}" id="myFilter" onclick="filterClass()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $class['LibelleDiv'] }}
            </label>
        </li>
        @endforeach
        @foreach ($groups as $class)
        <li style="padding-left: 10%">
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
                @if($time['Semaine'] == "A")
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px">
                @elseif($time['Semaine'] == "B")
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px ; margin-left: 90px;">
                @else
                <div class="{{ $time['Horaire'] }}">
                @endif
                @if($time['LibelleGrp'] == null)
                <span class="{{ $time['LibelleDiv'] }}">
                <p style="font-weight: bold">{{ $time['LibelleEns'] }}</p>
                    <p>{{ $time['LibelleDiv'] }}</p>
                    <p><i>{{ $time['LibelleSalle'] }}</i></p>
                </span>
                @else
                    @if($time['LibelleDiv'] == null)
                    <span class="{{ $time['LibelleGrp'] }}">
                    @else
                    <span class="{{ $time['LibelleDiv'] }}">
                    @endif
                    <p style="font-weight: bold">{{ $time['LibelleEns'] }}</p>
                    <p>{{ $time['LibelleGrp'] }}</p>
                    <p><i>{{ $time['LibelleSalle'] }}</i></p>
                </span>
                @endif
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
