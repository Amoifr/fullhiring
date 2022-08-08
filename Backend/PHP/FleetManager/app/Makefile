.DEFAULT_GOAL:=help

REGEX = '(?<=\DB_VOLUME_NAME=)[a-zA-Z0-9\._-]*'
VOLUME := $(shell cat docker/.env | grep -oP ${REGEX})

.PHONY: domidi
domidi:
	php bin/console doctrine:migration:diff

.PHONY: domimi
domimi:
	php bin/console doctrine:migration:migrate

.PHONY: cc
cc:
	php bin/console cache:clear

.PHONY: crud
crud:
	php bin/console make:admin:crud

.PHONY: entity
entity:
	php bin/console make:entity

.PHONY: fixtures
fixtures:
	php -d memory-limit=-1 bin/console doctrine:fixtures:load

.PHONY: translate
translate:
	php bin/console translation:extract --force --format=yaml --sort=asc --as-tree=8 fr

.PHONY: phpcsfixer
phpcsfixer:
	php ./vendor/bin/php-cs-fixer fix

.PHONY: phpstan
phpstan:
	php ./vendor/bin/phpstan analyse src tests --memory-limit=-1 --level=6

.PHONY: watch
watch:
	npm run watch