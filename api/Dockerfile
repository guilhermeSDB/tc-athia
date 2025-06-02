FROM php:8.4-cli

# Instalar extensões necessárias + postgresql-client (pg_isready)
RUN apt-get update && apt-get install -y \
libpq-dev \
postgresql-client \
unzip \
zip \
git \
curl \
&& docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos e instalar dependências
COPY . .
RUN composer install

# Copiar entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Usar entrypoint
ENTRYPOINT ["/entrypoint.sh"]

# Expor porta
EXPOSE 8000

# Comando de inicialização
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
