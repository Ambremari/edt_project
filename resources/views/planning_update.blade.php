@extends('base')

@section('title', 'Modification emploi du temps')

@section('content')
<div class="colleft-edt">
    <form method="POST" action="{{ route('planning.update', ['unit' => $unit['Unite']]) }}">
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
        <input type="hidden" value="{{ $unit['Unite'] }}" name="id">
        <div class="filterbox">
            <p><b>{{ $unit['LibelleEns'] }}</b></p>
            <p>{{ $unit['LibelleDiv'] }}</p>
            <p>{{ $unit['LibelleGrp'] }}</p>
            <p><i>{{ $unit['NomProf'] }} {{ $unit['PrenomProf'] }}</i></p>
            <label for="type">Horaire</label>
            <select class="form-control" id="selectSchedule" 
                name="schedule" minlength="2" maxlength="15"
                aria-describedby="type_feedback"
                onchange= colorSchedule() required>
                @foreach($times as $time)
                <option value="{{ $time['Horaire'] }}" {{ $time['Horaire'] == $unit['Horaire'] ? "selected" : "" }}>{{ $time['Horaire'] }}</option>
                @endforeach
            </select>
            <label for="type">Semaine</label>
            <select class="form-control" id="mySelect" 
                name="week" minlength="2" maxlength="15"
                aria-describedby="type_feedback" required>
                <option value=null {{ null == $unit['Semaine'] ? "selected" : "" }}></option>
                <option value="A" {{ "A" == $unit['Semaine'] ? "selected" : "" }}>A</option>
                <option value="B" {{ "B" == $unit['Semaine'] ? "selected" : "" }}>B</option>
            </select>
            <label for="type">Salle</label>
            <select class="form-control" id="mySelect" 
                name="room" minlength="2" maxlength="15"
                aria-describedby="type_feedback" required>
                @foreach($classrooms as $room)
                <option value="{{ $room['IdSalle'] }}" {{ $room['IdSalle'] == $unit['IdSalle'] ? "selected" : "" }}>{{ $room['LibelleSalle'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Modifier</button>
    </form>
</div>
<div class="colright-edt">

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
                @if($time['Semaine'] == "A" && $time['Horaire'] == $unit['Horaire'])
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px ; background-color: #FBCEB1">
                @elseif($time['Semaine'] == "A")
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px">
                @elseif($time['Semaine'] == "B" && $time['Horaire'] == $unit['Horaire'])
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px ; margin-left: 90px; background-color: #FBCEB1">
                @elseif($time['Semaine'] == "B")
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px ; margin-left: 90px">
                @elseif($time['Horaire'] == $unit['Horaire'])
                <div class="{{ $time['Horaire'] }}" style="background-color: #FBCEB1">
                @else
                <div class="{{ $time['Horaire'] }}">
                @endif
                @if($time['LibelleGrp'] == null)
                <span class="{{ $time['LibelleDiv'] }}">
                <p style="font-weight: bold">{{ $time['LibelleEns'] }}</p>
                    <p>{{ $time['LibelleDiv'] }}</p>
                </span>
                @else
                    @if($time['LibelleDiv'] == null)
                    <span class="{{ $time['LibelleGrp'] }}">
                    @else
                    <span class="{{ $time['LibelleDiv'] }}">
                    @endif
                    <p style="font-weight: bold">{{ $time['LibelleEns'] }}</p>
                    <p>{{ $time['LibelleGrp'] }}</p>
                </span>
                @endif
                </div>
        @endforeach
        @foreach($times as $time)
            <div class="{{ $time['Horaire'] }}" style="background-color : transparent;">
            </div>
        @endforeach
        </div>
    </div>
</div>
@include("edt_position")
<script>

function searchClass() {
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('studentInput');
  filter = input.value.toUpperCase();
  ul = document.getElementById("studentList");
  li = ul.getElementsByTagName('li');

  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("span")[0];
    txtValue = a.textContent || a.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}

position();
colorSchedule();
function colorSchedule(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");
        var select = document.getElementById("selectSchedule");
        var selected = select.value;

        for(var i = 0; i < div.length ; i++){
            var text = div[i].getAttribute("class");
            if(text == selected)
                div[i].style.borderColor = "#F53C3C";
            else
                div[i].style.borderColor = "#ddd";
        }
    }
</script>
@endsection
