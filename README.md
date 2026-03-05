# VIP2CARS --- Levantar el proyecto

Este proyecto está construido con **Laravel** y se ejecuta usando
**Docker**.\
El repositorio **ya incluye el archivo `.env.example`**, por lo que solo
es necesario copiarlo para crear el `.env`.

------------------------------------------------------------------------

# 1. Levantar el proyecto

Clonar el repositorio y entrar al directorio:

``` bash
git clone https://github.com/loxi1/prueba-tecnica-encuesta-vip2card
cd prueba-tecnica-encuesta-vip2card
```

------------------------------------------------------------------------

# 2. Crear archivo `.env`

El proyecto ya contiene `.env.example`.\
Solo debes copiarlo:

``` bash
cp src/.env.example src/.env
```

------------------------------------------------------------------------

# 3. Levantar contenedores Docker

``` bash
docker compose up -d --build
```

Esto levantará:

-   PHP / Laravel
-   Nginx
-   Base de datos (si está configurada)
-   Contenedor Node para assets

------------------------------------------------------------------------

# 4. Generar APP_KEY

Laravel requiere una clave de aplicación.

``` bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
```

------------------------------------------------------------------------

# 5. Crear la base de datos

Ejecutar migraciones y seeders:

``` bash
docker compose exec app php artisan migrate:fresh --seed
```

------------------------------------------------------------------------

# 6. Compilar assets (Tailwind / Vite)

``` bash
docker compose up -d node
docker compose exec node sh -lc "npm install && npm run build"
docker compose stop node
```

------------------------------------------------------------------------

# 7. Limpiar cache de Laravel

``` bash
docker compose exec app php artisan optimize:clear
```

------------------------------------------------------------------------

# 8. Acceder al proyecto

Abrir en el navegador:

    http://localhost

------------------------------------------------------------------------

# Estructura relevante del proyecto

    vip2cars/
    │
    ├── docker-compose.yml
    ├── README.md
    │
    └── src/
        ├── .env.example
        ├── .env
        ├── artisan
        ├── app/
        ├── database/
        └── routes/

------------------------------------------------------------------------

# Notas importantes

-   `.env.example` **sí se sube al repositorio**
-   `.env` **NO debe subirse a Git**
-   `APP_KEY` se genera al levantar el proyecto
-   Las migraciones crean las tablas necesarias del sistema
# prueba-tecnica-encuesta-vip2card
