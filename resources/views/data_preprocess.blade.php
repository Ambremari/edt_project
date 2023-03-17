@extends('base')

@section('title', 'Pré-traitement des données')

@section('content')
<div class="colleft">
    <div class="infos">
    <button class="tablinks" onclick="openInfo(event, 'NoDiv')">Elèves sans division : {{ count($students_no_div) }}</button>
    <button class="tablinks" onclick="openInfo(event, 'NoLV1')">Elèves sans Groupe LV1 : {{ count($students_no_lv1) }}</button>
    <button class="tablinks" onclick="openInfo(event, 'NoLV2')">Elèves sans Groupe LV2 : {{ count($students_no_lv2) }}</button>
    <button class="tablinks" onclick="openInfo(event, 'NoTeacher')">Enseignements sans enseignants : {{ count($subjects) }}</button>
    <button class="tablinks" onclick="openInfo(event, 'InfTime')">Enseignants avec volume horaire insuffisant : {{ count($teachers) }}</button>
    <button class="tablinks" onclick="openInfo(event, 'NoSubject')">Divisions avec enseignements manquants : {{ count($divisions) }}</button>
    <button class="tablinks" onclick="openInfo(event, 'DivVol')">Divisions avec volume horaire insuffisant : {{ count($divisions_vol) }}</button>
    <span>Dernier pré-traitement : </span>
    <span>Dernière moficiation de la base : </span>    
</div>
<button>Lancer le pré-traitement</button>
</div>
<div class="colright">
    <div id="NoDiv" class="tabcontentinfo">
        <ul id="studentList">
        @foreach( $students_no_div as $student )
        <li><a href="{{route('division.fill.form')}}">{{ $student['PrenomEleve'] }} {{ $student['NomEleve']}}</a></li>
        @endforeach
        </ul>
    </div>
    <div id="NoLV1" class="tabcontentinfo">
        <ul id="studentList">
        @foreach( $students_no_lv1 as $student )
        <li><a href="{{route('group.fill.form')}}">{{ $student['PrenomEleve'] }} {{ $student['NomEleve']}}</a></li>
        @endforeach
        </ul>
    </div>
    <div id="NoLV2" class="tabcontentinfo">
        <ul id="studentList">
        @foreach( $students_no_lv2 as $student )
        <li><a href="{{route('group.fill.form')}}">{{ $student['PrenomEleve'] }} {{ $student['NomEleve']}}</a></li>
        @endforeach
        </ul>
    </div>
    <div id="NoTeacher" class="tabcontentinfo">
        <ul id="studentList">
        @foreach( $subjects as $subject)
        <li><a href="{{route('link.subject')}}">{{ $subject['LibelleEns'] }} {{ $subject['NiveauEns']}}</a></li>
        @endforeach
        </ul>
    </div>
    <div id="InfTime" class="tabcontentinfo">
        <ul id="studentList">
        @foreach( $teachers as $teacher)
        <li><a href="{{route('link.subject.form', ['idProf' => $teacher['IdProf']])}}">{{ $teacher['PrenomProf'] }} {{ $teacher['NomProf']}}</a></li>
        @endforeach
        </ul>
    </div>
    <div id="NoSubject" class="tabcontentinfo">
        <ul id="studentList">
        @foreach( $divisions as $division)
        <li><a href="{{route('division.show', ['idDiv' => $division['IdDiv']])}}">{{ $division['LibelleDiv'] }}</a></li>
        @endforeach
        </ul>
    </div>
    <div id="DivVol" class="tabcontentinfo">
        <ul id="studentList">
        @foreach( $divisions_vol as $division)
        <li><a href="{{route('division.show', ['idDiv' => $division['IdDiv']])}}">{{ $division['LibelleDiv'] }} {{ $division['VolTotSalle'] }}/{{ $division['VolTotEns'] }}</a></li>
        @endforeach
        </ul>
    </div>

    
</div>




<script>

function openInfo(evt, infoName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontentinfo");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(infoName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
@endsection