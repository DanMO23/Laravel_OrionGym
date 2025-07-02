#!/bin/bash
set -e

# Executa migrations (opcional, remova se não quiser rodar sempre)
php artisan migrate --force || true

# Inicia o servidor Laravel
php artisan serve --host=0.0.0.0 --port=8000
