@extends('base')

@section('title', 'Incompatibilités horaires des enseignements')

@section('content')
<div class="colup">
<form method="POST" action="{{route('subject.incompatibility.add')}}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-warning">
            L'ajout n'a pas pu être effectué &#9785;
        </div>  
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div>
        <div class="my_input" style="display: inline-block">
            <label for="subject1">Enseignement 1</label>
            <select class="form-control" id="subject1" name="subject1" minlength="2" maxlength="15"
                aria-describedby="subject_feedback"
                value="{{ old('subject') }}" required>
                @foreach($subjects as $row)
                <option value="{{ $row['IdEns'] }}">{{ $row['LibelleEns'] }} {{ $row['NiveauEns'] }}</option>
                @endforeach
            </select>
            <label for="subject1">Enseignement 2</label>
            <select class="form-control" id="subject2" name="subject2" minlength="2" maxlength="15"
                aria-describedby="subject_feedback"
                value="{{ old('subject') }}" required>
                @foreach($subjects as $row)
                <option value="{{ $row['IdEns'] }}">{{ $row['LibelleEns'] }} {{ $row['NiveauEns'] }}</option>
                @endforeach
            </select>
        </div>
        @error('subject')
        <div id="subject_feedback" class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <button type="submit">Affecter</button>
</form>
</div>
<div class="coldown">
<div class="filter">
<label for="grade">Filtrer par niveau</label>
<select class="form-control" id="mySelect" onchange="filterSubject()">
    <option value="" selected>Tous</option>
    <option value="6EME">6ème</option>
    <option value="5EME">5ème</option>
    <option value="4EME">4ème</option>
    <option value="3EME">3ème</option>
</select>
</div>

<div class="myTable">
<table id="subjectTable">
  <tr class="header">
    <th>Enseignement 1</th>
    <th>Niveau</th>
    <th>Enseignement 2</th>
    <th>Niveau</th>
    <th></th>
  </tr>
  @foreach ($incomp as $row)
        <tr>
            <td>{{ $row['LibelleEns1'] }}</td>
            <td>{{ $row['NiveauEns1'] }}</td>
            <td>{{ $row['LibelleEns2'] }}</td>
            <td>{{ $row['NiveauEns2'] }}</td>
            <td><form method="POST" action="{{route('subject.incompatibility.delete')}}">
                @csrf
                <input type="hidden" value="{{ $row['IdEns1'] }}" name="subject1">
                <input type="hidden" value="{{ $row['IdEns2'] }}" name="subject2">
                <button type="submit">Supprimer</button>
            </form></td>
        </tr>
    @endforeach
</table>
</div>

</div>

<script>
function filterSubject() {
  var select, filter, table, tr, td, i, txtValue;
  select = document.getElementById("mySelect");
  filter = select.value;
  table = document.getElementById("subjectTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue == filter || filter == "") {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
@endsection