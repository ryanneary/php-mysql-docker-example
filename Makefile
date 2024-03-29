include .env

help: ## Show the help command
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

web: ## Navigate to the web container (via Bash) as the root user
	docker-compose exec web bash

mysql: ## Navigate to the mysql container as the root user
	docker-compose exec mysql mysql -p"$(MYSQL_ROOT_PASSWORD)"

destroy: ## Destroy the containers
	docker-compose down
	docker-compose stop
	docker-compose rm -f

clean: destroy ## Destroy the containers, and build new ones
	docker-compose up --build -d

up: ## Start the containers, if you have already built them (e.g. if you restart your machine).
	docker-compose up -d

logs-web: ## View the logs for the web container
	docker-compose logs web

logs-mysql: ## View the logs for the mysql container
	docker-compose logs mysql