FROM phpdockerio/php:8.1-fpm
WORKDIR "/application"

# Fix debconf warnings upon build
ARG PHP_UID=1000
ARG PHP_GID=1000

RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        php8.1-mbstring \
        php8.1-xml \
        php8.1-xmlrpc \
        php8.1-mysql \
        php8.1-pgsql \
        php8.1-sqlite3 \
        php8.1-gd \
        php8.1-cli \
        php8.1-curl \
        php8.1-intl \
        php8.1-imagick \
        php8.1-redis \
        php8.1-zip \
        php8.1-xdebug \
        php8.1-mcrypt \
        php8.1-memcache \
        php8.1-msgpack \
        php8.1-memcached \
        php8.1-soap \
        php8.1-ldap \ 
        php8.1-mongodb \ 
        php8.1-yaml; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN update-alternatives --set php /usr/bin/php8.1

# add cli user
RUN groupadd -g ${PHP_GID} php_console
RUN useradd -u ${PHP_UID} -g ${PHP_GID} php_console

RUN usermod -a -G www-data php_console
RUN usermod -a -G php_console www-data

EXPOSE 9000 3000 3001
