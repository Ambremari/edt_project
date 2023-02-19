Pour réaliser les tests : 
php artisan config:cache --env=testing
php vendor/phpunit/phpunit/phpunit --testdox

Pour revenir en local : 
php artisan config:cache --env=local
