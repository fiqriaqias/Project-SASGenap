FROM php:8.2-cli

COPY . /var/www/html/
WORKDIR /var/www/html

# Railway membutuhkan aplikasi berjalan di port yang dinamis via $PORT
CMD ["sh", "-c", "php -S 0.0.0.0:$PORT -t /var/www/html"]