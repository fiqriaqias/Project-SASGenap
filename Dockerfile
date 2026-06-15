FROM php:8.2-apache

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

# Tambahkan baris ini untuk mematikan mpm_event dan mengaktifkan mpm_prefork
RUN a2dismod mpm_event || true && a2enmod mpm_prefork

# Mengubah port Apache agar sesuai dengan environment variable $PORT dari Railway
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/' /etc/apache2/sites-enabled/000-default.conf

# Di Railway, port diekspos secara dinamis lewat variabel $PORT, 
# baris EXPOSE 80 di bawah ini bisa tetap ada atau dihapus (tidak berpengaruh besar).
EXPOSE 80

CMD ["apache2-foreground"]