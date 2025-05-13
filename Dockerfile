# Dockerfile para o container PHP-FPM (sem Apache)
FROM php:8.1-fpm

# Instala dependências necessárias
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql zip bcmath

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia os arquivos do projeto
COPY . /var/www

# Define permissões
RUN chown -R www-data:www-data /var/www
