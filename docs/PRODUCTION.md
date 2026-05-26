# Production deployment (Minimal Maison)

This repository ships a **local development** stack. Production uses the same services with overrides — not a separate architecture.

## Files

| File | Purpose |
|------|---------|
| `docker-compose.yml` | Base stack (nginx, wordpress, mysql, redis) |
| `docker-compose.prod.yml` | Production overrides (debug off, MailHog/phpMyAdmin disabled) |
| `.env.production` | Secrets and URLs (copy from `.env.production.example`, **gitignored**) |
| `nginx/conf.d/` | Local HTTP vhost |
| `nginx/conf.d/production/` | **Future:** TLS, `server_name`, stricter limits (keep dev config separate) |

## Recommended production flow

1. Copy `.env.production.example` → `.env.production` and set strong passwords.
2. Set `REDIS_PASSWORD` and enable Redis `requirepass` (see TODO in `docker-compose.yml` redis service).
3. Create `nginx/conf.d/production/default.conf` with:
   - `listen 443 ssl http2`
   - Real certificates (Let’s Encrypt or provider)
   - `server_name` for your domain
   - Same security locations as `nginx/conf.d/default.conf` (XML-RPC, uploads PHP block, sensitive files, PHP whitelist)
4. Mount production nginx config in `docker-compose.prod.yml` (commented example included).
5. Start:

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
- Unique `WP_CACHE_KEY_SALT` and `REDIS_PASSWORD`
- Restrict who can reach phpMyAdmin if you ever enable it (VPN / SSH tunnel only)

## Nginx separation

Keep **development** and **production** vhosts in separate directories so local changes never break TLS or domain rules:

```
nginx/
├── conf.d/default.conf          # local :8080
└── conf.d/production/           # add when deploying (not required for local dev)
    └── default.conf             # HTTPS, production server_name
```

## WooCommerce

No compose changes required — use the same `wordpress` image (PHP 8.3 + extensions). Ensure production cron is handled (system cron calling `wp cron event run` or traffic to `wp-cron.php`).
