# Bitcoin Poker Dice

Legacy Poker Dice and Video Poker web application built with AngularJS
and a PHP/CodeIgniter backend. Bitcoin was originally used for wagering.

This repository now includes a dockerised development stack so the
project can run on modern machines without juggling PHP versions or
manual database setup.

## Prerequisites

- Docker 24+ and Docker Compose plugin
- Git (to fetch Bower dependencies inside the container)

## Quick start

```bash
cp env.example .env
docker compose up --build -d
docker compose exec web npm install   # installs legacy build tooling (optional)
```

Open http://localhost:8080 in your browser. The application boots in
demo mode by default, so wagers and withdrawals stay local.

On first visit the backend issues a fresh GUID and account. Keep the
full URL (including the `/u/{guid}` path) bookmarked if you want to
return to the same wallet.

## Project structure

- `application/` – CodeIgniter 2 backend (controllers, models, views)
- `assets/` – AngularJS 1.2 front-end source
- `docker-compose.yml` – PHP 7.4 + MySQL 5.7 dev environment
- `docker/mysql/init/bitzee.sql` – schema imported automatically during the first MySQL start
- `Gruntfile.js` & `package.json` – legacy front-end build tooling (optional)

## Environment configuration

The backend reads database and Bitcoin settings from environment
variables. Update `.env` before running `docker compose up` if you need
different credentials.

Key variables:

- `APP_BASE_URL` – public URL for generated links
- `DB_*` – database connection settings
- `GAME_DEMO_MODE` – `true` keeps the site in demo mode (no outgoing BTC calls)

## Useful commands

```bash
docker compose logs -f web         # follow PHP/Apache logs
docker compose exec web php -m     # list installed PHP extensions
docker compose down                # stop and remove containers
```

## Notes

- The MySQL container seeds itself from `bitzee.sql` the first time it
  starts. Subsequent restarts reuse the persisted volume.
- Front-end vendor libraries are loaded over trusted CDNs; no local Bower
  install is required.
- Bitcoin RPC credentials default to harmless placeholders. Provide
  real values only if you plan to connect to a live wallet.
