@extends('base')

@section('title')
Contraintes horaires des enseignements
@endsection

@section('content')
<form method="POST" action="{{route('subject.constraints.update')}}">
    @csrf
<div class="colleft-edt">
    <div class="filterbox">
        <label for="grade">Niveau</label>
        <select class="form-control" id="mySelect" onchange="filterLevel()">
            <option value="6EME">6ème</option>
            <option value="5EME">5ème</option>
            <option value="4EME">4ème</option>
            <option value="3EME">3ème</option>
        </select>

        <span style ="margin-left: 50px;">
        <input class="form-check-input" type="checkbox" name="optional" value="optional" id="optional" onclick="filterOption()";>
            <label class="form-check-label" for="optional">
            Enseignements optionnels
            </label>
        </span>

        <div style="display: block">
            <input class="form-check-input" type="radio" name="id" value="all" id="option">
            <label class="form-check-label" for="option">
            Tous les enseignements de ce niveau
            </label>
        </div>
    </div>

    <input type="text" id="studentInput" onkeyup="searchStudent()" placeholder="Rechercher un enseignement...">
    <ul id="studentList">
        @foreach ($subjects as $row)
        <li><div class="{{ $row['OptionEns'] }}"><span class="{{ $row['NiveauEns'] }}">
        <input class="form-check-input" type="radio" name="id" value="{{ $row['IdEns'] }}" id="option">
        <label for="option" style="font-weight: normal;">
        {{ $row['LibelleEns'] }} {{ $row['NiveauEns'] }}
        </label>
        </span></div></li>
        @endforeach
    </ul>
</div>
<div class="colright-edt">
    @if ($errors->any())
        <div class="alert alert-warning">
            L'affectation n'a pas été prise en compte &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="edt" id="myEdt">
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
        <div class="content-edt">
        <div class="day-edt">
            <div>Lundi</div>
            <div>Mardi</div>
            <div>Mercredi</div>
            <div>Jeudi</div>
            <div>Vendredi</div>
            <div>Samedi</div>
        </div>
        <div id="bodyEdt">
        @foreach($times as $time)
            <div class="{{ $time['Horaire'] }}">
                <span>
                    <input class="checkbox" type="checkbox" name="first[]" 
                    value="{{ $time['Horaire'] }}" id="mybox" onclick="color1()"> 
                    <lablel for="mybox">Priorité 1</label>
                </span>
                <span>
                    
                    <input class="checkbox" type="checkbox" name="second[]" 
                    value="{{ $time['Horaire'] }}" id="mybox" onclick="color2()"> 
                    <lablel for="mybox">Priorité 2</label>
                </span>
            </div>
        @endforeach
        </div>
</div>
    </div>
    
    <button type="submit">Valider</button>
</div>
</form>

@include("edt_position")

<script>

position(); 

function filterOption() {
  var input = document.getElementById("optional");
  var ul = document.getElementById("studentList");
  var li = ul.getElementsByTagName('li');

  var flag = input.checked;

  filterLevel();

  if(flag)
    input.checked = true;

  for (var i = 0; i < li.length; i++) {
    var ens = li[i].getElementsByTagName("div")[0];
    var optEns = ens.getAttribute("class");
    if (ens) {
      if (((optEns != 0 && input.checked) || !input.checked) && li[i].style.display == "") 
        li[i].style.display = "";
      else
        li[i].style.display = "none";
    }
  } 

}

function filterLevel() {
  var select, filter, ul, li, div, span, td, i, a, nvlist;
  select = document.getElementById("mySelect");
  filter = select.value;
  ul = document.getElementById("studentList");
  li = ul.getElementsByTagName('li');

  var input = document.getElementById("optional");
  input.checked = false;

  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("span")[0];
    nvlist = a.getAttribute("class");
    if (nvlist) {
      if (nvlist == filter) {
        li[i].style.display = "";
        a.style.display = "";
      } else {
        li[i].style.display = "none";
        a.style.display = "none";
      }
    }
    }
}

function searchStudent() {
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

color1();
color2();



filterLevel();
</script>
@endsection