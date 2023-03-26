@extends('base')

@section('title', 'Modification emploi du temps')

@section('content')
<div class="colleft-edt">
<input type="text" id="studentInput" onkeyup="searchClass()" placeholder="Rechercher une classe...">
    <ul id="studentList" style="height: 300px;">
    @foreach ($divisions as $class)
        <li><span>
          <input class="form-check-input" type="radio" name="id" value="{{ $class['LibelleDiv'] }}" id="myFilter" onclick="filterClass()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $class['LibelleDiv'] }}
            </label>
        </span></li>
        @endforeach
        @foreach ($groups as $class)
        <li><span>
          <input class="form-check-input" type="radio" name="id" value="{{ $class['LibelleGrp'] }}" id="myFilter" onclick="filterClass()">
            <label class="radio-link" for="id" style="font-weight: normal;">
                {{ $class['LibelleGrp'] }}
            </label>
        </span></li>
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
                <div class="{{ $time['Horaire'] }}" style="width:70px; font-size: 12px ; margin-left: 70px;">
                @else
                <div class="{{ $time['Horaire'] }}">
                @endif
                <a href="{{route('planning.move', ['unit' => $time['Unite']])}}">
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
filterClass();
</script>
@endsection
