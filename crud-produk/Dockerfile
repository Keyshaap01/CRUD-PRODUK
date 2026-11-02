FROM php:8.3-fpm-alpine

RUN apk add --no-cache nginx supervisor \
    && docker-php-ext-install pdo_mysql \
    && mkdir -p /run/nginx /var/log/supervisor /var/www/html

WORKDIR /var/www/html
COPY . /var/www/html/
COPY deploy/nginx.conf /etc/nginx/http.d/default.conf
COPY deploy/supervisord.conf /etc/supervisord.conf

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
