@extends('base')

@section('title', 'Ajouter un groupe')

@section('content')
<div class="colup">
<form method="POST" action="{{route('group.add')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            Le groupe n'a pas pu être ajouté &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <div class="my_input" style="display: inline-block">
            <label for="lib">Libellé</label>
            <input type="text" id="lib" name="lib" minlength="2" maxlength="40"
                aria-describedby="lib_feedback"
                value="{{ old('lib') }}" required>
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
                onchange="filterGroupDivision()"
                value="{{ old('grade') }}" required>
                <option value="" selected></option>
                <option value="6EME">6ème</option>
                <option value="5EME">5ème</option>
                <option value="4EME">4ème</option>
                <option value="3EME">3ème</option>
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
                value="{{ old('headcount') }}" required>
        </div>
        @error('headcount')
        <div id="headcount_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
        <label style="display: block;">Divisions associées</label>
        <div id="divOptions" style="display: none;">
            @foreach($divisions as $div)
            <div class="my_input" style="display: inline-block">
                <span class="{{ $div['NiveauDiv'] }}">
                    <input class="form-check-input" type="checkbox" name="divisions[]" value="{{ $div['IdDiv'] }}" id="option">
                    <label class="form-check-label" for="option">
                    {{ $div['LibelleDiv'] }}
                    </label>
                </span>
            </div>
            @error('option')
            <div id="option_feedback" class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
            @endforeach
        </div>
    </div>
    <button type="submit">Ajouter</button>
</form>
</div>
<div class="coldown">
    @include('group_list')
</div>
@endsection

<script>
function filterGroupDivision() {
  var select, filter, div, span, td, i, txtValue;
  select = document.getElementById("grade");
  filter = select.value;
  div = document.getElementById("divOptions");
  span = div.getElementsByTagName("span");

  div.style.display = "";

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
</script>