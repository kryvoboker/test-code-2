up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose build

restart:
	docker compose down && docker compose up -d

vite:
	cd httpdocs && npm run dev

vite-build:
	cd httpdocs && npm run build