php-serve:
	php -S 0.0.0.0:8080 -t public public/index.php
u-test:
	vendor/bin/phpunit
cs-check:
	vendor/bin/phpcs
cs-fix:
	vendor/bin/phpcbf
mock-var:
	mkdir -p var/log && mkdir -p var/twig && mkdir -p var/db
