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
                Identifiant : {{ session()->get('user')['id'] }}
                    <form method="POST" action="{{route('logout.post')}}">
                        @csrf 
                            <button class="header_button" type="submit">Déconnexion</a>
                        </div>
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
                        <a href="#">Saisie</a>
                        <div class="dropdown-subcontent">
                            <a href="{{route('teacher.form')}}">Enseignants</a>
                            <a href="#">Elèves</a>
                        </div>
                    </div>
                    <div class="dropdown-sub">
                        <a href="#">Modification</a>
                        <div class="dropdown-subcontent">
                            <a href="#">Enseignants</a>
                            <a href="#">Elèves</a>
                        </div>
                    </div>
                    <div class="dropdown-sub">
                        <a href="#">Fiches</a>
                        <div class="dropdown-subcontent">
                            <a href="#">Enseignants</a>
                            <a href="#">Elèves</a>
                        </div>
                    </div>
                </div>    
            </div>

            <div class="dropdown">
                <span><a href="#">Structure</a></span>
                <div class="dropdown-content">
                    <a href="#">Divisions</a>
                    <a href="#">Groupes</a>
                    <a href="#">Affectation</a>
                </div>    
            </div>

            <div class="dropdown">
                <span><a href="#">Enseignements</a></span>
                <div class="dropdown-content">
                    <a href="#">Création</a>
                    <a href="#">Affectation</a>
                </div>    
            </div>

            <div class="dropdown">
                <span><a href="#">Etablissement</a></span>
                <div class="dropdown-content">
                    <a href="#">Infrastructures</a>
                    <a href="#">Horaires</a>
                    <a href="#">Fiche établissement</a>
                </div>    
            </div>

            <div class="dropdown">
                <span><a href="#">Emploi du temps</a></span>
                <div class="dropdown-content">
                    <a href="#">Contraintes horaires</a>
                    <a href="#">Contraintes matérielles</a>
                    <a href="#">Pré-traitement</a>
                    <a href="#">Génération automatique</a>
                    <a href="#">Modification manuelle</a>
                    <a href="#">Optimisation</a>
                </div>    
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