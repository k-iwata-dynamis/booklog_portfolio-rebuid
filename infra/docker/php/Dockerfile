FROM php:8.3-fpm-bullseye AS base

WORKDIR /data

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
  && apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    fonts-ipafont-gothic \
    fonts-ipafont-mincho \
    fonts-ipaexfont \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libgd-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && locale-gen en_US.UTF-8 \
  && localedef -f UTF-8 -i en_US en_US.UTF-8 \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath \
    gd \
  && composer config -g process-timeout 3600 \
  && composer config -g repos.packagist composer https://packagist.org

# Node.jsをインストール
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# yarnをインストール
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
#RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/+sources.list.d/yarn.list
RUN apt-get update && apt-get install yarn -y

FROM base AS development

COPY ./infra/docker/php/php.development.ini /usr/local/etc/php/php.ini

FROM base AS deploy

COPY ./infra/docker/php/php.deploy.ini /usr/local/etc/php/php.ini
COPY ./src /data

RUN composer install -q -n --no-ansi --no-dev --no-scripts --no-progress --prefer-dist \
  && chmod -R 777 storage bootstrap/cache \
  && php artisan optimize:clear \
  && php artisan optimize
