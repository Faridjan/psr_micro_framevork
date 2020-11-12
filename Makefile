u-test:
	vendor/bin/phpunit
php-serve:
	php -S 0.0.0.0:8080 -t public public/index.php