FROM php:8.3-fpm

# Добавляем аргументы для UID и GID
ARG UID=1000
ARG GID=1000

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libjpeg-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_mysql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Создаём пользователя с переданным UID и GID
RUN groupadd -g $GID usergroup && \
useradd -u $UID -g $GID -m -s /bin/bash user && \
chown -R user:usergroup /var/www

# Переключаемся на нового пользователя
USER user

# Устанавливаем рабочую директорию
WORKDIR /var/www