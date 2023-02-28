@extends('base')

@section('title')
Affectation des divisions
@endsection

@section('content')
<form method="POST" action="{{route('division.fill')}}">
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
</div>
@include('student_div_list')
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
    @foreach ($divisions as $row)
    <span class="{{ $row['NiveauDiv'] }}">
        <input type="radio" name="id" id="id" value="{{ $row['IdDiv'] }}">
        <label for="id">
        {{ $row['LibelleDiv'] }} (Effectif : {{ $row['EffectifReelDiv'] }}/{{ $row['EffectifPrevDiv'] }})
        </label>
    </span>
    @endforeach
</div>
<button type="submit">Affecter</button>
</div>
</form>

<script>
function filterLevel() {
  var select, filter, ul, li, div, span, td, i, a, nvlist;
  select = document.getElementById("mySelect");
  filter = select.value;
  ul = document.getElementById("studentList");
  div = document.getElementById("divOptions");
  span = div.getElementsByTagName("span");

  li = ul.getElementsByTagName('li');

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

filterLevel();
</script>
@endsection