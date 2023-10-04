
Link: https://app.devchallenge.it/
Task: https://app.devchallenge.it/tasks/online-round-85f3a4b4-f7a2-4176-8ff8-350051ce576b


1. Run migration
```shell
php bin/console doctrine:migrations:migrate
```
2. Run seeder to put initial data 
```shell
php bin/console doctrine:fixtures:load
```
Use that file to send http requests ./api-calls.http
