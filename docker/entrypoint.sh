#!/usr/bin/env bash
set -euo pipefail

echo "▶ Virtual Tour — entrypoint.sh"

# Fail fast if APP_KEY is not set
if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is not set. Generate one with: php artisan key:generate --show" >&2
    exit 1
fi

# Run bootstrapping when starting the main app process (php-fpm or supervisor)
FIRST_ARG="${1:-}"
if [[ "$FIRST_ARG" = "php-fpm" || "$FIRST_ARG" = "supervisord" ]]; then
    echo "  → Waiting for database..."
    until php artisan db:show --no-interaction > /dev/null 2>&1; do
        echo "     database not ready, retrying in 3s..."
        sleep 3
    done
    echo "  → Database ready."

    echo "  → Running migrations..."
    php artisan migrate --force --no-interaction

    echo "  → Caching config, routes, views..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache

    echo "  → Linking storage..."
    php artisan storage:link --quiet 2>/dev/null || true

    echo "  → Clearing stale cache..."
    php artisan cache:clear
fi

# Railway injects $PORT dynamically — patch nginx to listen on it
if [ -n "${PORT:-}" ] && [ -f /etc/nginx/http.d/default.conf ]; then
    echo "  → Setting nginx port to ${PORT}..."
    sed -i "s/listen [0-9]*;/listen ${PORT};/" /etc/nginx/http.d/default.conf
fi

echo "  → Starting: $*"
exec "$@"
