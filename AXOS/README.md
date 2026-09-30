# AXOS Job Portal

A reconstructed, cPanel-friendly Laravel 12 job portal based on the AXOS specification.

## Included
- Employer and Job Seeker accounts
- Admin role
- Employer company profiles and logos
- Job posting, editing, closing and searching
- Applications and applicant review
- Private resume upload/download
- Database notifications
- Dashboards
- AXOS dark UI and logo
- Security middleware, validation and rate limiting
- Health endpoint
- cPanel deployment notes

## Install
1. Upload the project to your cPanel account.
2. Run `composer install --no-dev --optimize-autoloader`.
3. Copy `.env.example` to `.env`.
4. Set database credentials and APP_URL.
5. Run `php artisan key:generate`.
6. Run `php artisan migrate --force`.
7. Run `php artisan storage:link`.
8. Make `storage` and `bootstrap/cache` writable.
9. Run `php artisan optimize`.
10. Point the domain document root to the project's `public` directory.

## Important
This is a reconstructed application generated from the AXOS requirements, not a recovered copy of a previous source repository.
