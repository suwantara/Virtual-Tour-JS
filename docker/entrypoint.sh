#!/usr/bin/env bash
set -euo pipefail

echo "▶ Virtual Tour — entrypoint.sh"

# Fail fast if APP_KEY is not set — running without it is insecure
if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY is not set. Generate one with: php artisan key:generate --show" >&2
    exit 1
fi

# Only run bootstrapping when starting the main app (not queue/scheduler)
if [ "${1:-}" = "php-fpm" ]; then
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

echo "  → Starting: $*"
exec "$@"
