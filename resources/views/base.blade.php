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
            <h3 style="float:right">
                Bienvenue <br>
                @if (session()->has('user'))
                        <form method="POST" action="{{route('logout.post')}}">
                            @csrf 
                                <button type="submit">Déconnexion</a>
                            </div>
                        </form>
                @else
                        <a href="/login">Connexion</a>
                @endif
            </h3>
        </div>
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
            <h2>@yield('title')</h2>
        <div>
        </div>
       <div class="content">
        @yield('content')
       </div>
    </body>
</html>