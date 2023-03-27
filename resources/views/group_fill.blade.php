@extends('base')

@section('title')
Affectation des Groupes
@endsection

@section('content')
<form method="POST" action="{{route('group.fill')}}">
    @csrf
<div class="colleft">
<div class="filterbox">
<label for="grade">Niveau</label>
<select class="form-control" id="mySelect" onchange="filterLevel()">
    <option value="6EME">6ème</option>
    <option value="5EME">5ème</option>
    <option value="4EME">4ème</option>
    <option value="3EME">3ème</option>
</select>
<label for="grade">Divisions</label>
<select class="form-control" id="divList" name="div" onchange="filterOption()">
  <option value="" selected></option>
  @foreach ($divisions as $division)
    <option class="{{ $division['NiveauDiv'] }}" value="{{ $division['IdDiv'] }}">{{ $division['LibelleDiv'] }}</option>
  @endforeach
</select>
<span style="display: block">
<label for="grade">Options</label>
<select class="form-control" id="optionList" name="option" onchange="filterOption()">
  <option value="" selected></option>
  @foreach ($options as $option)
    <option class="{{ $option['NiveauEns'] }}" value="{{ $option['IdEns'] }}">{{ $option['LibelleEns'] }}</option>
  @endforeach
</select>
</span>
</div>
<table id="myTable" style="display: none">
        @foreach($option_choices as $item)
        <tr>
            <td>{{ $item['IdEleve'] }}</td>
            <td>{{ $item['IdEns'] }}</td>
        </tr>
        @endforeach
</table>
<table id="divTable" style="display: none">
        @foreach($group_links as $link)
        <tr>
            <td>{{ $link['IdDiv'] }}</td>
            <td>{{ $link['IdGrp'] }}</td>
        </tr>
        @endforeach
</table>

<input type="text" id="studentInput" onkeyup="searchStudent()" placeholder="Rechercher un élève...">
<ul id="studentList">
    @foreach ($students as $row)
    <li class="{{ $row['IdEleve'] }}"><div class="{{ $row['IdDiv'] }}"><span class="{{ $row['NiveauEleve'] }}">
    <input class="form-check-input" type="checkbox" name="students[]" value="{{ $row['IdEleve'] }}" id="option">
    <label class="form-check-label" for="option">
      {{ $row['NomEleve'] }} {{ $row['PrenomEleve'] }}
    </label>
    </span></div></li>
    @endforeach
</ul>
</div>
<div class="colright">
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
<div class="class_check" id="divOptions">
    @foreach ($groups as $row)
    <span class="{{ $row['NiveauGrp'] }}">
      <div class="{{ $row['IdGrp'] }}">
        <input type="radio" name="id" id="id" value="{{ $row['IdGrp'] }}">
        <label for="id">
        {{ $row['LibelleGrp'] }} (Effectif : {{ $row['EffectifReelGrp'] }}/{{ $row['EffectifPrevGrp'] }})
        </label>
      </div>
    </span>
    @endforeach
</div>
<button type="submit">Affecter</button>
</div>
</form>

<script>
function filterOption() {
  var input = document.getElementById("optionList");
  var filterOption = input.value;
  var table = document.getElementById("myTable");
  var tr = table.getElementsByTagName("tr");
  var ul = document.getElementById("studentList");
  var li = ul.getElementsByTagName('li');
  var filterOptionLib = "";

  var options = input.getElementsByTagName("option");
  for(var j = 0 ; j < options.length ; j++){
    var optionValue = options[j].getAttribute('value');
    if(optionValue == filterOption)
      filterOptionLib = options[j].textContent || options[j].innerText;
  }

    for (var j = 0; j < li.length; j++) {
        li[j].style.display = "none";
    }

    for (var i = 0; i < tr.length; i++) {
        var ens = tr[i].getElementsByTagName("td")[1];
        var eleve = tr[i].getElementsByTagName("td")[0];
        if (ens) {
            var txtValue = ens.textContent || ens.innerText;
            var txtEleve = eleve.textContent || eleve.innerText;
            if (txtValue == filterOption || filterOption == "") {
                for (var j = 0; j < li.length; j++) {
                    var student = li[j].getAttribute("class");
                    if(student == txtEleve || filterOption == "")
                        li[j].style.display = "";
                } 
            }
        }
    }

  var inputDiv = document.getElementById("divList");
  var filterDiv = inputDiv.value;

  for (var i = 0; i < li.length; i++) {
    var div = li[i].getElementsByTagName("div")[0];
    var studDiv = div.getAttribute("class");
    if (div) {
      if ((studDiv == filterDiv || filterDiv == "" ) && li[i].style.display == "") 
        li[i].style.display = "";
      else
        li[i].style.display = "none";
    }
  } 

  var divTable = document.getElementById("divTable");
  var divTr = divTable.getElementsByTagName("tr");
  var div = document.getElementById("divOptions");
  var span = div.getElementsByTagName("span");
  var select = document.getElementById("mySelect");
  var filterLevel = select.value;

  for (var j = 0; j < span.length; j++) {
      span[j].style.display = "none";
    }

  for (var i = 0; i < divTr.length; i++) {
      var myDiv = divTr[i].getElementsByTagName("td")[0];
      var myGrp = divTr[i].getElementsByTagName("td")[1];
      if (myDiv) {
        var txtDiv = myDiv.textContent || myDiv.innerText;
        var txtGrp = myGrp.textContent || myGrp.innerText;
        if (txtDiv == filterDiv || filterDiv == "") {
          for (var j = 0; j < span.length; j++) {
              var idGrp = span[j].getElementsByTagName("div")[0];
              var group = idGrp.getAttribute("class");
              var nvGrp = span[j].getAttribute("class");
              var libGrp = span[j].textContent || span[j].innerText;
              var pattern = new RegExp(filterOptionLib);
              if((group == txtGrp || filterDiv == "") && nvGrp == filterLevel && (filterOption == "" || pattern.test(libGrp)))
                  span[j].style.display = "";
          } 
        }
      }
  }

}

function filterLevel() {
  var select, filter, ul, li, div, span, td, i, a, nvlist;
  select = document.getElementById("mySelect");
  filter = select.value;
  ul = document.getElementById("studentList");
  div = document.getElementById("divOptions");
  span = div.getElementsByTagName("span");
  li = ul.getElementsByTagName('li');
  var options = document.getElementById("optionList");
  var optSpan = options.getElementsByTagName("option");
  var divisions = document.getElementById("divList");
  var filterDiv = divisions.value;
  var divSpan = divisions.getElementsByTagName("option");

  for (i = 0; i < optSpan.length; i++) {
    var opt = optSpan[i].getAttribute("class");
    if (opt) {
      if (opt == filter) {
        optSpan[i].disabled = false;
      } else {
        optSpan[i].disabled = true;
        optSpan[i].selected = false;
      }
    }
  }

  for (i = 0; i < divSpan.length; i++) {
    var mydiv = divSpan[i].getAttribute("class");
    if (mydiv) {
      if (mydiv == filter) {
        divSpan[i].disabled = false;
      } else {
        divSpan[i].disabled = true;
        divSpan[i].selected = false;
      }
    }
  }

  filterOption();

  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("span")[0];
    nvlist = a.getAttribute("class");
    if (nvlist) {
      if (nvlist == filter) {
        a.style.display = "";
      } else {
        a.style.display = "none";
      }
    }
    }

  for (i = 0; i < span.length; i++) {
    td = span[i].getAttribute("class");
    if (td) {
      if (td == filter) {
        span[i].style.display = "";
      } else {
        span[i].style.display = "none";
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



filterLevel();
</script>
@endsection