# aislagratis

Plataforma Laravel para la gestion de solicitudes de aislamiento de aticos y bajo cubierta, servicios, citas e instalaciones. Incluye un sitio publico, portal de clientes, paneles internos y API versionada.

## Funcionalidades

- Solicitudes de estudio y seguimiento comercial.
- Gestion de servicios, areas de cobertura y preguntas frecuentes.
- Portal de clientes con verificacion de correo, inmuebles, citas e instalaciones.
- Paneles de administracion, ventas y tecnicos con permisos por rol.
- API Sanctum en `/api/v1`; las rutas protegidas requieren una cuenta activa y correo verificado.
- Metadatos SEO, sitemap XML dinamico, robots.txt dinamico y soporte PWA.

## Requisitos

- PHP 8.2 o superior y extensiones requeridas por Laravel.
- Composer 2.
- Node.js 20 LTS o superior y npm.
- MySQL o MariaDB para produccion. SQLite es adecuado para desarrollo y pruebas.

## Desarrollo local

En PowerShell, desde la raiz del proyecto:

```powershell
Copy-Item .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
npm ci
npm run build
php artisan storage:link
php artisan serve
```

Abre `http://127.0.0.1:8000`. Para MySQL/MariaDB, configura `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` en `.env` antes de migrar. La base SQLite local, los archivos `.env`, los logs, las dependencias y los assets compilados estan excluidos de Git.

## Configuracion

La configuracion local y los secretos deben permanecer en `.env` o en el gestor de variables del servidor; nunca los guardes en el repositorio. En produccion configura como minimo:

- `APP_ENV=production`, `APP_DEBUG=false` y `APP_URL=https://tu-dominio`.
- `APP_KEY` unico y generado para ese entorno.
- Credenciales de base de datos y SMTP propias de produccion.
- `SESSION_SECURE_COOKIE=true` y HTTPS activo.

La URL publica correcta es necesaria para generar enlaces absolutos, etiquetas canonicas, robots.txt y sitemap.xml. Revisa las etiquetas SEO y registra el sitemap publicado (`https://tu-dominio/sitemap.xml`) en Google Search Console y Bing Webmaster Tools despues de configurar el dominio.

Las cuentas demo estan desactivadas por defecto. Para desarrollo local, define `SEED_DEMO_USERS=true` y contrasenas unicas en el `.env` privado antes de ejecutar:

```powershell
php artisan db:seed --class=DatabaseSeeder
```

No ejecutes usuarios demo ni contrasenas de desarrollo en produccion.

## Pruebas y compilacion

```powershell
php artisan test
vendor/bin/pint --test app routes
composer validate --strict
npm ci
npm run build
```

GitHub Actions ejecuta las pruebas, valida `composer.json` y compila los assets al abrir un pull request o actualizar `main`.

## Despliegue en Hostinger

1. Comprueba en hPanel que el plan permite Laravel y PHP 8.2+, Composer y las extensiones PHP necesarias. Crea una base MySQL/MariaDB y un usuario con permisos limitados.
2. Despliega el repositorio fuera del directorio publico del sitio cuando sea posible. Configura el document root del dominio para que apunte exclusivamente al subdirectorio `public/` de Laravel. No expongas la raiz del proyecto, `.env`, `vendor/`, `storage/` ni `database/` por HTTP.
3. Crea el `.env` de produccion en el servidor (no lo subas a Git) con el dominio HTTPS, `APP_DEBUG=false`, una `APP_KEY` propia, datos de MySQL y los datos SMTP reales.
4. Instala y compila dependencias en el servidor si el plan proporciona Composer y Node.js:

   ```sh
   composer install --no-dev --prefer-dist --optimize-autoloader
   npm ci
   npm run build
   php artisan migrate --force
   php artisan storage:link
   php artisan optimize
   ```

   Si el plan no ofrece Node.js, ejecuta `npm ci` y `npm run build` localmente y transfiere el directorio generado `public/build/` por SFTP durante el despliegue. No es necesario versionar dependencias ni assets generados.
5. Asegura que el usuario de PHP pueda escribir en `storage/` y `bootstrap/cache/`; antes de ejecutar migraciones, crea una copia de seguridad de la base de datos.
6. Activa SSL/HTTPS en hPanel, establece `SESSION_SECURE_COOKIE=true` y confirma que las peticiones llegan a `public/index.php` mediante las reglas Apache incluidas.
7. Comprueba la pagina principal, inicio de sesion, formularios, envio de correo, enlaces de assets, `/robots.txt` y `/sitemap.xml`. Configura cron y un supervisor solo si habilitas tareas programadas o colas.

Los nombres de menus, rutas y opciones disponibles pueden variar entre planes de Hostinger. Sigue la documentacion de hPanel para apuntar el dominio a `public/`; si tu plan no permite configurar un document root personalizado, no muevas la raiz Laravel a `public_html` ni expongas sus archivos: consulta con Hostinger una configuracion segura antes de desplegar.

## API

- `POST /api/v1/auth/register`: crea una cuenta sin emitir token y envia enlace de verificacion.
- `POST /api/v1/auth/verification-notification`: reenvia el enlace sin revelar si el correo existe.
- `POST /api/v1/auth/login`: emite un token solo para cuentas activas y verificadas.
- Las rutas de perfil, solicitudes y notificaciones requieren Sanctum, correo verificado y cuenta activa.

## Licencia

No se incluye un archivo de licencia. El uso, la copia y la redistribucion del codigo no se conceden automaticamente; solicita autorizacion al titular antes de reutilizarlo.
