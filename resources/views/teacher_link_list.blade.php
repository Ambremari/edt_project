<input type="text" id="teacherInput" onkeyup="searchTeacher()" placeholder="Rechercher un enseignant...">
<ul id="teacherList">
    @foreach ($teachers as $row)
    <li><a href="{{route('link.subject.form', ['idProf' => $row['IdProf']])}}">{{ $row['NomProf'] }} {{ $row['PrenomProf'] }}</a></li>
    @endforeach
</ul>

<script>
function searchTeacher() {
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('teacherInput');
  filter = input.value.toUpperCase();
  ul = document.getElementById("teacherList");
  li = ul.getElementsByTagName('li');

  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("a")[0];
    txtValue = a.textContent || a.innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}
</script>