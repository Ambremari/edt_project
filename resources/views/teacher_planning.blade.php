@extends('base')

@section('title', 'Mon Emploi du temps')

@section('content')
<div class="central">
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
                <span class="{{ $time['LibelleEns'] }}">
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
colorClass();
</script>
@endsection
