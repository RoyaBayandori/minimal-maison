# Minimal Maison

Production-grade Docker development environment for **Minimal** — a luxury custom WordPress + WooCommerce site (Persian RTL, Iran).

Stack: **nginx** + **PHP 8.3 FPM** + **MySQL 8** + **Redis** + **phpMyAdmin** + **MailHog**. No Apache.

## Project structure

```
minimal-maison/
├── docker/
│   ├── php/                 # Custom WordPress PHP-FPM image (Redis, WooCommerce extensions)
│   ├── mysql/               # MySQL tuning (utf8mb4 / Persian)
│   ├── wordpress/           # wp-config-extra.php
│   └── scripts/             # backup-db.sh
├── nginx/
│   ├── nginx.conf           # Global nginx + rate limit zones
│   ├── conf.d/              # WordPress vhost
│   └── snippets/            # Shared FastCGI params
├── wordpress/
│   └── wp-content/          # Mounted separately (themes, plugins, uploads)
├── logs/                    # nginx & PHP logs
├── backups/                 # MySQL dumps
├── docker-compose.yml
├── docker-compose.prod.yml   # Production overrides (stub)
├── docs/PRODUCTION.md
├── .env.example
├── .env.production.example
└── Makefile
```

## Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or Docker Engine + Compose v2)
- 4 GB+ RAM recommended

## Quick start

1. **Clone and configure environment**

   ```bash
   cp .env.example .env
   # Edit passwords in .env if needed
   ```

2. **Build and start**

   ```bash
   docker compose build
   docker compose up -d
   ```

   Or with Make:

   ```bash
   make build
   make up
   ```

3. **Open WordPress**

   | Service     | URL                          |
   |-------------|------------------------------|
   | Site        | http://localhost:8080        |
   | phpMyAdmin  | http://localhost:8081        |
   | MailHog UI  | http://localhost:8025        |

4. **Complete the WordPress installer** in the browser (database credentials are pre-filled via Docker).

5. **Install Persian language (optional)**

   ```bash
   make install-lang
   ```

6. **Activate the Minimal Maison theme** under Appearance → Themes.

## WP-CLI

```bash
# Examples
make wp plugin install woocommerce --activate
make wp plugin install redis-cache --activate
make wp redis enable
make wp option update blogname "مینیمال"
```

Or directly:

```bash
docker compose run --rm wpcli plugin list
```

## Debug mode

Controlled only via `.env` (never hard-coded):

```env
WP_DEBUG=true
WP_DEBUG_LOG=true
WP_DEBUG_DISPLAY=false
```

Restart WordPress after changes:

```bash
docker compose up -d wordpress
```

Logs: `wordpress/wp-content/debug.log` (when `WP_DEBUG_LOG` is true).

## Redis object cache

1. Install the [Redis Object Cache](https://wordpress.org/plugins/redis-cache/) plugin.
2. Enable: `make wp redis enable`
3. Constants `WP_REDIS_*` are set in `docker/wordpress/wp-config-extra.php`.

## WooCommerce

PHP extensions (gd, zip, intl, bcmath, etc.) are included in the custom image. Install WooCommerce via WP-CLI or the admin, then build your custom theme with `add_theme_support( 'woocommerce' )` (already stubbed in the theme).

## Email (MailHog)

Configure [WP Mail SMTP](https://wordpress.org/plugins/wp-mail-smtp/) (or similar) for local dev:

| Setting | Value    |
|---------|----------|
| Host    | `mailhog` |
| Port    | `1025`   |
| Encryption | None  |
| Auth    | Off      |

View captured mail at http://localhost:8025.

## Database backup

```bash
make backup
# → backups/mysql/minimal_maison_YYYYMMDD_HHMMSS.sql.gz
```

## Security (nginx + WordPress)

- Directory listing disabled (`autoindex off`)
- XML-RPC blocked (nginx + mu-plugin)
- Sensitive files blocked (`.env`, `wp-config.php`, etc.)
- PHP execution blocked in **`uploads/` only**; other PHP uses a core/admin whitelist
- Rate limiting on `wp-login.php` and `wp-admin` PHP
- `server_tokens off`, security headers
- MySQL not exposed on host ports (phpMyAdmin uses internal `mysql:3306`)

## Persistent volumes

| Volume            | Purpose              |
|-------------------|----------------------|
| `mm_wordpress_data` | WordPress core files |
| `mm_mysql_data`     | Database             |
| `mm_redis_data`     | Redis AOF            |

`wp-content` is bind-mounted from `./wordpress/wp-content` for version control of themes/plugins.

## Stop / reset

```bash
docker compose down          # stop containers
docker compose down -v       # ⚠️ also removes volumes (fresh DB & core)
```

## Production

Local dev only by default. For production preparation see **[docs/PRODUCTION.md](docs/PRODUCTION.md)**:

- `docker-compose.prod.yml` — disables MailHog/phpMyAdmin, forces production debug off
- `.env.production.example` → copy to `.env.production` (gitignored)
- `nginx/conf.d/production/` — separate TLS vhost when you deploy

```bash
docker compose --env-file .env.production \
  -f docker-compose.yml -f docker-compose.prod.yml up -d
```

---


**Minimal Maison** — custom luxury jewelry, built for scale.
