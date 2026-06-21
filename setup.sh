#!/bin/bash
set -e

echo "=== X Mock セットアップ開始 ==="

echo "1. Dockerコンテナを起動中..."
docker-compose up -d --build

echo "2. コンテナの起動を待機中..."
sleep 10

echo "3. Composerパッケージをインストール中..."
docker-compose exec -T app composer install --no-interaction

echo "4. .envファイルを作成中..."
docker-compose exec -T app cp .env.example .env

echo "5. アプリケーションキーを生成中..."
docker-compose exec -T app php artisan key:generate

echo "6. ストレージリンクを作成中..."
docker-compose exec -T app php artisan storage:link

echo "7. データベースマイグレーションを実行中..."
docker-compose exec -T app php artisan migrate --force

echo "8. シードデータを投入中..."
docker-compose exec -T app php artisan db:seed --force

echo ""
echo "=== セットアップ完了! ==="
echo ""
echo "アクセス先:"
echo "  API サーバー  : http://localhost:8080"
echo "  phpMyAdmin   : http://localhost:8081"
echo ""
echo "テストアカウント:"
echo "  Email: user1@example.com / Password: password"
echo "  Email: user2@example.com / Password: password"
echo "  Email: user3@example.com / Password: password"
