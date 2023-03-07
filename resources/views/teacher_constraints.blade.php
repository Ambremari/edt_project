@extends('base')

@section('title', 'Renseigner mes contraintes')

@section('content')
<div class="central">
<form method="POST" action="{{route('update.prof.constraints')}}">
<div class="info">
        <span>Voeux 1 : {{ count($first_constraints) }} / 5</span>
        <span>Voeux 2 :  {{ count($sec_constraints) }} / 5</span>
    </div>
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Les contraintes n'ont pas été mises à jour &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    
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
        @foreach($times as $time)
            <div class="{{ $time['Horaire'] }}">
                <span>
                    @if(in_array(['IdProf' => $id_prof, 'Horaire' => $time['Horaire'], 'Prio' => 1], $first_constraints))
                        <input class="checkbox" type="checkbox" name="first[]" 
                        value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()" checked> 
                    @else
                        <input class="checkbox" type="checkbox" name="first[]" 
                        value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    @endif
                    <lablel for="mybox">Priorité 1</label>
                </span>
                <span>
                    @if(in_array(['IdProf' => $id_prof, 'Horaire' => $time['Horaire'], 'Prio' => 2], $sec_constraints))
                        <input class="checkbox" type="checkbox" name="second[]" 
                        value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()" checked> 
                    @else
                        <input class="checkbox" type="checkbox" name="second[]" 
                        value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()"> 
                    @endif
                    <lablel for="mybox">Priorité 2</label>
                </span>
            </div>
        @endforeach
        </div>
    </div>

    <button type="submit">Valider</button>
</form>
</div>

@include("edt_position")
<script>

position();
color1();
color2();
</script>
@endsection