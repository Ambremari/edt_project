@extends('base')

@section('title', 'Renseigner mes contraintes')

@section('content')
<div class="central">
<form method="POST" action="{{route('update.prof.constraints')}}">
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
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[0]['HeureDebut'] }}</div>
                <p>M1</p>
            </div>
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[1]['HeureDebut'] }}</div>
                <p>M2</p>
            </div>
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[2]['HeureDebut'] }}</div>
                <p>M3</p>
            </div>
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[3]['HeureDebut'] }}</div>
                <p>M4</p>
            </div>
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[4]['HeureDebut'] }}</div>
                <p>M5</p>
            </div>
            <div style="height: 40px;">
            </div>      
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[5]['HeureDebut'] }}</div>
                <p>S1</p>
            </div>
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[6]['HeureDebut'] }}</div>
                <p>S2</p>
            </div>
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[7]['HeureDebut'] }}</div>
                <p>S3</p>
            </div>
            <div class= "times-edt">
                <div class="start-time">{{ $start_times[8]['HeureDebut'] }}</div>
                <p>S4</p>
            </div>
        </div>
        <div id="bodyEdt">
        @foreach($times as $time)
            <div class="{{ $time['Horaire'] }}">
                <span>
                    @if(in_array(['IdProf' => $id_prof, 'Horaire' => $time['Horaire'], 'Prio' => 1], $constraints))
                        <input class="checkbox" type="checkbox" name="first[]" 
                        value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()" checked> 
                    @else
                        <input class="checkbox" type="checkbox" name="first[]" 
                        value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    @endif
                    <lablel for="mybox">Priorité 1</label>
                </span>
                <span>
                    @if(in_array(['IdProf' => $id_prof, 'Horaire' => $time['Horaire'], 'Prio' => 2], $constraints))
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
    function color1(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");

        for(var i = 0; i < div.length ; i++){
            var check1 = div[i].getElementsByTagName("input")[0];
            var check2 = div[i].getElementsByTagName("input")[1];
            if(check1){
                if(check1.checked){
                    check2.checked = false;
                    div[i].style.backgroundColor= "red";
                }
                else if(!check1.checked && !check2.checked)
                    div[i].style.backgroundColor= "#f6f5f5";
            }
        }
    }

    function color2(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");

        for(var i = 0; i < div.length ; i++){
            var check1 = div[i].getElementsByTagName("input")[0];
            var check2 = div[i].getElementsByTagName("input")[1];
            if(check2){
                if(check2.checked){
                    check1.checked = false;
                    div[i].style.backgroundColor= "yellow";
                }
                else if(!check1.checked && !check2.checked)
                    div[i].style.backgroundColor= "#f6f5f5";
            }
        }
    }

position();
color1();
color2();
</script>
@endsection