#!/bin/sh
# WordPress を用意し（未インストールの場合）、テーマを有効化して、教会サイトの内容を投入する。
#
# docker-compose の wpcli コンテナから実行される（docker-compose.yml を参照）。
# Docker を使わない場合は、WordPress のあるディレクトリで次のように実行する:
#   WP_URL=http://localhost:8080 sh /path/to/seed/setup.sh
set -eu

SEED_DIR=$(cd "$(dirname "$0")" && pwd)
WP_PATH=${WP_PATH:-.}
WP_URL=${WP_URL:-http://localhost:8080}
WP_TITLE=${WP_TITLE:-カトリック習志野教会}
WP_ADMIN_USER=${WP_ADMIN_USER:-admin}
WP_ADMIN_PASSWORD=${WP_ADMIN_PASSWORD:-}
WP_ADMIN_EMAIL=${WP_ADMIN_EMAIL:-admin@example.com}
THEME=narashino-catholic

cd "$WP_PATH"

ROOT_FLAG=
if [ "$(id -u)" = "0" ]; then
	ROOT_FLAG=--allow-root
fi

wp() {
	# ROOT_FLAG は空か --allow-root のどちらか（単語分割させる）。
	# shellcheck disable=SC2086
	command wp $ROOT_FLAG "$@"
}

echo "WordPress とデータベースの準備を待っています..."
attempts=0
until [ -f wp-config.php ] && wp db check >/dev/null 2>&1; do
	attempts=$((attempts + 1))
	if [ "$attempts" -ge 60 ]; then
		echo "WordPress またはデータベースに接続できません。" >&2
		exit 1
	fi
	sleep 2
done

if ! wp core is-installed >/dev/null 2>&1; then
	if [ -z "$WP_ADMIN_PASSWORD" ] || [ "$WP_ADMIN_PASSWORD" = "change-me-now" ]; then
		echo "WP_ADMIN_PASSWORD を .env で設定してください（初期値のままでは管理者を作成しません）。" >&2
		exit 1
	fi
	case "$WP_ADMIN_EMAIL" in
		*example.com) echo "注意: 管理者のメールアドレスが example.com のままです。" >&2 ;;
	esac
	wp core install \
		--url="$WP_URL" \
		--title="$WP_TITLE" \
		--admin_user="$WP_ADMIN_USER" \
		--admin_password="$WP_ADMIN_PASSWORD" \
		--admin_email="$WP_ADMIN_EMAIL" \
		--skip-email

	# 初回だけ設定する（再実行で本番のURLや言語を上書きしないため）。
	wp option update home "$WP_URL" >/dev/null
	wp option update siteurl "$WP_URL" >/dev/null
	wp option update timezone_string Asia/Tokyo >/dev/null
	wp language core install ja --activate >/dev/null 2>&1 \
		|| echo "日本語の言語パックを取得できなかったため、管理画面は英語のままです。"
fi

wp theme activate "$THEME"
wp rewrite structure '/%postname%/' --hard
wp eval-file "$SEED_DIR/seed.php"

echo "完了しました。サイト: $WP_URL / 管理画面: $WP_URL/wp-admin/"
