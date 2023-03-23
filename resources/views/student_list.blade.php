<input type="text" id="studentInput" onkeyup="searchStudent()" placeholder="Rechercher un élève...">
<ul id="studentList">
    @foreach ($students as $row)
    <li><a href="{{route('student.update.form', ['id' => $row['IdEleve']])}}">{{ $row['NomEleve'] }} {{ $row['PrenomEleve'] }}</a></li>
    @endforeach
</ul>
<script>
function searchStudent() {
  var input, filter, ul, li, a, i, txtValue;
  input = document.getElementById('studentInput');
  filter = input.value.toUpperCase();
  ul = document.getElementById("studentList");
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
