<h1 align=center>URL shortener</h1>

1.  Clone repository
2.  Run `docker-compose up -d` in project root folder
3.  Enter php container with `docker-compose exec php bash`
4.  Inside php container install composer dependencies: `composer install`
5.  Create database: `bin/console d:d:create`
6.  Run migrations: `bin/console d:m:migrate`
7.  You can run tests to see if all works fine running: `bin/phpunit`
8.  Get wild

Project is running at `http://localhost:9111`.<br/>
You can find documentation at `http://localhost:9111/api/docs`.
