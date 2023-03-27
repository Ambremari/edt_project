<!doctype html>
<html>
    <head>
        <title>@yield('title')</title>
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="header">
            <h3>Collège Jean Rachid</h3>
            <h1>Mon emploi du temps<h1>
            <h4 style="float:right; text-align: right">
                Bienvenue <br>
                @if (session()->has('user'))
                {{ session()->get('user')['firstname'] }} {{ session()->get('user')['name'] }}<br>
                Identifiant : {{ session()->get('user')['id'] }}<br>
                    <form method="POST" action="{{route('logout.post')}}">
                        @csrf
                            <button class="header_button" type="submit">Déconnexion</button>
                    </form>
                @else
                        <a href="/login">Se connecter</a>
                @endif
            </h4>
        </div>
        @if (session()->has('user') && session()->get('user')['role'] == 'dir')
        <div class="topnav">
            <div class="dropdown">
                <span><a href="#">Base Elèves et Enseignants</a></span>
                <div class="dropdown-content">
                    <div class="dropdown-sub">
                        <a href="#">Elèves</a>
                        <div class="dropdown-subcontent">
                            <a href="{{route('student.form')}}">Saisie</a>
                            <a href="{{route('student.update.list')}}">Modification</a>
                            <a href="{{route('student.option')}}">Scolarité</a>
                            <a href="{{route('students.show')}}">Fiches</a>
                        </div>
                    </div>
                    <div class="dropdown-sub">
                        <a href="#">Enseignants</a>
                        <div class="dropdown-subcontent">
                            <a href="{{route('teacher.form')}}">Saisie</a>
                            <a href="{{route('teacher.update.list')}}">Modification</a>
                            <a href="{{route('teachers.show')}}">Fiches</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <span><a href="#">Structure</a></span>
                <div class="dropdown-content">
                    <a href="{{route('division.form')}}">Divisions</a>
                    <a href="{{route('group.form')}}">Groupes</a>
                    <div class="dropdown-sub">
                        <a href="#">Affectation</a>
                        <div class="dropdown-subcontent">
                            <a href="{{route('division.fill.form')}}">Divisions</a>
                            <a href="{{route('group.fill.form')}}">Groupes</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown">
                <span><a href="{{route('subjects.show')}}">Enseignements</a></span>
                <div class="dropdown-content">
                    <a href="{{route('subjects.form')}}">Création</a>
                    <a href="{{route('link.subject')}}">Affectation</a>
                </div>
            </div>

            <div class="dropdown">
                <span><a href="#">Etablissement</a></span>
                <div class="dropdown-content">
                    <a href="{{route('classroom.form')}}">Infrastructures</a>
                    <a href="{{ route('schedule.show')}}">Horaires</a>
                    <a href="{{ route('info.show')}}">Fiche établissement</a>
                </div>
            </div>

            <div class="dropdown">
                <span><a href="#">Emploi du temps</a></span>
                <div class="dropdown-content">
                    <a href="{{ route('subjects.constraints') }}">Contraintes horaires</a>
                    <a href="{{ route('subject.incompatibility') }}">Incompatibilités des enseignements</a>
                    <a href="{{ route('constraints.classrooms') }}">Contraintes matérielles</a>
                    <a href="{{ route('data.preprocess') }}">Pré-traitement</a>
                    <a href="#">Génération automatique</a>
                    <a href="{{ route('planning.show') }}">Modification manuelle</a>
                    <a href="#">Optimisation</a>
                </div>
            </div>
        </div>
        @endif

        @if (session()->has('user') && session()->get('user')['role'] == 'prof')
        <div class="topnav">
            <div class="dropdown">
                <span><a href="{{route('planning.teacher')}}">Mon Emploi du Temps</a></span>
            </div>
            <div class="dropdown">
                <span><a href="{{route('prof.constraints')}}">Mes Contraintes</a></span>
            </div>
            </div>
        @endif

        @if (session()->has('user') && session()->get('user')['role'] == 'student')
        <div class="topnav">
            <div class="dropdown">
                <span><a href="{{route('planning.student')}}">Mon Emploi du Temps</a></span>
            </div>
            </div>
        @endif
            <h2>@yield('title')</h2>
        <div>
        </div>
       <div class="content">
        @yield('content')
       </div>

       <script>
function openPage(pageName,elmnt) {
  var i, tabcontent;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = "#F7D5D5";
}
</script>
    </body>

</html>
