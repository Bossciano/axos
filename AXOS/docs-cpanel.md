# cPanel deployment

Recommended layout:

/home/CPANEL_USER/axos
/home/CPANEL_USER/public_html

Prefer setting the domain document root to:
/home/CPANEL_USER/axos/public

If your hosting cannot change document root, use a controlled public_html deployment and keep `.env`, `app`, `config`, `database`, `resources`, `routes`, and `storage` outside public_html.

Commands:
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan storage:link
php artisan optimize

Create:
storage/app/private/resumes

Cron, if scheduling is later added:
* * * * * cd /home/CPANEL_USER/axos && php artisan schedule:run >> /dev/null 2>&1
