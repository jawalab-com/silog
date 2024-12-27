FROM dunglas/frankenphp:1.3.6

WORKDIR /var/www/html

COPY . .

RUN apt-get update && apt-get install -y \
    zip unzip curl git libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo_mysql gd bcmath opcache \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader \
    && npm install && npm run build

CMD ["frankenphp", "-F", "server.frankenphp.yaml"]
