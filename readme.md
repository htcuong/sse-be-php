## RUN APPLICATION
- Step 1: Clone source code from: https://github.com/htcuong/sse-be-php.git
- Step 2: Run "docker-compose build --no-cache" at root folder
- Step 3: Run "docker-compose up -d" at root folder
- Step 5: Run "./start.sh" at root folder
- HOST: http://localhost:8080
## Switch to TEST (using SQLite Database)
- Step 1: Run "./start-test.sh" at root folder
- Step 2: Run "docker exec -it php /bin/sh"
- Step 3: Run "composer test"
- Step 4: Run "composer coverage" (Output will be in src/reports)
## Switch to DEV (Using MySql Database)
- Step 1: Run "./start-dev.sh" at root folder