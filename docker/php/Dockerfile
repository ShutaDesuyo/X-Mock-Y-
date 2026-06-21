FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    gosu \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Node.js LTS (公式スクリプト経由でインストール)
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Windowsボリュームマウントでは www-data へのUID合わせが機能しないため、
# 起動スクリプトでディレクトリ権限を適切に設定してから www-data で動かす
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-custom.conf
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zzz-custom.ini
RUN chmod +x /usr/local/bin/docker-entrypoint.sh \
    && sed -i 's/^user = .*/;user = www-data/' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/^group = .*/;group = www-data/' /usr/local/etc/php-fpm.d/www.conf

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
