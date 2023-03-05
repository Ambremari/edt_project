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
    
    <table class="edt" id="myEdt">
        <tr>
            <th style="background-color: #f6f5f5"></th>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
            <th>Samedi</th>
        </tr>
        <tr>
        <td>
            <table class="cell-edt">
            @foreach($times as $time)
            @if($time['Jour'] == 'Lundi')
                <tr><div class= "time-edt">
                    <p>{{ $time['HeureDebut'] }}</p>
                    <p>{{ $time['HeureFin'] }}</p>
                </div>
                </tr>
            @endif
            @endforeach
                </table>
            </td>
            <td>
                <table class="cell-edt">
            @foreach($times as $time)
            @if($time['Jour'] == 'Mardi')
                <tr><div class="box-edt">
                    <span>
                    <input class="checkbox" type="checkbox" name="first[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    <lablel for="mybox">Priorité 1</label>
                    </span>
                    <span>
                    <input class="checkbox" type="checkbox" name="second[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()"> 
                    <lablel for="mybox">Priorité 2</label>
                    </span>
                </div></tr>
            @endif
            @endforeach
                </table>
            </td>
            <td>
                <table class="cell-edt">
            @foreach($times as $time)
            @if($time['Jour'] == 'Mercredi')
                <tr><div class= "box-edt">
                    <span>
                    <input class="checkbox" type="checkbox" name="first[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    <lablel for="mybox">Priorité 1</label>
                    </span>
                    <span>
                    <input class="checkbox" type="checkbox" name="second[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()"> 
                    <lablel for="mybox">Priorité 2</label>
                    </span>
                </div></tr>
            @endif
            @endforeach
                </table>
            </td>
            <td>
                <table class="cell-edt">
            @foreach($times as $time)
            @if($time['Jour'] == 'Jeudi')
                <tr><div class= "box-edt">
                    <span>
                    <input class="checkbox" type="checkbox" name="first[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    <lablel for="mybox">Priorité 1</label>
                    </span>
                    <span>
                    <input class="checkbox" type="checkbox" name="second[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()"> 
                    <lablel for="mybox">Priorité 2</label>
                    </span>
                </div></tr>
            @endif
            @endforeach
                </table>
            </td>
            <td>
                <table class="cell-edt">
            @foreach($times as $time)
            @if($time['Jour'] == 'Vendredi')
                <tr><div class= "box-edt">
                    <span>
                    <input class="checkbox" type="checkbox" name="first[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    <lablel for="mybox">Priorité 1</label>
                    </span>
                    <span>
                    <input class="checkbox" type="checkbox" name="second[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()"> 
                    <lablel for="mybox">Priorité 2</label>
                    </span>
                </div></tr>
            @endif
            @endforeach
                </table>
            </td>
            <td>
                <table class="cell-edt">
            @foreach($times as $time)
            @if($time['Jour'] == 'Samedi')
                <tr><div class= "box-edt">
                    <span>
                    <input class="checkbox" type="checkbox" name="first[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    <lablel for="mybox">Priorité 1</label>
                    </span>
                    <span>
                    <input class="checkbox" type="checkbox" name="second[]" value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()"> 
                    <lablel for="mybox">Priorité 2</label>
                    </span>
                </div></tr>
            @endif
            @endforeach
                </table>
            </td>
        </tr>
    </table>

    <button type="submit">Valider</button>
</form>
</div>

<script>
    function color1(){
        var table = document.getElementById("myEdt");
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
        var table = document.getElementById("myEdt");
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
</script>
@endsection