# Production deployment (Minimal Maison)

This repository ships a **local development** stack. Production uses the same services with overrides — not a separate architecture.

## Files

| File | Purpose |
|------|---------|
| `docker-compose.yml` | Base stack (nginx, wordpress, mysql) |
| `docker-compose.prod.yml` | Production overrides (debug off, MailHog/phpMyAdmin disabled) |
| `.env.production` | Secrets and URLs (copy from `.env.production.example`, **gitignored**) |
| `nginx/conf.d/` | Local HTTP vhost (dev-friendly PHP routing) |
| `nginx/conf.d/production/` | **Future:** TLS, `server_name`, stricter nginx rules |

## Recommended production flow

1. Copy `.env.production.example` → `.env.production` and set strong passwords.
2. Create `nginx/conf.d/production/default.conf` with TLS, real `server_name`, and tighter rules (uploads PHP deny, sensitive files, optional PHP whitelist).
3. Mount production nginx config in `docker-compose.prod.yml` (commented example included).
4. Start:

   ```bash
   docker compose --env-file .env.production \
     -f docker-compose.yml -f docker-compose.prod.yml up -d
   ```

## What to change vs local dev

- `WP_ENVIRONMENT_TYPE=production`, all `WP_DEBUG_*` false
- `FORCE_SSL_ADMIN=true`, real `WP_HOME` / `WP_SITEURL` (HTTPS)
- No public MySQL port (already internal-only)
- No phpMyAdmin or MailHog on public networks
- Real SMTP (not MailHog)
- Unique `WP_CACHE_KEY_SALT`
- Optional later: Redis service, PHP redis extension, object cache plugin

## Nginx separation

Keep **development** and **production** vhosts in separate directories:

```
nginx/
├── conf.d/default.conf          # local :8080, no-cache assets, permissive PHP
└── conf.d/production/           # HTTPS + stricter rules when deploying
    └── default.conf
```

## WooCommerce

Use the same `wordpress` image (PHP 8.3 + extensions). Ensure production cron is handled (system cron or `wp-cron.php`).
