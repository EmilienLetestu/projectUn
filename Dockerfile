FROM php:fpm

ENV WORKPATH "/var/www/onu"

RUN apt-get update -y \
    && apt-get install -y \
               libfreetype6-dev \
               libjpeg62-turbo-dev \
               libmcrypt-dev \
               libpng12-dev \
               zip \
               unzip \
               wget \
               curl \
               libcurl4-openssl-dev \
               pkg-config \
               libssl-dev

COPY docker/php/conf/php.ini /usr/local/etc/php/

# Core extensions
RUN pecl install apcu \
                 xdebug \
    && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_mysql opcache json pdo_pgsql pgsql \
    && docker-php-ext-enable apcu xdebug

# Composer
COPY docker/php/install-composer.sh /usr/local/bin/docker-app-install-composer
RUN chmod +x /usr/local/bin/docker-app-install-composer \
    && docker-app-install-composer \
    && mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

# Blackfire (Docker approach)
RUN version=$(php -r "echo PHP_MAJOR_VERSION.PHP_MINOR_VERSION;") \
    && curl -A "Docker" -o /tmp/blackfire-probe.tar.gz -D - -L -s https://blackfire.io/api/v1/releases/probe/php/linux/amd64/$version \
    && tar zxpf /tmp/blackfire-probe.tar.gz -C /tmp \
    && mv /tmp/blackfire-*.so $(php -r "echo ini_get('extension_dir');")/blackfire.so \
    && printf "extension=blackfire.so\nblackfire.agent_socket=tcp://blackfire:8707\n" > $PHP_INI_DIR/conf.d/blackfire.ini

# Blackfire Player
RUN curl -OLsS http://get.blackfire.io/blackfire-player.phar \
    && chmod +x blackfire-player.phar \
    && mv blackfire-player.phar /usr/local/bin/blackfire-player

RUN mkdir -p ${WORKPATH}

RUN mkdir -p \
		${WORKDIR}/var/cache \
		${WORKDIR}/var/logs \
		${WORKDIR}/var/sessions \

RUN chown www-data:www-data -R ${WORKPATH}

WORKDIR ${WORKPATH}

EXPOSE 9000

CMD ["php-fpm"]
