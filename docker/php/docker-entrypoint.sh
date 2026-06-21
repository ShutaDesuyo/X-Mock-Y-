#!/bin/sh
set -e

# Laravel が書き込む必要があるディレクトリのみ www-data に権限を付与
# chmod 777 ではなく所有者変更で最小権限を維持する
for dir in \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache; do
    mkdir -p "$dir"
    chown -R www-data:www-data "$dir"
    chmod -R 750 "$dir"
done

# public storage は nginx からも読み取れるよう 755 にする
mkdir -p storage/app/public
chown -R www-data:www-data storage/app/public
chmod -R 755 storage/app/public

touch storage/logs/php-fpm.log storage/logs/php-fpm-access.log
chown www-data:www-data storage/logs/php-fpm.log storage/logs/php-fpm-access.log
chmod 640 storage/logs/php-fpm.log storage/logs/php-fpm-access.log

exec gosu www-data "$@"
