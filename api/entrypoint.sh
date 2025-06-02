#!/bin/bash

echo "🚀 Aguardando o banco de dados ficar disponível..."

until pg_isready -h postgres -p 5432 -U "$POSTGRES_USER" > /dev/null 2>&1; do
  sleep 1
done

echo "✅ Banco de dados disponível. Instalando dependências..."
composer install --no-interaction

echo "📦 Rodando migrations via Phinx..."
composer migrate || echo "⚠️ Erro ao rodar migrations"

echo "📄 Geraando documentacao com Swagger..."
composer generate-swagger || echo "⚠️ Erro ao gerar Swagger"

echo "🔥 Iniciando servidor PHP embutido..."
exec php -S 0.0.0.0:8000 -t public
