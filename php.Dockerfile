FROM php:7.4-fpm-alpine

COPY php.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

# Install dependencies and extensions
RUN apk add --no-cache \
  freetype \
  libjpeg-turbo \
  libpng \
  libzip \
  freetype-dev \
  libjpeg-turbo-dev \
  libpng-dev \
  libzip-dev \
  && docker-php-ext-configure gd \
  --with-freetype \
  --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
  gd \
  pdo \
  pdo_mysql \
  zip \
  bcmath \
  && apk del --no-cache \
  freetype-dev \
  libjpeg-turbo-dev \
  libpng-dev \
  libzip-dev

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mkdir -p /var/www/html

COPY . /var/www/html

RUN chown -R laravel:laravel /var/www/html

RUN chown -R www-data:www-data .

RUN chmod -R gu+w storage

RUN chmod -R guo+w storage

RUN chmod -R 777 storage