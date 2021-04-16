ci:
	vendor/bin/phpunit
	vendor/bin/phpstan analyse -c phpstan.neon --memory-limit=256M
	vendor/bin/ecs check --config vendor/landingi/php-coding-standards/ecs.php
fix:
	vendor/bin/ecs check --fix --config vendor/landingi/php-coding-standards/ecs.php
analyze:
	vendor/bin/ecs check --config vendor/landingi/php-coding-standards/ecs.php
	vendor/bin/phpstan analyze -c phpstan.neon
unit:
	vendor/bin/phpunit
