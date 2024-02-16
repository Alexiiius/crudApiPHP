FROM php:apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN echo 'AddType application/x-httpd-php .php' >> /etc/apache2/apache2.conf
RUN service apache2 restart