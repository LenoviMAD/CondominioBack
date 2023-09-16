## Para utilizar la API localmente

<h1> Asegurarse antes de correr el proyecto</h1>
- Tener laragon instalado
- la version de php instalada es 7.4.20
- Activar las extenciones de php --pgsql y --pdo.pgsql
- Tener instalado postgres III.
- Crear una BD en postgres llamada 'apiCondominio'.

-   Al clonar por primera vez el repositorio, correr el comando --composer install

-   Para correr migraciones se usa el comando --php artisan migrate.
-   Para correr las seeds usar --php artisan db:seed.
-   Para levantar la API usar --php artisan serve.

-   Las rutas de la API estan en routes/api.php
