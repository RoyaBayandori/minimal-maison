.PHONY: up down build logs shell wp backup install-lang

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build --no-cache wordpress

logs:
	docker compose logs -f

shell:
	docker compose exec wordpress bash

wp:
	docker compose run --rm wpcli $(filter-out $@,$(MAKECMDGOALS))

backup:
	bash docker/scripts/backup-db.sh

install-lang:
	docker compose run --rm wpcli language core install fa_IR --activate

%:
	@:
