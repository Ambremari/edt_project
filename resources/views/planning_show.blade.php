@extends('base')

@section('title', 'Modification emploi du temps')

@section('content')
<div class="colleft-edt">
<input type="text" id="studentInput" onkeyup="searchClass()" placeholder="Rechercher une classe...">
    <ul id="studentList" style="height: 300px;">
    @foreach ($divisions as $class)
        <li><span>
          <input class="form-check-input" type="radio" name="id" value="{{ $class['LibelleDiv'] }}" id="myFilter" onclick="newFilterClass()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $class['LibelleDiv'] }}
            </label>
        </span></li>
        @endforeach
        @foreach ($groups as $class)
        @if($class['IdDiv'] == null)
        <li><span>
          <input class="form-check-input" type="radio" name="id" value="{{ $class['IdGrp'] }}" id="myFilter" onclick="newFilterClass()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $class['LibelleGrp'] }} {{ $class['NiveauGrp'] }}
            </label>
        </span></li>
        @endif
        @endforeach
    </ul>

    <input type="text" id="studentInput" onkeyup="searchTeacher()" placeholder="Rechercher un enseignant...">
    <ul id="studentList" style="height: 300px;">
    @foreach ($teachers as $teacher)
        <li><span>
          <input class="form-check-input" type="radio" name="id" value="{{ $teacher['IdProf'] }}" id="myFilter" onclick="filterTeacher()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $teacher['PrenomProf'] }} {{ $teacher['NomProf'] }}
            </label>
        </span></li>
        @endforeach
    </ul>
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
                @if($time['Semaine'] == "A")
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px">
                @elseif($time['Semaine'] == "B")
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px ; margin-left: 90px;">
                @else
                <div class="{{ $time['Horaire'] }}">
                @endif
                <a href="{{route('planning.move', ['unit' => $time['Unite']])}}">
                <span class="{{ $time['IdProf'] }}"></span>
                @if($time['LibelleGrp'] == null)
                <span class="{{ $time['LibelleDiv'] }}">
                <p style="font-weight: bold">{{ $time['LibelleEns'] }}</p>
                    <p>{{ $time['LibelleDiv'] }}</p>
                    <p><i>{{ $time['LibelleSalle'] }}</i></p>
                </span>
                @else
                    @if($time['LibelleDiv'] == null)
                    <span class="{{ $time['IdGrp'] }}">
                    @else
                    <span class="{{ $time['LibelleDiv'] }}">
                    @endif
                    <p style="font-weight: bold">{{ $time['LibelleEns'] }}</p>
                    <p>{{ $time['LibelleGrp'] }}</p>
                    <p><i>{{ $time['LibelleSalle'] }}</i></p>
                </span>
                @endif
                </a></div>
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
function newAssociateColor(){
        var colors = ["#FBCEB1", "#F2D2BD", "#E97451",	"#E3963E","#F28C28",	
                    "#D27D2D",	"#B87333","#FF7F50",	"#F88379",	"#8B4000",	
                    "#FAD5A5","#E49B0F","#FFC000",	"#DAA520",	"#FFD580"];
        var index = 0;
        var getColor = new Map();
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");
        for(var i = 0; i < div.length ; i++){
            var mySpan = div[i].getElementsByTagName("span")[1];
            var text = mySpan.getAttribute("class");
            if(!getColor.has(text)){
                getColor.set(text, colors[index])
                index++;
                if(index >= colors.length)
                    index = 0;
            }
        }
        return getColor;
    }

function newFilterClass(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");
        var input = document.getElementsByTagName("input");
        
        for(var i = 0; i < input.length ; i++){
            if(input[i].checked)
                var filter = input[i].value;
        }

        for(var i = 0; i < div.length ; i++){
            div[i].style.display = "none";
        }

        colors = associateColor();

        for(var i = 0; i < div.length ; i++){
            var mySpan = div[i].getElementsByTagName("span")[1];
            var text = mySpan.getAttribute("class");
            var myProf = div[i].getElementsByTagName("span")[0];
            var prof = myProf.getAttribute("class");
            if(filter == "" || filter == text){
                div[i].style.display = "";
                div[i].style.backgroundColor= colors.get(prof);
            }
        }
    }
newFilterClass();

function filterTeacher(){
        var table = document.getElementById("bodyEdt");
        var div = table.getElementsByTagName("div");
        var input = document.getElementsByTagName("input");
        
        for(var i = 0; i < input.length ; i++){
            if(input[i].checked)
                var filter = input[i].value;
        }

        for(var i = 0; i < div.length ; i++){
            div[i].style.display = "none";
        }

        colors = newAssociateColor();

        for(var i = 0; i < div.length ; i++){
            var mySpan = div[i].getElementsByTagName("span")[0];
            var text = mySpan.getAttribute("class");
            var myProf = div[i].getElementsByTagName("span")[1];
            var prof = myProf.getAttribute("class");
            if(filter == "" || filter == text){
                div[i].style.display = "";
                div[i].style.backgroundColor= colors.get(prof);
            }
        }
    }
newFilterClass();


</script>
@endsection
