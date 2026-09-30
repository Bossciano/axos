# AXOS Production Checklist

## Before deployment
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set real `APP_URL`
- [ ] Configure MySQL credentials
- [ ] Generate `APP_KEY`
- [ ] Enable HTTPS
- [ ] Set `SESSION_SECURE_COOKIE=true`
- [ ] Run migrations with `--force`
- [ ] Run `storage:link`
- [ ] Create `storage/app/private/resumes`
- [ ] Verify private resumes are not publicly accessible
- [ ] Run `php artisan optimize`

## Functional QA
- [ ] Employer registration/login
- [ ] Employer profile/logo
- [ ] Create/edit/close job
- [ ] Public search/filter
- [ ] Job seeker profile
- [ ] Resume upload
- [ ] Application submission
- [ ] Duplicate application prevention
- [ ] Employer applicant review
- [ ] Status changes
- [ ] Notifications
- [ ] Admin access
- [ ] Unauthorized URL access returns 403
- [ ] Expired/closed jobs cannot receive applications
- [ ] Mobile layout

## cPanel
- [ ] Domain document root points to `public`
- [ ] PHP 8.2+
- [ ] Composer dependencies installed
- [ ] `storage` and `bootstrap/cache` writable
- [ ] Database connection verified
- [ ] SSL active
- [ ] Cron configured if scheduler is used

## Important
Do not commit `.env`, private resumes, database dumps, or credentials.
