install:
	composer install
	php -r "file_exists('.env') || copy('.env.example', '.env');"
	php artisan key:generate
	php artisan storage:link
	php artisan div:init-env
	php artisan migrate
	php artisan make:filament-user
	php artisan shield:super-admin --user=1
	php artisan shield:generate --all --option=permissions