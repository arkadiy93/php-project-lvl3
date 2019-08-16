install:
	composer install
lint:
	composer run-script phpcs
test:
	composer run-script phpunit
run:
	php -S localhost:8000 -t public
logs:
	tail -f storage/logs/lumen.log

.PHONY: test