FROM php:8.0-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    apt-transport-https \
    openssl \
    acl \
    nano \
    git \
    unzip \
    gnupg \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    rsync \
    sshpass \
    && apt-get clean -y \
    && docker-php-ext-install soap \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
RUN printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini
RUN "date"

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install zip opcache exif bcmath

RUN apt-get update \
	&& apt-get install -y --no-install-recommends \
		libcurl4-openssl-dev \
		pkg-config \
		libssl-dev

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN set -xe && \
  groupadd -g 1000 -o -f user && \
  useradd --shell /bin/bash -u 1000 -g user -o -c "" -m user

WORKDIR /var/www/symfony
