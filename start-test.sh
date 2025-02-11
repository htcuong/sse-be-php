docker exec -it php /bin/sh -c "rm -rf database/test.sqlite && touch database/test.sqlite"
docker exec -it php /bin/sh -c "cp .env.testing .env"
docker exec -it php /bin/sh -c "php artisan config:cache"
docker exec -it php /bin/sh -c "php artisan migrate"
