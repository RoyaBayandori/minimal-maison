#!/usr/bin/env bash
# Dump MySQL database to backups/mysql/
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$ROOT"

# shellcheck disable=SC1091
source .env 2>/dev/null || true

STAMP="$(date +%Y%m%d_%H%M%S)"
OUT="backups/mysql/${MYSQL_DATABASE:-minimal_maison}_${STAMP}.sql.gz"

mkdir -p backups/mysql

docker compose exec -T mysql mysqldump \
  -u root \
  -p"${MYSQL_ROOT_PASSWORD}" \
  --single-transaction \
  --quick \
  "${MYSQL_DATABASE}" | gzip > "$OUT"

echo "Backup written: $OUT"
