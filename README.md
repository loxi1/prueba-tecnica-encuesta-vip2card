# VIP2CARS --- Laravel + Docker

Proyecto de prueba técnica construido con **Laravel 11**, **MySQL
(MariaDB)**, **Nginx** y **Docker Compose**.

Incluye:

-   Laravel 11
-   PHP 8.3 (FPM)
-   Nginx
-   MariaDB
-   Node + Vite
-   Datos de demostración mediante Seeders

------------------------------------------------------------------------

# Requisitos

Tener instalado:

-   Docker
-   Docker Compose
-   Git

------------------------------------------------------------------------

# Levantar el proyecto

Clonar el repositorio:

``` bash
git clone https://github.com/loxi1/prueba-tecnica-encuesta-vip2card.git
cd prueba-tecnica-encuesta-vip2card
```

------------------------------------------------------------------------

# 1. Reiniciar contenedores (opcional pero recomendado)

Esto elimina contenedores y volúmenes para empezar limpio.

``` bash
docker compose down -v
```

------------------------------------------------------------------------

# 2. Levantar contenedores

``` bash
docker compose up -d --build
```

Esto iniciará:

-   app (PHP-FPM)
-   web (Nginx)
-   db (MariaDB)
-   node (Vite)

------------------------------------------------------------------------

# 3. Crear archivo .env

El repositorio ya incluye `.env.example`.

``` bash
cp src/.env.example src/.env
```

------------------------------------------------------------------------

# 4. Instalar dependencias PHP

``` bash
docker compose exec app composer install
```

------------------------------------------------------------------------

# 5. Permisos requeridos por Laravel

``` bash
docker compose exec app sh -lc '
mkdir -p bootstrap/cache storage/framework/{cache,sessions,views} storage/logs &&
chmod -R 775 bootstrap/cache storage &&
chown -R www-data:www-data bootstrap/cache storage 2>/dev/null || true
'
```

------------------------------------------------------------------------

# 6. Generar APP_KEY

``` bash
docker compose exec app php artisan key:generate
```

------------------------------------------------------------------------

# 7. Migraciones y Seeders

``` bash
docker compose exec app php artisan migrate:fresh --seed
```

Esto cargará datos de demostración.

------------------------------------------------------------------------

# 8. Compilar frontend

``` bash
docker compose exec node sh -lc "npm install && npm run build"
```

------------------------------------------------------------------------

# Acceder al sistema

Abrir en el navegador:

http://localhost:8080

------------------------------------------------------------------------

# Comandos útiles

Ver logs Laravel:

``` bash
docker compose exec app tail -n 100 storage/logs/laravel.log
```

Ver logs nginx:

``` bash
docker compose logs web
```

Resetear base de datos:

``` bash
docker compose exec app php artisan migrate:fresh --seed
```

------------------------------------------------------------------------

# Estructura del proyecto

    vip2cars/
    │
    ├── docker-compose.yml
    ├── README.md
    │
    └── src/
        ├── .env.example
        ├── app/
        ├── bootstrap/
        ├── database/
        ├── public/
        ├── resources/
        ├── routes/
        └── storage/

------------------------------------------------------------------------

# Datos demo

Administrador:

email: anibal.cayetano@gmail.com\
password: acme654123

------------------------------------------------------------------------

# Notas

-   `.env` NO se sube al repositorio
-   `.env.example` sí se versiona
-   El proyecto incluye seeders con datos de prueba
