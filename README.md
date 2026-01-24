## If `composer.lock` file changes (add, update or remove package -> e.g., `composer require some/package`)
## Go to SSH and manually run
`
cd /domains/whitesmoke-spoonbill-547959.hostingersite.com/public_html
git pull origin main
composer install --no-dev --optimize-autoloader --ignore-platform-reqs  # ← Only this time
php artisan config:cache
php artisan route:cache
php artisan view:cache
`
