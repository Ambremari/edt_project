# Projet de Master CCI : Site web pour la gestion d'emplois du temps d'un collège

- Installation des dépendances du projet :
    ~~~
    composer install
    ~~~

- Création et alimentation de la base de données :
    ~~~
    php artisan db:seed
    ~~~

- Démarrage du serveur HTTP :
    ~~~
    php artisan serve
    ~~~

- Exécution des tests :
    ~~~
    php artisan config:cache --env=testing
    vendor/phpunit/phpunit/phpunit --testdox
    ~~~
- Revenir sur l'environnent local : 
    ~~~
    php artisan config:cache --env=local
    ~~~

Compatible avec Firefox, Brave

Non compatible avec Safari

