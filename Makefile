default: help

help:
	@echo "Usage:"
	@echo "     make [command]"
	@echo "Available commands:"
	@fgrep -h "##" $(MAKEFILE_LIST) | fgrep -v fgrep | sed -e 's/\\$$//' | sed -e 's/##//'

install: ## Install dependencies and run migrations
	$(MAKE) composer
	$(MAKE) database-migrate
	bin/console messenger:setup-transports

install-fresh: ## Install dependencies, Destroy and create database, run migrations and load fixtures, Generating holidays for 2020
	$(MAKE) composer
	bin/console doctrine:database:drop --force --if-exists --env=dev
	bin/console doctrine:database:create --env=dev
	bin/console messenger:setup-transports
	$(MAKE) database-migrate
	$(MAKE) database-load-fixtures
	bin/console generate:holidays

composer: ## Install dependencies
	composer install

database-migrate: ## Run migrations
	bin/console doctrine:migrations:migrate --no-interaction --env=dev

database-load-fixtures: ## Load fixtures
	bin/console doctrine:fixtures:load --no-interaction --env=dev

