docker exec -it php /bin/sh -c "cp .env.dev .env"
docker exec -it php /bin/sh -c "php artisan config:cache"
