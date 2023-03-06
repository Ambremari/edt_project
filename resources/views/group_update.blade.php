@extends('base')

@section('title', 'Modifier un groupe')

@section('content')
<div class="colup">
<form method="POST" action="{{route('group.update')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Le groupe n'a pas pu être modifié &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <p>Groupe {{ $group['IdGrp'] }}<p>
        <input type="hidden" value="{{ $group['IdGrp'] }}" name="id">
        <div class="my_input" style="display: inline-block">
            <label for="lib">Libellé</label>
            <input type="text" id="lib" name="lib" minlength="2" maxlength="40"
                aria-describedby="lib_feedback"
                value="{{ $group['LibelleGrp'] }}" required>
        </div>
        @error('lib')
        <div id="lib_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="grade">Niveau</label>
            <select class="form-control" id="grade" name="grade" minlength="2" maxlength="15"
                aria-describedby="grade_feedback"
                onchange="filterGroupDivision(); uncheck();"
                value="{{ $group['NiveauGrp'] }}" required>
                <option value="6EME" {{ $group['NiveauGrp'] == "6EME" ? "selected" : "" }}>6ème</option>
                <option value="5EME" {{ $group['NiveauGrp'] == "5EME" ? "selected" : "" }}>5ème</option>
                <option value="4EME" {{ $group['NiveauGrp'] == "4EME" ? "selected" : "" }}>4ème</option>
                <option value="3EME" {{ $group['NiveauGrp'] == "3EME" ? "selected" : "" }}>3ème</option>
            </select>
        </div>
        @error('grade')
        <div id="grade_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <div class="my_input" style="display: inline-block">
            <label for="headcount">Effectif prévu</label>
            <input type="number" id="headcount" name="headcount" min="1" max="35"
                aria-describedby="headcount_feedback"
                style="width:50px"
                value="{{ $group['EffectifPrevGrp'] }}" required>
        </div>
            @error('headcount')
        <div id="headcount_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <label style="display: block;">Divisions associées</label>
        <div id="divOptions">
        @foreach($divisions as $div)
            <div class="my_input" style="display: inline-block">
                <span class="{{ $div['NiveauDiv'] }}">
                @if(in_array(['IdGrp' => $group['IdGrp'], 'IdDiv' => $div['IdDiv'], 'LibelleDiv' => $div['LibelleDiv']], $group_div))
                    <input class="checkbox" type="checkbox" name="divisions[]" value="{{ $div['IdDiv'] }}" id="option" checked>
                @else
                    <input class="checkbox" type="checkbox" name="divisions[]" value="{{ $div['IdDiv'] }}" id="option">
                @endif    
                    <label class="form-check-label" for="option">
                    {{ $div['LibelleDiv'] }}
                    </label>
                </span>
            </div>
        @error('subject')
        <div id="option_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        @endforeach
    </div>
    <button type="submit">Modifier</button>
</form>
</div>
<div class="coldown">
    @include('group_list')
</div>
<script>
function filterGroupDivision() {
  var select = document.getElementById("grade");
  var filter = select.value;
  var div = document.getElementById("divOptions");
  var span = div.getElementsByTagName("span");

  for (var i = 0; i < span.length; i++) {
    var td = span[i].getAttribute("class");
    if (td) {
      if (td == filter) {
        span[i].style.display = "";
      } else {
        span[i].style.display = "none";
      }
    }
  }
}

function uncheck() {
  var div = document.getElementById("divOptions");
  var checkboxes = div.getElementsByTagName("input");

  for (var i = 0; i < checkboxes.length; i++) { 
		checkboxes[i].checked = false;
	}
}

filterGroupDivision();
</script>
@endsection

